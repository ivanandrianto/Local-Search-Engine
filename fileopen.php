<?php 

if (empty($_GET["path"])){
	$path = "";
} else {
	$path = $_GET["path"];
	$path_valid = true;
}

if($path_valid){
	echo "valid";
	echo "<br>";
	$command1 = "OpenFile.exe ";
	$command2 = $path;
	//$command2 = str_replace("\\","\\\\",$command2);
	$command2 = str_replace(" ","%20",$command2);
	$command=$command1.$command2;
	echo $command;
	exec($command);
} else {
	echo "ga valid";
}
echo '<script language="javascript"> window.close(); </script>';
?>