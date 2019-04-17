<?php
ob_start();
	//$now= date("s");
	session_start();
	$_SESSION['lecturunilorin'];

	if( !isset($_SESSION['lecturunilorin']) ) {
    $_SESSION['not_logged_in']="You must Log In to Continue";
    header("Location: ../lecturers");
    exit();
  }
	
	require_once '../databaseConnect.php';
	// select loggedin users detail
	$res=mysql_query("SELECT  * FROM lecturers WHERE lec_id=".$_SESSION['lecturunilorin']);
	$userRow=mysql_fetch_array($res);
	$name=$userRow['Surname'];
	$data=$name;
	

	if(isset($_POST['imgBase64'])){

		$rawData = $_POST['imgBase64'];
		$filteredData = explode(',', $rawData);
		
		//$id = $_POST['id'];
		
		$unencoded = base64_decode($filteredData[1]);

		
		
				$randomName = "User".".".$data.'.jpg';
				$path1 = 'C:/Users/VICTOR/Desktop/FaceRecognition_DeepNeuralNetworks-master/Face/' . $randomName;
				//Create the image 
				$fp1 = fopen($path1, 'w');
				fwrite($fp1, $unencoded);
				fclose($fp1);
				clearstatcache();
		

		
		$files=count(glob('../students/Attendance/*.jpg'));

		if ($files==1) {
			echo "Busy <br/>";
			$_SESSION['busy']="Face Recognition System is coming online now. Please wait....";
			echo $_SESSION['busy'];
			
			//exit();
		}else{
	
		$rawData = $_POST['imgBase64'];
		$filteredData = explode(',', $rawData);
		
		//$id = $_POST['id'];
		
		$unencoded = base64_decode($filteredData[1]);

		
		
				$randomName = "User".".".$data.'.jpg';
				$path = '../students/Attendance/' . $randomName;
				//Create the image 
				$fp = fopen($path, 'w');
				fwrite($fp, $unencoded);
				fclose($fp);
				clearstatcache();
		}
		
		# code...
	}
	
	
	

    
	ob_end_flush();?>
