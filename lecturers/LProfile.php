<?php
	ob_start();
	session_start();
  $logout=false;
  $shift=false;
  //$_SESSION['edit'];
  $_SESSION['lecturunilorin'];
  //echo $_SESSION['user'];
	require_once '../databaseConnect.php';
// if session is not set this will redirect to login page
  if( !isset($_SESSION['lecturunilorin']) ) {
    $_SESSION['not_logged_in']="You must Log In to Continue";
    header("Location: ../lecturers");
    exit();
  }

   $query=mysql_query("SELECT phone_num, Religion, m_status, State_of_origin, sex, qualification FROM lecturers WHERE lec_id=".$_SESSION['lecturunilorin']);
     $options=mysql_fetch_array($query);
     $phone=$options['phone_num'];
     $Religion=$options['Religion'];
     $m_status=$options['m_status'];
     $sex=$options['sex'];
     $State_of_origin=$options['State_of_origin'];
     $qualification=$options['qualification'];
  
   
	// select loggedin users detail
	$res=mysql_query("SELECT * FROM lecturers WHERE lec_id=".$_SESSION['lecturunilorin']);
  $userRow=mysql_fetch_array($res);
  //echo $_SESSION['lecturunilorin'];
    $_SESSION['editl'];
    //echo $_SESSION['edit'];
     if (!isset($_SESSION['editl']) && !empty($userRow['phone_num']) && !empty($userRow['m_status']) && !empty($userRow['Religion']) && !empty($userRow['State_of_origin']) && !empty($userRow['sex']) && !empty($userRow['First_Name']) && !empty($userRow['Surname']) && !empty($userRow['D_of_birth']) && !empty($userRow['qualification']) && !empty($userRow['profile_pic'])){

      header("Location: Lhome.php");
      exit();
  }
  
    if ($_SESSION['editl']) {
      $shift=true;
    }
     
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Edit | Lecturer's Profile</title>

<link rel="stylesheet" href="../assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="../css/croppie.css" />
<link rel="stylesheet" href="../css/font-awesome.min.css" type="text/css"  />
<link rel="stylesheet" href="../css/font-awesome.css" type="text/css"  />
<link rel="stylesheet" href="../css/datepicker.css" type="text/css" />
<link rel="shortcut icon" href="../images/favicon.ico"> 


<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/validator.min.js"></script>
 <script type="text/javascript" src="../js/profile_pic.js"></script>
 <!--link rel="stylesheet" href="../css/datepicker.css"-->
 <script type="text/javascript" src="jquery-ui-1.10.3.custom.min.css"></script>
</head>

