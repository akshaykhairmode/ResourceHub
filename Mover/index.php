<!-- Akshay Khairmode
12092017 -->
<?php
require '../Version.php';
$version = new Version;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>File Mover</title>
	<link rel="stylesheet" href="<?php echo $version->relative_version('./assets/bootstrap/css/bootstrap.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo $version->relative_version('./assets/font-awesome/css/font-awesome.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo $version->relative_version('./assets/bootstrap-social/bootstrap-social.css'); ?>">
	<script src="<?php echo $version->relative_version('./assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
  <script src="<?php echo $version->relative_version('./assets/jquery/jquery-3.2.1.min.js'); ?>"></script>
  <script src="<?php echo $version->relative_version('./assets/js/index.js'); ?>"></script>
</head>
<body>
  <style type="text/css">
    #disp{
      max-height: 700px !important;
      overflow-y: auto !important;
    }
    body{
      background: url("./assets/images/body.png");
    }
    table td {
      color:black !important;
    }
    table thead {
      color:black !important;
    }
    table {
      background-color: white !important;
    }
  </style>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand"><span><img src="<?php echo $version->relative_version('./assets/images/logo.png'); ?>" width="25" height="25"></span>File Mover Alpha</a>
    </div>
  </div>
</nav>
<div class="container" style="display:none;">
<div class="row">
<div class="col-md-5">
<div class="panel panel-default">
<div class="panel-heading"><b class="text-center">Select Options</b></div>
<div class="panel-body">
<form method="POST" name="form" id="form">
<br>
  <div class="form-group">
    <label >Date format to Check in Filenames.<b class="text-info">(Single value only)</b></label>
    <input type="text" name="date_format" id="date_format" class="form-control" placeholder="eg: dmY or d-m-Y" value="<?php echo (isset($_POST['date_format'])) ? $_POST['date_format'] : '' ; ?>">
    <div id="showDate"></div>
  </div>
 <div class="form-group">
    <label>Please select a seperator. <b class="text-info">Default : _  (Single Values only) </b></label>
    <input type="text" class="form-control" id="seperator" name="seperator" placeholder="eg: _ or # or -" value="<?php echo (isset($_POST['seperator'])) ? $_POST['seperator'] : '' ; ?>">
  </div>
  <div class="form-group">
    <label for="content">String to check in File Names.<b class="text-info">(Comma Seperated/Single Values)</b></label>
    <input type="text" class="form-control" id="content" name="content" placeholder="test,backup,etc" value="<?php echo (isset($_POST['content'])) ? $_POST['content'] : '' ; ?>">
  </div>
  <div class="form-group">
    <label for="content">Exclude these folders.<b class="text-info">Default: mBackup (Comma Seperated/Single Values)</b><b class="text-danger"> Case Sensitive</b></label>
    <input type="text" class="form-control" id="exclude" name="exclude" placeholder="eg: data , important" value="<?php echo (isset($_POST['exclude'])) ? $_POST['exclude'] : '' ; ?>">
  </div>
  <div class="form-group">
    <label for="content">Please specify backup folder name. <b class="text-info">Default: mBackup (Single Value Only) <b class="text-danger"> Case Sensitive</b></b></label>
    <input type="text" class="form-control" id="folderName" name="folderName" placeholder="eg: my_backups" value="<?php echo (isset($_POST['folderName'])) ? $_POST['folderName'] : '' ; ?>">
  </div>
  <div class="form-group">
    <label for="content">Execution Location</label>
    <input type="text" class="form-control" id="folder" name="folder" placeholder="Folder relative path" value="<?php echo (isset($_POST['folder'])) ? $_POST['folder'] : '' ; ?>">
  </div>
<button type="submit" class="btn btn-danger" name="submitForm" id="submitForm">Start Mover</button>
<button type="button" class="btn btn-primary" name="showFiles" id="showFiles">Get a list of matching files</button><br><br>
<button type="button" class="btn btn-info" name="sessExec" id="sessExec">Start Script for Currently Matched Files</button>
<input type="hidden" name="showMatch" id="showMatch" value="">
<input type="hidden" name="sessMove" id="sessMove" value="">
</form>
</div> <!-- Panel Body Close -->
<div class="text-center" style="padding-bottom: 10px;"><!-- Footer -->
  <a class="btn btn-social-icon btn-twitter" href="https://twitter.com/KhairmodeAkshay" target="_blank">
    <span class="fa fa-twitter"></span>
  </a>
  <a class="btn btn-social-icon btn-facebook" href="https://www.facebook.com/akshaykhairmode" target="_blank">
    <span class="fa fa-facebook"></span>
  </a>
  <a class="btn btn-social-icon btn-linkedin" href="https://www.linkedin.com/in/akshay-khairmode-95633471" target="_blank">
    <span class="fa fa-linkedin"></span>
  </a>
  <a class="btn btn-social-icon btn-github" href="https://github.com/akshaykhairmode" target="_blank">
    <span class="fa fa-github"></span>
  </a>
  <a class="btn btn-social-icon btn-google" href="https://plus.google.com/+akshaykhairmode" target="_blank">
    <span class="fa fa-google"></span>
  </a>
</div>
</div><!-- Panel DIV -->
</div> <!-- col-md-6 -->
<div id="disp" class="col-md-6" style="color:white;"></div>
<div class="col-md-1" id="loader" style="display:none;" ><img src="./assets/images/Magnify.gif"></div>
</div> <!-- Row Close -->
</div> <!-- Container Close -->
</body>
</html>