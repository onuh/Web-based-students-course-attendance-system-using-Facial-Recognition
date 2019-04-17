<?php
ob_start();
$failedLogin=false;

function ae_nocache(){
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
         header("last-modified:".gmdate("D, d M Y H:i:s")."GMT");
         header("cache-control:no-store, no-cache, must-revalidate, max-age=0");
         header("cache-control:post-check=0, pre-check=0", false);
         header("pragma:no-cache");
 }
 ae_nocache();
 //list($usec,$sec)=explode("", microtime());
 //echo $sec.'.'.$usec;
	

  session_start();
  if(isset($_SESSION['recognition'])){

    $failedLogin=true;
    unset($_SESSION['recognition']);
    
  }
  if(isset($_SESSION['registration'])){

    $failedreg=true;
    unset($_SESSION['registration']);
    
  }
  if(isset($_SESSION['train'])){

    $failedtrain=true;
    unset($_SESSION['train']);
    
  }
	$_SESSION['S_Admin'];
  $_SESSION['home']="Admin home page";
	require_once '../databaseConnect.php';
// if session is not set this will redirect to login page
  if( !isset($_SESSION['S_Admin']) ) {
    $_SESSION['not_logged_in']="You must Log In to Continue";
    header("Location: ../Admin");
    exit;
  }
	// select loggedin admin detail
	$res=mysql_query("SELECT * FROM admin WHERE Admin_id=".$_SESSION['S_Admin']);
	$userRow=mysql_fetch_array($res);
	//echo $userRow['Surname'];
	$_SESSION['editA']=$userRow['S_name'];
    $name=$userRow['Admin_id'];
    //echo $userRow['First_Name'];

//
    if (isset($_POST['editCourse']) && !isset($_SESSION['courses'])){

    $course_id = $_POST['course_id'];
    $course_title = trim($_POST['course_title']);
    $course_title = strip_tags($_POST['course_title']);
    $course_title = htmlspecialchars($_POST['course_title']);
    $course_code = trim($_POST['course_code']);
    $course_code = strip_tags($_POST['course_code']);
    $course_code = htmlspecialchars($_POST['course_code']);

     $updateCourse = mysql_query ("UPDATE courses SET course_title='$course_title', course_code='$course_code' WHERE course_id=".$course_id);
     $updateCourseattendance= mysql_query ("UPDATE student_course_attendance SET course_title='$course_title', course_code='$course_code' WHERE course_id=".$course_id);
     //echo $course_id;
     if (!$updateCourse) {
      $_SESSION['FupdateCourse'] = "Failed to Update Record.";
       # code...
     }else{

       $_SESSION['FUpdateSuccess']= "Course Updated Successfully.";
     }

      header("location:courses.php");
  //echo $course_id;

  }
  
     

    
                    if(isset($_POST['Add_course'])){

                            $NcourseTitle = trim($_POST['NcourseTitle']);
                            $NcourseTitle=strip_tags($NcourseTitle);
                            $NcourseTitle=htmlspecialchars($NcourseTitle);
                            $NcourseCode=trim($_POST['NcourseCode']);
                            $NcourseCode=strip_tags($NcourseCode);
                            $NcourseCode=htmlspecialchars($NcourseCode);

                            $stcCode=mysql_query("SELECT course_code FROM courses");
                            $codeArray = array();
                              while($course_codeRow=mysql_fetch_array($stcCode, MYSQL_ASSOC)){

                                $codeArray[]=$course_codeRow['course_code'];
                              }


                        if (in_array($NcourseCode, $codeArray)) {
                          $_SESSION['SameCode']="You Cannot Register Course Code that Already exists. Please Choose a different Course Code.";
                        }elseif (empty($NcourseTitle) || empty($NcourseCode)) {

                              $_SESSION['No_course'] = "You Must Enter a Valid Course Title and Course Code.";
                            }else{

                        $insertquery = "INSERT INTO courses(course_title,course_code) VALUES('$NcourseTitle','$NcourseCode')";
                        $rows = mysql_query($insertquery); 

                        $_SESSION['Course_success'] = "Course Added Successfully.";

                          }

                      header("Location: courses.php");
                    }


  
?>