<body>
  <script type="text/javascript" src="../js/webcam.js"></script>
   <!-- Configure a few settings and attach camera -->
    <script language="JavaScript">
     function setup() {
        Webcam.set({
            width: 150,
            height: 150,
            image_format: 'jpeg',
            jpeg_quality: 200
        });
        Webcam.attach( '#my_camera' );
    }
    </script>
    
    <style>
    .bgColor {
            max-width: 440px;
            height: 400px;
            background-color: #fff4ca;
            padding: 30px;
            border-radius: 4px;
            text-align: center;    
        }
        .Warning{


            color: red;
            margin-top: 120px;
            position: absolute;
           
            padding: 10px;
            width: 400px auto;
            font-family: Arial Narrow;
           
            font-style: italic;
            margin-left: 300px;
            background-color:#F7B3BD;
            border-radius: 3px;
           text-align: center;
           background-position: center;

               
        }
              .btn-sm{

                    position: absolute;
                     margin-top: 60px;
                    margin-left: 600px;
              }
              .btn-success{

                background-color:#2F0916;
                border:none;
                }
        .upload-preview {border-radius:10px;width: 150px;height: 150px;}
        #upload-preview {border-radius: 10px;}
        #body-overlay {background-color: rgba(0, 0, 0, 0.6);z-index: 999;position: absolute;left:30%; top:30%; width:0px; height:0px; display: none;}
        #body-overlay div {position:absolute;left:;top:50%;margin-top:0%;margin-left:;}
        #targetOuter{   
            position:relative;
            text-align: center;
            background-color: #F0E8E0;
            margin: 20px auto;
            width: 150px;
            height: 150px;
            
        }
            #my_camera button{
            position: absolute;
            bottom: 10px;
            left: 26%;
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
            -webkit-transition: all .2s ease;
            -moz-transition: all .2s ease;
            -o-transition: all .2s ease;
            -ms-transition: all .2s ease;
            transition: all .2s ease;
            z-index: 9999;
            }
            #my_camera button:hover{
            cursor: pointer;
            background: #2F0923;
            }
            #my_camera .btn-sm{


            }
            
        .inputFile{
            margin-top: 0px;
            left: 0px;
            right: 0px;
            top: 0px;
            width: 200px;
            height: 36px;
            background-color: #FFFFFF;
            overflow: hidden;
            opacity: 0;
            position: absolute;
            cursor: pointer;
        }
        .icon-choose-image {
            position: absolute;
            opacity: 0.5;
            top: 50%;
            left: 50%;
            margin-top: -24px;
            margin-left: -24px;
            width: 48px;
            height: 48px;
            cursor:pointer;
            
        }
        #profile-upload-option{
            display:none;
            position: absolute;
            top: 163px;
            left: 23px;
            margin-top: -60px;
            margin-left: -23px;
            border: #d8d1ca 1px solid;
            border-radius: 4px;
            background-color: #F0E8E0;
            width: 150px;
        }
        .profile-upload-option-list{
            margin: 1px;
            height: 25px;
            border-bottom: 1px solid #cecece;
            cursor: pointer;
            position: relative;
            padding:5px 0px;
            color: red;
        }
        .profile-upload-option-list:hover{
            background-color: #fffaf5;
        }
    </style>
    
    
      <style>
        .row{
          width:800px;
          margin-left: 100px;
          position: absolute;
          margin-top: 20px;

        }
        .RegArea{

            width: 1000px;
           height: 120%;
          
           margin-left: 180px;
            margin-right: 180px;
           position: absolute;
           background-color:#eee;

           box-shadow: 1px 1px 40px 5px #2F0916;

        }
         .form-control:focus{
                             box-shadow: 1px 1px 20px 10px #2F0916;
                           }
        body{
                background-color:  #eee;

        }
      .navbar-fixed-top{

        background-color: #2F0916;
        border-bottom: 2px solid purple;
        
      }
      .dropdown{

         background-color:  #2F0916;
         border-bottom-right-radius: 10px;
         border-bottom-left-radius: 10px;
      }
     #access{

               position: absolute;
            }
     
      </style>
	<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
           <ul class="nav navbar-nav navbar-center">
             <img src="../images/badge2.jpg" height="50px" width="50px" style="margin-left:30px;">
            <div class="school-name"><h5>Federal University of Technology, Minna</h5></div>
        </ul>
            <!--h4 align="center">University of Ilorin....</h4><br/><h5>Better by Far....</h5-->
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown" id="drop">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-user"></span>&nbsp; Lecturer's Email: <?php echo $userRow['Email']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                 <?php if (isset($_SESSION['editl']) && $_SESSION['editl']==$userRow['Surname']) {
                  # code...
                  $logout=true;
                }else{

                  $logout=false;
                } ?>
                <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Log Out</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
     </div>
    </nav> 
     
      <div class="RegArea">
        <?php 
            if (!isset($_SESSION['editl'])) {
    echo '<div class="Warning">You Must Upload Your Profile Picture To Bypass This Page in Your Next Login.<br/>Please Click The Photo Icon in the Passport Area to Choose a Photo OR Use The Webcam.<br/>If You started Your Passport Capture With Webcam and Want To Use File Upload, Refresh The Page.</div>';
  }

        ?>
    	<div id="my_camera" align="center">
               <?php //$profpic= $userRow['profile_pic'];?>
                <form id="uploadForm" action="upload.php" method="post">
                <div id="targetLayer"><?php if (file_exists("../images/images.jpg")){?><img src="../upload/<?php if (empty($userRow['profile_pic'])) {
                    echo "images.jpg";# do nothing
                } else{ echo $userRow['profile_pic'];}?>" width="150px" height="150px" class="upload-preview" /--><?php }?></div>
               <img id="phoicon" src="../images/photo.png"  class="icon-choose-image"/>
                <div class="icon-choose-image" onClick="$('#access').hide();showUploadOption();$('#snap').hide();"></div>
               <div id="profile-upload-option">
                <div class="profile-upload-option-list"><input name="userImage" id="upload_image" type="file" class="inputFile" onChange="showPreview(this);" onClick="$('#access').hide();"></input><span>Select Image</span></div>
                        <!--div class="profile-upload-option-list" onClick="removeProfilePhoto();">Remove</div-->
                <div class="profile-upload-option-list" onClick="hideUploadOption();$('#access').show();">Cancel</div>
                </div>

                <button id="snap" type="submit" name="upload" onClick="hideUploadOption();">Upload</button>
                
                <div id="body-overlay"> <div><img src="../loading.gif" width="64px" height="64px"/></div></div>
                <script language="javascript">

                $('#snap').hide();
                </script>
                </form>

                <!--div>
                    <button type="submit" onClick="hideUploadOption();>
                <input type="submit" value="Upload Photo" class="btnSubmit" onClick="hideUploadOption();"/>
                </div-->
           <!--p><div class="word">
           Choose a File by clicking the image icon above or Use the Webcam.
        </div></p-->
            </div>
    <!-- A button for taking snaps -->
     <input type="button" id="access" class="btn btn-sm btn-success" value="Use Webcam"  onClick="setup(); $(this).hide().next().show();">
    <input type="button" class="btn btn-primary btn-success" value="&nbsp;&nbsp;Snap&nbsp;&nbsp;"   onClick="take_snapshot(); $(this).hide().next().show();" style="display:none">
    <input type="submit" class="btn btn-primary btn-success" value="&nbsp;Upload&nbsp;" name=""  onClick="saveSnap(); $(this).hide().next().show();" style="display:none">
    <button type="submit" id="register" form="commentForm" class="btn btn-lg"  name="submit" value="" onClick="$('#phoicon').show();$(this).show().prev().prev().prev().show();" style="display:none">Save and Continue<i class="fa fa-sign-in" aria-hidden="true"></i></button>
    <input type="submit" id="register" form="commentForm" class="btn btn-lg"  name="submit" value="Save and Continue" onClick="$('#phoicon').();$('#phoicon').show();$(this).show().prev().prev().prev().prev().show();" style="display:none">
    
    <!--input type="button" class="btn btn-sm btn-success" value="Upload Image"    onClick="saveSnap(); $(this).hide().prev().prev().show();" style="display:none"-->

    <!--input type="button" value="Access Camera" onClick="setup(); $(this).hide().next().show();"-->
    <!--input type="button" value="Take Snapshot" onClick="take_snapshot()" style="display:none"-->
    
    <div class="row">
        <form method="POST" action="Lsubmit.php" id="commentForm" data-toggle="validator" role="form">
        
      <div class="col-md-6">

         <div class="form-group">
               <span class=""><i class="icon-user icon-large"></i></span>
              <input type="text" name="fname" id="fname" class="form-control" placeholder="Your First Name" maxlength="50" value="<?php echo $userRow['First_Name']; ?>" required/>

                
            </div>
            <br/>
            <div class="form-group">
                <span class=""><i class="icon-user icon-large"></i></span>
                <input type="text" name="sname" id="sname" class="form-control" placeholder="Your Surname" maxlength="50" value="<?php echo $userRow['Surname']; ?>" required/>
               
            </div>
            <br/>
  
             <div class="form-group">
               <span class=""><i class="icon-envelope icon-large"></i></span>
                <input type="email" name="email" id="email" class="form-control" placeholder="Your E-mail" maxlength="50" value="<?php echo $userRow['Email']; ?>" required/>
               
            </div>
            <br/>
            <div class="form-group">
             <span class=""><i class="fa fa-graduation-cap" style="font-size: 20px;"></i></span>
              <select class="form-control" name="option3" id="option3" value="<?php echo $userRow['qualification']; ?>" required> 
                        <option value="">Select Your Qualification</option>
                        <option value="B.Eng." <?php if($qualification=="B.Eng.")echo 'selected="selected"';?>>B.Eng.</option>
                        <option value="Dr." <?php if($qualification=="Dr.")echo 'selected="selected"';?>>Dr.</option>
                        <option value="Prof." <?php if($qualification=="Prof.")echo 'selected="selected"';?>>Prof.</option>
                        <option value="B.sc" <?php if($qualification=="B.sc")echo 'selected="selected"';?>>B.sc</option>
                        <option value="HND" <?php if($qualification=="HND")echo 'selected="selected"';?>>HND</option>
                    </select>
                
            </div>
            <br/>
            <div class="form-group">
                <span class=""><i class="fa fa-phone-square" style="font-size: 24px;"></i></span>
                <input type="phone" name="phone" id="phone" class="form-control" placeholder="phone Number" maxlength="11" value="<?php echo $userRow['phone_num']; ?>" required/>
                
            </div>
    
        </div>
        

      <div class="col-md-6">
            <div class="form-group">
                <span class=""><i class="icon-calendar icon-large"></i></span>
                <input type="text" name="dob" data-toggle="datepicker" class="form-control" placeholder="Date of Birth" maxlength="50" value="<?php echo $userRow['D_of_birth']; ?>" required/>
                
            </div>
            <br/>
           
         <div class="form-group">
             <span class=""><i class="icon-user icon-large"></i></span>
              <select class="form-control" name="option1" id="option1" value="<?php echo $userRow['sex']; ?>" required> 
                        <option value="">Select Your Gender</option>
                        <option value="Male" <?php if($sex=="Male")echo 'selected="selected"';?>>Male</option>
                        <option value="Female" <?php if($sex=="Female")echo 'selected="selected"';?>>Female</option>
                        <option value="Transgender" <?php if($sex=="Transgender")echo 'selected="selected"';?>>Transgender</option>
                    </select>
                
            </div>
            <br/>
            <div class="form-group">
             <span class=""><i class="icon-home icon-large"></i></span>
              <select class="form-control" name="option2" id="option2" value="<?php echo $userRow['State_of_origin']; ?>" required> 
                        <option value="">Select Your state of origin</option>
                        <option value="Abia" <?php if($State_of_origin=="Abia")echo 'selected="selected"';?>>Abia</option>
                        <option value="Adamawa" <?php if($State_of_origin=="Adamawa")echo 'selected="selected"';?>>Adamawa</option>
                        <option value="Akwa-Ibom" <?php if($State_of_origin=="Akwa-Ibom")echo 'selected="selected"';?>>Akwa-Ibom</option>
                        <option value="Anambra" <?php if($State_of_origin=="Anambra")echo 'selected="selected"';?>>Anambra</option>
                        <option value="bauchi" <?php if($State_of_origin=="bauchi")echo 'selected="selected"';?>>bauchi</option>
                        <option value="Benue" <?php if($State_of_origin=="Benue")echo 'selected="selected"';?>>Benue</option>
                        <option value="Borno" <?php if($State_of_origin=="Borno")echo 'selected="selected"';?>>Borno</option>
                        <option value="Cross-Rivers" <?php if($State_of_origin=="Cross-Rivers")echo 'selected="selected"';?>>Cross-Rivers</option>
                        <option value="Delta" <?php if($State_of_origin=="Delta")echo 'selected="selected"';?>>Delta</option>
                        <option value="Gombe" <?php if($State_of_origin=="Gombe")echo 'selected="selected"';?>>Gombe</option>
                        <option value="Jigawa" <?php if($State_of_origin=="Jigawa")echo 'selected="selected"';?>>Jigawa</option>
                        <option value="Kaduna" <?php if($State_of_origin=="Kaduna")echo 'selected="selected"';?>>Kaduna</option>
                        <option value="Kano" <?php if($State_of_origin=="Kano")echo 'selected="selected"';?>>Kano</option>
                        <option value="Katsina" <?php if($State_of_origin=="Katsina")echo 'selected="selected"';?>>Katsina</option>
                        <option value="Ekiti" <?php if($State_of_origin=="Ekiti")echo 'selected="selected"';?>>Ekiti</option>
                        <option value="Ondo" <?php if($State_of_origin=="Ondo")echo 'selected="selected"';?>>Ondo</option>
                        <option value="Ogun" <?php if($State_of_origin=="Ogun")echo 'selected="selected"';?>>Ogun</option>
                        <option value="Osun" <?php if($State_of_origin=="Osun")echo 'selected="selected"';?>>Osun</option>
                        <option value="Oyo" <?php if($State_of_origin=="Oyo")echo 'selected="selected"';?>>Oyo</option>
                        <option value="Kogi" <?php if($State_of_origin=="Kogi")echo 'selected="selected"';?>>Kogi</option>
                        <option value="Lagos" <?php if($State_of_origin=="Lagos")echo 'selected="selected"';?>>Lagos</option>
                        <option value="Nassarawa" <?php if($State_of_origin=="Nassarawa")echo 'selected="selected"';?>>Nassarawa</option>
                        <option value="Niger" <?php if($State_of_origin=="Niger")echo 'selected="selected"';?>>Niger</option>
                        <option value="Plateau" <?php if($State_of_origin=="Plateau")echo 'selected="selected"';?>>Plateau</option>
                        <option value="Rivers" <?php if($State_of_origin=="Rivers")echo 'selected="selected"';?>>Rivers</option>
                        <option value="Sokoto" <?php if($State_of_origin=="Sokoto")echo 'selected="selected"';?>>Sokoto</option>
                        <option value="Taraba" <?php if($State_of_origin=="Taraba")echo 'selected="selected"';?>>Taraba</option>
                        <option value="Yobe" <?php if($State_of_origin=="Yobe")echo 'selected="selected"';?>>Yobe</option>
                        <option value="Zamfara" <?php if($State_of_origin=="Zamfara")echo 'selected="selected"';?>>Zamfara</option>
                        <option value="F.C.T" <?php if($State_of_origin=="F.C.T")echo 'selected="selected"';?>>F.C.T</option>
                        <option value="Edo" <?php if($State_of_origin=="Edo")echo 'selected="selected"';?>>Edo</option>
                        <option value="Bayelsa" <?php if($State_of_origin=="Bayelsa")echo 'selected="selected"';?>>Bayelsa</option>
                        <option value="Enugu" <?php if($State_of_origin=="Enugu")echo 'selected="selected"';?>>Enugu</option>
                        <option value="Imo" <?php if($State_of_origin=="Imo")echo 'selected="selected"';?>>Imo</option>
                        <option value="Ekiti" <?php if($State_of_origin=="Ekiti")echo 'selected="selected"';?>>Ekiti</option>
                        <option value="Kebbi" <?php if($State_of_origin=="Kebbi")echo 'selected="selected"';?>>Kebbi</option>
                        <option value="Kwara" <?php if($State_of_origin=="Kwara")echo 'selected="selected"';?>>Kwara</option>
                    </select>
            
        </div>
            <br/>
            
            <div class="form-group">
              <span class=""><i class="fa fa-user-plus" style="font-size: 20px;"></i></span>
              <select class="form-control" name="option4" id="option4" value="<?php echo $userRow['m_status']; ?>" required> 
                        <option value="">marital Status</option>
                        <option value="Single"  <?php if($m_status=="Single")echo 'selected="selected"';?>>Single</option>
                        <option value="Maried"  <?php if($m_status=="Maried")echo 'selected="selected"';?>>Maried</option>
                        <option value="Divorced"  <?php if($m_status=="Divorced")echo 'selected="selected"';?>>Divorced</option>
                        <option value="Eunuch"  <?php if($m_status=="Eunuch")echo 'selected="selected"';?>>Eunuch</option>
                    </select>
                
            </div>
            <br/>
              <div class="form-group">
              <span class=""><i class="icon-group icon-large"></i></span>
              <select class="form-control" name="option5" id="option5" value="<?php echo $userRow['Religion']; ?>" required> 
                        <option value="">Religion</option>
                        <option value="Christian"  <?php if($Religion=="Christian")echo 'selected="selected"';?>>Christian</option>
                        <option value="Islam"  <?php if($Religion=="Islam")echo 'selected="selected"';?>>Islam</option>
                        <option value="Others"  <?php if($Religion=="Others")echo 'selected="selected"';?>>Others</option>
                       
                    </select>
               
            
            </div>
            </div>
      </div>
       <style>
                        .btn-lg{
                            margin-left: 300px;
                            position: absolute;
                            background-color:#A042FF;
                            margin-top: 355px;
                            width: 400px;
                            height: 35px;
                            padding: 4px;
                            border: none;
                            border-radius: 0px;
                            display: block;
                            color: #ffffff;

                        }
                         i{

                          margin-left: 10px;
                        }
                        .btn-lg:hover{

                            background-color: #2F0923;
                            color: #ffffff;
                        }
                        .btn-sm{
                            margin-left: 148px;
                            margin-top: -40px;
                            position: fixed;
                            background-color:#2F0916;
                            border: none;
                            color: white;
                            
                        }
                        
                        .btn-block{

                            width: -50px;
                            margin-top: 350px;
                            margin-left: 40px;
                            position: absolute;

                        }
                        .btn-primary{
                             margin-left: 155px;
                             margin-top: -40px;
                              background-color:#2F0916;
                              position: absolute;
                              border: none;
                              
                        }
                        .btn-primary:hover{
                             background-color:#2F0923;
                        }
                        .school-name{

                          margin-left: 100px;
                          margin-top: -50px;
                          padding: 5px;
                          position: absolute;
                          font-weight: 50px;
                          font-family: Arial Narrow;
                          color: #fff;
                        }
                </style>

                 <style>
                #my_camera{
                    margin-left: 120px;
                    height: 150px;
                    width:150px;
                    position: relative;
                    border: none;
                    border-radius: 10px;
                    margin-top: 80px;
                    text-align: center;
                    background-image: url("../images/images.jpg");
                }

              <?php if ($shift):?>
                #my_camera{
                    margin-left: 420px;
                    height: 150px;
                    width:150px;
                    position: relative;
                    border: none;
                    border-radius: 10px;
                    margin-top: 80px;
                    text-align: center;
                    background-image: url("../images/images.jpg");
                }
                .btn-sm{
                            margin-left: 445px;
                            margin-top: -40px;
                            position: fixed;
                            background-color:#2F0916;
                            border: none;
                            color: white;
                            }
                  .btn-primary{
                             margin-left: 458px;
                             margin-top: -40px;
                              background-color:#2F0916;
                              position: absolute;
                              border: none;
                              
                        }
              <?php endif ?>

            
        }

                .btn-default{

                    width:500px;
                    margin-left: 600px;
                    margin-top: 335px;
                    position: absolute;
                    background-color: #A042FF;
                    
                }


               .btn-success:hover{
                background-color: #2F0923;

               }
               #register{

                bottom: 10%;
                border-radius: 3px;
                background-color: #2F0916;
                color: #fff;

               }
               @media screen and (max-width: 40em){

                .RegArea{

                  height: 1300px;



                }
                  #register{

               width: 77%;
               margin-left: 115px;

               }

               }

            </style>
            <script>
              $('#register').show();
            </script>
    </form>  
    </div>
