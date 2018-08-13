<?php 
	require 'database.php';
	$id_f = 0;
	
	if ( !empty($_GET['id_f'])) {
		$id_f = $_REQUEST['id_f'];
	}
	
	if( !empty($_GET['piloten_id'])) {
		$piloten_id = $_REQUEST['piloten_id'];
	}
	
	
	if ( !empty($_POST)) {
		// keep track post values
		$id_f = $_POST['id_f'];
		$piloten_id = $_POST['piloten_id'];
		
		// delete data
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM flugzeug  WHERE id_f = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id_f));
		Database::disconnect();
		header("Location: piloten.php?id=$piloten_id");
		
	} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Flugzeug löschen</h3>
		    		</div>
		    		
	    			<form class="form-horizontal" action="delete_flugzeug.php" method="post">
	    			  <input type="hidden" name="id_f" value="<?php echo $id_f;?>"/>
                      <input type="hidden" name="piloten_id" value="<?php echo $piloten_id;?>"/>
					  <p class="alert alert-error">Sicher das Flugzeug löschen?</p>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-danger">Ja</button>
						  <a class="btn btn-info" href="index.php">Nein</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>