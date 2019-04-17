<?php
session_start();

if (isset($_POST['recognition'])){
    
    $file='c:/xampp/htdocs/attendance-system/students/Attendance/*.jpg';



    @array_map('unlink', glob($file));

    
    $recog=pclose(popen('start /B c:\xampp\htdocs\attendance-system\students\Recognition.exe', 'r'));
     
    $_SESSION['recognition']="start";
    //exit();
    header("location:Adhome.php");

  }

  if (isset($_POST['registration'])){

    
    pclose(popen('start /B c:\xampp\htdocs\attendance-system\students\Register.exe', 'r'));
    $_SESSION['registration']="start";
    //exit();
    header("location:Adhome.php");

  }
  if (isset($_POST['train'])){

    
    pclose(popen('start /B c:\xampp\htdocs\attendance-system\students\train.exe', 'r'));
    $_SESSION['train']="start";
    //exit();
    header("location:Adhome.php");

  }
  ?>