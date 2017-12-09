<?php
session_start();
$user_id=$_SESSION['u_id'];
$answer_id=$_GET['id'];
$q_id=$_SESSION['q_id'];
$upvote=$_GET['done'];
$user='root';
$pwd='';
$host='localhost';
$database='quora';
$sql_connection=mysqli_connect($host,$user,$pwd);
$database_connection=mysqli_select_db($sql_connection,$database);
if($upvote==true){
    $remove_upvote="DELETE FROM upvotes where user_id='$user_id' AND ans_id='$answer_id'";
    if(mysqli_query($sql_connection,$remove_upvote)){
    //        echo "Insert successful";
        }
        else{
    //        echo "Error"
            mysqli_error($sql_connection);
        }
}
else{
    $insert_upvote="INSERT INTO upvotes VALUES ('','$user_id','$answer_id')";
     if(mysqli_query($sql_connection,$insert_upvote)){
    //        echo "Insert successful";
        }
        else{
    //        echo "Error"
            mysqli_error($sql_connection);
        }
}
$redirect="Location:qp.php?id=".$q_id;
header($redirect);
?>