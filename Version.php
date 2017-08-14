<?php

class Version {

private $asset_extns;

public function __construct(){

	//assets possible extensions
	$this->asset_extns = array('js','png','gif','jpg','jpeg','css');

}

public function relative_version($path){
		if(file_exists($path)){
			$extension = pathinfo($path,PATHINFO_EXTENSION);
			if(in_array($extension, $this->asset_extns) !== false){
				$modifiedTime = filemtime($path);
				$newPath = $path . "?v=" . $modifiedTime;
				return $newPath;
			}else{
				die("Version Error : Can only be used for following file types " .implode(", ", $this->asset_extns));
			}
		}else{
			die("Version Error : File not found in the specified Path");
		}
	}

}