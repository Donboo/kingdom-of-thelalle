<?php
	
	header('Access-Control-Allow-Origin: *');
	
	include 'config/connection.php';

	
	function setFightItem() {
		global $dbh;
		
		$id = (int)htmlentities($_GET["id"]);
		
		$query = $dbh->prepare("UPDATE `blocks` SET `visibility` = '0' WHERE `id` = '$id'");
		$query->execute();
		
		if($query) {
			die(json_encode(array("ok" => 1))); //04:22
		} else {
			die(json_encode(array("ok" => 0)));
		}
		
	}
	
	setFightItem();
	