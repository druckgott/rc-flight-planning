<?php 
	
	require 'database.php';
	require 'functions.php';

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	require 'config_file.php';
	
	$history_id = null;
	
	if ( !empty($_GET['history_id'])) {
		$history_id= $_REQUEST['history_id'];
	}
	
	
	if ( !empty($_POST)) {
		// keep track post values
		$history_id = $_POST['history_id'];
		//echo "history_id:" . $history_id;
		
		// delete data
		$sql = 'DELETE FROM history WHERE history_id = ?';
		$q = $pdo->prepare($sql);
		$q->execute(array($history_id));
		
		
		//Database::disconnect();
		header("Location: history.php");
		
	} 
	
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/bootstrap.min.js"></script>
    <!-- dynamitable --> 
	<script src="../js/dynamitable.jquery.min.js"></script>
</head>

<body>
    <div class="container">
<p></p>
<p><a href="index.php" class="btn btn-info">Zurück</a></p>
 
  
  <div class="row">
  <div class="col-sm-14">
    <div class="row">
      <div class="col-xs-14">
      
      
        		<h1><span class="glyphicon glyphicon-plane"></span>vergangene Flüge</h1>
				
				<table class="js-dynamitable     table table-bordered table-condensed">
		              <thead>
		                <tr>
                          <th>Nr.</th>
                          <th>Pilotenname  <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>
                          <th>Flugzeugname  <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>
                          <th>Flugzeugtyp  <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>
                          <th>Flugzeugantrieb  <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>
                          <th>Startzeit  <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>
                          <th>Endzeit  <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>
                          <th>Flugzeit  <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>
                          <th>Löschen</th>
		                </tr>
                         <tr>
                         	<th></th>
                        	<th><input class="js-filter  form-control input-sm" type="text" value=""></th>
                            <th><input class="js-filter  form-control input-sm" type="text" value=""></th>
                            <th><input class="js-filter  form-control input-sm" type="text" value=""></th>
                            <th><input class="js-filter  form-control input-sm" type="text" value=""></th>
                            <th><input class="js-filter  form-control input-sm" type="text" value=""></th>
                        	<th><input class="js-filter  form-control input-sm" type="text" value=""></th>
                            <th><input class="js-filter  form-control input-sm" type="text" value=""></th>
                            <th></th>
        				</tr>
        			 </thead>
                      
					 <tbody>

                            

    
    
		              <?php 
					  // include 'database.php';
					   //$pdo = Database::connect();					   
					   //$sql3 = 'SELECT F.*, FT.* FROM flugzeug As F, flugzeug_typ As FT WHERE F.piloten_id = ' . $id . ' AND F.flugzeugtyp_id = FT.flugzeugtyp_id ORDER BY F.name_f asc;';
					   //$sql3 = 'SELECT H.* FROM history As H WHERE F.flugzeugtyp_id = FT.flugzeugtyp_id AND F.piloten_id = P.id ORDER BY P.name asc;';
					   
					   	$sql3 = 'SELECT H.* FROM history As H ORDER BY H.history_starttime asc;';		
						
						$counter=0;
	 				   foreach ($pdo->query($sql3) as $row) {
								$counter++;
								//$published = ($row['published'] == 1)?'selected':'';
								$table_class="";
						   		echo '<tr class="' . $table_class . '">';
								//echo '<td><span class="' . $icon_class . '" aria-hidden="true"></span></td>';
								echo '<td>'.$counter . '</td>';
								echo '<td>'. $row['history_name'] . '&nbsp;'. $row['history_vorname'] . '</td>';
								echo '<td>'. $row['history_name_f'] . ' </td>';
								echo '<td>'. $row['history_name_ft'] . ' </td>';
								echo '<td>'. $row['history_name_fa'] . ' </td>';
								echo '<td>'. $row['history_starttime'] . ' </td>';
								echo '<td>'. $row['history_stoptime'] . '</td>';
								$flighttime=(strtotime($row['history_stoptime']) - strtotime($row['history_starttime'])) ;
								//echo '<td>'. date("H:i:s",$flighttime+strtotime("1970/1/1")) . '</td>';
								if($flighttime < $einstellung['global_max_flight_time']){
								echo '<td>'. date("i:s",$flighttime+strtotime("1970/1/1")) . ' Min</td>';
								} else {
								echo '<td>Flugzeit mehr als '. $einstellung['global_max_flight_time'] . ' Sec.</td>';
								}
								echo '<td width=1 >';
								
								echo '<form class="form-horizontal" action="history.php" method="post">';
	    			  			echo '<input type="hidden" name="history_id" value="' . $row['history_id'] . '"/>';
					  			echo '<div class="form-actions">';
						 		echo '<button type="submit" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>';
								echo '</div>';
								echo '</form>';
						
							   	echo '</td>';
								
							   	echo '</tr>';
									
					   }
					   //Database::disconnect();
					  ?>
				      </tbody>
	            </table>
        

        
      </div>
      
      
      </div>   
 <?php
 Database::disconnect();
 
 ?>  
 
    
<!-- jquery --> 
<script src="../js/jquery-2.1.1.min.js"></script>
<!-- dynamitable --> 
<script src="../js/dynamitable.jquery.min.js"></script>

  </body>
</html>
