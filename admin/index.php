<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/scrollfix.js" type="text/javascript"></script>
    
    <title>Flugplanung MFC-Dachau e.V.</title>



<style>
<!--
.glyphicon { cursor: pointer; }
input,
select { width: 100%; }

-->

</style>



</head>

<body onunload="unloadP('UniquePageNameHereScroll')" onload="loadP('UniquePageNameHereScroll')">

<?php 

	require 'database.php';
	$pdo = Database::connect();
	require 'config_file.php';
	
	$flieger_id = 0;
	$piloten_id = 0;
	$update_type = 0;
	$ordering = 0;
	$max_rows=0;

    if ( !empty($_GET['update_type'])) {
		$update_type = $_REQUEST['update_type'];
	}
	
	if ( !empty($_GET['ordering'])) {
		$ordering = $_REQUEST['ordering'];
	}

    if ( !empty($_GET['piloten_id'])) {
		$piloten_id = $_REQUEST['piloten_id'];
	}
	
	if ( !empty($_GET['flieger_id'])) {
		$flieger_id = $_REQUEST['flieger_id'];
	}
	
	if ( !empty($_GET['max_rows'])) {
		$max_rows = $_REQUEST['max_rows'];
	}
		
	
	
	
	
		if ( !empty($_POST)) {
		
		$update_type = $_POST['update_type'];
		//echo "update_type $update_type";
		
			if($update_type == "flugzeug_update" ){
			
				// keep track post values
				$flieger_id = $_POST['flieger_id'];
				$piloten_id = $_POST['piloten_id'];

				// validate input
				$valid = true;
				if (empty($flieger_id)) {
					$flieger_idError = 'Please enter flieger_select';
					$valid = false;
				}
				if (empty($piloten_id)) {
					$piloten_idError = 'Please enter piloten_id';
					$valid = false;
				}
		
				//echo "id: $id, flieger_select $flieger_select";
				if ($valid) {
			
					//echo "flieger_id $flieger_id, piloten_id $piloten_id";
					//$pdo = Database::connect();
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
					//alle flieger published 0
					$sql5 = "UPDATE flugzeug set published = ? WHERE piloten_id = ?";
					$q = $pdo->prepare($sql5);
					$q->execute(array(2, $piloten_id));

					$sql = "UPDATE flugzeug set published = ? WHERE id_f = ?";
					$q = $pdo->prepare($sql);
					// published = 1 setzten bei id x
					$q->execute(array(1, $flieger_id));
        			//Database::disconnect();
			
				}
		}
		
		
		if( $update_type == "order_update" ){
			
				$ordering = $_POST['ordering'];
				$piloten_id = $_POST['piloten_id'];
				$max_rows = $_POST['max_rows'];
				
				$valid = true;
				if (empty($ordering)) {
					$orderingError = 'Please enter ordering';
					$valid = false;
				}
				if (empty($piloten_id)) {
					$piloten_idError = 'Please enter piloten_id';
					$valid = false;
				}
				
				if ($valid) {
			
					
					//echo "ordering $ordering, piloten_id $piloten_id";
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
					$sql7 = "SELECT * FROM piloten where id = ?";
					$q = $pdo->prepare($sql7);
					$q->execute(array($piloten_id));
					$data = $q->fetch(PDO::FETCH_ASSOC);
					$name = $data['name'];
					$vorname = $data['vorname'];
					$email = $data['email'];
					$ordering_old = $data['ordering'];				
					$published = $data['published'];
					$aktivated = $data['aktivated'];
					
					
					
					//alle flieger published 0
					
					// alle elemente zwischen neu und alt neu sortieren
					$alt = $ordering_old;
					$neu = $ordering;
					//pruefen das die sachen in den grenzen bleiben
					if($neu > $max_rows){
						$neu = $max_rows+1;
					}
					if($neu < 1){
						$neu=1;
					}
					
					
					if( $alt < $neu ){

						$array_order[$alt] = $neu;
	
						for ($i = $alt+1; $i <= $neu; $i++) {
							$move_to = $i -1;
    						$array_order[$i] = $move_to;
    						//print "$i --> $move_to\n";
						}

					}

					if( $alt > $neu ){
	
						$array_order[$alt] = $neu;
	
						for ($i = $alt-1; $i >= $neu; $i--) {
							$move_to = $i +1;
    						$array_order[$i] = $move_to;
    						//print "$i --> $move_to\n";
						}
	
	
					}

					// ordering neu gennerien ueber funktion
					$sql5 = reOrderRows("piloten","ordering", $array_order);
					$q = $pdo->prepare($sql5);
					$q->execute();

			
				}
				
				
				
				
		}
					
		
	}
		
					   
	?>

  <div class="container">   
