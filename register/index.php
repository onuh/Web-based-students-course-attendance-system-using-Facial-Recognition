<?php
ob_start();
    session_start();
require_once '../databaseConnect.php';
$error=false;

if ( isset($_POST['btn-register']) ) {
        // clean user inputs to prevent sql injections
       
        $email = trim($_POST['email']);
        $email = strip_tags($email);
        $email = htmlspecialchars($email);
        
        $pass = trim($_POST['pass']);
        $pass = strip_tags($pass);
        $pass = htmlspecialchars($pass);

        $Confirmpass = trim($_POST['Confirmpass']);
        $Confirmpass = strip_tags($Confirmpass);
        $Confirmpass = htmlspecialchars($Confirmpass);


        $option = $_POST['option'];

        // password validation
        if (empty($pass)){
            $error = true;
            $passError = "Please enter your password.";
        } else if(strlen($pass) < 6) {
            $error = true;
            $passError = "Password must have atleast 6 characters.";
        } 
        if (empty($Confirmpass)){
            $error = true;
            $ConfirmpassError = "Please confirm your password.";
        }
        else if ($Confirmpass!==$pass) {
            $error = true;
            $ConfirmpassError = "The Password do not match.";
        }

        $password = hash('sha256', $pass);

        //basic email validation
        if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
            $error = true;
            $emailError = "Please enter a valid email address.";
        }

        //option validation
        if ($option=='') {
            $error = true;
            $optionError = "Select your Profile.";
        }   

        switch ($option) {

                case 'Lecturer':
            // check email exist or not
            $query = "SELECT Email FROM lecturers WHERE Email='$email'";
            $result = mysql_query($query);
            $count = mysql_num_rows($result);
            if($count!=0){
                $error = true;
                $emailError = "Provided Email is already in use by another Lecturer.";
            }
             else if (!$error) {
            # code...

                $query = "INSERT INTO lecturers(Email,Password) VALUES('$email','$password')";
                $res = mysql_query($query);     
        
                }   
                    break;

                    case 'Student':
            // check email exist or not
            $query = "SELECT Email FROM students WHERE Email='$email'";
            $result = mysql_query($query);
            $count = mysql_num_rows($result);
            if($count!=0){
                $error = true;
                $emailError = "Provided Email is already in use by another Student.";
            }
         else if (!$error) {

                $query = "INSERT INTO students(Email,Password) VALUES('$email','$password')";
                $res = mysql_query($query);
            }

                
                     break;
           /* case 'Admin':
            // check email exist or not
            $query = "SELECT Email FROM admin WHERE Email='$email'";
            $result = mysql_query($query);
            $count = mysql_num_rows($result);
            if($count!=0){
                $error = true;
                $emailError = "Provided Email is already in use by another Admin.";
            }
         else if (!$error) {

                $query = "INSERT INTO admin(Email,Password) VALUES('$email','$password')";
                $res = mysql_query($query);
            }

            break;*/
                    default:
                    # code...
                      break;


}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Registrations</title>
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

			<h1>Students & Lecturers Registration</h1>
					<div class="head">
						<a href="../" title="Click to return home"><img src="../students/images/logo_only2.png"  alt="Futminna Logo"/></a>
					</div>
				<form data-toggle="" role="form" method="POST" action="../register/" >
					<div align="center" style="margin-top: -15px; background-color:<?php if ($error) {
                       echo " #DDA0DD;";
                    }else if($res){echo "#B3FFD9;";}?> padding: 3px; border-radius: 3px; color:<?php if ($error) {
                       echo  "red;";
                    }else{ echo "green;"; } ?>"><?php if ($error) {
                        echo "Registration Failed!";
                    }elseif (!$error && isset($_POST['btn-register'])){ echo "Registration Successful! Log In with Link Below.";} ?></div>
					<i class="icon-envelope icon-large" style="margin-left: 5px;"></i><div class="error"><?php if ($error) {
                        echo $emailError;
                    } ?></div>
						<input type="email" class="text" name="email" value="<?php echo @$email; ?>" placeholder="Enter Your Email"  required />
					<i class="icon-lock icon-large" style="margin-left: 5px;"></i><div class="error"><?php if ($error) {
                        echo $passError;
                    } ?></div>
						<input type="password" name="pass" value="<?php ?>" placeholder="Enter Your Password" required />
					<i class="icon-lock icon-large" style="margin-left: 5px;"></i><div class="error"><?php if ($error) {
                        echo $ConfirmpassError;
                    } ?></div>
						<input type="password" name="Confirmpass" value="<?php ?>" placeholder="Confirm Your Password" required />
					<i class="icon-list icon-large" style="margin-left: 5px;"></i><div class="error"><?php if ($error) {
                        echo $optionError;
                    } ?></div>
						<select name="option" style="width: 100%;" required >
							<option value="">Select your Profile</option>
							<option value="Lecturer">Lecturer</option>
							<option value="Student">Student</option>
						</select>

						<div class="submit">
							<input type="submit" name="btn-register" value="Register" >
					</div>	
					<p><?php if($res) {

                    if ($option=='Student') {
                        echo '<a  href="../students/">Please Login Here</a>'; 

                    }elseif ($option=='Admin') {

                        echo '<a  href="../Admin/">Please Login Here</a>';  
                    
                        # code...
                    } else{

                      echo '<a href="../lecturers/">Please Login Here</a>';    
                    }
                    
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
			 <!-----//end-main---->
		 <style type="text/css">
		 	.head img{

		 		margin-top: 30px;
		 	}
		 </style>		
</body>
</html>