<?php 
	
	require 'database.php';

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
	$id_f = null;
	$id_fa = null;
	
	if ( !empty($_GET['id_f'])) {
		$id_f = $_REQUEST['id_f'];
	}
	
	if ( !empty($_GET['piloten_id'])) {
		$piloten_id = $_REQUEST['piloten_id'];
		//echo $piloten_id;
	}	
	
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$name_fError = null;
		$piloten_idError = null;
		$flugzeugtyp_idError = null;
		$id_fa_Error = null;
		$publishedError = null;
		$aktivatedError = null;
		$flugzeug_kommentar = null;

		// keep track post values
		$name_f = $_POST['name_f'];
		$piloten_id = $_POST['piloten_id'];
		$flugzeugtyp_id = $_POST['flugzeugtyp_id'];			
		$id_fa = $_POST['id_fa'];		
		$published = $_POST['published'];
		$aktivated = $_POST['aktivated'];
		$flugzeug_kommentar = $_POST['flugzeug_kommentar'];
		
		// validate input
		$valid = true;
		if (empty($name_f)) {
			$name_fError = 'Please enter Flugzeugname';
			$valid = false;
		}

		if (empty($piloten_id)) {
			$piloten_idError = 'Please select a Pilot';
			$valid = false;
		}		
		if (empty($flugzeugtyp_id)) {
			$flugzeugtyp_idError = 'Please select flugzeugtyp';
			$valid = false;
		} 
		if (empty($id_fa)) {
			$id_fa_Error = 'Please select Engine';
			$valid = false;
		} 				
		
		
		if (empty($published)) {
			$publishedError = 'Please select wartend/hanger';
			$valid = false;
		}
		if (empty($aktivated)) {
			$aktivatedError = 'Please select anwesend/abwesend';
			$valid = false;
		}	

		if($aktivated == 2){
				//sicherstellen, dass es keinen inaktiven gibt der aber freigegeben ist
				if($aktivated == 2) { $published = 2; }					
		}
		
		//echo "id_f $id_f";
					
		// update data
		if($valid){
			
			if (null!=$id_f) {
			
				$sql = "UPDATE flugzeug  set name_f = ?, piloten_id = ?, flugzeugtyp_id = ?, flugzeugantrieb_id = ?, flugzeug_kommentar = ?,  published =?, aktivated = ? WHERE id_f = ?";
				$q = $pdo->prepare($sql);			
				$q->execute(array($name_f, $piloten_id, $flugzeugtyp_id, $id_fa, $flugzeug_kommentar, $published, $aktivated, $id_f));
			
			//Database::disconnect();			
			}else{
			
				$sql12 = "SELECT COUNT(*) as total_rows FROM flugzeug WHERE piloten_id = ?";
				$q = $pdo->prepare($sql12);
				$q->execute(array($piloten_id));
				$data = $q->fetch(PDO::FETCH_ASSOC);
				$number_of_aircrafts = $data['total_rows'];
				if ( $number_of_aircrafts == 0 ) {
					$published=1;
				}
		
				$sql = "INSERT INTO flugzeug (name_f, piloten_id, flugzeugtyp_id, flugzeugantrieb_id, flugzeug_kommentar, published, aktivated) values(?, ?, ?, ?, ?, ?, ?)";			   
				$q = $pdo->prepare($sql);
				$q->execute(array($name_f, $piloten_id, $flugzeugtyp_id, $id_fa, $flugzeug_kommentar, $published, $aktivated));
			
			}
		
		header("Location: piloten.php?id=$piloten_id");
		}
		
		
	} elseif(!empty($_GET['id_f'])) {
		//$pdo = Database::connect();
		//$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM flugzeug where id_f = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id_f));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$name_f = $data['name_f'];
		$piloten_id = $data['piloten_id'];
		$flugzeugtyp_id = $data['flugzeugtyp_id'];	
		$id_fa = $data['flugzeugantrieb_id'];
		$flugzeug_kommentar= $data['flugzeug_kommentar'];
		$published = $data['published'];
		$aktivated = $data['aktivated'];
		
	}
	
		//$sql4 = "SELECT * FROM piloten where aktivated = 1 ORDER BY name asc;";
		$sql4 = "SELECT * FROM piloten ORDER BY name asc;";
		$q = $pdo->prepare($sql4);
		$piloten_array=$pdo->query($sql4);
		
		$sql5 = "SELECT * FROM flugzeug_typ ORDER BY name_ft asc;";
		$q = $pdo->prepare($sql5);
		$flugzeug_array=$pdo->query($sql5);

		$sql6 = "SELECT * FROM flugzeug_antrieb ORDER BY name_fa asc;";
		$q = $pdo->prepare($sql6);
		$antrieb_array=$pdo->query($sql6);


		
						
		Database::disconnect();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

  <link   href="../css/bootstrap.min.css" rel="stylesheet">
  <script src="../js/bootstrap.min.js"></script>
 <script src="../js/bootstrap.js"></script>
 
 
 <!-- 
 <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.5/css/bootstrap-select.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.5/js/bootstrap-select.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />

  -->


</head>

