<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/bootstrap.min.js"></script>

<style>
<!--
.glyphicon { cursor: pointer; }
input,
select { width: 100%; }
-->

</style>

</head>

<body>


  <div class="container">   

<p><a href="index.php" class="btn btn-success">Home</a>&nbsp;<a href="piloten.php" class="btn btn-success">Pilot erstellen</a></p>
    
  <div class="row">
  <div class="col-sm-14">
   
				<h1><span class="glyphicon glyphicon-off" aria-hidden="true">Inaktive Piloten Liste</h1>

				
				<table class="js-dynamitable     table table-bordered table-condensed">
		              <thead>
		                <tr>
                          <th>Info  <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>
		                  <th>Name  <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>
                          <th>Vorname <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>
		                  <th>Email Address <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>
		                  <th>Reihenfolg. <span class="js-sorter-desc     glyphicon glyphicon-chevron-down pull-right"></span> <span class="js-sorter-asc     glyphicon glyphicon-chevron-up pull-right"></span> </th>
                          <th>wartend</th>
                          <th>anwesend</th>
		                  <th>Aktion</th>
		                </tr>
                        <tr>
                        	<th></th>
							<th><input class="js-filter  form-control input-sm" type="text" value=""></th>
		  					<th><input class="js-filter  form-control input-sm" type="text" value=""></th>
          					<th><input class="js-filter  form-control input-sm" type="text" value=""></th>
          					<th><input class="js-filter  form-control input-sm" type="text" value=""></th>
          					<th></th>
                            <th></th>
                            <th></th>
        				</tr>
        			 </thead>
                      
					 <tbody>
		              <?php 
					   include 'database.php';
					   $pdo = Database::connect();
					   $sql = 'SELECT * FROM piloten WHERE aktivated = 2 ORDER BY ordering asc;';
					   					   
	 				   foreach ($pdo->query($sql) as $row) {

						   		$published = ($row['published'] == 1)?'wartend':'hanger';
								$aktivated = ($row['aktivated'] == 1)?'anwesend':'abwesend';

								if($row['name'] == "Trennung"){
									$table_class = "danger";
								}else{
									$table_class = "";	
								}
								
						   		echo '<tr class="' . $table_class . '">';
								echo '<td><span class="btn glyphicon glyphicon-off" aria-hidden="true" style="color:#d9534f"></td>';
							   	echo '<td>'. $row['name'] . '</td>';
							   	echo '<td>'. $row['vorname'] . '</td>';
							   	echo '<td>'. $row['email'] . '</td>';
								echo '<td>'. $row['ordering'] . '</td>';
							   	echo '<td>'. $published . '</td>';
							   	echo '<td>'. $aktivated . '</td>';
							    echo '<td width=200 >';
							   	//echo '<a class="btn btn-xs" href="read.php?id='.$row['id'].'">Read</a>';
							   	//echo '&nbsp;';
							   	if($row['name'] != "Trennung"){
									echo '<a class="btn btn-success btn-xs" href="piloten.php?id='.$row['id'].'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
							   		echo '&nbsp;';
							   		echo '<a class="btn btn-danger btn-xs" href="delete.php?id='.$row['id'].'"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
									echo '&nbsp;';
								}
							   	echo '<a class="btn btn-info btn-xs" href="change.php?id='.$row['id'].'&change=hangar"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a>';
							   	echo '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
					  ?>
				      </tbody>
	            </table>

  </div>
</div>

    </div> <!-- /container -->
    

    
    <!-- jquery --> 
<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script> 

<!-- dynamitable --> 
<script src="../js/dynamitable.jquery.min.js"></script>

  </body>
</html>
