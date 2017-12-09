<!DOCTYPE HTML>
<html>
    <head>
        <title> Register </title>
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
    </head>
<body>
<?php
session_start();
        date_default_timezone_set("Asia/Kolkata");
        $user='root';
        $pwd='';
        $host='localhost';
        $database='quora';
        $sql_connection=mysqli_connect($host,$user,$pwd);
        $database_connection=mysqli_select_db($sql_connection,$database);
        $r_user='';
        $r_pwd='';
        $r_name='';
    
	   if(isset($_POST['reguser'])&&isset($_POST['pass'])&&isset($_POST['regname'])){
			$r_user=$_POST['reguser'];
			$r_pwd=$_POST['pass'];
	        $r_name=$_POST['regname'];
       }
        $query_check="SELECT * FROM users WHERE username='$r_user';";
        if($database_connection){
				$res=mysqli_query($sql_connection,$query_check);
				
			}
	       else{
				print "Database not found";
				mysqli_close($sql_connection);
	   }
    $existerr='';
    if(isset($_POST['reguser'])&&isset($_POST['pass'])&&isset($_POST['regname'])){
		if(mysqli_num_rows($res)==1){
			$existerr="Username already exists. Please enter another username";
		}	
		if(mysqli_num_rows($res)==0){
			$insert_query="INSERT INTO users VALUES ('','$r_user','$r_pwd','$r_name');";
             if (mysqli_query($sql_connection, $insert_query)) {
//            echo "New record created successfully";
              header('Location:login.php');  
            } else {
//                echo "Error: " . $sql . "<br>" . mysqli_error($sql_connection);
                mysqli_error($sql_connection);
            }
		}
	}
    mysqli_close($sql_connection);
    ?>
        <div style="padding-top:225px; padding-left:500px;font-size: 20px;">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="register">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        <span>Register <br> <br>
        Username <input type="text" name="reguser" value="" style="position: absolute; top:282px; left:595px;" form="register"> <br> <br>
        Password <input type="password" name="pass" value="" style="position: absolute; top:330px; left:595px;" form="register"> <br> <br>
        Full Name <input type="text" name="regname" value="" style="position: absolute; top:378px; left:595px;" form="register">
            </span>
        </form>    
        <button type="submit" value="submit" form="register" style="position: absolute;top:429px;left: 600px;"> Register </button>
            <?php
                print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style=\"color:red;font-size:14px;\">".$existerr."</span>";
            ?>
        </div>
    <br>
       
    </body>
</html>