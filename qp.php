<!DOCTYPE html>
<html>
    
<?php
session_start();
//        print_r($_SESSION);
        if($_SESSION['valid']==false){
		header('Location:login.php');
        }
        error_reporting(-1);
        $user_name=$_SESSION['name'];
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
            $sql_insert="INSERT INTO answers VALUES ('$ques_det','','$new_ans','$adate','$user_name','','','');";
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
    <body  background="back.jpg">
        <header>
        <ul id="navbar">
            <li> <a href="index.php"> <img src="quora.png" width="80" height="40"></a>  </li>
            <li> <a href="index.php">Home</a></li>
            <li> <a href="ans.php">Answer</a></li>
            <li> <a href="notif.php">Notifications</a></li>
            <li> <input type="text" name="searchbar" placeholder="Search on Quora" style= "height:1.4em; width:27em;"> </li>
            <li><a href="logout.php"> <input type="button" name="ask" value="Logout" href="logout.php" style= "background-color: #AA2200; color: white; height: 2em;"> </a></li>
        </ul>
        </header>
        <aside style="float:right;">
            <p style="border-bottom:0.5px solid lightgray;">Related questions</p>
            <a href=""> Related question 1</a>
            <br>
            <a href=""> Related question 2</a>
        </aside>
        <section id="qa">
            <?php
//            echo "Book".(int) $book;
            $_SESSION['q_id']=$ques_det;
            print "<p class=\"ques\"> $question </p>
            <p class=\"td\"> Asked on $q_d</p>    
            <button class=\"blue\"> Answer </button>
            <button class=\"blue\"> Request </button>
            <a class=\"links\"> Follow </a>
            <a class=\"links\"> Comment </a>
            <a class=\"links\"> Share </a>
            <a class=\"links\"> Downvote </a>
            <a class=\"links\"" ;
            if($book==false)
                print " href=\"book_add.php?id=$ques_det&done=$book\"> Bookmark</a>";
            else
                print "href =\"book_add.php?id=$ques_det&done=$book\"> Remove Bookmark</a>";
            print "</section>";
                ?>
            <br>
        <section id="mans">
            
                <form id="aform"  method="post" action="qp.php?id=<?php echo htmlspecialchars($_GET['id']);?>">
                <textarea name="ans" placeholder="Enter your answer here" rows=6 cols=70></textarea>
                <br>
                <input form="aform" type="submit" value="Submit answer">
            </form>
            <?php
                $sql_ans="SELECT * FROM answers where q_id='$ques_det' ORDER BY upvotes DESC;";
                if($result_ans=mysqli_query($sql_connection,$sql_ans)){
                    $na=mysqli_num_rows($result_ans);
                    $i=0;
                    while($row_a=mysqli_fetch_array($result_ans,MYSQLI_ASSOC)){
                        $answers[$i]=$row_a['answer'];
                        $dates[$i]=$row_a['date'];
                        $unames[$i]=$row_a['u_name'];
                        $ans_ids[$i]=$row_a['a_id'];
                        $ans_dels[$i]=$row_a['del'];
                        $i++;
                    }
                    //header('Location:qp.php?id='.$ques_det);   
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
                        print"<article style=\"border:1px solid rgb(38, 13, 38); padding-left:10px;margin-right:100px;\">
                    <p class=\"td\"> Answered on $dates[$i] by $unames[$i]</p>
                    <p class=\"ans\"> $answers[$i]</p>
                    ";
                        if($upvote){
                        print "<p> <a href=\"upvote.php?id=$ans_ids[$i]&done=$upvote\"> <button class=\"blue\">    
                         Upvoted | $n_up</button> </a>";
                        }
                        else{
                            print "<p><a href=\"upvote.php?id=$ans_ids[$i]&done=$upvote\"> <button class=\"blue\">    
                         Upvote | $n_up</button> </a>";
                        }
                             print "<a class=\"links\" href=\"\"> Downvote</a>
                    </p>
                </article>";
                    print "<article style=\"padding-left:30px;\"><p style=\"color:grey\">Comments";
                    if(isset($_POST["comment$i"])){
                    $new_com=$_POST["comment$i"];
                    }

                    else{
                        $new_com=NULL;
                    }
                    if($new_com!=NULL){
                        $sql_insert_comm="INSERT INTO comments VALUES ('','$ans_ids[$i]','$user_name','$new_com','','');";
                        if (mysqli_query($sql_connection, $sql_insert_comm)) {
            //            echo "New record created successfully";
                        } 
                        else {
            //                echo "Error: " . $sql . "<br>" . mysqli_error($sql_connection);
                            mysqli_error($sql_connection);
                        }
                    }

                    $fetch_comments="SELECT * FROM comments WHERE ans_id='$ans_ids[$i]';";
                    $res_c=mysqli_query($sql_connection,$fetch_comments);
                    $n_c=mysqli_num_rows($res_c);
                    $cv=0;

                    while($row_c=mysqli_fetch_array($res_c,MYSQLI_ASSOC)){
                            $comments[$cv]=$row_c['comment'];
                            $usernames[$cv]=$row_c['user_name'];
                            $comm_dels[$cv]=$row_c['del'];
                            $cv++;
                        }
                    for($cv=0;$cv<$n_c;$cv++){
                        if($comm_dels[$cv]==0){
                            print "<div style=\"border-bottom:0.5px solid grey;margin:0px 250px 0px 10px;\">
                                    <p style=\"font-size:12px;color:blue;\">$usernames[$cv]</p>
                                    <p style=\"font-size:15px;\">$comments[$cv]</p>
                                    </div>
                                    ";
                        }
                    }
                    ?>
                    <br><form id="comform<?php echo $i;?>" method="post" action="qp.php?id=<?php echo htmlspecialchars($_GET['id']);?>">
                    <textarea name="comment<?php echo $i;?>" placeholder="Enter your comment" rows=2 cols=55></textarea>
                    <br>
                    <input form="comform<?php echo $i;?>" type="submit" value="Comment">
            </form></article>
                <?php
                }
                $i++;
            }
                            mysqli_close($sql_connection);  
                
             ?>
            
        </section>
        </section>
    </body>
</html>