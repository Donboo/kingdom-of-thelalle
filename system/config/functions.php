<?php
	
	function getIPAddress() {
		if( isset( $_SERVER["HTTP_CLIENT_IP"] ) && !empty( $_SERVER["HTTP_CLIENT_IP"] ) ) {
			return $_SERVER["HTTP_CLIENT_IP"];
		} else if( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) && !empty( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
			return $_SERVER["HTTP_X_FORWARDED_FOR"];
		} else if( isset( $_SERVER["REMOTE_ADDR"] ) && !empty( $_SERVER["REMOTE_ADDR"] ) ) {
			return $_SERVER["REMOTE_ADDR"];
		} else {
			die();
		}
	}
	
	function redirect($where) {
		header("Location: $where");
		exit(); // noredirect
	}
	
	function login() {
		global $dbh;
		
			if(isset($_GET["username"]) && isset($_GET["password"])) {
			
				$username = htmlentities($_GET["username"]);
				$password = htmlentities($_GET["password"]);
				
				//cache
				$query = $dbh->prepare("SELECT `id`, `experience` FROM `players` WHERE `username` = :username AND `password` = :password LIMIT 1");
				$query->execute(array(
					"username" => $username,
					"password" => hash("sha256", "mOGhbVyt!4JkL".$password."44EkVoKnLo")
				));
				if($query->rowCount() == 1) {
					setcookie("username", $username);
					$result = json_encode(array("ok" => 1));
				} else {
					$result = json_encode(array("ok" => 0));
				}
				echo $result;
			}
	}
	