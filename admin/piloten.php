<?php 
	
	require 'database.php';
	require 'functions.php';
	
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
	$id = null;	
	$emailsend = null;
	$published = null;
	$aktivated = null;
	
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	

	if ( !empty($_POST)) {
		// keep track validation errors
		$nameError = null;
		$vornameError = null;
		$emailError = null;
		$emailsendError = null;
		$orderingError = null;
		$unique_idError = null;
		$kommentar = null;
		$publishedError = null;
		$aktivatedError = null;
		// keep track post values
		$name = $_POST['name'];
		$vorname = $_POST['vorname'];
		$email = $_POST['email'];
		$emailsend = $_POST['emailsend'];
		$ordering = $_POST['ordering'];	
		$unique_id = $_POST['unique_id'];
		$kommentar = $_POST['kommentar'];			
		$published = $_POST['published'];
		$aktivated = $_POST['aktivated'];


		if(empty($unique_id)){
				$unique_id = generateRandomNumer($pdo);
		}

		if(empty($ordering)){
				$ordering = 999999;
		}
			
		
				
		// validate input
		$valid = true;
		if (empty($name)) {
			$nameError = 'Please enter Name';
			$valid = false;
		}

		if (empty($vorname)) {
			$vornameError = 'Please enter Vorname';
			$valid = false;
		}		
		/*if (empty($email)) {
			$emailError = 'Please enter Email Address';
			$valid = false;
		} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$emailError = 'Please enter a valid Email Address';
			$valid = false;
		}*/
		if ( !filter_var($email,FILTER_VALIDATE_EMAIL) and !empty($email)) {
			$emailError = 'Please enter a valid Email Address';
			$valid = false;
		}
		if (empty($emailsend)) {
			$emailsendError = 'E-Mail senden ja/nein?';
			$valid = false;
		}	
		/*if (empty($ordering)) {
			$orderingError = 'Please select a position';
			$valid = false;
		}
		
		if (empty($unique_id)) {
			$unique_idError = 'Please select a uniqu_id';
			$valid = false;
		}*/
		
		if (empty($published)) {
			$publishedError = 'Please select wartend/hanger';
			$valid = false;
		}
		if (empty($aktivated)) {
			$aktivatedError = 'Please select anwesend/abwesend';
			$valid = false;
		}		



		//berechnen der des letzten ordering Wertes
		$sql2 = 'SELECT * FROM piloten WHERE published = 1 AND aktivated = 1 ORDER BY ordering asc;';
		$maxrowdel = $pdo->prepare($sql2);
		$maxrowdel->execute();
		$maxrows = $maxrowdel->rowCount();
		
		
		//checken ob Pilot schon vorhanden ist	
		$sql = "SELECT COUNT(*) as total_rows FROM piloten where name = ? AND vorname = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($name, $vorname));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$pilot_already_count= $data['total_rows'];
		// Anzahl Reihen größer null, und der Pilot wird nicht editiert (nur bei Neuerstellung, deswegen das get id
		if($pilot_already_count != 0 && empty($_GET['id'])){		
			$nameError = 'Name und Vorname schon vorhanden';
			$vornameError = 'Name und Vorname schon vorhanden';
			$valid = false;
		}			
		
									
		if($aktivated == 2 or $published == 2){
				//sicherstellen, dass es keinen inaktiven gibt der aber freigegeben ist
				if($aktivated == 2) { $published = 2; }
				$ordering=999999;
		}elseif ($aktivated == 1 and $published == 1 and $ordering == 999999){
			//wenn pilot im hanger und er wird in die warteliste geschoben, dann letze Position +1
			$ordering=$maxrows+1;
		}elseif ($aktivated == 1 and $published == 1){
			//wenn pilot  in der Warteliste und nur geupdated wird dann gleiche Position beibehalten
			$ordering=$ordering;
		}else{
				$ordering=999999;
		}		
		
						
		// update data, wenn eine id vorhanden und valid, sonst lege einen neuen Piloten an
		if($valid){
			
			if (null!=$id) {
							
				$sql = "UPDATE piloten  set name = ?, vorname = ?, email = ?, emailsend = ?, ordering =?, published = ?, aktivated = ?, unique_id = ?, kommentar = ? WHERE id = ?";
				$q = $pdo->prepare($sql);
				$q->execute(array($name, $vorname, $email, $emailsend, $ordering, $published, $aktivated, $unique_id, $kommentar, $id));
						
			}else{
				
				$uniqu_id = generateRandomNumer($pdo);
				$ordering = 999999;
						

					//wenn keine Id neuen Piloten anlegen
					$sql = "INSERT INTO piloten (name, vorname, email, emailsend, ordering, published, aktivated, unique_id, kommentar) values(?, ?, ?, ?, ?, ?, ?, ?, ?)";
					$q = $pdo->prepare($sql);
					$q->execute(array($name, $vorname, $email, $emailsend, $ordering, $published, $aktivated, $unique_id, $kommentar));	
					//get the inserted id
					$new_id = $pdo->lastInsertId();	

		
			}
			
    		if (isset($_POST['save_exit'])) {
        		header("Location: index.php");
    		}
    		elseif (isset($_POST['save'])) {
				header("Location: piloten.php?id=$new_id");
    		}
				
			
			
			
		}
		
		
	} elseif(!empty($_GET['id'])) {
			//$pdo = Database::connect();
			//$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM piloten where id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			$data = $q->fetch(PDO::FETCH_ASSOC);
			
			$name = $data['name'];
			$vorname = $data['vorname'];
			$email = $data['email'];
			$emailsend = $data['emailsend'];
			$ordering = $data['ordering'];		
			$unique_id = $data['unique_id'];	
			$kommentar = $data['kommentar'];
			$published = $data['published'];
			$aktivated = $data['aktivated'];
		//Database::disconnect();
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
    
    			<div class="col-sm-offset-2 col-sm-10">
    				<div class="row">
		    			<h3><?php if(empty($_GET['id'])) { echo "Pilot erstellen"; }else{ echo "Pilot updaten"; }  ?></h3>
		    		</div>
    		
	    			<form action="piloten.php?id=<?php echo $id ?>" method="post">
                    
                    
					  <div class="form-group <?php echo !empty($nameError)?'has-error':'';?>">
                      
					    <label class="control-label">Name</label>
					    <div class="controls">
					      	<input name="name" class="form-control" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-block"><?php echo $nameError;?></span>
					      	<?php endif; ?>
					   </div>
					  </div>
                      
                      
                      	<div class="form-group <?php echo !empty($vornameError)?'has-error':'';?>">
					    <label class="control-label">Vorname</label>
					    <div class="controls">
					      	<input name="vorname" class="form-control" type="text"  placeholder="Vorname" value="<?php echo !empty($vorname)?$vorname:'';?>">
					      	<?php if (!empty($vornameError)): ?>
					      		<span class="help-block"><?php echo $vornameError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
                      
					  <div class="form-group <?php echo !empty($emailError)?'has-error':'';?>">
					    <label class="control-label">Email Address (optional)</label>
					    <div class="controls">
					      	<input name="email" class="form-control" type="text" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
					      	<?php if (!empty($emailError)): ?>
					      		<span class="help-block"><?php echo $emailError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>

					  <div class="form-group <?php echo !empty($emailsendError)?'has-error':'';?>">
					    <label class="control-label">Email Senden?</label>
					    <div class="controls">
                        	<label class="form-control"><input type="radio" value="1" <?php echo ($emailsend == 1)?'checked="checked"':'';?> name="emailsend">Ja</label>
							<label class="form-control"><input type="radio" value="2" <?php echo ($emailsend == 2)?'checked="checked"':'';?> name="emailsend">Nein</label>

					      	<?php if (!empty($emailsendError)): ?>
					      		<span class="help-block"><?php echo $emailsendError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
                 
                      	<div class="form-group <?php echo !empty($publishedError)?'has-error':'';?>">
					    <label class="control-label">wartend/hanger</label>
					    <div class="controls">
					      	<!-- <input name="published" type="text"  placeholder="published Number" value="<?php //echo !empty($published)?$published:'';?>"> -->
                            <select class="form-control" name="published" id="published">
              					<option value="2" <?php echo ($published == 2)?'selected="selected"':'';?>>hanger</option>
                                <option value="1" <?php echo ($published == 1)?'selected="selected"':'';?> >wartend</option>	
            				</select>
					      	<?php if (!empty($publishedError)): ?>
					      		<span class="help-block"><?php echo $publishedError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
                      	<div class="form-group <?php echo !empty($aktivatedError)?'has-error':'';?>">
					    <label class="control-label">anwesend/abwesend</label>
					    <div class="controls">
					      	<!-- <input name="aktivated" type="text"  placeholder="aktivated Number" value="<?php //echo !empty($aktivated)?$aktivated:'';?>"> -->
                            <select class="form-control" name="aktivated" id="aktivated">
              					<option value="1" <?php echo ($aktivated == 1)?'selected="selected"':'';?> >anwesend</option>
              					<option value="2" <?php echo ($aktivated == 2)?'selected="selected"':'';?>>abwesend</option>
            				</select>
					      	<?php if (!empty($aktivatedError)): ?>
					      		<span class="help-block"><?php echo $aktivatedError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
                      
					  <div class="form-group ">
					    <label class="control-label" >Kommentar</label>
					    <div class="controls">
                            <textarea class="form-control" id="kommentar" name="kommentar" type="text"  placeholder="Kommentar" rows="3"><?php echo !empty($kommentar)?$kommentar:'';?></textarea>
					   </div>
					  </div>
                       
                       
                      <div class="form-group <?php echo !empty($unique_idError)?'has-error':'';?>">
					    <label class="control-label">Unique Id <?php if (!empty($unique_id)) { ?> <a href="/flugtag/personal.php?uid=<?php echo $unique_id; ?>" target= "_blank">(Link personalisierte Seite)</a>  <?php } ?></label>
					    <div class="controls">
					      	<input name="unique_id" class="form-control" type="text"  placeholder="Unique Id" value="<?php echo !empty($unique_id)?$unique_id:'';?>" readonly>
					      	<?php if (!empty($unique_idError)): ?>
					      		<span class="help-block"><?php echo $unique_idError;?></span>
					      	<?php endif;?>
                            
					    </div>
					  </div>


                       <div class="form-group <?php echo !empty($orderingError)?'has-error':'';?>">
					    <label class="control-label">Reihenfolge</label>
					    <div class="controls">
					      	<input name="ordering" class="form-control" type="text"  placeholder="Ordering" value="<?php echo !empty($ordering)?$ordering:'';?>" readonly>
					      	<?php if (!empty($orderingError)): ?>
					      		<span class="help-block"><?php echo $orderingError;?></span>
					      	<?php endif;?>
					    </div>
					   </div>


                                       
                      
                      
					  <div class="form-actions">
                          <button type="submit" class="btn btn-success" name="save_exit">
                      <?php if(empty($_GET['id'])) { echo "Speichern + schließen"; }else{ echo "Update"; }  ?>
						  </button>    
                           
                      <?php if(empty($_GET['id'])) {  ?>
					      
                         <button type="submit" class="btn btn-success" name="save">Speichern</button>  
                       <?php } ?>   
                          
                          
						<?php if(!empty($_GET['id'])) { echo "<a href=\"flugzeug.php?piloten_id=".$id."\" class=\"btn btn-info\">Flugzeug erstellen</a> "; }  ?>
                      
                                                                        
                          
						  <a class="btn btn-info" href="index.php">Zurück</a>
						
                        </div>
					</form>
				</div>
				
    </div> <!-- /container -->
    
 
 
    <?php if(!empty($_GET['id'])) { ?>
    
 
   <div class="container">   
  <div class="row">
  <div class="col-sm-14">
    <div class="row">
      <div class="col-xs-14">
      
      
        		<h1><span class="glyphicon glyphicon-plane"></span> Flugzeuge des Piloten <?php echo "$vorname $name"; ?></h1>
				
				<table class="js-dynamitable     table table-bordered table-condensed">
		              <thead>
		                <tr>
                          <th>Flugzeugname</th>
                          <th>Flugzeugtyp</th>
                          <th>verfügbar</th>
                          <th>gerade Ausgewaehlt</th>
                          <th>Aktion</th>
		                </tr>
        			 </thead>
                      
					 <tbody>

                            

    
    
		              <?php 
					  // include 'database.php';
					   //$pdo = Database::connect();					   
					   $sql3 = 'SELECT F.*, FT.* FROM flugzeug As F, flugzeug_typ As FT WHERE F.piloten_id = ' . $id . ' AND F.flugzeugtyp_id = FT.flugzeugtyp_id ORDER BY F.name_f asc;';
					   			
						
	 				   foreach ($pdo->query($sql3) as $row) {

						   		$aktivated = ($row['aktivated'] == 1)?'btn glyphicon glyphicon-eye-open':'btn glyphicon glyphicon-eye-close';
								$published = ($row['published'] == 1)?'btn glyphicon glyphicon-ok-circle':'btn glyphicon glyphicon-ban-circle';
						   		$style_aktivated = ($row['aktivated'] == 1)?'color:#5cb85c':'color:#d9534f';
								$style_published = ($row['published'] == 1)?'color:#5cb85c':'color:#d9534f';
								//$published = ($row['published'] == 1)?'selected':'';
								$table_class="";
						   		echo '<tr class="' . $table_class . '">';
								//echo '<td><span class="' . $icon_class . '" aria-hidden="true"></span></td>';
							   	echo '<td>'. $row['name_f'] . '</td>';
								echo '<td>'. $row['name_ft'] . '</td>';
								echo '<td><span class="'. $aktivated . '" aria-hidden="true" style="' . $style_aktivated . '"></span></td>';
								echo '<td><span class="'. $published . '" aria-hidden="true" style="' . $style_published . '"></span></td>';
							   	echo '<td width=140 >';
							    echo '<a class="btn btn-info btn-xs" href="flugzeug.php?id_f='.$row['id_f'].'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
								echo '&nbsp;';
							   	echo '<a class="btn btn-danger btn-xs" href="delete_flugzeug.php?id_f='.$row['id_f'].'&piloten_id='.$row['piloten_id'].'"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';							
							   	echo '</td>';
							   	echo '</tr>';
									
					   }
					   //Database::disconnect();
					  ?>
				      </tbody>
	            </table>
        

        
      </div>
      
      
      </div>   
      
    <?php    }  ?>
 <?php
 Database::disconnect();
 ?>  
  </body>
</html>
