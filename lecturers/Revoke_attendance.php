
<?php ob_start();
	session_start();
	$_SESSION['lecturunilorin'];

	if( !isset($_SESSION['lecturunilorin']) ) {
	$_SESSION['not_logged_in']="You must Log In to Continue";
    header("Location: ../lecturers");
    exit();
  }elseif (isset($_POST['student_id'])) {

	require_once '../databaseConnect.php';

	$student_id=$_POST['student_id'];
	$course_code=$_SESSION['attendCourseSelect'];
	$prev_attendance= $_SESSION['attendance'];
	$prev_last_attendance_time=  $_SESSION['last_attendance_time'];

$RevokeUpdate=mysql_query("UPDATE attendance_history SET attendance='$prev_attendance',last_attendance_time='$prev_last_attendance_time' WHERE course_code='$course_code' AND att_id='$student_id'");
$RevokeUpdate1=mysql_query("UPDATE student_course_attendance SET last_attendance_time='$prev_last_attendance_time',attendance='$prev_attendance' WHERE course_code='$course_code' AND att_id='$student_id'");

	}
	
unset( $_SESSION['last_attendance_time']); unset($_SESSION['attendance']);
ob_end_flush();
?>