<?php 
session_start();
$_SESSION['S_Admin'];

if (!$_SESSION['S_Admin']) {
	$_SESSION['not_logged_in']="You must Log In to Continue";
	header("location:../Admin");
}else{

	$_SESSION['Lecturer'] = "displaying_all_lecturers";
	header("location:Adhome.php");
}




?>