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

$q_or_c=$_GET['bool'];
$ac_id=$_GET['id'];
$ques_id=$_GET['q_id'];
if($q_or_c==0){
    $update_query="UPDATE answers SET del=1,mod_name='$mod_name' WHERE a_id='$ac_id'";
    if(mysqli_query($sql_connection,$update_query)){
//        echo "Value updated";
    }
    else{
//        echo "Error";
    }
}
elseif($q_or_c==1){
    $update_query="UPDATE comments SET del=1,mod_name='$mod_name' WHERE com_id='$ac_id'";
    if(mysqli_query($sql_connection,$update_query)){
//        echo "Value updated";
    }
    else{
//        echo "Error";
    }
}

mysqli_close($sql_connection);
$redirect="Location:mod_qp.php?id=".$ques_id;
header($redirect);
?>
