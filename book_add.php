<?php
session_start();
//print_r($_SESSION);
	$user_id=$_SESSION['u_id'];
    $q_id=$_GET['id'];
    $book=$_GET['done'];
    $user='root';
    $pwd='';
    $host='localhost';
    $database='quora';
    $sql_connection=mysqli_connect($host,$user);
    $database_connection=mysqli_select_db($sql_connection,$database);
    if($book==false){
        $sql_bookmark="INSERT INTO bookmarks VALUES ('','$user_id','$q_id');";
        if(mysqli_query($sql_connection,$sql_bookmark)){
    //        echo "Insert successful";
        }
        else{
    //        echo "Error"
            mysqli_error($sql_connection);
        }
    }
    else{
        $bookmark_remove="DELETE FROM bookmarks WHERE user_id='$user_id' AND q_id='$q_id'";
    }
    if(mysqli_query($sql_connection,$bookmark_remove)){
    //        echo "delete successful";
        }
        else{
    //        echo "Error"
            mysqli_error($sql_connection);
        }
    $redirect="Location:qp.php?id=".$q_id;
    header($redirect);
?>
    