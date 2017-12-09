<!DOCTYPE html>
<html>
    
<?php
session_start();
        if($_SESSION['valid']==false){
		header('Location:login.php');
        }
        error_reporting(-1);
        $mod_name=$_SESSION['mod_name'];
        $uid=$_SESSION['u_id'];
        date_default_timezone_set("Asia/Kolkata");
	    $adate=date('jS M Y');
	    $user='root';
        $pwd='';
        $host='localhost';
        $database='quora';
        $sql_connection=mysqli_connect($host,$user,$pwd);
        $database_connection=mysqli_select_db($sql_connection,$database);
        $ques_det=$_GET['id'];
        $sql_bookmark_check="SELECT * FROM bookmarks WHERE q_id='$ques_det' AND user_id='$uid';";
//        $book=false;
        if($res_b=mysqli_query($sql_connection,$sql_bookmark_check)){
            if(mysqli_num_rows($res_b)==0){
                $book=false;
            }
            else{
                $book=true;
            }
        }
        $sql_fetch_q="SELECT * FROM questions where q_id='$ques_det';";
        if($res_q=mysqli_query($sql_connection,$sql_fetch_q)){
//            echo "query";
            while($row_q=mysqli_fetch_assoc($res_q)){
                $question=$row_q['question'];
                $q_d=$row_q['date'];
            }
        }
        //$new_ans=NULL;
        if(isset($_POST['ans'])){
		$new_ans=$_POST['ans'];
        }
        
        else{
            $new_ans=NULL;
        }
        if($new_ans!=NULL){
            $sql_insert="INSERT INTO answers VALUES ('$ques_det','','$new_ans','$adate','$user_name','');";
            if (mysqli_query($sql_connection, $sql_insert)) {
//            echo "New record created successfully";
            } else {
//                echo "Error: " . $sql . "<br>" . mysqli_error($sql_connection);
                mysqli_error($sql_connection);
            }
            //header('Location: qp.php?id=$ques_det');
            
        }
        
    
    ?>
    <head>
        <title><?php print $question;?></title>
        <link rel="stylesheet" href="styles.css"/>
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
    </head>
    <body background="mod_back.jpg">
        <header>
        <ul id="navbar">
            <li> <a href="mod_index.php"> <img src="quora.png" width="80" height="40"></a>  </li>
            <li> <a href="mod_index.php" >Home</a></li>
            <li> <a href="">Answer</a></li>
            <li> <a href="">Notifications</a></li>
            <li> <input type="text" name="searchbar" placeholder="Search on Quora" style= "height:1.4em; width:27em;"> </li>
            <li><a href="logout.php"> <input type="button" name="ask" value="Logout" href="logout.php" style= "background-color: #AA2200; color: white; height: 2em;"> </a></li>
        </ul>
        </header>
<!--
        <aside style="float:right;">
            <p style="border-bottom:0.5px solid lightgray;">Related questions</p>
            <a href=""> Related question 1</a>
            <br>
            <a href=""> Related question 2</a>
        </aside>
-->
        <section id="qa">
            <?php
            $_SESSION['q_id']=$ques_det;
            print "<p class=\"ques\"> $question </p>
            <p class=\"td\"> Asked on $q_d</p>";
            print "</section>";
                ?>
            <br>
        <section id="mans">
            
<!--
                <form id="aform"  method="post" action="qp.php?id=<?php echo htmlspecialchars($_GET['id']);?>">
                <textarea name="ans" placeholder="Enter your answer here" rows=6 cols=70></textarea>
                <br>
                <input form="aform" type="submit" value="Submit answer">
            </form>
-->
            <?php
                $sql_ans="SELECT * FROM answers where q_id='$ques_det';";
                if($result_ans=mysqli_query($sql_connection,$sql_ans)){
                    $na=mysqli_num_rows($result_ans);
                    $i=0;
                    while($row_a=mysqli_fetch_array($result_ans,MYSQLI_ASSOC)){
                        $answers[$i]=$row_a['answer'];
                        $dates[$i]=$row_a['date'];
                        $unames[$i]=$row_a['u_name'];
                        $ans_ids[$i]=$row_a['a_id'];
                        $ans_dels[$i]=$row_a['del'];
                        $ans_mods[$i]=$row_a['mod_name'];
                        $i++;
                    }
                }
                $i=0;
                while($i<$na){
                    if($ans_dels[$i]==0){
                        $upvote_fetch="SELECT * FROM upvotes where ans_id='$ans_ids[$i]';";
                        $res_u=mysqli_query($sql_connection,$upvote_fetch);
                        $n_up=mysqli_num_rows($res_u);
                        $upvote_detail="SELECT * FROM upvotes where ans_id='$ans_ids[$i]' AND user_id='$uid';";
                        $res_utf=mysqli_query($sql_connection,$upvote_detail);
                        if(mysqli_num_rows($res_utf)==0){
                            $upvote=false;
                        }
                        else{
                            $upvote=true;
                        }
                        print"<article>
                        <p class=\"td\"> Answered on $dates[$i] by $unames[$i]</p>
                        <p class=\"ans\"> $answers[$i]</p>
                        ";
                        if($upvote){
                            print "<p> <button class=\"blue\">    
                             Upvotes | $n_up</button>";
                        }
                        else{
                            print "<p> <button class=\"blue\">    
                                Upvotes | $n_up</button>";
                        }
    //                         print "<a class=\"links\" href=\"\"> Downvote</a>";
                        print " <a class=\"links\" href=\"delete.php?bool=0&q_id=$ques_det&id=$ans_ids[$i]\">Delete Answer</a></p> </article>";
                        print "<p style=\"color:grey\">Comments";

                        $fetch_comments="SELECT * FROM comments WHERE ans_id='$ans_ids[$i]';";
                        $res_c=mysqli_query($sql_connection,$fetch_comments);
                        $n_c=mysqli_num_rows($res_c);
                        $cv=0;
                        while($row_c=mysqli_fetch_array($res_c,MYSQLI_ASSOC)){
                                $comments[$cv]=$row_c['comment'];
                                $usernames[$cv]=$row_c['user_name'];
                                $comm_ids[$cv]=$row_c['com_id'];
                                $comm_dels[$cv]=$row_c['del'];
                                $comm_mods[$cv]=$row_c['mod_name'];
                                $cv++;
                        }
                        for($cv=0;$cv<$n_c;$cv++){
                            if($comm_dels[$cv]==0){
                                print "<div style=\"border-bottom:0.5px solid grey;margin:0px 250px 0px 10px;\">
                                        <p style=\"font-size:12px;color:blue;\">$usernames[$cv]</p>
                                        <p style=\"font-size:15px;\"\>$comments[$cv]</p>
                                        <p> <a class=\"links\" href=\"delete.php?bool=1&q_id=$ques_det&id=$comm_ids[$cv]\">Delete Comment</a> </div>";
                            }
                            else{
                                print  "<p style=\"border-top: 1px solid darkgrey;border-bottom: 1px solid darkgrey;margin-right:325px;\" class=\"ans\">Comment has been deleted by $comm_mods[$cv]</p>";
                            }
                        }
                    }
                    else{
                        print  "<p style=\"border-top: 1px solid darkgrey;border-bottom: 1px solid darkgrey;margin-right:325px;\" class=\"ans\">Answer has been deleted by $ans_mods[$i]</p>";
                    }
                    $i++;
                }
                    mysqli_close($sql_connection); 
             ?>
            
        </section>
        </section>
    </body>
</html>