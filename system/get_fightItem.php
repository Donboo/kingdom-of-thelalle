<?php
	
	header('Access-Control-Allow-Origin: *');
	
	include 'config/connection.php';

	
	function getFightItem() {
		global $dbh;
		
		$username = htmlentities($_GET["username"]);
		
		$query = $dbh->prepare("SELECT `weapon_upgrade` FROM `players` WHERE `username` = :username LIMIT 1");
		$query->execute(array(
			"username" => $username
		));
		$result = $query->fetch(PDO::FETCH_ASSOC);
		
		die(json_encode($result));
	}
	
	getFightItem();
	