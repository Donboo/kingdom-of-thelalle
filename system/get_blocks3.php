<?php
	
	header('Access-Control-Allow-Origin: *');
	
	include 'config/connection.php';
	
	/*
	$incepere_x = 0;
	for($i = 0; $i < 100; $i++) {
		$query = $dbh->prepare("INSERT INTO `blocks` (block_id, pos_x, pos_y) VALUES (3, $incepere_x, \\50)");
		$query->execute();
		$incepere_x += 25;
	}*/
	
	function getBlocks() {
		global $dbh;
		$query = $dbh->prepare("SELECT `id`, `block_id`, `pos_x`, `pos_y`, `visibility` FROM `blocks`");
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		
		/*
		foreach($result as $r) {
			$n = $r["pos_y"] + 100;
			$query2 = $dbh->prepare("UPDATE `blocks` SET `pos_y` = '$n' WHERE `id` = '".$r["id"]."'");
			$query2->execute();
		}*/
		
		die(json_encode($result));
	}
	
	getBlocks();
	