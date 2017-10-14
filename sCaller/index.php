<?php require("Socket.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Socket Caller</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body style="margin-top: 20px;">
	<div class="container">
		<div class="row col-md-6">
			<div class="panel panel-default">
		     <div class="panel-heading">Execute Script in background</div>
			  <div class="panel-body">
			  	<form method="POST" name="socketui_submit" accept-charset="utf-8">
				  
				  <div class="form-group">
				    <label for="url">URL:</label>
				    <input type="text" class="form-control" id="url" name="url" placeholder="eg : http://localhost/test.php" value="<?php echo (isset($_POST['url'])) ?  $_POST['url'] : '' ; ?>"  required>
				  </div>

				    <div class="form-group">
					  <label for="channel">Select Channel:</label>
					  <select class="form-control" id="channel" name="channel">
					    <option value="http">HTTP</option>
					    <option value="https">HTTPS</option>
					  </select>
					</div>

					<div class="form-group">
					    <label for="data">Data to send (Comma Seperated):</label>
					    <input type="text" class="form-control" id="data" name="data">
				  	</div>

				  	<div class="checkbox-inline">
					  <label><input type="radio" name="process" value="B" required>Execute in Background</label><br>
					  <label><input type="radio" name="process" value="F" required>Execute in Foreground</label>
					</div>

				  <div class="form-group">
				   <input type="submit" name="submitURL" class="form-control btn btn-primary" id="url">
				  </div>
				</form>
			  </div>
			</div>
		</div>
		<div class="row col-md-12">
			<?php 
				if(isset($_POST['submitURL'])){

					$socket = new Socket;

					$url = $_POST['url'];

					if(isset($_POST['data'])){
						$params = explode(",", $_POST['data']);
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

						$socket->do_in_foreground($url,$params,$channel);

					}
				}
			?>
		</div>
	</div>
</body>
</html>