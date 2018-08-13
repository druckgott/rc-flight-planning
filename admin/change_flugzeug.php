<?php 
	require 'database.php';
	$id_f = 0;
	
	if ( !empty($_GET['id_f'])) {
		$id_f = $_REQUEST['id_f'];
	}
	
	if ( !empty($_GET['aktiv_flugzeug'])) {
		$aktiv_flugzeug = $_REQUEST['aktiv_flugzeug'];
	}
			
	
		
		// delete data
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$sql = "UPDATE pilotes SET aktiv_flugzeug=? WHERE id_f=?";
		$q = $pdo->prepare($sql);
		$q->execute(array($aktiv_flugzeug, $id_f));

		
		Database::disconnect();		
		header("Location: index.php");
			
		
?>