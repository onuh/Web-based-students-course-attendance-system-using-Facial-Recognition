<?php 
session_start();
$_SESSION['S_Admin'];

if (!$_SESSION['S_Admin']) {
	$_SESSION['not_logged_in']="You must Log In to Continue";
	header("location:../Admin");
}else{

	$_SESSION['courses'] = "displaying_all_courses";
	header("location:Adhome.php");
}




?>