</div>
     <script language="JavaScript">
       
        // preload shutter audio clip
        var shutter = new Audio();
        shutter.autoplay = false;
        shutter.src = navigator.userAgent.match(/Firefox/) ? 'shutter.ogg' : 'shutter.mp3';
        
        function take_snapshot() {
            // play sound effect
            shutter.play();
            // take snapshot and get image data
            Webcam.snap( function(data_uri) {
                // display results in page
                document.getElementById('my_camera').innerHTML ='<img id="upload-preview" src="'+data_uri+'"/>';
                $(".icon-choose-image").css('opacity','0.2');
            } );
        }

        function saveSnap(){
       
         // Get base64 value from <img id='imageprev'> source
            var base64image =  document.getElementById("upload-preview").src;
             $(".icon-choose-image").css('opacity','0.2');
             Webcam.upload( base64image, "../imageProcess1.php", function(code, text) {
                 console.log('Saved successfully');
                 //console.log(text);

            });


               //Webcam.reset();


            //document.getElementById('my_camera').innerHTML +='<div class="word"><p>Successfully Uploaded! To take another Picture, Click "Register" without filling the Form. Continue with "Access Webcam"</p></div>';
           
              
        }
            document.getElementById("snap").addEventListener("click", function() {
               //context.drawImage(video, 0, 0, 640, 480);
                // Littel effects
               // $('#video').fadeOut('slow');
                //$('#canvas').fadeIn('slow');
                $('#snap').hide();
                $('#body-overlay').show();
                $('#register').show();
                $('#access').show();
                //$('#new').show();
                
                // Allso show upload button
                //$('#upload').show();
            });    
    </script>
   
   
    <!--script src="../assets/jquery-1.11.3-jquery.min.js"></script-->
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../js/croppie.js"></script>
    
   <script src="../js/datepicker.js"></script>
  <script>
    $(function() {
      $('[data-toggle="datepicker"]').datepicker({
        autoHide: true,
        zIndex: 2048,
      });
    });
  </script>
  
   <?php if ($logout):?>
    <script language="Javascript">
    $('#drop').hide();
    </script>
    <?php endif ?>
                 <style>
                    footer {
                        
                       
                        display: block;
                        color: ;
                        width: 100%;
                        font-size: 14px;
                        position: fixed;
                        background-color:#2F0916;
                        bottom: 0px;
                        text-align: center;
                        text-decoration: none;
                        border-top: 2px solid purple;
                        border-radius: none;
                        color:#fff ;
                    }
                </style>
    <footer>Department of Computer Engineering - Futminna &copy; 2018. All Rights Reserved Final Year Project. Developed by <a href="https://www.facebook.com/akoredeezekiel.ojeyemi" target="_blank">Korede Ojeyemi</a></footer> 
