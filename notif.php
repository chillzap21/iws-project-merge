<!DOCTYPE html>
<html>
    <head>
        <title> Write Answers - Quora </title>
        <link rel="stylesheet" href="styles.css"/>
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
        <style>
            aside{
                width: 200px;
            }
            aside a{
                color: darkgray;
            }
        </style>
    </head>
    <body  background="back.jpg">
        <header>
        <ul id="navbar">
            <li> <a href="index.php"> <img src="quora.png" width="80" height="40"></a>  </li>
            <li> <a href="index.php">Home</a></li>
            <li> <a href="ans.php" >Answer</a></li>
            <li> <a href="notif.php" class="active">Notifications</a></li>
            <li> <input type="text" name="searchbar" placeholder="Search on Quora" style= "height:1.4em; width:27em;"> </li>
            <li> <a href="logout.php"><input type="button" name="ask" value="Logout" style= "background-color: #AA2200; color: white; height: 2em;"> </a></li>
        </ul>
        </header>
        <section id="qa" style="margin-top:70px;">
<?php
session_start();
            if($_SESSION['valid']==false){
            header('Location:login.php');
            }
            $user='root';
            $pwd='';
            $database='quora';
            $host='localhost';
            $sql_connection=mysqli_connect($host,$user,$pwd);
            $database_connection=mysqli_select_db($sql_connection,$database);
            $sql_notif="SELECT * FROM notifications;";
            if($res_notif=mysqli_query($sql_connection,$sql_notif)){
                $n_notif=mysqli_num_rows($res_notif);
                $i=0;
                while($row=mysqli_fetch_array($res_notif,MYSQLI_ASSOC)){
                    $notifs[$i]=$row['notif'];
                    $i++;
                }
            }
            if(!$database_connection){
                die("Connection failed:".mysqli_connect_error());
            }
            mysqli_close($sql_connection);
            for($i=$n_notif-1;$i>=0;$i--){
                print "<article>
                    <p class=\"notif\" style=\"color:gray; font-size:15px;\"> $notifs[$i] </p>
                </article>";
            }
            ?>
        </section>
    </body>
</html>