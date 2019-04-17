<?php
session_start();
$_SESSION['lecturunilorin'];
require_once '../databaseConnect.php';
if( !isset($_SESSION['lecturunilorin']) ) {
$_SESSION['not_logged_in']="You must Log In to Continue";
    header("Location: ../lecturers");
    exit();
  }
$course_id=$_GET['course_id'];
$id="";

$CourseDelete = mysql_query("UPDATE courses SET lec_id='$id' WHERE course_id='$course_id'") or die(mysql_error());

if ($CourseDelete) {
	mysql_query("UPDATE student_course_attendance SET lec_id='0' WHERE course_id='$course_id'");
	$_SESSION['CourseUnbound'] = "The Course was Unbound Successfully.";
}

header('location:bindcourses.php');
?>