</body>         
</html>
<div id="uploadimageModal" class="modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content"  style="height:700px;">
      		<div class="modal-header">
          <!-- add onclick="$('#snap').show();" to show upload button after close is clicked -->
        		<button type="button" class="close"  data-dismiss="modal">&times;</button>
        		<h4 class="modal-title">You Must Reduce Your Profile Picture Size</h4>
      		</div>
      		<div class="modal-body">
        		<div class="row">
  					<div class="col-md-8 text-center">
						  <div id="image_demo" style="width:350px; margin-top:30px; position:relative;"></div>
  					</div>
  					<div class="col-md-4" style="padding-top:30px;">
  						<br />
  						<br />
  						<br/>
						  <!--button style="margin-left:-420px; margin-top:300px;" class="btn btn-success crop_image">Crop & Upload Image</button-->
					</div>
				</div>
      		</div>
      		<div class="modal-footer" style="margin-top:550px;">
                    <!-- add onclick="$('#snap').show();" to show upload button after close is clicked -->
        		<button type="button"  class="btn btn-success crop_image"  data-dismiss="modal">Crop & Upload Image</button>
      		</div>
    	</div>
    </div>
</div>
<script>  
$(document).ready(function(){

	$image_crop = $('#image_demo').croppie({
    enableExif: true,
    viewport: {
      width:200,
      height:200,
      type:'square' //circle
    },
    boundary:{
      width:300,
      height:300
    }
  });

  $('#upload_image').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      $image_crop.croppie('bind', {
        url: event.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
    $('#uploadimageModal').modal('show');
  });

  $('.crop_image').click(function(event){
    $image_crop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function(response){
      $.ajax({
        url:"upload.php",
        type: "POST",
        data:{"image": response},
        success:function(data)
        {
          $('#uploadimageModal').modal('hide');
          $('#targetLayer').html(data);
        }
      });
    })
  });

});  
</script>
<?php unset($_SESSION['editl']);
 ob_end_flush(); ?>