<!--[if IE 8 ]>    <html class="ie ie8 no-js" lang="en"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en"><!--<![endif]-->
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta http-equiv="cache-control" content="no-cache" > 
        <meta http-equiv="pragma" content="no-cache">
        <title>Futminna Admin | Admin Home Panel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="Computer Engineering Department Futminna" />
        <meta name="keywords" content= />
        <meta name="Korede Ezikiel Ojeyemi" content="Attendance system" />
        <link rel="shortcut icon" href="../images/favicon.ico"> 
        
        <link rel="stylesheet" media="all" href="../css/font-awesome.min.css">

        <link href="../css/simple-sidebar.css" rel="stylesheet">
        
        <link href="<?php if(isset($_SESSION['courses']) || isset($_SESSION['Lecturer']) || isset($_SESSION['student']) ){ echo '../css/bootstrap1.css';}else{ echo '../assets/css/bootstrap.min.css';} ?>" rel="stylesheet" media="">
        <link rel="stylesheet" type="text/css" href="../css/DT_bootstrap.css" />
        <!--script type="text/javascript" src="../js/jquery.min.js"></script-->
        <script src="../js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
        


        <!--script type="text/javascript" src="../js/validator.min.js"></script-->
        <script type="text/javascript" charset="utf-8" language="javascript" src="../js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8" language="javascript" src="../js/DT_bootstrap.js"></script>
        <!--script type="text/javascript" src="../js/detect_face.js"></script-->
        <!--link href="css/simple-sidebar.css" rel="stylesheet"-->
		<!--script type="text/javascript" src="js/modernizr.custom.86080.js"></script-->
         <!--script type="text/javascript">
            $(window).load(function(){
                $('#content').hide();

    });
   
</script-->
       
        <!--script type="text/javascript" src="js/script.js"></script-->
        <style>
        .navbar-fixed-top{

        background-color: #2F0916;
        border-bottom: 2px solid #DDA0DD;
       
      }
      .dropdown{

         background-color:  #2F0916;
         margin-right: 0px;
      }
      
      .dropdown-menu ul{
        background-color:  #B9E9FF;
        float: right;

      }
      table{

        width: 40%;
        column-width: 10px;
        margin-right: 20px;
      }
      th{

        width: 10px;
      }

      </style>
        
    </head>
    <body>

 
        <style>
            #sidebar-wrapper{

                
                border-radius: 0px;
                background-color: #2F0916;
                margin-top: 50px;
                margin-right: 10px solid #CCFFFF;

            }
            #sidebar-wrapper li{

                margin-left: 45px;
                margin-right: 70px;
                font-family: 'Perpetua Titling MT';

            }

            body{

                 background-color: #eee;
            }
            .upload-preview{

                margin-top: 25px;
                margin-left: -25px;
            }
             #rect {
                       background-color:#fff;
                       border:2px solid #DDA0DD;
                       height:150px;
                       
                       margin-top:30%;
                        width:150px;
                    }
                    
                   

                    .AdminWorkview{


                      margin-left: 10%;
                      margin-right: 20%;
                      margin-top: -500px;
                      position: absolute;
                      height: auto;
                      max-height: 80%;
                      width: 80%;
                      font-family: 'Segoe UI Semilight';
                    }
                    .school-name{

                          
                          margin-top: -40px;
                          padding: 5px;
                          position: absolute;
                          font-style: bold;
                          font-family: Arial Narrow;
                          color: #fff; 
                          width: 300px;


                        }

                    
                    
        </style>
         

        <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
            <ul class="nav navbar-nav navbar-center">
             <img src="../images/badge2.jpg" style="<?php if(isset($_SESSION['student']) || isset($_SESSION['Lecturer']) || isset($_SESSION['courses']) ){ echo 'margin-left:-115px; height:50px;'; } else{ echo 'margin-left:-15px;  height:50px;'; }?> ">
            <div class="school-name" style="<?php if(isset($_SESSION['student']) || isset($_SESSION['Lecturer']) || isset($_SESSION['courses']) ){ echo 'margin-left:-55px;'; } else{ echo 'margin-left: 45px;'; }?> >">Federal University of Technology, Minna</div>
            <form action="../Admin/Face_System.php" method="POST">
            <button type="submit" name="recognition" value="" style="margin-left:20%; margin-top:-2.5%; position:absolute; border:1px solid #fff; border-radius:2px; display:<?php if(isset($_SESSION['student']) || isset($_SESSION['Lecturer']) || isset($_SESSION['courses']) ){ echo "none;"; }?>">Recognition system</button>
            <button type="submit" name="registration" value="" style="margin-left:32%; margin-top:-2.5%; position:absolute; border:1px solid #fff; border-radius:2px; display:<?php if(isset($_SESSION['student']) || isset($_SESSION['Lecturer']) || isset($_SESSION['courses']) ){ echo "none;"; }?>">Registration system</button>
            <button type="submit" name="train" value="" style="margin-left:44%; margin-top:-2.5%; position:absolute; border:1px solid #fff; border-radius:2px; display:<?php if(isset($_SESSION['student']) || isset($_SESSION['Lecturer']) || isset($_SESSION['courses']) ){ echo "none;"; }?>">Training system</button>
            </form>
        </ul>
            
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <span class="glyphicon glyphicon-user"></span>&nbsp; Welcome Admin  <?php echo $userRow['F_name']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a  href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Log Out</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
     </div>
    </nav> 
