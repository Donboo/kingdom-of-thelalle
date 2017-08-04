<?php
	
	header('Access-Control-Allow-Origin: *');
	
	include 'config/connection.php';
	
	/*
	$query = $dbh->prepare("SELECT * FROM `blocks`");
	$query->execute();
	echo "var map = [";
	foreach($query->fetchAll(PDO::FETCH_ASSOC) as $row) {
		echo "{
			\"block_id\": ".$row["block_id"].",
			\"pos_x\": ".$row["pos_x"].",
			\"pos_y\": ".$row["pos_y"].",
			\"visibility\": 1
		},<br />";
	}
	echo "];";
	*/
	
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
	