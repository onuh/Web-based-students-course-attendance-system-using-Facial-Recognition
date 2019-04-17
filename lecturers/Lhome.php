<?php
	ob_start();
	session_start();
  $display=true;
  if (isset($_SESSION['Attendance'])) {
     $attendancesession=true;
  }
  $success=false;
  $profileFace=false;
  $Noface=false;
  $Revoke=false;
  $AttendanceSuccess=false;
  $FetchBindedCourses=false;
  $bind_courses=false;
  $AttendanceFailure=false;
  $AttendanceduplicateRevoke=false;
	$_SESSION['lecturunilorin'];
  //$_SESSION['Attendance'];
	require_once '../databaseConnect.php';
  $time= gmdate("d M Y");
  //echo $time;
// if session is not set this will redirect to login page
  if( !isset($_SESSION['lecturunilorin']) ) {
    $_SESSION['not_logged_in']="You must Log In to Continue";
    header("Location: ../lecturers");
    exit();
  }
	// select loggedin users detail
	$res=mysql_query("SELECT * FROM lecturers WHERE lec_id=".$_SESSION['lecturunilorin']);
	$userRow=mysql_fetch_array($res);

  if (mysql_num_rows($res)==0) {
    header("Location: ../lecturers");
    exit;
  }

	//echo $userRow['Surname'];
	$_SESSION['editl']=$userRow['Surname'];


  if (isset($_POST['view'])) {

    $_SESSION['coursesCode']=$_POST['ViewCourse'];

      header("location: view.php");

   }
  
  if (isset($_POST['Terminate_attSession'])) {

    unset($_SESSION['attendCourseSelect']);
    unset($_SESSION['total_attendance']);
    header("location:Lhome.php#");
  }

if (isset($_POST['take_attendace'])) { 

         

            $CourseCode=$_POST['AttCourse'];


            $_SESSION['attendCourseSelect']=$CourseCode;

             $coursesHistory=mysql_query("SELECT last_course_attendance_time, total_attendance FROM attendance_history WHERE course_code='$CourseCode'");
              $coursesHistoryRow=mysql_fetch_array($coursesHistory);
              $total_attendance=$coursesHistoryRow['total_attendance'];
              if (empty($total_attendance)) {
                $total_attendance=0;
              }
              $total_attendance=$total_attendance+1;
              $_SESSION['total_attendance']=$total_attendance;
              $last_course_attendance_time=$coursesHistoryRow['last_course_attendance_time'];
              
                if ($time!=$last_course_attendance_time) {
                      
                      $UpdatecoursesHistory1= mysql_query("UPDATE attendance_history SET last_course_attendance_time='$time',total_attendance='$total_attendance' WHERE course_code='$CourseCode'");

                      //$UpdatecoursesHistory2= mysql_query("UPDATE attendance_history SET total_attendance='$total_attendance' WHERE course_code='$CourseCode'");
     
 
                }


            //echo $CourseCode;
    
           
          }
          if (isset($_POST['Bind_course'])) {

           $SelectedCourse= $_POST['stcourse_id'];
           
          // $_SESSION['courseS']=$SelectedCourse;

      $stcourse=mysql_query("SELECT course_title, course_code, lec_id FROM courses WHERE course_id=".$SelectedCourse);

      $stcourseRow=mysql_fetch_array($stcourse);
      $lecturerid=$stcourseRow['lec_id'];
      $course_title=$stcourseRow['course_title'];
      $course_code=$stcourseRow['course_code'];
      $stid=$_SESSION['lecturunilorin'];

      $stcourse1=mysql_query("SELECT course_code FROM courses WHERE lec_id=".$stid);
      $storeArray = array();
      while($stcourseRow1=mysql_fetch_array($stcourse1, MYSQL_ASSOC)){

        $storeArray[]=$stcourseRow1['course_code'];
      }


if (in_array($course_code, $storeArray)) {

  $_SESSION['RepatedCourse']="You Have Already Bound the selected Course Before. Please Select a different Course.";
}elseif (!empty($lecturerid) && $lecturerid !=$stid) {
  $lecCheck=mysql_query("SELECT * FROM lecturers WHERE Lec_id=".$lecturerid);
  $userRowlecCheck=mysql_fetch_array($lecCheck);
  $qualify=$userRowlecCheck['qualification'];
  $Mstatus=$userRowlecCheck['m_status'];
  $gender=$userRowlecCheck['sex'];
  $lecFName= $userRowlecCheck['First_Name'];
  $lecSName= $userRowlecCheck['Surname'];
  $lecPhone= $userRowlecCheck['phone_num'];
  if($gender=="Female"){$pronoun="her";}elseif($gender=="Male"){$pronoun="him";}else{$pronoun="him/her";}
  if($pronoun=="her"){$pronoun1="her";}elseif($pronoun=="him"){$pronoun1="his";}else{$pronoun1="him/her";}
  if ($qualify=="Dr.") {
    $post="Dr.";
  }elseif($qualify=="Prof.") {$post="Prof.";}elseif ($qualify!=="Dr."&&"Prof." && $gender=="Male") {
   $post="Mr.";
  }elseif($gender=="Female" && $Mstatus=="Maried"){$post="Mrs.";}elseif($gender=="Female" && $Mstatus=="Single"||"Divorced" ){
    $post="Miss.";
  }else{$post="";}
  $_SESSION['courseAlreadyBinded']="The course you are trying to bind to yourself is bounded to ".'<b>'.$post." ".$lecFName." ".$lecSName.'</b>'."."."<br/>"."You can contact $pronoun on ".'<b>'.$lecPhone.'</b>'." to get the privilege of taking attendance on $pronoun1 behalf.";
}else{

      
      //mysql_query("UPDATE Admin SET phone_number='$phone', S_name='$sname', F_name='$fname' WHERE Admin_id=".$_SESSION['S_Admin']);
      $bindCourse=mysql_query("UPDATE courses SET lec_id='$stid' WHERE course_id=".$SelectedCourse);
      if (mysql_num_rows($stcourse)!=0) {
       $_SESSION['Bindedcos']= '<div class="Warning" style="margin-top:-480px; margin-left:350px; position:absolute; color:green;">'."Course Binded to you successfully.".'</div>';
       $UpdateStudentLecturersCourse=mysql_query("UPDATE student_course_attendance SET lec_id='$stid' WHERE course_code='$course_code'");
      }else{

           $_SESSION['Bindedcos']= '<div class="Warning alert alert-error fade in error" style="margin-top:-480px; margin-left:350px; position:absolute; color:red;">'.'<button type="button" class="close" data-dismiss="alert">X</button>'."The Course You are trying to Bind to yourself may have been Removed by the Admin.".'</div>';
      }

      

      }
       

  
      header("location: bindcourses.php");

    }

  if (isset($_SESSION['Attendance'])) {

       $success=true;
    if (!empty($_SESSION['stu_id'])) {
                        
                      //echo $_SESSION['stu_id'];
                      $res1=mysql_query("SELECT * FROM students WHERE stu_id=".$_SESSION['stu_id']);
                        $userRow1=mysql_fetch_array($res1);
                        if (mysql_num_rows($res1)==0) {
                         $_SESSION['stu_id']=="";
                          $Noface=true;
                        }elseif (mysql_num_rows($res1)==1) {
                          # code...
                        
                          $face = $userRow1['profile_pic'];
                          $nameF = $userRow1['First_Name'];
                        
                           $nameS = $userRow1['Surname'];
                          $level = $userRow1['Level'];
                         $matric_no = $userRow1['Mat_no'];
                        $profileFace=true;
                        }
                       
                      //echo '<img src=../upload/$image width="150px" height="150px" class="" style="margin-left:300px;"/>';
                      //echo '<div class="">$Surname $firstName.</div>';
                          
                    }else{

                      $Noface=true;
                    }
                    
                   

        

          }
          

