<!DOCTYPE HTML>
<html>
    <head>
        <title> Moderator Login Page </title>
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
    </head>
<body  background="mod_back.jpg">
<?php
session_start();
    
        date_default_timezone_set("Asia/Kolkata");
        $user='root';
        $pwd='';
        $host='localhost';
        $database='quora';
        $sql_connection=mysqli_connect($host,$user,$pwd);
        $database_connection=mysqli_select_db($sql_connection,$database);
        $l_user='';
	   $l_pwd='';
	   if(isset($_POST['loguser'])&&isset($_POST['pass'])){
			$l_user=$_POST['loguser'];
			$l_pwd=$_POST['pass'];
	   }
        $query_login="SELECT * FROM mods WHERE username='$l_user' AND password='$l_pwd';";
        if($database_connection){
				$res=mysqli_query($sql_connection,$query_login);
				mysqli_close($sql_connection);
			}
	else{
				print "Database not found";
				mysqli_close($sql_connection);
	}
    $loginerr='';
    if(isset($_POST['loguser'])&&isset($_POST['pass'])){
		if(mysqli_num_rows($res)==1){
            $res_array=mysqli_fetch_row($res);
			$_SESSION['valid']=true;
			$_SESSION['username']=$l_user;
			$_SESSION['mod_name']=$res_array[3];
			$_SESSION['u_id']= $res_array[0];
            $_SESSION['is_mod']=true;    
            header('Location:mod_index.php');
		}	
		if(mysqli_num_rows($res)==0){
			$loginerr="Invalid username or password";
		}
	}
    ?>
        <div style="padding-top:225px; padding-left:500px;font-size: 20px;">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="signin">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        <span>Moderator Login <br> <br>
        Username <input type="text" name="loguser" value="" style="position: absolute; top:282px; left:595px;"id="signin"> <br> <br>
        Password <input type="password" name="pass" value="" style="position: absolute; top:330px; left:595px;"id="signin"> 
            </span>
        </form>    
        <button type="submit" value="Moderator Sign-in" form="signin" style="position: absolute;top:381px;left: 600px;"> Sign-in </button>
            <br>
            <br>
        <p style=""> Click <a href="login.php"> here </a> to login as user</p>
            <?php
                print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style=\"color:red;font-size:14px;\">".$loginerr."</span>";
            ?>
        </div>
    <br>
    </body>
</html>