<!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        <img src="../upload/<?php if (empty($userRow['picture'])) {
                    echo "images.jpg";# do nothing
                } else{ echo $userRow['picture'];}?>" width="150px" height="150px" class="upload-preview" id="rect">
                    </a>
                </li>
                <br/><br/><br/><br/><br/><br/><br/>
                <?php if(isset($_SESSION['courses']) || isset($_SESSION['Lecturer']) || isset($_SESSION['student']) ){echo '<li>
                    <a href="Adhome.php">&emsp;&emsp;Home<i class="icon icon-home" style="margin-left: -100px;"></i></a>
                </li>';}?>
                <li>
                    <a href="AdminP.php">&ensp;Edit Profile<i class="icon icon-edit" style="margin-left: -150px;"></i></a>
                </li>
                <li>
                    <a href="Lecturer.php">&emsp;Lecturers<i class="icon icon-group" style="margin-left: -135px;"></i></a>
                </li>
                <li>
                    <a href="student.php" id="" >&emsp;Students<i class="icon icon-group" style="margin-left: -130px;"></i></a>
                </li>
                     <li>
                    <a href="courses.php">&emsp;Courses<i class="icon icon-book" style="margin-left: -120px;"></i></a>
                </li>
               
            </ul>

        </div>

        
        

        <!-- /#sidebar-wrapper -->
<script src="../assets/js/bootstrap.min.js"></script>
<!--link rel="stylesheet" href="../assets/css/bootstrap.min.css" type="text/css"  /-->

    <style type="text/css">
   #lecturers{

margin-left: 450px;
margin-top: -500px;
overflow-y: auto;
height: 500px;

   }
  {

    width: 250px;
   }
#students{

margin-left: 450px;
margin-top: -500px;
overflow-y: auto;
height: 500px;

}
#courses{

margin-left: 450px;
margin-top: -550px;
overflow-y: auto;
height: 500px;

}
th{
  width: auto;
}
.table{

  width: 80%;
}
.row-fluid{

   width: 80%;
}
.alert-info{

   width: 74.5%;
   background-color: #2F0916;
}
.Warning{

  color: red;
  font-style: italic;
 
}
.Success{

  color: green;
  font-style: italic;
 
}
button{
           
            font-family: 'Raleway', sans-serif;
            color: #fff;
            margin-bottom: 10px;
            background-color: #2F0916;
            padding: 7px 15px;
            display: block;
            border: none;
            border-radius: 2px;
            font-size: 14px;
            margin-right: 10px;
            
            }
            button:hover{
            cursor: pointer;
            background:#2F0923;
            }
            .No_course{

                color: red;
                padding-bottom: 5px;

            }
            
</style>



