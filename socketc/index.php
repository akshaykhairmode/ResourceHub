<?php require("Socket.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Socket Caller</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<style type="text/css">
	div {
		font-family: sans-serif;
	}
</style>
<body style="margin-top: 20px;">
	<div class="container">
		<div class="row col-md-6 col-md-offset-3">
			<div class="panel panel-default">
		     <div class="panel-heading">Execute Script</div>
			  <div class="panel-body">
			  	<form method="POST" name="socketui_submit" accept-charset="utf-8">
				  
				  <div class="form-group">
				    <label for="url">URL:</label>
				  	<div class="input-group">
				    <span class="input-group-addon">
				    	  <select id="channel" name="channel">
						    <option value="http">HTTP</option>
						    <option value="https">HTTPS</option>
						  </select>
						  <span><b>://</b></span>
				    </span>
				    <input type="text" class="form-control" id="url" name="url" placeholder="eg : www.google.com" value="<?php echo (isset($_POST['url'])) ?  $_POST['url'] : '' ; ?>"  required>
					</div>
				  </div>

					<div class="form-group">
					    <label for="data">Data to send (Comma Seperated) or JSON Object:</label>
					    <input type="text" class="form-control" id="data" name="data" placeholder="test1,test2,test3 or {'first':'test1','second':'test2','third':'test3'}">
				  	</div>

				  	<div class="checkbox-inline">
					  <label><input type="radio" name="process" value="B" required>Execute in Background</label><br>
					  <label><input type="radio" name="process" value="F" required>Execute in Foreground</label>
					</div>

				  <div class="form-group">
				   <input type="submit" name="submitURL" onclick="return validate();" class="form-control btn btn-primary" id="url">
				  </div>
				</form>
				<div id="messageDiv" class="text-info"></div>
			  </div>
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
			</div>
		</div>
		<div class="row col-md-6 col-md-offset-3">
			<?php 
				if(isset($_POST['submitURL'])){

					$socket = new Socket;

					$parsed = parse_url($_POST['url']);

					if (empty($parsed['scheme'])) {
					    
						$url = $_POST['channel'] . "://" . $_POST['url'];

					}


					if(isset($_POST['data'])){

						$json_data = $_POST['data'];

						if($json_data[0] == "{" or $json_data[0] == "[" ){

							$params = json_decode($json_data,true);

						}else{

							$params = explode(",", $json_data);

						}

					}else{
						$params = false;
					}

					if($_POST['channel'] == "http"){
						$channel = false;
					}elseif($_POST['channel'] == "https"){
						$channel = true;
					}

					if($_POST['process'] == "B"){

						echo $socket->do_in_background($url,$params,$channel);

					}elseif($_POST['process'] == "F"){
						
						echo $socket->do_in_foreground($url,$params,$channel);

					}
				}
			?>
		</div>
	</div>
	<script type="text/javascript">
		function validate(){
			// var post_data = $("#data").val();
			$("#messageDiv").html("");
			var url = $("#url").val();
			if(url.startsWith("http") === true){
				$("#messageDiv").html("URL should not contain http or https");
				return false;
			}
		}
	</script>
</body>
</html>