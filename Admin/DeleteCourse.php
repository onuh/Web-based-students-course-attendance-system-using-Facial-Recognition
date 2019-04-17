<?php
session_start();
$_SESSION['S_Admin'];
require_once '../databaseConnect.php';
if( !isset($_SESSION['S_Admin']) ) {
	$_SESSION['not_logged_in']="You must Log In to Continue";
    header("Location: ../Admin");
    exit;
  }
$course_id=$_GET['course_id'];

$CourseDelete = mysql_query("delete from courses where course_id='$course_id'") or die(mysql_error());

if ($CourseDelete) {
	
	$_SESSION['DeleteSuccess'] = "The Course was Removed Successfully.";
}

header('location:courses.php');
?>