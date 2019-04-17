<?php
	ob_start();
	session_start();
  $_SESSION['lecturunilorin'];
	require_once '../databaseConnect.php';
// if session is not set this will redirect to login page
  if( !isset($_SESSION['lecturunilorin']) ) {
    $_SESSION['not_logged_in']="You must Log In to Continue";
    header("Location: ../lecturers");
    exit();
  }
	// select loggedin users detail
	$res=mysql_query("SELECT * FROM lecturers WHERE lec_id=".$_SESSION['lecturunilorin']);
	$userRow=mysql_fetch_array($res);

    if(isset($_POST['submit'])){

    $fname=trim($_POST['fname']);
    $fname=strip_tags($_POST['fname']);
    $fname=htmlspecialchars($_POST['fname']);
    $sname=trim($_POST['sname']);
    $sname=strip_tags($_POST['sname']);
    $sname=htmlspecialchars($_POST['sname']);
    $phone=trim($_POST['phone']);
    $phone=strip_tags($_POST['phone']);
    $phone=htmlspecialchars($_POST['phone']);
    $email=trim($_POST['email']);
    $email=strip_tags($_POST['email']);
    $email=htmlspecialchars($_POST['email']);
    $dob=trim($_POST['dob']);
    $dob=strip_tags($_POST['dob']);
    $dob=htmlspecialchars($_POST['dob']);
    $option1=$_POST['option1'];
    $option2=$_POST['option2'];
    $option3=$_POST['option3'];
    $option4=$_POST['option4'];
    $option5=$_POST['option5'];


    $update = mysql_query("UPDATE lecturers SET phone_num='$phone', D_of_birth='$dob', qualification='$option3', Religion='$option5', sex='$option1', State_of_origin='$option2', m_status='$option4', Surname='$sname', First_Name='$fname' WHERE lec_id=".$_SESSION['lecturunilorin']);

     header("Location: Lhome.php");
    
}?><?php ob_end_flush(); ?>