<?php
/*
Akshay Khairmode
*/

class Version {

private $asset_extns;

public function __construct(){

	//assets possible extensions
	$this->asset_extns = array('js','png','gif','jpg','jpeg','css');

}

private function URL_exists($url){
   $headers=get_headers($url);
 
   if(stripos($headers[0],"200 OK")){

   	$extension = pathinfo($url,PATHINFO_EXTENSION);

   	if(in_array($extension, $this->asset_extns) !== false){

   		$return['status'] = true;

   		$mod = trim($headers[3],"Last-Modified:");
		$dt = new DateTime($mod, new DateTimezone('UTC'));
		$return['modified'] = $dt->getTimestamp();

   	}else{

   		throw new Exception("Version Error : Can only be used for assets with following extensions " .implode(", ", $this->asset_extns));
   	}

   }else{
   		$return['status'] = false;
   }
   
   return $return;
}

		public function relative_version($path){
			try{
				if(file_exists($path)){
					$extension = pathinfo($path,PATHINFO_EXTENSION);
					if(in_array($extension, $this->asset_extns) !== false){

						$modifiedTime = filemtime($path);
						$newPath = $path . "?v=" . $modifiedTime;
						return $newPath;

					}else{
						throw new Exception("Version Error : Can only be used for assets with following extensions " .implode(", ", $this->asset_extns));
					}
				}else{
					throw new Exception("Version Error : File  not found in  the specified Path");
				}
			}catch(Exception $e){
				echo $e->getMessage();
			}	
		}

		public function absolute_version($path){

			try{

				$URL_data = $this->URL_exists($path);
				$modifiedTime = (isset($URL_data['modified'])) ?  $URL_data['modified'] : false ;
				$status = $URL_data['status'];


				if($status === false){

					throw new Exception("Version Error : File does not exist.");
					
				}elseif(empty($modifiedTime) !== false){

					throw new Exception("Version Error : File modified time is empty");

				}else{

					$extension = pathinfo($path,PATHINFO_EXTENSION);

					if(in_array($extension, $this->asset_extns) !== false){

						$newPath = $path . "?v=" . $modifiedTime;
						return $newPath;

					}else{

						throw new Exception("Version Error : Can only be used for assets with following extensions " .implode(", ", $this->asset_extns));
						
					}
					
				}
			}catch(Exception $e){
				echo $e->getMessage();
			}
		}
}

?>
