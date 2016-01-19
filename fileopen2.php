<?php 

if (empty($_GET["path"])){
	$path = "";
} else {
	$path = $_GET["path"];
	$path_valid = true;
}



if($path_valid){
	session_start();
		ob_end_flush();
		ob_start();
		$descriptorspec = array(
			0 => array("pipe", "r"),   // stdin is a pipe that the child will read from
			1 => array("pipe", "w")   // stdout is a pipe that the child will write to
			//2 => array("pipe", "w")    // stderr is a pipe that the child will write to
		);
		
		$process = proc_open("OpenFile.exe ".escapeshellarg($path), $descriptorspec, $pipes);
		if (is_resource($process)) {
		
		}
		proc_close($process);
}
echo '<script language="javascript"> window.close(); </script>';
?>