<body>
    <div class="container">
    
    			<div class="col-sm-offset-2 col-sm-10">
    				<div class="row">
		    			<h3><?php if(empty($_GET['id_f'])) { echo "Flugzeug erstellen"; }else{ echo "Flugzeug updaten"; }  ?></h3>
		    		</div>
    		
	    			<form action="flugzeug.php?id_f=<?php echo $id_f?>" method="post">
                    
                    
					  <div class="form-group <?php echo !empty($name_fError)?'has-error':'';?>">
					    <label class="control-label" >Flugzeugname</label>
					    <div class="controls">
					      	<input name="name_f" class="form-control" type="text"  placeholder="Flugzeugname" value="<?php echo !empty($name_f)?$name_f:'';?>">
					      	<?php if (!empty($name_fError)): ?>
					      		<span class="help-block"><?php echo $name_fError;?></span>
					      	<?php endif; ?>
					   </div>
					  </div>
                      
                      
                      
					<div class="form-group <?php echo !empty($piloten_idError)?'has-error':'';?>">
					    <label class="control-label">Pilot auswaehlen</label>
					    <div class="controls">
                            <select class="form-control" name="piloten_id" id="piloten_id">
                            
                            <?php
							//hier muss anbefangen werden, wenn kein Pilot ausgewählt ist, muss selected dastehen, damit nicht der falsche Pilot ausversehen ein Flugzeug bekommt
							$selected_flag=0;
							foreach ($piloten_array as $row) {
								if($row['name'] != "Trennung"){
									$selected_pilot = ($row['id'] == $piloten_id)?'selected':'';
									if($row['id'] == $piloten_id){ $selected_flag=1; }
								?>
                            	<option <?php echo $selected_pilot; ?> value="<?php echo $row['id']; ?>"><?php echo $row['name'] . '&nbsp;' . $row['vorname']; ?></option>
                            <?php
								}
							}	
							
							if($selected_flag == 0){?> <option selected value="0">select</option> <?php }
							
								?>                                
            				</select>
								<?php if (!empty($pilotenidError)): ?>
					      		<span class="help-block"><?php echo $pilotenidError;?></span>
					      	<?php endif;?>
					  	</div>
                        </div>
                        
                        
                        
                        
                      	<div class="form-group <?php echo !empty($flugzeugtyp_idError)?'has-error':'';?>">
					    <label class="control-label">Flugzeugtyp</label>
					    <div class="controls">
                            <select class="form-control selectpicker" name="flugzeugtyp_id" id="flugzeugtyp_id" >
                            
                               <?php
							$selected_flag=0;
							foreach ($flugzeug_array as $row_ft) {
									$selected_flugzeugtyp = ($row_ft['flugzeugtyp_id'] == $flugzeugtyp_id)?'selected':'';
									if($row_ft['flugzeugtyp_id'] == $flugzeugtyp_id){ $selected_flag=1; }
								?>
                            	<option data-subtext="<i class='glyphicon glyphicon-eye-open'></i>" <?php echo $selected_flugzeugtyp; ?> value="<?php echo $row_ft['flugzeugtyp_id']; ?>" ><?php echo $row_ft['name_ft']; ?> </option>
                            <?php
							}	
							
							if($selected_flag == 0){?> <option selected value="0">select</option> <?php }
							
								?>     
                                    

  
            				</select>
					      	<?php if (!empty($flugzeugtyp_idError)): ?>
					      		<span class="help-block"><?php echo $flugzeugtyp_idError;?></span>
					      	<?php endif;?>
					  	</div>
                      </div>




              
                      	<div class="form-group <?php echo !empty($id_fa_Error)?'has-error':'';?>">
					    <label class="control-label">Flugzeugantrieb</label>
					    <div class="controls">
                            <select class="form-control" name="id_fa" id="id_fa">
                            
                               <?php
							$selected_flag=0;
							foreach ($antrieb_array as $row_fa) {
									$selected_flugzeugantrieb = ($row_fa['id_fa'] == $id_fa)?'selected':'';
									if($row_fa['id_fa'] == $id_fa){ $selected_flag=1; }
								?>
                            	<option <?php echo $selected_flugzeugantrieb; ?> value="<?php echo $row_fa['id_fa']; ?>"><?php echo $row_fa['name_fa']; ?></option>
                            <?php
							}	
							
							if($selected_flag == 0){?> <option selected value="0">select</option> <?php }
							
								?>         

            				</select>
					      	<?php if (!empty($id_fa_Error)): ?>
					      		<span class="help-block"><?php echo $id_fa_Error;?></span>
					      	<?php endif;?>
					  	</div>
                      </div>
                      
                      
                      
                     
                      	<div class="form-group <?php echo !empty($aktivatedError)?'has-error':'';?>">
					    <label class="control-label">verfuegbar</label>
					    <div class="controls">
					      	<!--	<input name="aktivated" type="text"  placeholder="aktivated Number" value="<?php // echo !empty($aktivated)?$aktivated:'';?>"> -->
                            <select class="form-control" name="aktivated" id="aktivated">
              					<option value="1" selected>verfuegbar</option>
              					<option value="2">nichtverfuegbar</option>
            				</select>
					      	<?php if (!empty($aktivatedError)): ?>
					      		<span class="help-block"><?php echo $aktivatedError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
                      
                      

					  <div class="form-group ">
					    <label class="control-label" >Kommentar</label>
					    <div class="controls">
                            <textarea class="form-control" id="flugzeug_kommentar" name="flugzeug_kommentar" type="text"  placeholder="Kommentar" rows="3"><?php echo !empty($flugzeug_kommentar)?$flugzeug_kommentar:'';?></textarea>
					   </div>
					  </div>
                      
                      
                                            
                      <input type="hidden" name="published" value="<?php echo !empty($published)?$published:'2';?>"/>
                      
                      
					  <div class="form-actions">
                      <button type="submit" class="btn btn-success">
                      <?php if(empty($_GET['id_f'])) { echo "Erstellen"; }else{ echo "Update"; }  ?>
						  </button>
						  <a class="btn btn btn-info" href="piloten.php?id=<?php echo $piloten_id; ?>">Zurück (Piloten)</a>
                          <a class="btn btn btn-info" href="index.php">Zurück (Index)</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->

  </body>
</html>
