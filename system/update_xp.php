<?php
	
	header('Access-Control-Allow-Origin: *');
	
	include 'config/connection.php';

	function updateXP() {
		global $dbh;
		
		$username = htmlentities($_GET["username"]);
		
		$query = $dbh->prepare("UPDATE `players` SET `experience` = `experience`+25 WHERE `username` = :player LIMIT 1");
		$query->execute(array(
			"player" => $username
		));
	
	}
	
	updateXP();
	