<?php
	
	if(isset($_COOKIE["username"]) && isset($_COOKIE["password"])) header("Location: /launch.php");
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Kingdom of Thelalle</title>
		<link rel="stylesheet" href="style.css">
		<script>
		function getResponse(url, callback) {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if(this.readyState == 4 && this.status == 200) {
			callback(xhttp.responseText);
		}
	};
	xhttp.open("GET", url, true);
	xhttp.send();
}
		</script>
		
		<!-- DISABLE CACHE -->
		<meta http-equiv="cache-control" content="max-age=0" />
		<meta http-equiv="cache-control" content="no-cache" />
		<meta http-equiv="expires" content="0" />
		<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
		<meta http-equiv="pragma" content="no-cache" />
		
	</head>
	<body>
		<div class="content">
			<div class="box">
				<div class="box-inner-padding">
					<h1 style="margin-bottom: 15px;">Login</h1>
					<p>Username:</p>
					<input id="username" type="text" class="input" name="username" style="margin-bottom: 15px;" />
					<p>Password:</p>
					<input id="password" type="password" class="input" name="password" style="margin-bottom: 15px;" />
					<a onclick="join()" href="javascript:void()" class="button">Join!</a>
					<br /><br />
					<!--<a href="/register.php" style="color: #000;">Inregistreaza-te!</a>-->
				</div>
			</div>
		</div>
		<script>
			var screenHeight = window.innerHeight;
			var margin = ( screenHeight - 253 ) / 2;
			document.querySelector(".box").style.margin = margin + "px auto";
			
			function join() {
				var username = document.getElementById("username").value;
				var password = document.getElementById("password").value;
				
				getResponse("http://localhost/system/login.php?username=" + username + "&password=" + password, function(response) {
					var json = JSON.parse(response);
					if(json.ok == 0) {
						alert("Acest user nu exista!");
					} else {
						setCookie("username", username, 100000);
						window.location.replace("http://localhost:5000");
					}
				});
			}
			
			function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
		</script>
	</body>
</html>