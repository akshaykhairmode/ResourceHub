<?php  

/*
Akshay Khairmode
*/

class Multithreading
{

    function do_in_background($url, $params, $ssl)
    {
	    $post_string = http_build_query($params);
	    $parts = parse_url($url);
            $errno = 0;
	    $errstr = "";

	    if($ssl === true){
	    //For secure server
	     $fp = fsockopen('ssl://' . $parts['host'], isset($parts['port']) 
                  ? $parts['port'] : 443, $errno, $errstr, 30);
	    }elseif($ssl === false){
	    // For localhost and un-secure server
	   	 $fp = fsockopen($parts['host'], isset($parts['port']) 
                    ? $parts['port'] : 80, $errno, $errstr, 30);
	    }
	   
	    if(!$fp)
	    {
	        echo "Error while opening socket connection";    
	    }
	    $out = "POST ".$parts['path']." HTTP/1.1\r\n";
	    $out.= "Host: ".$parts['host']."\r\n";
	    $out.= "Content-Type: application/x-www-form-urlencoded\r\n";
	    $out.= "Content-Length: ".strlen($post_string)."\r\n";
	    $out.= "Connection: Close\r\n\r\n";
	    if (isset($post_string)) $out.= $post_string;
	    fwrite($fp, $out);
	    fclose($fp);
  }
}
?>