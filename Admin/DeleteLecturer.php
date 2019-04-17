<?php
session_start();
$_SESSION['S_Admin'];
require_once '../databaseConnect.php';
if( !isset($_SESSION['S_Admin']) ) {
	$_SESSION['not_logged_in']="You must Log In to Continue";
    header("Location: ../Admin");
    exit;
  }
	$lec_id=$_GET['lec_id'];
	$getProfilePicString=mysql_query("SELECT profile_pic FROM lecturers where Lec_id='$lec_id'");
	$ProfilePicStringrow=mysql_fetch_array($getProfilePicString);
	@unlink('../upload/'.$ProfilePicStringrow['profile_pic']);

$CourseDelete = mysql_query("delete from lecturers where lec_id='$lec_id'") or die(mysql_error());
$updateCourseBindings= mysql_query("UPDATE courses SET lec_id='' WHERE lec_id='$lec_id'");

if ($CourseDelete) {
	
	$_SESSION['DeleteLecturer'] = "Lecturer was Removed Successfully.";
}

header('location:lecturer.php');
?>