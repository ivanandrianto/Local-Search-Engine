<html>
<head>
<script type="text/javascript">
</script>
</head>
<body>
<?php
if (empty($_GET["dir"])){
	$dir = "";
} else {
	$dir = $_GET["dir"];
}
if (empty($_GET["curDir"])){
	$curDir = "";
} else {
	$curDir = $_GET["curDir"];
}
	$notToRoot;	
	if($dir != "selDri"){
		if((strlen($dir)==2) && ($dir{1}=':')){
			$command = "chdir";
			exec($command,$output2,$return);
			$curDrive=$output2[0];
			if($curDrive{0} != $dir{0}){
				$command=$dir;
			} else {
				$command="cd\\";
			}
		} else if($dir == "dirUp"){
			//check number of backslash
			$count = 0;
			$i = 0;
			while($i<strlen($curDir)){
				if($curDir{$i} == '\\'){
					$count++;
				}
				$i++;
			}
			if($count>2){
				$notToRoot = true;
			} else {
				$notToRoot = false;
			}
			$curDirLength = strlen($curDir);
				$substrLength = $curDirLength-2;
				if($substrLength>0){
					$str = substr($curDir,2,$substrLength);
					$command="cd \\";
					$command.=" && "."cd ".$str;
				} else {
					$command="cd \\";
				}
				$command.=" && "."cd ..";
		} else {
			if($dir != "\\"){
				$notToRoot = true;
				$curDirLength = strlen($curDir);
				$substrLength = $curDirLength-2;
				if($substrLength>0){
					$str = substr($curDir,2,$substrLength);
					$command="cd \\";
					$command.=" && "."cd ".$str;
				} else {
					$command="cd \\";
				}
				$command.=" && "."cd ".$dir;
			} else {
				$notToRoot = false;
				$command="cd ".$dir;				
			}
		}
		$command.=" && "."dir /ad /b";
		exec($command,$output,$return);
		$arraysize = count($output);
		$i=0;
		echo "<select name='dirSelect' size='5' id='dirSelect'>";
		if($notToRoot){
			echo "<option value='dirUp'>Up Directory</option>";
		} else {
			/*if($curDir{0} == 'C'){
				echo "<option value='\E'>E:</option>";
			} else {
				echo "<option value='\C'>C:</option>";
			}*/
			echo "<option value='selDri'>Select Drive</option>";
		}
		while($i<$arraysize){
			echo "<option class='folder_item' value='".$output[$i]."'>".$output[$i]."</option>";
			$i++;
		}
		echo "</select>";
	} else {
		$command = "wmic logicaldisk where drivetype=3 get caption";
		exec($command,$output,$return);
		$arraysize = count($output)-1;
		
		echo "<select name='dirSelect' size='5' id='dirSelect'>";
		$i=1;
		while($i<$arraysize){
			echo "<option class='drive_item'  value='".$output[$i]."'>".$output[$i]."</option>";
			$i++;
		}
		echo "</select>";
	}
	
	
?>
</body>
</html>
