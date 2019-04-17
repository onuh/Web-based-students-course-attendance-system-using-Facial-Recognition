<?php
session_start();
if( !isset($_SESSION['lecturunilorin']) ) {
    $_SESSION['not_logged_in']="You must Log In to Continue";
    header("Location: ../lecturers");
    exit();
  }

$_SESSION['Attendance']="Database_Checked";
$file="../students/Output.txt";
$f=fopen($file, "r") or die('cannot open file:'.$file);
$id=fgets($f);
fclose($f);
//echo $id;

$files=count(glob('../students/Attendance/*.jpg'));

		if ($files==1) {
			if($_SESSION['offline']==0){

				$_SESSION['offline']=1;
			}
			$_SESSION['offline']++;
			echo "Busy <br/>";
			if($_SESSION['offline']<=4){

				$_SESSION['busy']="Face Recognition System is Currently Busy. Please Try Again...";
			}else{

				$_SESSION['busy']="Face Recognition System is Offline. Please Contact the Admin.";
			}
			
			echo $_SESSION['busy'];
			
			//exit();
		}

		if ($files==0){

			unset($_SESSION['offline']);
		}

if (isset($_SESSION['busy']) && !empty($id)) {

	$_SESSION['stu_id']="";
	//echo $_SESSION['stu_id'];
	# code...
}else{
      
      $_SESSION['stu_id']=$id;

      $handle=fopen($file, "w") or die('cannot open file:'.$file);
      $data="";
      fwrite($handle, $data);
	  fclose($handle);

}


header("location:Lhome.php#");

?>