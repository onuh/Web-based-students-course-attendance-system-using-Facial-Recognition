<?php
 ob_start();
    session_start();
require_once '../databaseConnect.php';

    $error = false;
    
    if( isset($_POST['btn-login']) ) {  
        
        // prevent sql injections/ clear user invalid inputs
        $email = trim($_POST['email']);
        $email = strip_tags($email);
        $email = htmlspecialchars($email);
        
        $pass = trim($_POST['pass']);
        $pass = strip_tags($pass);
        $pass = htmlspecialchars($pass);
        // prevent sql injections / clear user invalid inputs
        
        if(empty($email)){
            $error = true;
            $emailError = "Please enter your email address.";
        } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
            $error = true;
            $emailError = "Please enter valid email address.";
        }
        
        if(empty($pass)){
            $error = true;
            $passError = "Please enter your password.";
        }
        
        // if there's no error, continue to login
        if (!$error) {
            
            $password = hash('sha256', $pass); // password hashing using SHA256
        
            $res=mysql_query("SELECT Email, password, Lec_id FROM lecturers WHERE Email='$email'");
            $row=mysql_fetch_array($res);
            $count = mysql_num_rows($res); // if uname/pass correct it returns must be 1 row
            //echo $row['Lec_id'];
            if( $count == 1 && $row['password']==$password ) {
                $_SESSION['lecturunilorin'] = $row['Lec_id'];
               // echo $_SESSION['lecturunilorin'];

                header("Location: Lprofile.php");
            }else{

                  $FailedLogin='Invalid Credentials Or you are <b>NOT</b> a Lecturer.';
                   $alternateLogin='<a  href="../students/">Log in As Student Instead</a>';
            }
        }
        
    }
    if (isset($_SESSION['not_logged_in'])) {
        
        $FailedLogin=$_SESSION['not_logged_in'];

        unset($_SESSION['not_logged_in']);
    }   

?>
<!DOCTYPE html>
<html>
<head>
	<title>Lecturers Login</title>
		<meta charset="utf-8">

		<link href="../students/css/style.css" rel='stylesheet' type='text/css' />
		<link href="../css/font-awesome.min.css" rel='stylesheet' type='text/css' />
        <link rel="shortcut icon" href="../images/favicon.ico">

		<script type="text/javascript" src="../students/js/jquery.min.js"></script>
		<script type="text/javascript" src="../students/js/validator.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
</head>
<body>
	 <!-----start-main---->
	 <div class="main">
		<div class="login-form">
			<h1>Lecturer Login</h1>
					<div class="head">
						<a href="../" title="Click to return home"><img src="../students/images/logo_only2.png"  alt="Futminna Logo"/></a>
					</div>
				<form data-toggle="" role="form" action="../lecturers/" method="POST" >
                    <div align="center" style="margin-top: -15px; color: red; background-color: <?php if ($FailedLogin) {
                       echo "#DDA0DD;";
                    }?> padding: 3px; border-radius: 3px;"><?php if ($FailedLogin || isset($_SESSION['not_logged_in'])) {
                        echo $FailedLogin;
                    }?></div>
						<i class="icon-envelope icon-large" style="margin-left: 5px;"></i><div class="error"><?php if ($error) {
                        echo $emailError;
                    } ?></div>
						<input type="email" name="email" value="" placeholder="Enter Your Email"  required />
						<i class="icon-lock icon-large" style="margin-left: 5px;"></i><div class="error"><?php if ($error) {
                        echo $passError;
                    } ?></div>
						<input type="password" name="pass" value="" placeholder="Enter Your Password" required />

						<div class="submit">
							<input type="submit" name="btn-login" value="Log in" >
					</div>	
					<p><a href="#">Forgot Password ?</a></p><br>
                    <p><?php if ($FailedLogin) {
                       echo  $alternateLogin;
                    } ?></p>
				</form>
			</div>
			<!--//End-login-form-->
			 <!-----start-copyright---->
   					<div class="copy-right">
						<p>Designed by <a href="">Korede Ojeyemi &copy; 2018.</a></p> 
					</div>
				<!-----//end-copyright---->
		</div>

        <?php if ($FailedLogin) {
               echo '<style type="text/css">
            .head img{

                margin-top: 12px;
            }
         </style>';
            } ?>
            
 <!-----//end-main---->
		 		
</body>
</html>