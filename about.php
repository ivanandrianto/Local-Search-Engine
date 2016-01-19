<html>
<head>
	<title>About US | SRC48</title>
	<link rel="stylesheet" href="style/style.css">
	<script type="text/javascript" src="assets/js/jquery-1.8.2.js"></script>
	<script type="text/javascript" src="assets/js/jquery-ui.js"></script>
</head>
<body onload="getRootDir()">
<script>
$(document).ready(function(){
		$("#about-content").show();
		$("#orang-content").hide();
		
		$("#about").click(function(){
			$("#about-content").show();
			$("#orang-content").hide();
		});
		
		$("#orang").click(function(){
			$("#about-content").hide();
			$("#orang-content").show();
		});
    });
</script>
<?php include('header.php');



?>
<div class="container">
<div class="sidebar">
<table id="table-menu-about" border="1" width="200" style="border-style:none;border-radius:5px;">
<tr><td><div id="about">About</div></td></tr>
<tr><td><div id="orang">Orang</div></td></tr>
</table>
</div>
<div class="primary-content">
<div id="about-content"><h2>About</h2>SRC48 adalah mesin pencari lokal yang terinspirasi dari idol group JKT48</div>
<div id="orang-content"><h2>Orang</h2>
<center>
<p>
<img src="images/pp/tm.jpg" width="300" width="300"><br>
Pratama Nugraha Damanik
</p>
<p>
<img src="images/pp/ivn.jpg" width="300" width="300"><br>
Ivan Andrianto
</p>
<p>
<img src="images/pp/mhs.jpg" width="300" width="300"><br>
Mahesa Gandakusuma
</p>
</center>
</div>
</div>
<?php include('script.php');?>
<?php

?>
<div id="recent_search">
</div>
<div id="result">
</div>


<div id="res"></div>
<div id="foot">(C)2015 SRC48. All rights reserved</div>
</div>
</center>
<?php include('footer.php');?>
</div>

</body>
</html>