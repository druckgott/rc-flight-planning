<?php 
	require 'database.php';
	$id = 0;
	
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}

	if ( !empty($_GET['ordering'])) {
		$ordering = $_REQUEST['ordering'];
		$orderingnew = $ordering + 1;
	}
		
	if ( !empty($_GET['move'])) {
		$move = $_REQUEST['move'];
	}
			
	
		//move down
		if($move == "down"){
			$orderingnew = $ordering + 1;
		}
		
		//move up
		if($move == "up"){
			$orderingnew = $ordering - 1;	
		}
		
		
		// delete data
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//$sql = "UPDATE piloten set ordering =? WHERE id = ?";
		$sql = "UPDATE piloten SET ordering=(CASE ordering WHEN " . $ordering . " THEN  " . $orderingnew . " ELSE  " . $ordering . " END) WHERE ordering= " . $ordering . " OR ordering= " . $orderingnew;
		$q = $pdo->prepare($sql);
		$q->execute(array($ordering, $id));
		
		//nochmal zur Sicherheit sortieren
		$sql2 = 'SET @var:=0; UPDATE piloten SET ordering=(@var:=@var+1) WHERE published = 1 ORDER BY ordering ASC';
		$reorder = $pdo->prepare($sql2);
		$reorder->execute();		
		
		
		Database::disconnect();
		
		header("Location: index.php");
	
		
		
?>