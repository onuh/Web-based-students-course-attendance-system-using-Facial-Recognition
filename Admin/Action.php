<?php
session_start();
$_SESSION['S_Admin'];
require_once '../databaseConnect.php';
if( !isset($_SESSION['S_Admin']) ) {
	$_SESSION['not_logged_in']="You must Log In to Continue";
    header("Location: ../Admin");
    exit;
  }
$student_id=$_GET['student_id'];
$type=$_GET['type'];
echo $type.'<br/>';
echo $student_id;

if ($type=="icon-unlock") {
	$UpdateSuspendOrRelease = mysql_query("UPDATE students SET status='1' WHERE stu_id='$student_id'") or die(mysql_error());
}else{
	$UpdateSuspendOrRelease = mysql_query("UPDATE students SET status='0' WHERE stu_id='$student_id'") or die(mysql_error());
}
if ($type!="icon-unlock" || "icon-lock") {

	//$student_id=$_POST['id1'];
	//echo "We are set to remove the student with ID ".$type." from the Database";
	$getProfilePicString=mysql_query("SELECT profile_pic FROM students where stu_id='$type'");
	$ProfilePicStringrow=mysql_fetch_array($getProfilePicString);
	@unlink('../upload/'.$ProfilePicStringrow['profile_pic']);
	$StudentDelete = mysql_query("DELETE FROM students where stu_id='$type'") or die(mysql_error());
	$StudentDelete = mysql_query("DELETE FROM student_course_attendance where att_id='$type'") or die(mysql_error());
	$StudentDelete = mysql_query("DELETE FROM attendance_history where att_id='$type'") or die(mysql_error());
	$mask="User.".$type.'*.*';
	@array_map('unlink', glob('../students/Database/'.$mask));
	@array_map('unlink', glob('../students/Detected_Face/'.$mask));
}


header('location:student.php');
?>