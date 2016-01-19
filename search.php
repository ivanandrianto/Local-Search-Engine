<html>
<head>
	<title>Search | SRC48</title>
	<link rel="stylesheet" href="style/style.css">
	<script type="text/javascript" src="assets/js/jquery-1.8.2.js"></script>
	<script type="text/javascript" src="assets/js/jquery-ui.js"></script>
</head>
<body onload="getRootDir()">
<?php include('header.php');
$res_string="";
$keyword_valid = $path_valid = $type_valid = false;

if (empty($_GET["keyword"])){
	$keyword = "";
} else {
	$keyword = $_GET["keyword"];
	$keyword_valid = true;
}

if (empty($_GET["path"])){
	$path = "";
} else {
	$path = $_GET["path"];
	$path_valid = true;
}

if (empty($_GET["type"])){
	$type = "";
} else {
	$type = $_GET["type"];
	$type_valid = true;
}

echo "<script type='text/javascript'>zx()</script>";

?>
<div class="container">
<div class="sidebar">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
	<div id="input-keyword"><input style="height:40px;" type="text" placeholder="keyword" name="keyword" id="keyword" value=""  required><input type="submit" name="submit-search" id="submit-search" value=""></div><br/>
	<div id="adv-search">Advanced Search</div>
	<div id="adv-option">
	<input type="text" name="dirpath" id="dirpath" value="C:" readonly >
	<div class="sidebar-dir" id="dir"></div>
	<div class="sel">
	<label><input type="radio" name="searchtype" value="DFS" required checked>DFS</option></label></br>
	<label><input type="radio" name="searchtype" value="BFS">BFS</option></label></br>
	</div>
	</div>
</form>
</div>
<div class="content-result">
<div id="percent-bar-wrapper">
	<div id="percent-bar-area">
		<div id="percent-bar" style="width:0%">	
		</div>
	</div>
	<div id="percentage"></div>
</div>
<div id="pr">
<center><div id="searchname"></div></center>
<center><div id="numres"></div></center>
<center><div id="time"></div></center>

</div>
<div id="res"></div>
<div id="tree"></div>
<?php include('script.php');?>
<?php
ini_set('max_execution_time', 300);

