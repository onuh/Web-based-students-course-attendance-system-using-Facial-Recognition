<?php
ob_start();
	session_start();
	$_SESSION['S_Admin'];
	require_once '../databaseConnect.php';

$filename = 'pic_'.date('YmdHis') . '.jpeg';
if(is_array($_FILES)) {
	if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
		$sourcePath = $_FILES['userImage']['tmp_name'];
		$targetPath = "../upload/$filename";
		if(move_uploaded_file($sourcePath,$targetPath)) {
?>
			<img src="<?php echo $targetPath; ?>" width="150px" height="150px" class="upload-preview" />
<?php
		}
	}
}
	// select loggedin users detail
	$res=mysql_query("SELECT picture, Email FROM students WHERE Admin_id=".$_SESSION['S_Admin']);
	$userRow=mysql_fetch_array($res);
	//echo $userRow['profile_pic'];
	$oldPic = $userRow['picture'];
	$update = mysql_query("UPDATE students SET picture='$filename' WHERE Admin_id=".$_SESSION['S_Admin']);
	$file_path = '../upload/';
    $src = $file_path.$oldPic;
    @unlink($src);

    
	ob_end_flush();?> 