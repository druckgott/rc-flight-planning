<?php 
	
	require 'database.php';
	require 'functions.php';
	
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
<p><a href="piloten.php" class="btn btn-success">Pilot erstellen</a>&nbsp;<a href="flugzeug.php" class="btn btn-info">Flugzeug erstellen</a>&nbsp;<a href="index.php" class="btn btn-info">Zurück</a></p>
 
  
  <div class="row">
  <div class="col-sm-14">
    <div class="row">
      <div class="col-xs-14">
      
      
        		<h1><span class="glyphicon glyphicon-plane"></span> Alle Flugzeuge und Piloten </h1>
				
				<table class="js-dynamitable     table table-bordered table-condensed">
		              <thead>
		                <tr>
                          <th>Pilotenname <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>
                          <th>Flugzeugname <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>
                          <th>Flugzeugtyp <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>
                          <th>Pilot anwesend  </th>
                          <th>Flugzeug anwesend </th>
		                </tr>
                         <tr>
                        	<th><input class="js-filter  form-control input-sm" type="text" value=""></th>
                            <th><input class="js-filter  form-control input-sm" type="text" value=""></th>
                            <th><input class="js-filter  form-control input-sm" type="text" value=""></th>
                            <th></th>
                            <th></th>
        				</tr>
        			 </thead>
                      
					 <tbody>

                            

    
    
		              <?php 
					  // include 'database.php';
					   //$pdo = Database::connect();					   
					   //$sql3 = 'SELECT F.*, FT.* FROM flugzeug As F, flugzeug_typ As FT WHERE F.piloten_id = ' . $id . ' AND F.flugzeugtyp_id = FT.flugzeugtyp_id ORDER BY F.name_f asc;';
					   $sql3 = 'SELECT F.*, FT.*, P.*, F.published AS F_published, P.published AS P_published, F.aktivated AS F_aktivated, P.aktivated AS P_aktivated FROM flugzeug As F, flugzeug_typ As FT , piloten As P WHERE F.flugzeugtyp_id = FT.flugzeugtyp_id AND F.piloten_id = P.id ORDER BY P.name asc;';
					   			
						
	 				   foreach ($pdo->query($sql3) as $row) {

						   		$p_aktivated = ($row['P_aktivated'] == 1)?'btn glyphicon glyphicon-eye-open':'btn glyphicon glyphicon-eye-close';
								$f_aktivated = ($row['F_aktivated'] == 1)?'btn glyphicon glyphicon-eye-open':'btn glyphicon glyphicon-eye-close';
								//$published = ($row['F_published'] == 1)?'btn glyphicon glyphicon-ok-circle':'btn glyphicon glyphicon-ban-circle';
						   		$style_p_aktivated = ($row['P_aktivated'] == 1)?'color:#5cb85c':'color:#d9534f';
								$style_f_aktivated = ($row['F_aktivated'] == 1)?'color:#5cb85c':'color:#d9534f';
								//$published = ($row['published'] == 1)?'selected':'';
								$table_class="";
						   		echo '<tr class="' . $table_class . '">';
								//echo '<td><span class="' . $icon_class . '" aria-hidden="true"></span></td>';
								echo '<td>'. $row['name'] . '&nbsp;'. $row['vorname'] . '</td>';
								echo '<td>'. $row['name_f'] . ' </td>';
								echo '<td>'. $row['name_ft'] . '</td>';
								echo '<td><span class="'. $p_aktivated . '" aria-hidden="true" style="' . $style_p_aktivated . '"></span></td>';
								echo '<td><span class="'. $f_aktivated . '" aria-hidden="true" style="' . $style_f_aktivated . '"></span></td>';
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
