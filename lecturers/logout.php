<?php

	session_start();
	
	if (!isset($_SESSION['lecturunilorin'])) {
		$_SESSION['not_logged_in']="You are not Logged In";
		header("Location: ../lecturers");
	} 
	
	if (isset($_GET['logout'])) {
		unset($_SESSION['lecturunilorin']);
		session_unset();
		session_destroy();
		header("Location: ../lecturers");
		exit();
	}