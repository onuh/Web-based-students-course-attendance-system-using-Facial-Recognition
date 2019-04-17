<?php

	session_start();
	
	if (!isset($_SESSION['S_Admin'])) {
		$_SESSION['not_logged_in']="You are not Logged In";
		header("Location: ../Admin");
	} 
	if (isset($_GET['logout'])) {
		unset($_SESSION['S_Admin']);
		session_unset();
		session_destroy();
		header("Location: ../Admin");
		exit;
	}