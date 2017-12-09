<!DOCTYPE html>
<html>
    <head>
        <title> Bookmarks </title>
        <link rel="stylesheet" href="styles.css"/>
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
    </head>
    <body background="back.jpg">
<?php
session_start();
        if($_SESSION['valid']==false){
		header('Location:login.php');
        }
        date_default_timezone_set("Asia/Kolkata");
        $user='root';
        $pwd='';
        $host='localhost';
        $database='quora';
        $sql_connection=mysqli_connect($host,$user,$pwd);
        $database_connection=mysqli_select_db($sql_connection,$database);
        $user_id=$_SESSION['u_id'];
        $fetch_book="SELECT * FROM bookmarks WHERE user_id='$user_id';";
        if($result_b=mysqli_query($sql_connection,$fetch_book)){
            $n_b=mysqli_num_rows($result_b);
            $i=0;
            while($row_b=mysqli_fetch_array($result_b,MYSQLI_ASSOC)){
                $ques_ids[$i]=$row_b['q_id'];
                $i++;
            }
        }
//        echo $n_b;
        for($q=0,$i=$n_b-1;$i>=0;$i--,$q++){
            $fetch_ques="SELECT question FROM questions WHERE q_id='$ques_ids[$i]';";
            $result_q=mysqli_query($sql_connection,$fetch_ques);
            $row_q=mysqli_fetch_assoc($result_q);
            $questions[$q]=$row_q['question'];
            $question_ids[$q]=$ques_ids[$i];
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
        <section id="qa"> 
            <br>
            <br>
             <?php
                if($n_b==0){
                    ?>
                <article>
                        <p class="ques"> You have no bookmarks</p>
            </article>
                    <?php
                }
                $i=$n_b-1;
                while($i>=0){
                    print "<article>
                        <p class=\"ques\"> <a href=\"qp.php?id=$question_ids[$i]\">$questions[$i]</a></p>
                        
                        </article>";
                    $i--;
                }
            ?>
        </section>
    </body>
</html>