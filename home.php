<html>
<head>
	<title>SRC48 Search Engine</title>
	<link rel="stylesheet" href="style/style.css">
	<script type="text/javascript" src="assets/js/jquery-1.8.2.js"></script>
	<script type="text/javascript" src="assets/js/jquery-ui.js"></script>
</head>
<body onload="getRootDir()">
<?php //include('header.php');?>
<div class="container">
<?php include('header.php');?>
<div class="content">
<center>
<script>
$(document).ready(function(){
	$("#adv-option").hide();
    $("#adv-search").click(function(){
        $("#adv-option").toggle(1000);
    });
});
</script>
<?php include('script.php');?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	set_time_limit(1000);
	
	$keyword=(isset($_POST['keyword']))?$_POST['keyword']:'';
	$dirpath=(isset($_POST['dirpath']))?$_POST['dirpath']:'';
	$searchtype=(isset($_POST['searchtype']))?$_POST['searchtype']:'';
	if($keyword != ''){
		$out = array();
		$command="C:/z/WindowsFormsApplication1.exe"." ".$keyword." ".$dirpath." ".$searchtype;
		//exec($command,$output,$return);

		
		/* START CARA PAKE XML */
		/*
		$keyword=(isset($_POST['keyword']))?$_POST['keyword']:'';
		$keywordtag = "<Keyword>".$keyword."</Keyword>";
		$directory=(isset($_POST['directory']))?$_POST['directory']:'';
		$directorytag = "<Directory>".$directory."</Directory>";
		$searchtype=(isset($_POST['search_type']))?$_POST['directory_value']:'';
		$searchtypetag = "<SearchType>".$searchtype."</SearchType>";
		$waktusekarang = strtotime('now');
		$filetag = "<File>".$keyword."-".$waktusekarang."</File>";
		
		//wait other process to finish
		$status = 0;
		while($status == 0){
			$myfile = fopen("status.txt", "r") or die("Unable to open file!");
			$status = fgets($myfile);
			if($status{0} == '1'){
				$status=1;
			}
			fclose($myfile);
		}
		
		//kembalikan status ke 0
		$File = "status.txt";
		$Handle = fopen($File, 'w');
		fwrite($Handle,"0");
		fclose($Handle);
		
		//menulis ke file
		$File = "File.xml";
		$Handle = fopen($File, 'w');
		fwrite($Handle,"<?xml version=\"1.0\" encoding=\"UTF-8\"?>");
		fwrite($Handle,"<Data>");
		fwrite($Handle,$keywordtag);
		fwrite($Handle,$directorytag);
		fwrite($Handle,$searchtypetag);
		fwrite($Handle,$filetag);
		fwrite($Handle, "</Data>");
		fclose($Handle);
		
		//waiting for result
		$status = 0;
		while($status == 0){
			$myfile = fopen("status.txt", "r") or die("Unable to open file!");
			$status = fgets($myfile);
			if($status{0} == '1'){
				$status=1;
			}
			fclose($myfile);
		}
		*/
		/* END CARA PAKE XML */
		//redirect and display result'
		$redirectURL = "search.php?keyword=".$keyword."&path=".$dirpath."&type=".$searchtype;
		header("Location:".$redirectURL);
	}
}
?>
<img id="main-logo" width="100px" width="100px" src="images/logo/logo2.jpg">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
	<div id="input-keyword"><input style="height:40px;" type="text" placeholder="keyword" name="keyword" id="keyword" value=""  required><input type="submit" name="submit-search" id="submit-search" value=""></div><br/>
	<div id="adv-search">Advanced Search</div>
	<div id="adv-option">
	<input type="text" name="dirpath" id="dirpath" value="C:" readonly >
	<div class id="dir"></div>
	<div class="sel">
	<label><input type="radio" name="searchtype" value="DFS" required checked>DFS</option></label></br>
	<label><input type="radio" name="searchtype" value="BFS">BFS</option></label></br>
	</div>
	</div>
</form>
</center>
</div>
<div id="foot">(C)2015 SRC48. All rights reserved</div>
</div>
<center>
<?php include('footer.php');?>
</center>
</div>
</body>
</html>