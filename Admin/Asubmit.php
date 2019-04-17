<?php
	ob_start();
	session_start();
  $_SESSION['S_Admin'];
	require_once '../databaseConnect.php';
// if session is not set this will redirect to login page
  if( !isset($_SESSION['S_Admin']) ) {
    $_SESSION['not_logged_in']="You must Log In to Continue";
    header("Location: ../Admin");
    exit;
  }
	// select loggedin users detail
	$res=mysql_query("SELECT * FROM admin WHERE Admin_id=".$_SESSION['S_Admin']);
	$userRow=mysql_fetch_array($res);

    if(isset($_POST['Asubmit'])){

    $fname=trim($_POST['fname']);
    $fname=strip_tags($_POST['fname']);
    $fname=htmlspecialchars($_POST['fname']);
    $sname=trim($_POST['sname']);
    $sname=strip_tags($_POST['sname']);
    $sname=htmlspecialchars($_POST['sname']);

    $phone=trim($_POST['phone']);
    $phone=strip_tags($_POST['phone']);
    $phone=htmlspecialchars($_POST['phone']);

    

    $updateA = mysql_query("UPDATE Admin SET phone_number='$phone', S_name='$sname', F_name='$fname' WHERE Admin_id=".$_SESSION['S_Admin']);

     header("Location: Adhome.php");
    
}?><?php ob_end_flush(); ?>