<?php if (isset($_SESSION['Lecturer'])) { unset($_SESSION['home']);

 ?>
<div id="lecturers">
  <?php if (isset($_SESSION['DeleteLecturer'] )) {
 echo '<div class="Success">'.$_SESSION['DeleteLecturer'].'</div>';
} ?>
  <table cellpadding="0" cellspacing="0" border="0" border-radius= "5px" class="table  table-bordered" id="example">
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-user icon-large"></i>&nbsp;<em>Lecturers Table</em></strong>
                                </div>
                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Surname</th>                                                        
                                        <th>Take Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 
                                  <?php $user_query=$query = mysql_query("SELECT *FROM lecturers");
                                    while($row=mysql_fetch_array($user_query)){
                                    $lec_id=$row['Lec_id']; ?>
                                     <tr class="del<?php echo $lec_id ?>">
                                    <td><?php echo $row['First_Name']; ?></td> 
                                    <td><?php echo $row['Surname']; ?></td>
                                    <td width="5">


                                        <a rel="tooltip"  title="Delete" id="" href="DeleteLecturer.php<?php echo '?lec_id='.$lec_id; ?>" class="btn btn-danger"><i class="icon-trash icon-large"></i></a>
                                        <!--?php include('delete_student_modal.php'); ?-->
                   
                    <!--?php include('Edit_course_modal.php'); ?-->
                                    </td>
                                    
                                         <!-- Modal edit user -->
                                
                                    </tr>
                                    <?php } ?>
                           
                                </tbody>
                            </table>
  
</div>
<?php } unset($_SESSION['Lecturer']); unset($_SESSION['DeleteLecturer']); ?>


<?php if (isset($_SESSION['student'])) { unset($_SESSION['home']); ?>

<div id="students">
  <table cellpadding="0" cellspacing="0" border="0" border-radius= "5px" class="table  table-bordered" id="example">
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-user icon-large"></i>&nbsp;<em>Students Table</em></strong>
                                </div>
                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Surname</th>
                                        <th>Level</th>
                                        <th>Matric Number</th>
                                        <th>Take Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 
                                  <?php $user_query1=$query1 = mysql_query("SELECT *FROM students");
                                    while($row1=mysql_fetch_array($user_query1)){
                                    $id1=$row1['stu_id']; if ($row1['status']==0) {
                                      $type="icon-unlock";
                                    }else{$type="icon-lock";} ?>
                                     <tr class="del<?php echo $id1 ?>">
                                    <td><?php echo $row1['First_Name']; ?></td> 
                                    <td><?php echo $row1['Surname']; ?></td>
                                    <td><?php echo $row1['Level']; ?></td>
                                    <td><?php echo $row1['Mat_no']; ?></td>
                                    <td width="20">

                                        <a rel="tooltip"  title="Remove Student from System" id="" href="#Remove_student<?php echo $id1; ?>" data-toggle="modal" class="btn btn-danger"><i class="icon-trash icon-large"></i></a>
                                        <!--?php include('delete_student_modal.php'); ?-->
                    <a  rel="tooltip"  title="<?php if($row1['status']==0){ echo "Suspend Student for Impersonation";}else{echo "Release Student from Suspension";}?>" id="" href="Action.php<?php echo '?student_id='.$id1.'&'.'key1='.'QxzderXStybgfdUIT5MHYFDSkjhgfreuyDFRghVcXzWERTfSaOUUVVrRCkkhGFdBjkrRRtF4%$d268HhfLJhhfdvreswfvxvnDSeeWqIuYtRybOHFUIGYUrhvhfyuGFuyretdhjkFHgffGHGHFgcdrg54mhytrewqphgrTTdfrpUYbNMresGljlkhkgiftsdrfyiuoirtrsryguiyyifhfudfhjlkfcgkhljkdfghkhgfhklkjhgfghjklkjhgfghjklkjhgfghjk789770HvhfFgjkFHddh'.'&'.'key2='.'QxzderXStybgfdUIT5$MHYFDSkjhgfreuyDFRghVcXzWERTfSaOUUVVrRCkkhGFdBjkrRRtF4%$d268HhfLJhhfdvreswfvxvnDSeeWqIuYtRybOHFUIGYUrhvhfyuGFuyretdhjkFHgffGHGHFgcdrg54mhytrewqphgrTTdfrpUYbNMresGljlkhkgiftsdrfyiuoirtrsryguiyyifhfudfhjlkfcgkhljkdfghkhgfhklkjhgfghjklkjhgfghjklkjhgfghjk789770HvhfFgjkFHddh'.'&'.'type='.$type.'&'.'key3='.'QxzderXStybgfdUIT5$MHYFDSkjhgfreuyDFRghVcXzWERTfSaOUUVVrRCkkhGFdBjkrRRtF4%$d268HhfLJhhfdvreswfvxvnDSeeWqIuYtRybOHFUIGYUrhvhfyuGFuyretdhjkFHgffGHGHFgcdrg54mhytrewqphgrTTdfrpUYbNMresGljlkhkgiftsdrfyiuoirtrsryguiyyifhfudfhjlkfcgkhljkdfghkhgfhklkjhgfghjklkjhgfghjklkjhgfghjk789770HvhfFgjkFHddh'; ?>"  class="btn btn-success"><i class="<?php echo $type." "."icon-large";?>"></i></a>
                    <?php include('delete_student_modal.php'); ?>
                                    </td>
                                    <?php  ?>
                                         <!-- Modal edit user -->
                                
                                    </tr>
                                    <?php } ?>
                           
                                </tbody>
                            </table>
  
  
</div>
<?php } unset($_SESSION['student']); ?>