<p></p>
<p><a href="piloten.php" class="btn btn-success">Pilot erstellen</a>&nbsp;<a href="flugzeug.php" class="btn btn-info">Flugzeug erstellen</a>&nbsp;<a href="inaktiv.php" class="btn btn-danger">Inaktive Piloten</a>&nbsp;<a href="flugzeug_liste.php" class="btn btn-danger">Piloten/Flugzeugliste</a>&nbsp;<a href="history.php" class="btn btn-danger">Verlauf</a>&nbsp;<a href="edit_config.php" class="btn btn-default">Einstellungen</a>&nbsp;<a href="../index.php" class="btn btn-default">TV-Seite</a>&nbsp;<a href="../changelog.txt" target="_blank" class="btn btn-default">changelog.txt</a></p>
    
  <div class="row">
  <div class="col-sm-14">
    <div class="row">
      <div class="col-xs-6">
      
      
        		<h1><span class="glyphicon glyphicon-plane"></span>Warteliste auf Flug</h1>
				
				<table class="js-dynamitable     table table-bordered table-condensed">
		              <thead>
		                <tr>
		                  <th width="60" >pos.</th>
                          <th width="1">Info</th>
		                  <th>Name</th>
                          <!--<th>Vorname </th>-->
                          <th>Flugzeug </th>
		                  <!--<th>Email Address <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>-->
                          <!--<th>warten</th>-->
                          <!--<th>anwesend <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>-->
		                  <th width="1">move</th>
                          <th width="1">Aktion</th>
		                </tr>
        			 </thead>
                      
					 <tbody>

                            

    
    
		              <?php 
					  // include 'database.php';
					   //$pdo = Database::connect();
					   

					   
					   
					   
					   $sql = 'SELECT * FROM piloten WHERE aktivated = 1 AND published = 1 ORDER BY ordering asc;';
					   
					   //maximale Zeilen erhalten
					   $del = $pdo->prepare($sql);
					   $del->execute();
					   $maxrows = $del->rowCount() - 1;
					   
					   $rowcounter=0;
					   $tablecounter=0;
					   $array_waittime=array();
					   $add_waittime_flag=1;
					   $wait_position=1;
					   
					   //durchscnittsflugzeit fuer alle Piloten
					   $sql_history_all = 'SELECT * FROM history ORDER BY history_starttime asc;';
						$array_flightime_all=array();	
						foreach ($pdo->query($sql_history_all) as $row_history_all) {			
							$flighttime=(strtotime($row_history_all['history_stoptime']) - strtotime($row_history_all['history_starttime'])) ;
							//nur speichern wenn nicht größer als eine vorgegebene Maximalzeit
							//echo "max_flight_time	" . $einstellung['global_max_flight_time'] . "|||flighttime	" . $flighttime . "";
							if($einstellung['global_max_flight_time']>=$flighttime){
								array_push($array_flightime_all,$flighttime);
							}
						}
						$durchschnittsflugzeit_all = array_sum($array_flightime_all)/(sizeof($array_flightime_all));		
								
						

	 				   foreach ($pdo->query($sql) as $row) {
						   
						   
						   		$sql_flieger = 'SELECT * FROM flugzeug  WHERE piloten_id = ' . $row['id'] . ' AND aktivated = 1 ORDER BY name_f asc;';
								
								//Flugzeit berechnen
								if($row['name'] != "Trennung"){

									$sql_history = 'SELECT * FROM history  WHERE history_piloten_id = ' . $row['id'] . ' ORDER BY history_starttime asc;';
								
									//Durchscnittsflugzeit fuer genau diesen Piloten
									$array_flightime=array();
								
									foreach ($pdo->query($sql_history) as $row_history) {
									
										$flighttime=(strtotime($row_history['history_stoptime']) - strtotime($row_history['history_starttime'])) ;
										if($flighttime > 0 && $einstellung['global_max_flight_time'] >= $flighttime){
											array_push($array_flightime,$flighttime);
										}
									}
									$durchschnittsflugzeit = array_sum($array_flightime)/(sizeof($array_flightime));
									// wenn fuer diesen
									if(sizeof($array_flightime) == 0){
										$durchschnittsflugzeit = $durchschnittsflugzeit_all;
									}
								
									array_push($array_waittime,$durchschnittsflugzeit);
									if($add_waittime_flag == 1){
										$waittime = array_sum($array_waittime)-$durchschnittsflugzeit;
										$add_waittime_flag = null;
									}
									//echo "name: " . $row['name'] . "flugzeit: " . $durchschnittsflugzeit . " lenge: " . sizeof($array_flightime) . "";
								}
								
								
						   		//tabelle färben
						   		if($tablecounter==0){ $table_class = "success"; $icon_class = "btn glyphicon glyphicon-plane"; $style=""; }
								if($tablecounter==1){ $table_class = "warning"; $icon_class = "btn glyphicon glyphicon-flash"; $style=""; }
								if($tablecounter==2){ $table_class = "warning"; $icon_class = "btn glyphicon glyphicon-flash"; $style=""; }
								if($tablecounter>=3){ $table_class = "active"; $icon_class = "btn glyphicon glyphicon-stop"; $style=""; }
								//wenn kein Flieger ausgewaehlt ist alles uberschrieben
								$selected_flag=0;
								foreach ($pdo->query($sql_flieger) as $row_flieger) {
									if($row_flieger['published'] == 1){ $selected_flag=1; }
								}
								if($selected_flag == 0) { $table_class = "danger"; $icon_class = "btn glyphicon glyphicon-fire"; $style="background-color:#FF0000; color:#FFFFFF;"; }
								
								
								
						   		$published = ($row['published'] == 1)?'warten':'Hangar';
								
								//trennungen abfangen
								if($row['name'] == "Trennung"){
									$table_class = "bg-info";
									$icon_class = "btn glyphicon glyphicon-random";
									$style="color:blue";
									$add_waittime_flag=1;
									$wait_position++;
								}
								
						   		echo '<tr class="' . $table_class . '">';
								//echo '<td>'. $row['ordering'] . '</td>';
								
								echo '<td>';
								echo '<form action="index.php" method="post">';
								echo '<fieldset>';
								//echo '<div class="col-xs-2">';
								echo '<input class="form-control" type="text" name="ordering" value="'. $row['ordering'] . '" onchange="this.form.submit();">';
								//echo '</div>';
								echo '<input type="hidden" name="piloten_id" value="'.$row['id'].'"/>';
								echo '<input type="hidden" name="update_type" value="order_update"/>';
								echo '<input type="hidden" name="max_rows" value="'.$maxrows.'"/>';
								
								echo '</fieldset>';
								echo '</form>';
								echo '</td>';
								
								
								echo '<td><span class="' . $icon_class . '" aria-hidden="true" style="' . $style . '"></span></td>';
								//Flugzeit nur anzeigen wenn keine Trennung
								if($row['name'] != "Trennung"){
							   		echo '<td><div title="Warteposition: '. $wait_position .'&#10;Piloteninfo: '. $row['kommentar'] .'&#10;prog. Flugzeit ca: ' . date("H:i:s",$durchschnittsflugzeit+strtotime("1970/1/1")) . '&#10;Wartezeit ca: ' . date("H:i:s",$waittime+strtotime("1970/1/1")) . '">'. $row['name'] . '&nbsp;'. $row['vorname'] . '</div></td>';
								}else{
									echo '<td>'. $row['name'] . '&nbsp;'. $row['vorname'] . '</td>';	
								}
								

								
								echo '<td>';
								if($row['name'] != "Trennung"){

									
                     				echo '<form action="index.php" method="post">';
									echo '<fieldset>';
									echo '<select name="flieger_id" id="flieger_id" class="form-control" onchange="this.form.submit();">';
									$selected_flag=0;
									foreach ($pdo->query($sql_flieger) as $row_flieger) {
										//zahler der Prueft ob ein Flieger angewaehlt ist
										$set_selected = ($row_flieger['published'] == 1)?'selected':'';
										
										if($row_flieger['published'] == 1){ $selected_flag=1; }
										
  										echo '<option '.$set_selected.' value="'.$row_flieger['id_f'].'">' . $row_flieger['name_f'] . '</option>';
									}
									
									if($selected_flag == 0){ echo '<option selected value="0">Select</option>';}
									
									echo '</select>';
										
								}
								echo '<input type="hidden" name="piloten_id" value="'.$row['id'].'"/>';
								echo '<input type="hidden" name="update_type" value="flugzeug_update"/>';
								echo '</fieldset>';
								echo '</form>';
								echo '</td>';


							   	//echo '<td>'. $row['email'] . '</td>';
							   	//echo '<td>'. $published . '</td>';
							   	//echo '<td>'. $aktivated . '</td>';
								echo '<td >';
								if( $rowcounter < $maxrows ) {
							   		echo '<a class="btn-group btn-group-xs" href="move.php?id='.$row['id'].'&ordering='.$row['ordering'].'&move=down"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></a>';
									echo '&nbsp;';
								}
								if( $rowcounter > 0 ) {
									echo '<a class="btn-group btn-group-xs" href="move.php?id='.$row['id'].'&ordering='.$row['ordering'].'&move=up"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></a>';
								}
								echo '</td>';
							   	echo '<td width=100 >';
							   	//echo '<a class="btn btn-xs" href="read.php?id='.$row['id'].'">Read</a>';
								if($row['name'] != "Trennung"){
							   		echo '&nbsp;';
							   		echo '<a class="btn btn-success btn-xs" href="piloten.php?id='.$row['id'].'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
								}
							    echo '&nbsp;';
							    //echo '<a class="btn btn-info btn-xs" href="change.php?id='.$row['id'].'&change=hangar"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a>';
								
								
								if($row['name'] == "Trennung" and $row['ordering'] == 1){
							   		echo '<a class="btn btn-default btn-xs" href="change.php?id='.$row['id'].'&change=hangar&trennung=remove&aktion=start"><span class="glyphicon glyphicon-envelope" style="color:#5cb85c" aria-hidden="true"></span></a>';
								}elseif($row['name'] == "Trennung"){
							   		echo '<a class="btn btn-default btn-xs" href="change.php?id='.$row['id'].'&change=hangar&trennung=remove"><span class="glyphicon glyphicon-home" style="color:#d9534f" aria-hidden="true"></span></a>';									
								}else{
							   		echo '<a class="btn btn-info btn-xs" href="change.php?id='.$row['id'].'&change=hangar"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a>';									
								}
								
							   	echo '</td>';
							   	echo '</tr>';
								
								$rowcounter++;
								
								if($row['name'] == "Trennung"){
									$tablecounter++;
								}
									
					   }
					   //Database::disconnect();
					   
					   
					   
					   
					   	//anzahl aller aktiver Piloten auslesen
						$sql = 'SELECT * FROM piloten WHERE aktivated = 1 AND name != "Trennung" ORDER BY ordering asc;';
						//maximale Zeilen erhalten
						$del = $pdo->prepare($sql);
						$del->execute();
						$all_piloten = $del->rowCount();
	
	
					  ?>
                      
   			      </tbody>
	            </table>
        

        
      </div>
      <div class="col-xs-4">
        
				<h1><span class="glyphicon glyphicon-home"></span>Hangar</h1>

				
				<table class="js-dynamitable     table table-bordered table-condensed">
		              <thead>
		                <tr>
                          <th width="1" >Info</th>
		                  <th>Name<span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span></th>
                           <th width="1" >Aktion</th>
		                </tr>
                        <tr>
                        	<th><?php echo $all_piloten; ?> P.</th>
							<th><input class="js-filter  form-control input-sm" type="text" value=""></th>
                            <th></th>
        				</tr>
        			 </thead>
                      
					 <tbody>
                     
                     
                     <tr class="bg-info">
					<td><span class="btn glyphicon glyphicon-random" aria-hidden="true"></td>
					<td>Trennung</td>
					<!--<td>-</td>-->
					<td ><a class="btn btn-info btn-xs" href="change.php?change=flight&trennung=add"><span class="glyphicon glyphicon-plane" aria-hidden="true"></span></a></td>
					</tr>
                                
                     
		              <?php 
					   //include 'database.php';
					   //$pdo = Database::connect();
					   $sql = 'SELECT * FROM piloten WHERE aktivated = 1 AND published = 2  ORDER BY name asc;';
					   
					   $rowcounter=0;
	 				   foreach ($pdo->query($sql) as $row) {
						   
								if($row['published'] == 2 and $row['aktivated'] == 1){ $icon_class = "btn glyphicon glyphicon-home"; $table_class = ""; } 
								$published = ($row['published'] == 1)?'warten':'Hangar';
								
								if($row['name'] == "Trennung"){
									$table_class = "bg-info";
									$icon_class = "btn glyphicon glyphicon-random";
								}
								
						   		echo '<tr class="' . $table_class . '">';
								echo '<td><span class="' . $icon_class . '" aria-hidden="true"></td>';
							   	echo '<td>'. $row['name'] . '&nbsp;'. $row['vorname'] . '</td>';
							   	//echo '<td>'. $row['vorname'] . '</td>';
							    //echo '<td>'. $row['email'] . '</td>';
								//echo '<td>'. $row['ordering'] . '</td>';
							   	//echo '<td>'. $published . '</td>';
							   	//echo '<td>'. $aktivated . '</td>';
							    echo '<td width=125 >';
							   	//echo '<a class="btn btn-xs" href="read.php?id='.$row['id'].'">Read</a>';
								if($row['name'] != "Trennung"){
							   		echo '&nbsp;';
							   		echo '<a class="btn btn-success btn-xs" href="piloten.php?id='.$row['id'].'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
								}
								echo '&nbsp;';
							   	echo '<a class="btn btn-info btn-xs" href="change.php?id='.$row['id'].'&change=flight"><span class="glyphicon glyphicon-plane" aria-hidden="true"></span></a>';
								echo '&nbsp;';
								echo '<a class="btn btn-danger btn-xs" href="javascript:change_to_inaktiv('.$row['id'].');"><span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span></a>';
								echo '</td>';
							   	echo '</tr>';
								
								$rowcounter++;
					   }
					   Database::disconnect();
					   
					   
					   
					   function reOrderRows($tablename, $ordercol, $idsarray){

    						$query = "UPDATE $tablename SET $ordercol = (CASE $ordercol ";
    						foreach($idsarray as $prev => $new) {
      							$query .= " WHEN $prev THEN $new\n";
    						}
    						$query .= " END) WHERE $ordercol IN (" . implode(",", array_keys($idsarray)) . ")";

    						return $query;
						}



					  ?>
				      </tbody>
	            </table>
                
                
                
                
      </div>
    </div>
  </div>
</div>

    </div> <!-- /container -->

<script type="text/javascript">
function change_to_inaktiv(rowid) {
var answer = confirm ("Soll der Pilot wirklich inaktiv gesetzt werden?")
if (answer)
window.location="change.php?id=" + rowid + "&change=inaktiv";
}





</script>
	
<!-- jquery --> 
<script src="../js/jquery-2.1.1.min.js"></script>
<!-- dynamitable --> 
<script src="../js/dynamitable.jquery.min.js"></script>

  </body>
</html>