?>

<!--[if IE 8 ]>    <html class="ie ie8 no-js" lang="en"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" lang="en"> <![endif]-->
<!--[if gt IE 9]-->  <html class="no-js">      <!--[endif]-->
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <title>Futminna Lecturer | Home</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="Computer Engineering Department Unilorin" />
        <meta name="keywords" content= />
        <meta name="Korede Ezikiel Ojeyemi" content="CPE" />
        <link rel="shortcut icon" href="../images/favicon.ico"> 
        <link href="../css/simple-sidebar.css" rel="stylesheet">
        <link rel="stylesheet" media="all" href="../css/font-awesome.min.css">
        <link href="<?php if(isset($_SESSION['courseBinded']) || isset($_SESSION['Lecturer']) || isset($_SESSION['student']) || isset($_SESSION['view'])  ){ echo '../css/bootstrap1.css';}else{ echo '../assets/css/bootstrap.min.css';} ?>" rel="stylesheet" media="">
        <link rel="stylesheet" type="text/css" href="../css/DT_bootstrap.css" />
         <script src="../js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
        <!--link rel="stylesheet" href="../assets/css/bootstrap.min.css" type="text/css"  /-->
        
        <script type="text/javascript" charset="utf-8" language="javascript" src="../js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8" language="javascript" src="../js/DT_bootstrap.js"></script>
        <!--link href="css/simple-sidebar.css" rel="stylesheet"-->
		<!--script type="text/javascript" src="../js/jquery.min.js"></script-->
        <!--script type="text/javascript">
            $(window).load(function(){
                $('#displayinfo').hide();

    });
   
</script-->
<script type="text/javascript">
  
</script>
       
        <!--script type="text/javascript" src="js/script.js"></script-->
        <script type="text/javascript">
          



        </script>
        <style>
        .navbar-fixed-top{

        background-color:#2F0916;
        border-bottom: 2px solid #DDA0DD;
        
        
      }
      .dropdown{

         background-color: #2F0916;
      }
      </style>


    </head>
    <body>
        <style>
        
  .content{
display: block;
position: relative;
overflow: hidden;
height: 500px;
bottom: -1px;
margin: 0;
margin-left: 300px;
margin-top: -545px;
border-radius: 3px;}

