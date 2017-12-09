<!DOCTYPE html>
<html>
    <head>
        <title> Home - Quora </title>
        <link rel="stylesheet" href="styles.css"/>
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
    </head>
    <body background="back.jpg">
<?php
session_start();
        if($_SESSION['valid']==false){
		header('Location:login.php');
        }
//        echo $_SESSION['u_id'];
//        print_r($_SESSION);
        date_default_timezone_set("Asia/Kolkata");
	    $qdate=date('jS M Y');
	    $user='root';
        $pwd='';
        $host='localhost';
        $database='quora';
        $sql_connection=mysqli_connect($host,$user,$pwd);
        $database_connection=mysqli_select_db($sql_connection,$database);
        $sql_fetch="SELECT * FROM questions;";
        if($result=mysqli_query($sql_connection,$sql_fetch)){
            $nq=mysqli_num_rows($result);
            $i=0;
            while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                $questions[$i]=$row['question'];
                $dates[$i]=$row['date'];
                $ques_ids[$i]=$row['q_id'];
                $i++;
            }
        }
        if(!$database_connection)
        {
            die("Connection failed:".mysqli_connect_error());
        }
        //echo "Database connected";    
        
        if(isset($_POST['ques'])){
		$ques=$_POST['ques'];
        }
        
        else{
            $ques=NULL;
        }
        if($ques!=NULL){
            $sql_insert="INSERT INTO questions VALUES ('','$ques','$qdate');";
//            echo $ques;
            if (mysqli_query($sql_connection, $sql_insert)) {
//            echo "New record created successfully";
            } else {
//                echo "Error: " . $sql . "<br>" . mysqli_error($sql_connection);
                mysqli_error($sql_connection);
            }
            header('Location: index.php');
            exit;
            
        }
        
        
    ?>  
        <header>
        <ul id="navbar">
            <li> <a href="index.php"> <img src="quora.png" width="80" height="40"></a>  </li>
            <li> <a href="index.php" class="active">Home</a></li>
            <li> <a href="ans.php">Answer</a></li>
            <li> <a href="notif.php">Notifications</a></li>
            <li> <input type="text" name="searchbar" placeholder="Search on Quora" style= "height:1.4em; width:27em;"> </li>
            <li> <a href="logout.php"> <input type="button" name="ask" value="Logout" href="logout.php" style= "background-color: #AA2200; color: white; height: 2em;"> </a></li>
        </ul>
        </header>
        <aside style="float:left; margin-left:80px;">
            
            <a href="bookmarks.php">Bookmarks</a>
            <br>
        </aside>
        <section id="qa"> 
            <br>
            <br>
            <form id="qform"  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <textarea name="ques" placeholder="Enter your question here" rows=3 cols=90></textarea>
                <br>
                <input form="qform" type="submit" value="Ask question">
            </form>
            <br>
            <br>
            <?php
                
                $i=$nq-1;
                while($i>=0){
                    $ans_exist=0;
                    $fetch_answer="SELECT * FROM answers WHERE q_id='$ques_ids[$i]' AND del=0 ORDER BY upvotes DESC LIMIT 1;";
                    if($res_ans=mysqli_query($sql_connection,$fetch_answer)){
//                        print "in if";
                        $ans_exist=mysqli_num_rows($res_ans);
                        $row=mysqli_fetch_assoc($res_ans);
                        if($ans_exist){
                            $answer=$row['answer'];
                        }
                    }
                    else{
                        mysqli_error($sql_connection);
                    }
                    print "<article style=\"border: 0.5px solid #000033;\">
                        <p class=\"ques\"> <a href=\"qp.php?id=$ques_ids[$i]\">$questions[$i]</a></p>
                        <p class=\"td\">Asked on $dates[$i]</p>";
                        if($ans_exist){?>
                            <textarea readonly style="margin-left:20px;"rows="2" cols="85"><?php print $answer;?></textarea>    
                        <?php 
                        }
                        print "<p> <a href=\"qp.php?id=$ques_ids[$i]\"><button class=\"blue\"> Answer </button></a>
                        </article>";
                    $i--;
                }
            mysqli_close($sql_connection);
            ?>
            
        </section>
        
    </body>
</html>