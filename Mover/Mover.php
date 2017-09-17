<?php
require '../Socket.php';
class Mover extends Socket{

	private $location;
	private $names;
	private $date;
	private $folder_name;
	private $exit = false;
	private $seperator = "_";
	private $date_format;
	private $form_data;
	private $showdata;
	private $fcount;
	private $excluded_folders = array('mBackup');

	public function __construct(){

		session_start();

		$this->form_data = $_POST;
		$this->location = $this->form_data['folder'];
		$this->date_format = $this->form_data['date_format'];
		$this->folder_name = (!empty($this->form_data['folderName'])) ? $this->form_data['folderName'] : "mBackup" ;
		$this->names = (!empty($this->form_data['content'])) ? $this->form_data['content'] : false ;
		$this->seperator = (!empty($this->form_data['seperator'])) ? $this->form_data['seperator'] : "_";

		if(!is_dir($this->location)){
			echo "The Path Specified Does not exist.";
			$this->exit = true;
			return;
		}

		if(empty($this->date_format) && empty($_POST['content'])){
			echo "Please specify a date format or text content.";
			$this->exit = true;
			return;
		}

		if(count(explode(",",$this->folder_name)) > 1){
			echo "The Folder name must be a single string.";
			$this->exit = true;
			return;
		}

		if(count(explode(",",$this->seperator)) > 1){
			echo "Cannot use multiple seperators.";
			$this->exit = true;
			return;
		}

		

		if(!empty($this->form_data['exclude'])){
			$exp_excluded_folders = explode(",",$this->form_data['exclude']);
			foreach ($exp_excluded_folders as $key => $value) {
				$this->excluded_folders[] = $value;
			}
		}

	}

	private function strposa($haystack, $needle, $offset=0) { // Function which takes needle as array
	    if(!is_array($needle)) $needle = array($needle);
	    foreach($needle as $query) {
	        if(strpos($haystack, $query, $offset) !== false) return true; // stop on first true result
	    }
	    return false;
	}

	private function startMover($files = false){


		if($files === false){
			$set_exit_flag = 1;
			$files = $_SESSION['mover_data'];
		}

		$success_array = array();
		$failed_array = array();

		if(!is_array($files)){
			$files = array($files);
		}

		foreach($files as $file){

			$dirname = dirname($file);
			$filemtime = date('d/M/Y h:i A',filemtime($file));
			$file_ext = pathinfo($file, PATHINFO_EXTENSION);
			$filename_wo_ext = rtrim(basename($file),'.'.$file_ext);
			$filename_w_ext = basename($file);
			$filesize = round(filesize($file)/1024,2);

			if(!file_exists($dirname.DIRECTORY_SEPARATOR.$this->folder_name)){
				mkdir($dirname.DIRECTORY_SEPARATOR.$this->folder_name);
			}

			if(rename($file, $dirname.DIRECTORY_SEPARATOR.$this->folder_name.DIRECTORY_SEPARATOR.$filename_w_ext) === true){

				echo $this->showdata = "<tr>
									<td>".$filename_w_ext."</td>
									<td>".$filesize." KB </td>
									<td>".$filemtime."</td>
									<td>".dirname($file)."</td>
									<td>Success</td>
									</tr>";

			}else{

				echo $this->showdata = "<tr>
									<td>".$filename_w_ext."</td>
									<td>".$filesize." KB </td>
									<td>".$filemtime."</td>
									<td>".dirname($file)."</td>
									<td>Failed</td>
									</tr>";
			}
		}

		if(isset($set_exit_flag)){
				echo $this->showdata = "</tbody></table>";
				exit;
			}
		
	}

	private function checkDate($string){
		if (DateTime::createFromFormat($this->date_format, $string) !== FALSE) { // If a string a date
		    return true;
		}else{
			return false;
		}
	}

	public function Execute(){

		if($this->exit === true){
			return;
		}

		$names_exploded = explode(",",$this->names);
		// print_r($names_exploded);

		$dir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->location));

		if($this->form_data['showMatch'] == "Y"){

			$_SESSION['mover_data'] = array();

			echo $this->showdata = "<div>".$this->fcount."</div><br>
							  <table class='table table-condensed'>
							  <thead>
							  <th>File Name</th>
							  <th>File Size</th>
							  <th>File Modified Date</th>
							  <th>File Path</th>
							  </thead><tbody>";


		}elseif($this->form_data['showMatch'] == "N"){

			echo $this->showdata = "<table class='table table-condensed'>
							  <thead>
							  <th>File Name</th>
							  <th>File Size</th>
							  <th>File Modified Date</th>
							  <th>File Path</th>
							  <th>Status</th>
							  </thead><tbody>";

		}

		if($this->form_data['sessMove'] == "Y"){

			if(!empty($_SESSION['mover_data'])){
				$this->startMover(false);
			}else{
				echo "Session Data not found.";
				return;
			}

		}

		$this->fcount = 0;
		
		foreach ($dir as $name => $fileinfo) {

			// echo $name,"<br>";
			// continue;
			$dirname = dirname($name);
			$file_ext = pathinfo($name, PATHINFO_EXTENSION);
			$filepath = $name;
			$filename_wo_ext = rtrim(basename($name),'.'.$file_ext);
			$filename_w_ext = basename($name);
			$filesize = round(filesize($name)/1024,2);
			$filemtime = date('d/M/Y h:i A',filemtime($name));

			if(in_array($filename_wo_ext,array(".","..")) === true or empty($filename_wo_ext) or $this->strposa($dirname, $this->excluded_folders)){
				continue;
			}

	        $explode_filename = explode($this->seperator, $filename_wo_ext);

	        foreach ($explode_filename as $key => $value) { // Check if date exists in filename

	        	if($this->form_data['showMatch'] == "Y"){

	        		if($this->checkDate($value) === true || in_array($value , $names_exploded) !== false) {

	        			$this->fcount++;

	        			$_SESSION['mover_data'][] = $name;

		        		echo $this->showdata = "<tr>
		        							<td>".$filename_w_ext."</td>
		        							<td>".$filesize." KB </td>
		        							<td>".$filemtime."</td>
		        							<td>".dirname($filepath)."</td>
		        							</tr>";
	        			}
        		}else{

        			if($this->checkDate($value) === true || in_array($value , $names_exploded) !== false) {

		        			$this->fcount++;

	        				$this->startMover($name);

	        			}


        		}
	        }
		   
		}//Foreach Close

		if($this->fcount == 0) { echo $this->showdata = "<tr><td colspan=4 align='center'>No Files Found</td></tr>" ;}

		echo $this->showdata = "</tbody></table>";

	}//Execute Close

}//Class Close

$mover = new Mover();
$mover->Execute();
?>