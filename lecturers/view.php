<?php session_start();
$_SESSION['lecturunilorin'];
require_once '../databaseConnect.php';
if( !isset($_SESSION['lecturunilorin']) ) {
	$_SESSION['not_logged_in']="You must Log In to Continue";
    header("Location: ../lecturers");
    exit();
  }else{
 	$_SESSION['view']=$_SESSION['coursesCode'];
 	if (empty($_SESSION['view'])) {
 		
 		$_SESSION['choose']="select";
 	}
 	
  	header('location:Lhome.php#');

  }
  ?>