<?php if (isset($_SESSION['courses'])) { unset($_SESSION['home']); ?>
<div id="courses">

  <?php if ($_SESSION['FupdateCourse']) {
    echo '<div class="Warning">'.$_SESSION['FupdateCourse'].'</div>';
    # code...
  }else{

    echo '<div class="Success">'.$_SESSION['FUpdateSuccess'].'</div>';
  } unset($_SESSION['FupdateCourse']); unset($_SESSION['FUpdateSuccess']); ?>
  <?php if ($_SESSION['DeleteSuccess']) {
    echo '<div class="Success">'.$_SESSION['DeleteSuccess'].'</div>';
  } unset ($_SESSION['DeleteSuccess']);?>
  <?php if (isset($_SESSION['No_course'])) {

                                  echo'<div class="Warning" style="position:; margin-top:;">'. $_SESSION['No_course'].'</div>';
                                }elseif (isset( $_SESSION['SameCode'])) {
                                  echo'<div class="Warning" style="position:; margin-top:;">'. $_SESSION['SameCode'].'</div>';
                                }else{ echo'<div class="Success" style="position:; margin-top:;">'. $_SESSION['Course_success'].'</div>';} if (isset($_SESSION['No_course'])) { unset($_SESSION['No_course']);}if (isset($_SESSION['SameCode'])) { unset($_SESSION['SameCode']);} if (isset($_SESSION['Course_success'])) { unset($_SESSION['Course_success']);} ?>
                                 <form method="POST" action="Adhome.php" id="add" data-toggle="validator" role="form">
                                <input type="text" name="NcourseTitle" id="" class="form-control" placeholder="Type a New Course Title here" style="width: 250px; text-align: left;" maxlength="50" value="" required />&emsp;&emsp;&emsp;
                                <input type="text" name="NcourseCode" id="" class="form-control" placeholder="Course Code" style="width: 150px; text-align: left;" maxlength="6" value="" required />
                                <button id="" type="submit" name="Add_course" class="form-control" form="add">Add Course</button>
                                
                                
                                </form>
  <table cellpadding="0" cellspacing="0" border="0" border-radius= "5px" class="table  table-bordered" id="example">
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>

                                    <strong><i class="icon-user icon-large"></i>&nbsp;<em>Courses Table</em></strong>
                                </div>

                                
                                
                                <thead>
                                    <tr>
                                        <th>Course Title</th>
                                        <th>Course Code</th>                                                        
                                        <th>Take Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 
                                  <?php $user_query2=$query2 = mysql_query("SELECT *FROM courses");
                                    while($row2=mysql_fetch_array($user_query2)){
                                    $course_id=$row2['course_id']; ?>
                                     <tr class="del<?php echo $course_id ?>">
                                    <td><?php echo $row2['course_title']; ?></td> 
                                    <td><?php echo $row2['course_code']; ?></td>
                                    <td width="5">


                                        <a rel="tooltip"  title="Delete course" id="" href="DeleteCourse.php<?php echo '?course_id='.$course_id; ?>" class="btn btn-danger"><i class="icon-trash icon-large"></i></a>
                                        <!--?php include('delete_student_modal.php'); ?-->
                    <a  rel="tooltip"  title="Edit course" id="e<?php echo $course_id; ?>" href="#Edit_course<?php echo $course_id; ?>" data-toggle="modal" class="btn btn-success"><i class="icon-edit icon-large"></i></a>
                    <?php include('Edit_course_modal.php'); ?>
                                    </td>
                                    
                                         <!-- Modal edit user -->

                                
                                    </tr>
                                    <?php } ?>
                           
                                </tbody>
                            </table>
  
</div>
               
<?php  } unset($_SESSION['courses']);   ?>


