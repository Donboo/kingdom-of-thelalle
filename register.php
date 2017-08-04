<?php
	
	if(isset($_COOKIE["username"]) && isset($_COOKIE["password"])) header("Location: /index.html");
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Kingdom of Thelalle</title>
		<link rel="stylesheet" href="style.css">
		<script src="js-functions.js"></script>
		
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
					<p>EMail:</p>
					<input id="email" type="email" class="input" name="email" style="margin-bottom: 15px;" />
					<a onclick="join()" href="javascript:void()" class="button">Register!</a>
					<br /><br />
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
				var email = document.getElementById("email").value;
				
				getResponse("http://localhost/system/register.php?username=" + username + "&pass=" + password + "&email=" + email, function(response) {
					var json = JSON.parse(response);
					if(json.ok == 0) {
						alert(json.msg);
					} else {
						window.location.replace("http://localhost/launch.php");
					}
				});
			}
		</script>
	</body>
</html>