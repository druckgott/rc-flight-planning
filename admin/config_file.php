<?php 
	
	$sql_config = 'SELECT * FROM einstellungen ORDER BY name_s asc;';
	 
	foreach ($pdo->query($sql_config) as $row) {
		$einstellung[$row['name_s']] = $row['value_s'];

	}

		
	//echo $einstellung['index_background'];		   

?>
