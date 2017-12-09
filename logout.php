<?php
	session_start();
	unset($_SESSION['username']);
	unset($_SESSION['name']);
	$_SESSION['valid']=false;
	header('Location:login.php');
?>