<?php
	
	header('Access-Control-Allow-Origin: *');
	
	include 'config/connection.php';

	
	function setFightItem() {
		global $dbh;
		
		$username = htmlentities($_GET["username"]);
		$weapon = (int)htmlentities($_GET["item"]);
		
		if($weapon == 1) 
			$exp = 75;
		elseif($weapon == 2) 
			$exp = 150;
		elseif($weapon == 3) 
			$exp = 350;
		else
			die("invalid");
		
		$query = $dbh->prepare("UPDATE `players` SET `weapon_upgrade` = :weapon, `experience` = `experience` - :experience  WHERE `username` = :username LIMIT 1");
		$query->execute(array(
			"username" => $username,
			"weapon" => $weapon,
			"experience" => $exp
		));
		
		if($query) {
			die(json_encode(array("ok" => 1))); //04:22
		} else {
			die(json_encode(array("ok" => 0)));
		}
		
	}
	
	setFightItem();
	