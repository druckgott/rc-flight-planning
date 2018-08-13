<?php 
	require 'database.php';
	
	$id = null;
	$sendmail = null;
	$trennung = null;
	$aktivate_starttime = null;
	$aktion = null;
	$flag_stop_flight == null;
	
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( !empty($_GET['change'])) {
		$change = $_REQUEST['change'];
	}
	
	if ( !empty($_GET['trennung'])) {
		$trennung = $_REQUEST['trennung'];
	}	
	
	if ( !empty($_GET['aktion'])) {
		$aktion = $_REQUEST['aktion'];
	}				
	
		
		// delete data
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		//berechnen der des letzten ordering Wertes




		//$sql2 = 'SELECT P.* FROM piloten As P WHERE P.published = 1 AND P.aktivated = 1 ORDER BY P.ordering asc;';
		$sql2 = 'SELECT P.*, F.*, FT.*, FA.* FROM piloten As P LEFT JOIN flugzeug As F ON (P.id = F.piloten_id) LEFT JOIN flugzeug_typ As FT ON (F.flugzeugtyp_id = FT.flugzeugtyp_id) LEFT JOIN flugzeug_antrieb As FA ON (F.flugzeugantrieb_id = FA.flugzeugantrieb_id) WHERE ((P.published = 1 AND P.aktivated = 1 AND F.published = 1) OR P.name = "Trennung") ORDER BY P.ordering asc;';
		$maxrowdel = $pdo->prepare($sql2);
		$maxrowdel->execute();
		$maxrows = $maxrowdel->rowCount();	
		
		
	if($change == "hangar"){
		$counter=1;
		
		foreach ($maxrowdel as $row){

			//wenn der erste Pilot gefunden, steht der Counter auf 2 und sendmail auf 1, dann wird bis zur nachsten Trennung keine E-mail gesendet, dann wird sendmail auf 2 gestetzt, jetzt wird an die nächsten 2 Gruppen (ev mehrere Piloten) eine E-mail gesendet
			if($sendmail==1 and $counter == 4 && $row['name'] != "Trennung" && $row['emailsend'] == 1  && !empty($row['email'])) { // 
				
					/*$empfaenger = $row['email'];
					$betreff = "ACHTUNG, MFC-Dachau Flugtag-Info";
					$from = "From: MFC-Dachau <no-replay@mfc-dachau.>";
					$text = "Hallo " . $row['vorname'] . " " . $row['name'] . ", bitte Flieger vorbereiten Sie sind gleich an der Reihe."; 
					mail($empfaenger, $betreff, $text, $from);*/
							
			}	
					
			//E-mail aktion starten	wenn erste Trennung entfernt wird	
			if($aktion == "start" && $counter == 1 && $row['name'] == "Trennung"){
				$sendmail = 1;						
			}
			
			//history Schreiben
			if($aktion == "start" && $counter == 2 && $row['name'] != "Trennung"){
				
				
				if($flag_stop_flight == null ) {
					//Allen noch fliegenden Piloten werden beim ersten Lauf der Schleife auf fertig gesetzt
					$sql = "UPDATE history set history_stoptime = ? WHERE history_starttime = history_stoptime";
					$q = $pdo->prepare($sql);
					$q->execute(array(date('Y-m-d H:i:s')));
					$flag_stop_flight = 1;
				}
				
				//Fuer die naechste Pilotengruppe wird die Zeit in die History eingetragen 
				$sql = "INSERT INTO history (history_piloten_id, history_name, history_vorname, history_name_f, history_name_ft, history_name_fa, history_starttime, history_stoptime) values(?, ?, ?, ?, ?, ?, ?, ?)";
				$q = $pdo->prepare($sql);
				$q->execute(array($row['id'], $row['name'], $row['vorname'], $row['name_f'], $row['name_ft'], $row['name_fa'], date('Y-m-d H:i:s'), date('Y-m-d H:i:s')));	
			}		
			
			
			### Bei jeder Trennung hochzaehler
			if($row['name'] == "Trennung"){	
					$counter++;
			}		
		
			
		} //foreach ende
		
		
		
		$published=2;
		$aktivated=1;
		$ordering=999999;		
		
		
	} //if ($change == "hangar") ende


	//in warteliste schieben
	if($change == "flight"){
			$published=1;
			$aktivated=1;
			$ordering=$maxrows+1;
	}


	//in warteliste schieben
	if($change == "inaktiv"){
			$published=2;
			$aktivated=2;
			$ordering=999999;
	
			
	}
	
//wenn eine Trennung kommt diese erstellen, sonst die Piloten verschieben
	if($trennung == "add"){
		
		//wenn keine Id neuen Piloten anlegen
		$sql = "INSERT INTO piloten (name, vorname, email, ordering, published, aktivated) values(?, ?, ?, ?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array("Trennung", "-", "", $ordering, 1, 1));	
	//wenn trennung remove, dann die Trennung loeschen						
	}elseif($trennung == "remove"){
		$sql = "DELETE FROM piloten  WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
	}elseif(($change == "hangar") or ($change == "flight") or ($change == "inaktiv")){	
	//sonst update bei Pilot verschieben zu hanger oder flight je nach variable		
		//$sql = "UPDATE piloten set ordering =? WHERE id = ?";
		$sql = "UPDATE piloten SET ordering =?, published = ?, aktivated = ? WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($ordering, $published, $aktivated, $id));		
	} //ende if($trennung == "add"){
		
		
	//Piloten die in der Warteliste sind neu sortieren	

		$sql2 = 'SET @var:=0; UPDATE piloten SET ordering=(@var:=@var+1) WHERE published = 1 ORDER BY ordering ASC';
		$reorder = $pdo->prepare($sql2);
		$reorder->execute();
		
		Database::disconnect();	
		

		header("Location: index.php");
	
		
		
?>