$command="SearchEngine.exe ".$keyword." ".$type." ".$path;
$cmd=$command;
//$command="C:/z/WindowsFormsApplication1.exe"." ".$keyword." ".$dirpath." ".$searchtype;
if($keyword_valid && $path_valid && $type_valid){

	/*exec($command,$output,$return);
	$xmlDoc = new DOMDocument();
	$xmlDoc->load("results.xml");

	$results = $xmlDoc->getElementsByTagName( "Result" );
	  foreach( $results as $res )
	  {
	  $titles = $res->getElementsByTagName( "Title" );
	  $title = $titles->item(0)->nodeValue;
	  
	  $contents = $res->getElementsByTagName( "Content" );
	  $content = $contents->item(0)->nodeValue;
	  
	  $locations = $res->getElementsByTagName( "Location" );
	  $location = $locations->item(0)->nodeValue;
	  
	  echo $title."-".$content."-".$location;	 
	  }*/
		session_start();
		ob_end_flush();
		ob_start();
		$descriptorspec = array(
			0 => array("pipe", "r"),   // stdin is a pipe that the child will read from
			1 => array("pipe", "w")   // stdout is a pipe that the child will write to
			//2 => array("pipe", "w")    // stderr is a pipe that the child will write to
		);
		$count = 0;
		$process = proc_open("SearchEngine.exe ".escapeshellarg($keyword)." ". escapeshellarg($path)." ".escapeshellarg($type), $descriptorspec, $pipes);
		$percent = 0;
		$finish = false;
		if (is_resource($process)) {
			/*fwrite($pipes[0],$keyword."\n");
			fwrite($pipes[0],$path."\n");
			fwrite($pipes[0],$type."\n");
			fclose($pipes[0]);*/
			echo '<script language="javascript"> document.getElementById("searchname").innerHTML = "Hasil pencarian untuk <strong>'.$keyword.'</strong><br>Jenis Penelusuran '.$type.'<br>Path '.str_replace("\\", "\\\\", $path).'"</script>';
			while(($percent<100) && (!$finish)){
				$str = stream_get_line($pipes[1],1024,"[");
				$tag = stream_get_line($pipes[1],1024,"]");
				if(strcmp($tag,"Progress") == 0){
					//$percent = floatval(stream_get_line($pipes[1],1024,"[/Progress]"));
					$per = stream_get_line($pipes[1],1024,"[/Progress]");
					if(strcmp($per,"NaN")==0){
						$finish = true;
					}
					$percen2 = floatval($per);
					$percent = $percen2;
					$echopercent = "<script language='javascript'> document.getElementById('percent-bar-area').innerHTML = \" ";
					$echopercent .= "<div id='percent-bar' style='width:".$percent."%';></div>\" ";
					$echopercent .= "</script>";
					echo $echopercent;
					echo '<script language="javascript"> document.getElementById("percentage").innerHTML = "'.$percent.'%"</script>';
				} else if(strcmp($tag,"Title") == 0){
					$title = stream_get_line($pipes[1],1024,"[/Title]");
					$str = stream_get_line($pipes[1],1024,"[Location]");
					$location = stream_get_line($pipes[1],1024,"[/Location]");
					$location = str_replace('\\', '\\\\', $location);
					//$location = str_replace(':\\', ':\\\\:', $location);
					$str = stream_get_line($pipes[1],1024,"[Excerpt]");
					$excerpt = stream_get_line($pipes[1],1024,"[/Excerpt]");
					$excerpt = str_replace(array("\r\n", "\n\r", "\r", "\n"), " ",$excerpt);
					$excerpt = str_replace('"','\"',$excerpt);
					$excerpt = str_replace('<','&lt;',$excerpt);
					$excerpt = str_replace('>','&gt;',$excerpt);
					//$link = "<a href='file://".$location."'>".$title."</a>";
					//$link = "<a href='file:///".str_replace("/","\\",$location)."\"target = \"_blank\">".$title."</a>";
					//$link = str_replace("\\","\\\\",$link);
					$link = "<a href='fileopen2.php?path=".$location."' target=\'blank_\''>".$title."</a>";
					echo '<script language="javascript"> document.getElementById("res").innerHTML += "<div class=\"res-item\"><div class=\"res-item-title\">'.$link.
					'</div><br><div class=\"res-item-excerpt\">'.$excerpt.'</div></div><br><br>"</script>';
					
					$count++;
					echo '<script language="javascript"> document.getElementById("numres").innerHTML ="'.$count.' hasil ditemukan"</script>';
				}
			echo str_repeat(' ',1024 * 64);
			flush();
			}
			
			$string="";
			$str = stream_get_line($pipes[1],1024,"[Time]");
			$str = stream_get_line($pipes[1],1024,"[/Time]");	
			echo '<script language="javascript"> document.getElementById("time").innerHTML ="Waktu yang diperlukan '.floatval($str).' milisekon"</script>';
			$str = stream_get_line($pipes[1],2048000,"[Tree]");
				$str = stream_get_line($pipes[1],2048000,"[/Tree]");
				$str = str_replace(array("\r\n", "\n\r", "\r", "\n"), "<br>",$str);
				$str = str_replace('\\', '\\\\', $str);
				$str = str_replace(" ", "-",$str);
				//if($str{$l} == ']') {$true=false;}
			echo '<script language="javascript"> document.getElementById("tree").innerHTML ="<pre>'.$str.'</pre>"</script>';
			if($count==0){
				echo '<script language="javascript"> document.getElementById("numres").innerHTML ="Tidak ada hasil"</script>';
			}
			
		}	
		
		proc_close($process);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	set_time_limit(1000);
	
	
	$keyword=(isset($_POST['keyword']))?$_POST['keyword']:'';
	$dirpath=(isset($_POST['dirpath']))?$_POST['dirpath']:'';
	$searchtype=(isset($_POST['searchtype']))?$_POST['searchtype']:'';
	if($keyword != ''){
		$out = array();
		$redirectURL = "search.php?keyword=".$keyword."&path=".$dirpath."&type=".$searchtype;
		header("Location:".$redirectURL);
	}
}
?>
<div id="recent_search">
</div>
<div id="result">
</div>


<div id="res"></div>
</div>
<div id="foot">(C)2015 SRC48. All rights reserved</div>
</div>
<?php include('footer.php');?>

</body>
</html>