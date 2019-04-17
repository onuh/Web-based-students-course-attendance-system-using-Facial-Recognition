<?php
session_start();
$_SESSION['lecturunilorin'];
if( !isset($_SESSION['lecturunilorin']) ) {
	$_SESSION['not_logged_in']="You must Log In to Continue";
    header("Location: ../lecturers");
    exit();
  }else{


  	$_SESSION['Fetch']="Fetching your courses from Database";
  	header("location:Lhome.php");
  } 
























?>