.content video, .content canvas{
display: block;
position: relative;
max-height: 500px;
height: 100%;
margin: auto;
border-radius: 3px;
}

  </style>  
  



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
             #circle {
                       background-color:#fff;
                       border:2px solid  #DDA0DD; 
                       height:150px;
                       border-radius:50%;
                       -moz-border-radius:50%;
                       -webkit-border-radius:50%;
                        width:150px;
                    }
                    .displayinfo{

                        margin-left: 400px;
                        position: absolute;
                        height: 450px auto;
                        width: 800px;
                        margin-top: -500px;
                        font-family: 'Segoe UI Semilight';
                        font-size: 16;
                        background-color: #eee;
                        border-radius: 5px;
                        box-shadow: 1px 1px 40px 5px  #2F0916;
                        display: <?php if (isset($_SESSION['Attendance'])) {
                         echo "none";
                        } ?>;

                    }
                    .stuImg{

                      float: right;
                      margin-right: 200px;
                      margin-top: 150px;

                    }
                    .Noface{

                      float:right;
                      font-style: italic;
                      font-family: Arial Narrow;
                      margin-right: 200px;
                      margin-top: 150px;
                      text-align: center;
                      height: 150px;
                      width: 150px;
                      border:2px solid grey;
                      font-weight: bold;
                      padding: 2px;
                    }
                    .alert-danger{

                      padding-left:5px;
                      padding-right:5px;
                      border-radius:2px;
                    }
                    .alert-success{

                      padding-left:5px;
                      padding-right:5px;
                      border-radius:2px;
                      }
                    .stu_info{

                        float:right;
                        margin-right: -300px;
                        margin-top: 315px;
                        height: 200px;
                        width: 300px;

                        

                    }

                    label{

                        padding: 3px;
                        margin-left: 50px;
                    }
                    l{
                        margin-left: 15em;
                       position: absolute;


                        

                    }
                     #processing{

            
             margin-left: 190px;
             margin-top: 300px;
            background-color: #fff;
            position: absolute;
            text-align: center;
            -webkit-transition: all .2s ease;
            -moz-transition: all .2s ease;
            -o-transition: all .2s ease;
            -ms-transition: all .2s ease;
            transition: all .2s ease;
            z-index: 999;
            border-radius: 3px;
            padding: 5px;
            opacity: 1;
            box-shadow: 1px 1px 40px 5px black;


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
                    
        .GetAttendance{

              
              color: red;
              float: right;
              margin-right: 100px;
              vertical-align: center;
        }
        .Warning{

  color: red;
  font-style: italic;
  position: absolute;
  text-align: center;
  margin-top: -480px;
  margin-left: 26%;
  
  
 
}
.Avail{

  background-color:;
 
  margin-left: 40%;
  font-style: italic; 
 position: absolute;
  margin-top: -550px;
  text-align: center;
  background-color:#DDA0DD;
  border-radius: 3px;
  padding: 10px;
}
.Avail1{

  
  color: #ffffff;
  margin-left: 40%;
  margin-right:285px;
  font-style: italic;
  font-weight: bold; 
 position: absolute;
  margin-top: -550px;
  text-align: center;
  background-color:black;
  border-radius: 2px;
  padding: 10px;
  font-family: 'Perpetua Titling MT';
  font-variant: small-caps;
}

        .AttendanceSuccess{

          color: green;
          font-style: italic;
          text-align: left;
          font-weight:bold;
          font-family: Arial Narrow;
          float: right;
          margin-top: 118px;
          margin-left: 715px;
          position: absolute;
         
        }

        .btn-sm{
                            
                           float: right; 
                           margin-top: 380px;
                           margin-right: -105px;
                           font-style: bold;
                           font-family: Arial Narrow; 
                            border: none;
                             -webkit-transition: all .2s ease;
                             -moz-transition: all .2s ease;
                            -o-transition: all .2s ease;
                            -ms-transition: all .2s ease;
                            transition: all .2s ease;
                            z-index: 9999;}

        .Binded{

          margin-top: -500px;
         
          overflow-y: auto;

    
        }
        .Warning1{

          color: red; 
          margin-top: 106px; 
          text-align: left; 
          font-weight: normal;
          position: absolute;
          float: right;
          margin-left: 715px;
          font-style: italic;
          font-family: Arial Narrow;
        }

       
        </style>

        <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
           <ul class="nav navbar-nav navbar-center">
             <img src="../images/badge2.jpg" style="<?php if(isset($_SESSION['student_courses']) || isset($_SESSION['courseBinded']) || isset($_SESSION['view']) ){ echo 'margin-left:-115px; height:50px;'; } else{ echo 'margin-left:-15px;  height:50px;'; }?> ">
            <div class="school-name" style="<?php if(isset($_SESSION['student_courses']) || isset($_SESSION['courseBinded']) || isset($_SESSION['view'])){ echo 'margin-left:-55px;'; } else{ echo 'margin-left: 45px;'; }?> >">Federal University of Technology, Minna</div>
        </ul>
            
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <span class="glyphicon glyphicon-user"></span>&nbsp; Welcome Home  <?php if ($userRow['qualification']=="Dr." || $userRow['qualification']== "Prof.") {
                    echo $userRow['qualification']." ".$userRow['First_Name'];
                }elseif ($userRow['sex']== "Male") {
                   echo "Mr. ". $userRow['First_Name']; 
                }else{ echo $userRow['First_Name'];}  ?> ! &nbsp;<span class="caret"></span></a>

              <ul class="dropdown-menu">

                <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Log Out</a></li>
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
                        <img src="../upload/<?php if (empty($userRow['profile_pic'])) {
                    echo "images.jpg";# do nothing
                } else{ echo $userRow['profile_pic'];}?>" width="150px" height="150px" class="upload-preview" id="circle">
                    </a>
                </li>
                <br/><br/><br/><br/><br/><br/><br/>
                <?php  if (isset($_SESSION['courseBinded']) || isset($_SESSION['view'])) {echo '<li>
                    <a href="Lhome.php" style="margin-left:25px;margin-right:25px;">&nbsp;Home<i class="icon icon-home" style="margin-left: -100px;"></i></a>
                </li>';} ?>
                <li>
                    <a href="Lprofile.php" style="margin-left:5px;">&nbsp;&nbsp;Edit Profile<i class="icon icon-edit" style="margin-left: -150px;"></i></a>
                </li>
                <li>
                  <?php if (isset($_SESSION['attendCourseSelect'])) {

                        echo '<a href="#" id="hell"  style="margin-left:-20px; margin-right:-35px;">Take Attendance<span class="glyphicon glyphicon-facetime-video" style="margin-left:-10px;"></span></a>';
                    } else{

                        echo '<a href="studentAttendance.php" id="attend"  style="margin-left:-15px; margin-right:-25px;">Take Attendance</a>';
                    }?>
                    
                </li>
                     <li>
                    <a href="bindcourses.php"  style="margin-left:-2px; margin-right:0px;">&nbsp;Bind Courses<i class="icon icon-book" style="margin-left: -160px;"></i></a>
                </li>
                 
               <li>
                    <a href="view.php"  style="margin-left:-5px; margin-right:-10px; ">&nbsp;View Students<i class="icon icon-eye-open" style="margin-left: -170px;"></i></a>
                </li>
            </ul>

        </div>

        <div class="content" id="content">
        
        
            <script type="text/javascript">document.getElementById('content').style.display='none';</script>

            <div id="RevokeSuccess" class="Warning1 alert-danger">Attendance for <?php echo $_SESSION['attendCourseSelect'];?> was <b>REVOKED</b><br>For the student Below.</div>
            <script type="text/javascript">document.getElementById('RevokeSuccess').style.display='none';</script>
            
            <video id="video" width="640" height="480" style="position: absolute; " preload autoplay loop muted></video>

            <?php if ($profileFace):?>
            <img src="../upload/<?php if(isset($_SESSION['Attendance']) && !empty($_SESSION['stu_id'])){
                echo $face;

            } ?>" width="150px" height="150px" class="stuImg"/>

            <?php if (!empty($_SESSION['stu_id'])) {


              $idStudent=$_SESSION['stu_id'];
              $codeCourse=$_SESSION['attendCourseSelect'];
              //echo $codeCourse;

              //$res1=mysql_query("SELECT * FROM students WHERE stu_id=".$_SESSION['stu_id']);

              $FaceHistoryInsert= mysql_query("SELECT attendance, last_attendance_time, course_code FROM attendance_history WHERE att_id='$idStudent' AND course_code='$codeCourse'");
              $userFaceHistoryRow=mysql_fetch_array($FaceHistoryInsert);
              $_SESSION['last_attendance_time']= $userFaceHistoryRow['last_attendance_time'];
              $HistoryTime=$userFaceHistoryRow['last_attendance_time'];
              $_SESSION['attendance']=$userFaceHistoryRow['attendance'];
              $Historyattendance=$userFaceHistoryRow['attendance'];
              $Historyattendance1=$Historyattendance+1;
              $HistoryCcode=$userFaceHistoryRow['course_code'];

              $FaceInsert= mysql_query("SELECT attendance, last_attendance_time, course_code FROM student_course_attendance WHERE att_id='$idStudent' AND course_code='$codeCourse'");
              $userFaceRow=mysql_fetch_array($FaceInsert);
              $Ccode=$userFaceRow['course_code'];

              //$attid=$userFaceRow['att_id'];
              //$attenPresent=$userFaceRow['attendance'];

              $last_attendance_time=$userFaceRow['last_attendance_time'];
              //echo $attenPresent;
              //$attenPresent=$attenPresent+1;

              //echo $attenPresent;
              
                if (!empty($Ccode) && $HistoryTime!=$time) {

                 $UpdateAttendace=mysql_query("UPDATE student_course_attendance SET attendance='$Historyattendance1' WHERE course_code='$codeCourse' AND att_id='$idStudent'");
                $UpdateAttendace=mysql_query("UPDATE student_course_attendance SET last_attendance_time='$time' WHERE course_code='$codeCourse' AND att_id='$idStudent'");
                $UpdateAttendaceHistory=mysql_query("UPDATE attendance_history SET attendance='$Historyattendance1' WHERE course_code='$codeCourse' AND att_id='$idStudent'");
                $UpdateHistoryAttendace=mysql_query("UPDATE attendance_history SET last_attendance_time='$time' WHERE course_code='$codeCourse' AND att_id='$idStudent'");
                }

              $sessiontotal=$_SESSION['total_attendance'];
               mysql_query("UPDATE attendance_history SET total_attendance='$sessiontotal', last_course_attendance_time='$time' WHERE course_code='$codeCourse' AND total_attendance=''");  
                
            } ?>
          <?php if (!empty($Ccode)  && $HistoryTime!=$time) {?>

            <div class="stu_info">

              <b>Name: </b><?php echo $nameS." ".$nameF ?><br/>
              <b>Matric Number: </b><?php echo $matric_no ?><br/>
              <b>Level: </b><?php echo $level ?>
              <?php $Revoke = true; ?>
              <?php $AttendanceSuccess = true; ?>
            </div>
              <?php }elseif($HistoryTime==$time && !empty($Ccode)){ ?>

              <div class="stu_info">

              <b>Name: </b><?php echo $nameS." ".$nameF ?><br/>
              <b>Matric Number: </b><?php echo $matric_no ?><br/>
              <b>Level: </b><?php echo $level ?>
              <?php $AttendanceduplicateRevoke=true; ?>
              
            </div>

            <?php }else{ ?>

            <div class="stu_info">

              <b>Name: </b><?php echo $nameS." ".$nameF ?><br/>
              <b>Matric Number: </b><?php echo $matric_no ?><br/>
              <b>Level: </b><?php echo $level ?>
              <?php $Revoke = false; ?>
              <?php $AttendanceSuccess = false; ?>
              <?php $AttendanceFailure=true; ?>
            </div>





            <?php }?>
            <?php endif ?>
            <?php if ($Noface):?>
            <div class="Noface" style="color: red; text-align: center; padding: 2px; "><br/><?php if (isset($_SESSION['busy'])) {
              echo $_SESSION['busy'];
            }else{ echo "Student's Face Does Not Match Any Face In Face Database."; }?></div>
            <?php endif ?>
            <form action="Lhome.php#" method="POST" >
            <input type="submit" id="terminate" class="btn btn-sm btn-danger" value="Terminate Attendance for <?php echo $_SESSION['attendCourseSelect']; ?>" name="Terminate_attSession"  onClick="$('#terminate').hide();" style="margin-left: 67%;margin-top: 450px; position: absolute;">
            </form>
            <?php if ($AttendanceSuccess): ?>

            <div class="AttendanceSuccess alert-success" id="AttendanceSuccess" style="font-weight: normal; margin-top: 92px;">Attendance for <?php echo $_SESSION['attendCourseSelect']; ?> was <strong>Updated</strong><br/>For the Student Below.</div>
            <?php endif ?>
            <?php if ($AttendanceFailure): ?>
                <div class="AttendanceSuccess alert-danger" style="color: red; margin-top: 92px; text-align: left; font-weight: normal; " id="AttendanceSuccess">Attendance was <strong>NOT</strong> Taken for the Student Below.<br/>He/She did <strong>NOT</strong> Register for <?php echo $_SESSION['attendCourseSelect'];?>.</div>
              <?php endif ?>
              <?php if ($AttendanceduplicateRevoke): ?>
                <div class="AttendanceSuccess alert-danger" style="color: red; margin-top: 92px; text-align: left; font-weight: normal; " id="AttendanceSuccess">Attendance for the Student below is <strong>ALREADY</strong><br/>Taken for <?php echo $_SESSION['attendCourseSelect'];?> for  <strong>TODAY</strong>.</div>
              <?php endif ?>
            <canvas id="canvas" width="640" height="480" style="position: absolute; "></canvas>
            <?php if ($Revoke):?>

            <input type="button" id="Revoke" class="btn btn-sm btn-danger" value="Revoke Attendance"  onClick="">

            <script type="text/javascript">

             
            </script>
            <?php endif ?>
            
            <div id="processing"><div style="margin-top:8px; margin-left: 15px;" ><img src="loading2.gif" align="left" alt="Processing" width="50px" height="50px" /></div><h4 align="right" style="color: #000; font-style: italic; font-family:Arial Narrow; text-align:center; padding: 5px; border:none; margin-top: 10px;">Checking Face Database....Please wait...</h4></div><br/><br/><br/>
            <script type="text/javascript">document.getElementById('processing').style.display='none';</script>
              


        </div>

        <?php if (isset($_SESSION['Fetch'])) {
          $display=false;
            $take_attendace=true;

          echo '<style>'."button{
           
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
            background:  #2F0923;
            }" .'</style>';

          $FetchBindedCourses=true;

          $resCourses=mysql_query("SELECT lec_id FROM courses WHERE lec_id=".$_SESSION['lecturunilorin']);
          $userCoursesRow=mysql_fetch_array($resCourses);

          $courses=$userCoursesRow['lec_id'];
          if (empty($courses)) {

            echo '<div class="Warning" style="margin-left:40%; border:1px solid purple;border-radius: 3px;font-family: Arial Narrow;font-size: 20;padding: 10px;">'."You have not bound any Course to yourself.<br/>You Must bind a Course to yourself in order to take attendance for the course.<br/>Click on <b>BIND COURSES</b> to bind courses to yourself.".'</div>';
          }else{

            echo '<div class="Avail">'."Please Select One of your Course(s) Below to mark Attendance ".'</div>';

            $resCourses=mysql_query("SELECT *FROM courses WHERE lec_id=".$_SESSION['lecturunilorin']);

            echo '<div class="Binded">';

             echo '</div>';
            
          echo '<form method="post" id="Attdcourse" action="Lhome.php">';
          while($userCoursesRow=mysql_fetch_array($resCourses)){
            
           // echo '<input type="radio" style="margin-left:50%;" name ="AttCourse" required >'.'<b>'.'&emsp;'. $userCoursesRow['course_code'].'</b>';
            echo '<input type="radio" style="margin-left:50%;" name ="AttCourse" value'."=".'"'.$userCoursesRow['course_code'].'"'." required>".'<b>'.'&emsp;'. $userCoursesRow['course_code'].'</b>';
             
            
          } echo '</form>'; 
                  echo '<button type="submit" form="Attdcourse" style="margin-left:45.5%;" id="take_attendace" name="take_attendace">'."Commence Attendance Session".'</button>';
          }

          
        } unset($_SESSION['Fetch']); ?>




        <?php if (isset($_SESSION['view']) && !empty($_SESSION['view']) ) { ?>

  
        <style type="text/css">
          
           th{
  width: auto;
  font-size: 10;
}
td{
  
  font-size: 15;
  font-family:Arial Narrow;

}
.course_display_table {

                      margin-left: 350px;
                      margin-top: -550px;
                      overflow-y: auto;
                      height: 400px;

                                         
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

        </style>

      

<div class="course_display_table">
  <table cellpadding="0" cellspacing="0" border="0" border-radius= "5px" class="table  table-bordered" id="example">
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-user icon-large"></i>&nbsp;<em>Lists of students offering <?php echo $_SESSION['coursesCode']; ?> and their Attendance Information.</em></strong>
                                </div>
                                <thead>
                                    <tr>
                                        <th>Name of Student</th>
                                        <th>Matric Number</th>
                                        <th>Level</th>
                                        <th>Student's Attendance</th>
                                        <th>Student's Last Attendance Date</th>
                                        <th>No. of Time(s) Course Held</th>
                                        <th><?php echo $_SESSION['coursesCode'];?> Last Attendance Date</th>
                                        <th>Percentage Attendance</th>
                                        <th>Exam Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 
                                  <?php $coursesC=$_SESSION['coursesCode'];
                                  $user_query=mysql_query("SELECT *FROM student_course_attendance WHERE course_code='$coursesC'");
                                    $student_id= array();
                                    while($row=mysql_fetch_array($user_query)){
                                    $student_id[]=$row['att_id']; //$cid=$row['course_id']; 

                                     foreach ($student_id as $id) {
                                       $fetch_student_data=mysql_query("SELECT *FROM students WHERE stu_id='$id'");
                                       $row3=mysql_fetch_array($fetch_student_data);
                                        $fetch_history_data=mysql_query("SELECT *FROM attendance_history WHERE course_code='$coursesC' AND att_id='$id'");
                                       $row4=mysql_fetch_array($fetch_history_data);
                                     }

                                    ?>

                                     <tr class="del<?php echo $student_id ?>">
                                    <td><?php echo $row3['First_Name']." ".$row3['Surname']; ?></td> 
                                    <td><?php echo $row3['Mat_no']; ?></td>
                                    <td><?php echo $row3['Level']; ?></td>
                                    <td><?php echo $row4['attendance']; ?></td>
                                    <td><?php if (empty($row4['last_attendance_time'])) {
                                      echo '<div style="color:red;" >'."Never Attended Class".'</div>';
                                    }else{ echo $row4['last_attendance_time'];} ?></td>
                                    <td><?php echo $row4['total_attendance']; ?></td>
                                    <td><?php if (empty($row4['last_course_attendance_time'])) {
                                      echo '<div style="color:red;" >'."Lecture is Yet to Commence".'</div>';
                                    }else{ echo $row4['last_course_attendance_time']; }?></td>
                                    <td><?php if ($row4['total_attendance']!=0) {
                                      echo (ceil(($row4['attendance'] / $row4['total_attendance'])*100))."%";
                                    }else{ echo "0"."%";}  ?></td>
                                    <td><?php if ($row4['total_attendance']!=0 && (($row4['attendance'] / $row4['total_attendance'])*100)>=75 ) {
                                      echo '<div class="" style="color:green;">'."Qualified".'</div>';
                                    }else{echo'<div class="" style="color:red;">'. "Unqualified".'</div>'; }?></td>
                                   
                                    
                                         <!-- Modal edit user -->
                                
                                    </tr>
                                    <?php }  unset($_SESSION['coursesCode']); ?>
                           
                                </tbody>
                            </table>
  
</div>




        <?php


         $display=false;

          echo "<script>

          $('#hell').hide();

          </script>";



         }elseif(isset($_SESSION['choose'])){?>



          <style type="text/css">

          .courses{

            padding: 10px;
            margin-left: 37%;
            border:1px solid purple;
            border-radius: 3px;
            font-family: Arial Narrow;
            font-size: 20;
            margin-right: 285px;
            
          }

          button{
           
            font-family: "Raleway", sans-serif;
            color: #fff;
            margin-bottom: 10px;
            background-color: #2F0916;
            padding: 7px 15px;
            display: block;
            border: none;
            border-radius: 2px;
            font-size: 14px;
            
            position: absolute;
            
            }
            button:hover{
            cursor: pointer;
            background: #2F0923;
            }



          </style>

         
  <?php
         $display=false;

          echo "<script>

          $('#hell').hide();

            

         function printElem() {
          var content = document.getElementById(divId).innerHTML;
          var mywindow = window.open('', 'Print', 'height=600,width=800');

          mywindow.document.write('<html><head><title>Print</title>');
          mywindow.document.write('</head><body >');
          mywindow.document.write(content);
          mywindow.document.write('</body></html>');

          mywindow.document.close();
          mywindow.focus()
          mywindow.print();
          mywindow.close();
          return true;
}

          </script>";


           
            echo '<div class="Avail1" style="margin-left:37%; box-shadow: 1px 1px 40px 5px grey;">'."Please Select One of your Course(s) Below to view students Attendance Information. ".'</div>'.'<br/>';

            $resCourses=mysql_query("SELECT *FROM courses WHERE lec_id=".$_SESSION['lecturunilorin']);
            $userCoursesRow=mysql_fetch_array($resCourses);

            echo '<div class="Binded">';

            $courses=$userCoursesRow['lec_id'];
            if (empty($courses)) {

              echo '<div class="courses" style="color:red; font-weight:bold; text-align:center;">'."Sorry, It looks like you don't teach any Course. Please Bind a Course to Yourself and try again.".'</div>';
             
            }else{
              

              $resCourses=mysql_query("SELECT *FROM courses WHERE lec_id=".$_SESSION['lecturunilorin']);

          echo '<form class="courses" method="post" id="View_students_attendance" action="Lhome.php">';
          while($userCoursesRow=mysql_fetch_array($resCourses)){
            
           // echo '<input type="radio" style="margin-left:50%;" name ="AttCourse" required >'.'<b>'.'&emsp;'. $userCoursesRow['course_code'].'</b>';
            
            echo '<input type="radio" style="margin-left:5%; " name ="ViewCourse" value'."=".'"'.$userCoursesRow['course_code'].'"'." required>".'<b>'.'&emsp;'. $userCoursesRow['course_code'].'</b>'."  "."---".$userCoursesRow['course_title'];
             
            echo "<br/>";
           
          } 
             echo '</form>';

          echo '<button type="submit" form="View_students_attendance" style="margin-left:50%; background-color:black; box-shadow: 1px 1px 40px 5px grey; " id="viewR" name="view">'."View Registered students".'</button>';

          
                  
         }
       }

       echo '</div>';

        unset($_SESSION['view']);
        unset($_SESSION['choose']);
        

         ?> 

        



  <?php if (isset($_SESSION['courseBinded'])) { $bind_courses=true; $display=false;

    echo "<script>

          $('#hell').hide();

          </script>";

    $courses=mysql_query("SELECT course_id, course_title, course_code, lec_id FROM courses ");
         while($coursesRow=mysql_fetch_array($courses)){

            $stucourses[] = $coursesRow;


          }

    ?>



   <style type="text/css">
            
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
            margin-left: 680px;
            margin-top: -522px;
            position: absolute;
            
            }
            button:hover{
            cursor: pointer;
            background:  #2F0923;
            }
            
     
                       th{
  width: auto;
}
.course_display_table {

                      margin-left: 350px;
                      margin-top: -450px;
                      overflow-y: auto;
                      height: 400px;

                                         
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

          </style>

          

  <form method="POST" action="Lhome.php" id="BindCourse" data-toggle="validator" role="form">

    <div class="input-group">
    <select class="form-control" name="stcourse_id" style="margin-left: 350px; margin-top: -500px;width: 300px;" id="courses" required>
      <option value="">Select Courses to bind</option>
    <?php foreach ($stucourses as $coursesRow):?>
      <option value="<?=$coursesRow['course_id'];?>"><?=$coursesRow['course_title']." "."(".$coursesRow['course_code'].")";?></option>
    <?php endforeach; ?>
    </select>
  </div>
  </form>
  <button id="Bind_course" type="submit" name="Bind_course" class="" form="BindCourse">Bind Course</button>
  <?php if (isset($_SESSION['RepatedCourse'])) {
  echo '<div class="Warning">'.$_SESSION['RepatedCourse'].'</div>';
}unset($_SESSION['RepatedCourse']);if (isset($_SESSION['Bindedcos'])) {
  echo $_SESSION['Bindedcos'];
}unset($_SESSION['Bindedcos']); if (isset($_SESSION['CourseUnbound'])) {
  echo '<div class="Warning" style="color:green;">'.$_SESSION['CourseUnbound'].'</div>';
}unset($_SESSION['CourseUnbound']); if (isset($_SESSION['courseAlreadyBinded'])) {
  echo '<div class="Warning" style="margin-top: -490px; text-align:left;">'.$_SESSION['courseAlreadyBinded'].'</div>';} unset($_SESSION['courseAlreadyBinded']);?>
  
<div class="course_display_table">
   <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong><i class="icon-user icon-large"></i>&nbsp;<em>Here are the Courses You teach</em></strong>
                                </div>
  <table cellpadding="0" cellspacing="0" border="0" border-radius= "5px" class="table  table-bordered" id="example">
                               
                                <thead>
                                    <tr>
                                        <th>Course Title</th>
                                        <th>Course Code</th>                                                        
                                        <th>Take Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 
                                  <?php $user_query=$query = mysql_query("SELECT *FROM courses WHERE lec_id=".$_SESSION['lecturunilorin']);
                                    while($row=mysql_fetch_array($user_query)){
                                    $lec_id=$row['lec_id']; $cid=$row['course_id']; ?>

                                     <tr class="del<?php echo $lec_id ?>">
                                    <td><?php echo $row['course_title']; ?></td> 
                                    <td><?php echo $row['course_code']; ?></td>
                                    <td width="5">


                                        &emsp;&emsp;&emsp;&emsp;<a rel="tooltip" title="Unbound Course" id="" href="deleteCourse.php<?php echo '?course_id='.$cid; ?>" class="btn btn-danger"><i class="icon-trash icon-large"></i></a>
                                        <!--?php include('delete_student_modal.php'); ?-->
                    <!--?php include('Edit_course_modal.php'); ?-->
                                    </td>
                                    
                                         <!-- Modal edit user -->
                                
                                    </tr>
                                    <?php } ?>
                           
                                </tbody>
                            </table>
  
</div>
<?php } unset($_SESSION['courseBinded']); ?>


        <script>

    //$('#displayinfo').hide();
    var element=document.getElementById('hell');


    

     

      element.onclick = function Listen() {
   
        //$('#displayinfo').hide();
        
       document.getElementById('hell').style.display='none';
      document.getElementById('displayinfo').style.display='none';
      document.getElementById('content').style.display='block';
      var video = document.getElementById('video');
      var canvas = document.getElementById('canvas');
      var context = canvas.getContext('2d');
     
      
      var tracker = new tracking.ObjectTracker('face');
      tracker.setInitialScale(4);
      tracker.setStepSize(2);
      tracker.setEdgesDensity(0.1);

      tracking.track('#video', tracker, { camera: true });


      tracker.on('track', function(event) {
      context.clearRect(0, 0, canvas.width, canvas.height);

      

        event.data.some(function(rect) {
        context.drawImage(video, 0, 0, 640, 480);
        context.strokeStyle = '#2F0916';
        context.strokeRect(rect.x, rect.y, rect.width, rect.height);
        context.font = '11px Helvetica';
        context.fillStyle = "#fff";
        
        //$('#video').fadeOut('slow');
        document.getElementById('video').style.display='none';
       
    
         extract();
       
        
     
        document.getElementById('processing').style.display='block';
         

       

      setTimeout(function(){
       
        //document.getElementById('FaceAttendance').submit();
                  
        //window.location.href='FaceAttendance.php';
      
        location.replace('FaceAttendance.php');


        
       },3000); 
 


    event.data.return(false);
      
      
       
       
    });

//event.data.some();
return;
       
      });
      
   



    
  

     }



function extract(){
       
        //document.getElementById('canvas').style.display='block';
        //document.getElementById('canvas').style.display='none';
        var dataUrl = canvas.toDataURL();
                //$('#processing').show();
                $.ajax({
                  type: "POST",
                  url: "Attendance.php",
                  data: { 
                     imgBase64: dataUrl
                     
                  },
                  //afterSend: function(){$("#processing").show();}
                }).done(function(msg) {
                  console.log('saved');

                });

                return;
       
} 



  </script>

  <script type="text/javascript">

            
            /*  var course_code= <?php //echo $_SESSION['attendCourseSelect'] ?>;
              var last_attendance_time=<?php //echo $HistoryTime ?>;
              var attendance=<?php// echo $Historyattendance  ?>;*/


       
              



       document.getElementById("Revoke").addEventListener("click", function(){

        $('#Revoke').hide();
        $('#AttendanceSuccess').hide();

        var id= <?php echo $_SESSION['stu_id'] ?>;


         $.ajax({
                  type: "POST",
                  data: { 

                     student_id: id
                    
                  },
                  cache:false,
                  url: "Revoke_attendance.php",
              }).done(function(msg) {
                  console.log('Atterndance Revoked!');
               //$('.Warning1').html("Attendance was <b>REVOKED</b> for "+course_code+" for the student  below.");
                  //afterSend: function(){$("#processing").show();}
                  $('#RevokeSuccess').show();
                });

          
});


  </script>

  <script type="text/javascript">
    
  </script>

<script type="text/javascript" src="../js/tracking-min.js"></script>
        <script type="text/javascript" src="../js/face-min.js"></script>

        <?php if ($display){?>
        <div class="displayinfo" id="displayinfo">
             

                <form class="" method="">

                <br/>
                <?php if ($userRow['qualification']=="Dr." || $userRow['qualification']=="Prof.") {

                    echo '<label class="" align=""><b>Title:</b></label>&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;';
                   echo "&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;";
                    echo $userRow['qualification'];
                    echo "<br/>";
                }elseif ($userRow['sex']=="Male") {
                    echo '<label class="" align=""><b>Title:</b></label>&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;';
                   echo "&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;";
                   echo "Mr."; echo "<br/>";
                }else{ } ?>
                <label class="" align=""><b>First Name:</b></label>&emsp;&emsp;&emsp;&emsp;&emsp;<l><?php echo $userRow['First_Name']; ?></l><br/>
                <label class="" align="" ><b>Last Name:</b></label>&emsp;&emsp;&emsp;&emsp;&emsp;<l><?php echo $userRow['Surname']; ?></l><br/>

                <label class="" align="" ><b>Mobile:</b></label>&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;<l><?php echo $userRow['phone_num']; ?></l><br/>
                
                <label class="" align=""> <b>State of Origin:</b></label>&emsp;&emsp;&emsp;&nbsp;&nbsp;<l><?php echo $userRow['State_of_origin']; ?></l><br/>
                <label class="" align="" > <b>Religion:</b></label>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;<l><?php echo $userRow['Religion']; ?></l><br/>
                
                <label class="" align=""><b>Marital Status:</b></label>&ensp;&emsp;&emsp;&emsp;&nbsp;<l><?php echo $userRow['m_status']; ?></l><br/>

                <label class="" align="" ><b>Sex:</b></label>&ensp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<l><?php echo $userRow['sex']; ?></l><br/>
    
                <label class="" align="" id="center">E-mail: </label>&ensp;&ensp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;<l><?php echo $userRow['Email']; ?></l><br/>

                <label class="" align="" id="center">Date of Birth:</label>&emsp;&emsp;&emsp;&emsp;&nbsp;<l><?php echo $userRow['D_of_birth']; ?></l><br/>       
    </form>
   
    

        </div>
        <?php } ?>
        <!-- /#sidebar-wrapper -->
<script src="../assets/js/bootstrap.min.js"></script>



<?php if ($success):?>
    <script language="Javascript">
      $('#displayinfo').hide();
      //$('#processing').show();
        setTimeout(function(){
       // $('#processing').fadeOut('slow');
        element.click();

       },1000); 
     
    //$('#new').show();
    //$('#processing').show();
    </script>
    <?php endif ?>

<?php if ($FetchBindedCourses):?>

  <script language="Javascript">
      $('#displayinfo').hide();
$('#attend').hide();
</script>
  <?php endif ?>
<?php if ($take_attendace):?>
  <script language="Javascript">
  ('#take_attendace').hide();
  </script>
<?php endif ?>
<?php if ($bind_courses):?>
  <script language="Javascript">
  $('#displayinfo').hide(); 
    </script>
<?php endif ?>
<?php if ($attendancesession):?>
  <script language="Javascript">
     
     document.getElementById('displayinfo').style.display='none';
      document.getElementById('content').style.display='block';
      </script>
<?php endif ?>
<style type="text/css">

@media print {
  
      body, html{
          width: 100%;
      }

      .course_display_table {

                      margin-left: 350px;
                      margin-top: -110%;
                      overflow-y: auto;
                      height: 400px auto;

                                         
                       }
      .displayinfo{

                        margin-left: 300px;
                        position: absolute;
                        height: 450px auto;
                        width: 800px;
                        margin-top: -110%;
                        font-family: 'Segoe UI Semilight';
                        font-size: 16;
                        background-color: #A8D0D0;
                        border-radius: 5px;
                        box-shadow: 1px 1px 40px 5px #330066;

                    }
          #courses{

            display: none;
          }
        #Bind_course{
          display: none;
        }


  a[href]:after {
    content: none !important;
  }
}

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
                                  

    </body>
                 
    </html>
    <?php unset($_SESSION['stu_id']); unset($_SESSION['Attendance']); if (isset($_SESSION['busy'])) {
      unset($_SESSION['busy']);
    }  ob_end_flush(); ?>