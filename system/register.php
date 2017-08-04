<?php
	
	include 'config/connection.php';
	include 'config/functions.php';
	
	$ip = getIPAddress();
	$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));	
	include 'lang/' . strtolower($query["countryCode"]) . '.php';
	
	
	function register() {
		global $dbh;
		
		if(isset($_POST["username"]) && isset($_POST["pass"]) && isset($_POST["email"])) {
		
			$username = htmlentities($_POST["username"]);
			$password = htmlentities($_POST["pass"]);
			$email = htmlentities($_POST["email"]);
			
			//cache
			$query = $dbh->prepare("SELECT `username` FROM `players` WHERE `username` = :username LIMIT 1");
			$query->execute(array(
				"username" => $username
			));
			if($query->rowCount()) 
				$result = json_encode(array("ok" => 0, "msg" => "Numele exista deja"));
			else {
				$query = $dbh->prepare("INSERT INTO `players` (`username`, `password`, `email`, `weapon_upgrade`, `experience`) VALUES (:username, :password, :email, 0, 0)");
				$query->execute(array(
					"username" => $username,
					"password" => hash("sha256", "mOGhbVyt!4JkL".$password."44EkVoKnLo"),
					"email" => $email // + verificare
				));
			}
				$result = json_encode(array("ok" => 1));
			
			die($result);
		} else {
			redirect("/index.php");
		}
	}
	
	register();
	