<?php if (isset($_SESSION['home'])) { ?>



        <div class="AdminWorkview">

<div style="border:1px #e8e8e8 solid;  box-shadow: 1px 1px 40px 5px  #2F0916; margin:-50px 0px 10px 200px">
    <div style="border-bottom:1px #e8e8e8 solid;background-color:grey;padding:8px;font-size:20px;font-weight:700;color:#45484d;">
     RESPONSIBILY OF SYSTEM ADMINS <div style="float: right; font-size: 12px;"><b>Admin Name:</b>  <?php echo $userRow['F_name']."  ".$userRow['S_name']; ?><br/><b>Mobile:</b><?php echo $userRow['phone_number']; ?></div></div>
    <div style="padding:8px;font-size:18px;">
      <p style="font-style: justify; font-family: Arial Narrow; margin-left: 5%; font-size: 18px;">The Systems Admins are saddled with the responsibility of managing the facial detection and recognitin system, the lecturers and students. In addition, Admins are expected to recieve all the lists of courses offered by the department and upload them to the database. Great care must be taken to avoid mistakes in spellings of course titles and course codes.<br> Admins should take deleting a course added as the last resort as students are likely to have registered the course and even had several attendance recorded for such courses. However, there is provisions for editing a previously added course. Admins should <b>NOT</b> on any occassion <b>EDIT</b> course codes as they are unique. Admins are at liberty to <b>DELETE</b> the accounts of both lecturers and students who are no longer member of the institution.<br> A lecturer who have been found to take attendance to favor some certain student to the detriment of others, his/her account <b>SHOULD</b> be suspended bases on approval from the <b>HEAD OF DEPARTMENT</b> or any other <b>HIGHER AUTHORITY</b> in the school governing body. <br>Please adhere strictly to this instructions.<br> You may in addition recieve constant calls from the lecturers to restart the <b>FACE RECOGNIZER</b>, this is because, students faces are not correctly recognised due to inadequate or improper training by the system, Please keep your phone line registerd with the system active. This is for easy attendance taking for the day. Thanks</p><div style="float: right;"><a href="https://www.facebook.com/akoredeezekiel.ojeyemi" target="_blank">Korede Ojeyemi</a></div><br>
</div>
  </div>
        </div>

        <?php } ?>

       

    </body>
    
    <style>
                   
                    footer {
                        margin-top: -100px;
                       
                        display: block;
                        color: ;
                        width: 100%;
                        font-size: 14px;
                        position: fixed;
                        background-color: #2F0916;
                        bottom: 0px;
                        text-align: center;
                        text-decoration: none;
                        border-top: 2px solid #DDA0DD;
                        border-radius: none;
                        padding: 10px;
                        color: #fff;
                    }
    </style>
    <footer>Department of Computer Engineering - Futminna &copy; 2018. All Rights Reserved Final Year Project. Developed by <a href="https://www.facebook.com/akoredeezekiel.ojeyemi" target="_blank">Korede Ojeyemi</a></footer> 

     <script src="../js/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="../css/sweetalert.css">
    <?php if ($failedLogin):?>
    <script language="Javascript">
       swal({ title: "PLEASE WAIT...",
          text: "Face Recognition services is starting",
          type: "info",
          timer: 35000,
          showConfirmButton: false,
       },
       function(){
        swal("RESPONSE", "Face Recognition System Started Successfully!", "success")
          });
    </script>
     <?php endif ?>
     <?php if ($failedreg):?>
    <script language="Javascript">
       swal({ title: "PLEASE WAIT...",
          text: "Face Registration services is starting",
          type: "info",
          timer: 35000,
          showConfirmButton: false,
       },
       function(){
        swal("RESPONSE", "Face Registration System Started Successfully!", "success")
          });
    </script>
     <?php endif ?>
     <?php if ($failedtrain):?>
    <script language="Javascript">
       swal({ title: "PLEASE WAIT...",
          text: "System Training will Commence shortly",
          type: "info",
          timer: 35000,
          showConfirmButton: false,
       },
       function(){
        swal("RESPONSE", "Training of system with Faces in database started Successfully!", "success")
          });
    </script>
     <?php endif ?>
    </html>
    <?php  ob_end_flush(); ?>
    