<?php
  ob_start();
  session_start();
  $logout=false;
  $shift=false;
  //$_SESSION['edit'];
  $_SESSION['S_Admin'];
  //echo $_SESSION['user'];
  require_once '../databaseConnect.php';
// if session is not set this will redirect to login page
  if( !isset($_SESSION['S_Admin']) ) {
    $_SESSION['not_logged_in']="You must Log In to Continue";
    header("Location: ../Admin");
    exit;
  }

   
  // select loggedin users detail
  $res=mysql_query("SELECT * FROM admin WHERE Admin_id=".$_SESSION['S_Admin']);
  $userRow=mysql_fetch_array($res);
  //echo $_SESSION['lecturunilorin'];
    $_SESSION['editA'];
    //echo $_SESSION['edit'];
     if (!isset($_SESSION['editA']) && !empty($userRow['phone_number']) && !empty($userRow['picture']) && !empty($userRow['F_name']) && !empty($userRow['S_name'])){

      header("Location: Adhome.php");
      exit;
  }
  
    if ($_SESSION['editA']) {
      $shift=true;
    }
     
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Futminna Edit | Admin's Profile</title>

<link rel="stylesheet" href="../assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="../css/croppie.css" />
 <link rel="stylesheet" media="all" href="../css/font-awesome.min.css">
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
            margin-top: 60px;
            position: absolute;
           
            padding: 10px;
            width: 400px auto;
            font-family: Arial Narrow;
           
            font-style: italic;
            margin-left: 220px;
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
            body{

                 
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
          margin-top: 30px;

        }
        .RegArea{

            width: 1000px;
            height: 100%;
          
           margin-left: 180px;
           position: absolute;
           background-color: #eee;
           box-shadow: 1px 1px 40px 5px #2F0916;
        }
         .form-control:focus{
                            box-shadow: 1px 1px 20px 10px #2F0916;
                             
                        }
        body{
                background-color: #eee;

        }
      .navbar-fixed-top{

        background-color:#2F0916;
        border-bottom: 2px solid #DDA0DD;
        
      }
      .dropdown{

         background-color:  #2F0916;
         border-bottom-right-radius: 10px;
         border-bottom-left-radius: 10px;
      }
     #access{

               position: absolute;
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
        <span class="glyphicon glyphicon-user"></span>&nbsp; Admin's Email: <?php echo $userRow['Email']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                 <?php if (isset($_SESSION['editA']) && $_SESSION['editA']==$userRow['S_name']) {
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
            if (!isset($_SESSION['editA'])) {
    echo '<div class="Warning">You Must Upload Your Profile Picture To Bypass This Page in Your Next Login.<br/>Please Click The Photo Icon in the Passport Area to Choose a Photo OR Use The Webcam.<br/>If You started Your Passport Capture With Webcam and Want To Use File Upload, Refresh The Page.</div>';
  }

        ?>
      <div id="my_camera" align="center">
               <?php //$profpic= $userRow['profile_pic'];?>
                <form id="uploadForm" action="upload.php" method="post">
                <div id="targetLayer"><?php if (file_exists("../images/images.jpg")){?><img src="../upload/<?php if (empty($userRow['picture'])) {
                    echo "images.jpg";# do nothing
                } else{ echo $userRow['picture'];}?>" width="150px" height="150px" class="upload-preview" /--><?php }?></div>
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
    <button type="submit" id="register" form="AdminForm" class="btn btn-lg"  name="Asubmit" value="" onClick="$('#phoicon').show();$(this).show().prev().prev().prev().show();" style="display:none">Save and Continue<i class="fa fa-sign-in" aria-hidden="true"></i></button>
    <input type="submit" id="register" form="AdminForm" class="btn btn-lg"  name="Asubmit" value="Save and Continue" onClick="$('#phoicon').();$('#phoicon').show();$(this).show().prev().prev().prev().prev().show();" style="display:none">
    
    <!--input type="button" class="btn btn-sm btn-success" value="Upload Image"    onClick="saveSnap(); $(this).hide().prev().prev().show();" style="display:none"-->

    <!--input type="button" value="Access Camera" onClick="setup(); $(this).hide().next().show();"-->
    <!--input type="button" value="Take Snapshot" onClick="take_snapshot()" style="display:none"-->
    
    <div class="row">
        <form method="POST" action="Asubmit.php" id="AdminForm" data-toggle="validator" role="form">

         <div class="form-group">
               <span class=""><i class="icon-user icon-large"></i></span>
              <input type="text" name="fname" id="fname" class="form-control" placeholder="Your First Name" maxlength="50" value="<?php echo $userRow['F_name']; ?>" required/>

               
            </div>
            <br/>
            <div class="form-group">
                 <span class=""><i class="icon-user icon-large"></i></span>
                <input type="text" name="sname" id="sname" class="form-control" placeholder="Your Surname" maxlength="50" value="<?php echo $userRow['S_name']; ?>" required/>
                
            </div>
            <br/>
  
             <div class="form-group">
                <span class=""><i class="icon-envelope icon-large"></i></span>
                <input type="email" name="email" id="email" class="form-control" placeholder="Your E-mail" maxlength="50" value="<?php echo $userRow['Email']; ?>" required/>
                
            </div>
            <br/>
            <div class="form-group">
                <span class=""><i class="fa fa-phone-square" style="font-size: 24px;"></i></span>
                <input type="phone" name="phone" id="phone" class="form-control" placeholder="phone Number" maxlength="11" value="<?php echo $userRow['phone_number']; ?>" required/>
                
            </div>
        
      </div>
       <style>
                        .btn-lg{
                            margin-left: 150px;
                            position: absolute;
                            background-color:#2F0916;
                            margin-top: 320px;
                            width: 700px;
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

                            background-color: #8F20FF;
                            color: #ffffff;
                        }
                        .btn-sm{
                            margin-left: 460px;
                            margin-top: -40px;
                            position: fixed;
                            background-color:#2F0916;
                            border: none;
                            color: white;
                            
                            

                        }
                        .btn-success{

                        background-color:#2F0916;
                        border:none;
                        }
                         #register{

                bottom: 8%;
                border-radius: 3px;
                background-color: #2F0916;
                color: #fff;

               }
                         @media screen and (max-width: 40em){

                .RegArea{

                  height: 800px;



                }
                  #register{

               width: 80%;
               margin-left: 105px;
               bottom: 15%;

               }

               }
                        
                        .btn-block{

                            width: -50px;
                            margin-top: 350px;
                            margin-left: 40px;
                            position: absolute;

                        }
                        .btn-primary{
                             margin-left: 470px;
                             margin-top: -40px;
                              background-color:#2F0916;
                              border: none;
                              
                        }
                        .btn-primary:hover{
                             background-color:#8F20FF;
                        }
                </style>

                 <style>
                #my_camera{
                    margin-left: 430px;
                    height: 150px;
                    width:150px;
                    position: relative;
                    border: none;
                    border-radius: 10px;
                    margin-top: 150px;
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
                    background-color: #2F0916;
                    
                }


               .btn-success:hover{
                background-color: #2F0923;

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
             Webcam.upload( base64image, "../imageProcess2.php", function(code, text) {
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
    
  
   <?php if ($logout):?>
    <script language="Javascript">
    $('#drop').hide();
    </script>
    <?php endif ?>
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
        		<button type="button"  class="btn btn-success crop_image" data-dismiss="modal">Crop & Upload Image</button>
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
<?php unset($_SESSION['editA']);
 ob_end_flush(); ?>