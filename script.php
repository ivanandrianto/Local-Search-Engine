<script type="text/javascript">
	function getRootDir(){
		var urlpath = "dirList.php?dir=" + "\\" + "&curDir=C:";
		$.ajax({
			type: "POST",
		  url: urlpath,
		  success: function(data) {
			$("#dir").html(data);
		  }
		});
	}
</script>
<script>
	$(document).ready(function(){
		$("#dir").change(function() {

			var dir = $(dirSelect).val();
			var curDir = document.getElementById('dirpath').value;
			var urlpath = 'dirList.php?dir=' + dir + '&curDir=' + curDir;
			$.ajax({
				type: "POST",
			  url: urlpath,
			  success: function(data) {
				$("#dir").html(data);
			  }
			});
			
			if(dir != ""){
				if((dir != "dirUp") && (dir != "selDri")){
					if(curDir == "Select Drive"){
						var curDir = dir;
					} else {
						var curDir = curDir + '\\' + dir;
					}
					document.getElementById("dirpath").value = curDir;
				} else if(dir != "selDri"){
					
					var lastbackslash;
					var backslashfound = false;
					var j = curDir.length-1;
					
					while (backslashfound == false){
						if(curDir.charAt(j) == '\\'){
							backslashfound = true;
						}
						j--;
					}
					var res = curDir.substring(0, j+1);
					document.getElementById("dirpath").value = res;
				} else {
					document.getElementById("dirpath").value = "Select Drive";
				}
			}
		});
    });
</script>