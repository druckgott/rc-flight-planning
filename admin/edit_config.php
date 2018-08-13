<?php 

	require 'database.php';
	$pdo = Database::connect();
	require 'config_file.php';

	require 'functions.php';
	
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$config_names = array("index_background",	"index_text_color",	"index_num_top_b",	"index_num_bottom_b",	"index_font_size_top_b",	"index_font_size_split_top_b",	"index_font_size_bottom_b",	"index_icon_split_color","index_back_split_color",	"index_wait_time",	"index_back_color_first",	"index_back_color_second",	"index_back_color_third",	"index_back_color_other",	 "global_max_flight_time", "index_back_color_frame", "index_box_high", "index_round_waittime");
	
	if ( !empty($_POST)) {
		$valid = true;
		
		//Flugzeit auf Zahl überprüfen, alles andere ist eh nur mit Auswahl möglich
		$global_max_flight_timeError = null;
		$global_max_flight_time = $_POST['global_max_flight_time'];
		
		if (!ctype_digit($global_max_flight_time)) {
			$global_max_flight_timeError = 'Bitte eine Zahl eingeben';
			$valid = false;
		}

		$index_box_highError = null;
		$index_box_high = $_POST['index_box_high'];
		
		if (!ctype_digit($index_box_high)) {
			$index_box_highError = 'Bitte eine Zahl eingeben';
			$valid = false;
		}

		$index_round_waittimeError = null;
		$index_round_waittime = $_POST['index_round_waittime'];
		
		if (!ctype_digit($index_round_waittime)) {
			$index_round_waittimeError = 'Bitte eine Zahl eingeben';
			$valid = false;
		}			
			
				
						
		// update data, wenn eine id vorhanden und valid, sonst lege einen neuen Piloten an
		if($valid){
							
			$sql = "UPDATE einstellungen set name_s = ?, value_s = ? WHERE name_s = ?";
			$q = $pdo->prepare($sql);
			
			foreach ($config_names as $config_names) {
				if(!empty($_POST[$config_names])){
					$q->execute(array($config_names, $_POST[$config_names], $config_names));
				}
			}
	
		
			header("Location: edit_config.php");
			
		}
		
		
		
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jscolor.js"></script>
</head>

<body>
    <div class="container">
    
    			<div class="col-sm-offset-2 col-sm-10">
    				<div class="row">
		    			<h3>Einstellungen</h3>
		    		</div>
    		
	    			<form action="edit_config.php" method="post">
                    
                      
					  <!-- <div class="form-group <?php //echo !empty($emailError)?'has-error':'';?>">
					    <label class="control-label">Email Address (optional)</label>
					    <div class="controls">
					      	<input name="email" class="form-control" type="text" placeholder="Email Address" value="<?php //echo !empty($email)?$email:'';?>">
					      	<?php //if (!empty($emailError)): ?>
					      		<span class="help-block"><?php //echo $emailError;?></span>
					      	<?php //endif;?>
					    </div>
					  </div> -->

					  <div class="form-group <?php //echo !empty($emailError)?'has-error':'';?>">
					    <label class="control-label">TV-Seite Hintergrundfarbe</label>
					    <div class="controls">
					      	<input name="index_background" class="form-control jscolor" type="text" placeholder="BDBDBD" value="<?php echo !empty($einstellung['index_background'])?$einstellung['index_background']:'';?>">
					      	<?php //if (!empty($emailError)): ?>
					      		<span class="help-block"><?php //echo $emailError;?></span>
					      	<?php //endif;?>
					    </div>
					  </div>
  
  					  <div class="form-group <?php //echo !empty($emailError)?'has-error':'';?>">
					    <label class="control-label">TV-Seite Text Farbe</label>
					    <div class="controls">
					      	<input name="index_text_color" class="form-control jscolor" type="text" placeholder="000000" value="<?php echo !empty($einstellung['index_text_color'])?$einstellung['index_text_color']:'';?>">
					      	<?php //if (!empty($emailError)): ?>
					      		<span class="help-block"><?php //echo $emailError;?></span>
					      	<?php //endif;?>
					    </div>
					  </div>
                      					  <div class="form-group <?php //echo !empty($emailError)?'has-error':'';?>">
					    <label class="control-label">TV-Seite Anzahl große Wartepositionen</label>
					    <div class="controls">
                       
                            <select class="form-control" name="index_num_top_b" id="index_num_top_b">
                             <?php for ($i = 1; $i <= 50; $i++) { ?>
              					<option value="<?php echo $i; ?>" <?php echo ($einstellung['index_num_top_b'] == $i)?'selected="selected"':'';?>><?php echo $i; ?></option>
                             <?php } ?>   
            				</select>
					      	<?php //if (!empty($emailError)): ?>
					      		<span class="help-block"><?php //echo $emailError;?></span>
					      	<?php //endif;?>
					    </div>
					  </div>
                      					  <div class="form-group <?php //echo !empty($emailError)?'has-error':'';?>">
					    <label class="control-label">TV-Seite Anzahl Spalten für kleine Anzeige</label>
					    <div class="controls">
                             <select class="form-control" name="index_num_bottom_b" id="index_num_bottom_b">
                             <?php for ($i = 1; $i <= 10; $i++) { ?>
              					<option value="<?php echo $i; ?>" <?php echo ($einstellung['index_num_bottom_b'] == $i)?'selected="selected"':'';?>><?php echo $i; ?></option>
                             <?php } ?>   
            				</select>
					      	<?php //if (!empty($emailError)): ?>
					      		<span class="help-block"><?php //echo $emailError;?></span>
					      	<?php //endif;?>
					    </div>
					  </div>
                      	
                        <div class="form-group <?php //echo !empty($emailError)?'has-error':'';?>">
					    <label class="control-label">TV-Seite Schriftgröße für oberen Boxenbereich</label>
					    <div class="controls">
                              <select class="form-control" name="index_font_size_top_b" id="index_font_size_top_b">
                             <?php for ($i = 1; $i <= 5; $i++) { ?>
              					<option value="h<?php echo $i; ?>" <?php echo ($einstellung['index_font_size_top_b'] == 'h'.$i)?'selected="selected"':'';?>>h<?php echo $i; ?></option>
                             <?php } ?>   
            				</select>
                            
					      	<?php //if (!empty($emailError)): ?>
					      		<span class="help-block"><?php //echo $emailError;?></span>
					      	<?php //endif;?>
					    </div>
					  </div>
                      					  <div class="form-group <?php //echo !empty($emailError)?'has-error':'';?>">
					    <label class="control-label">TV-Seite Schriftgröße für oberen Boxenbereich Trennung</label>
					    <div class="controls">
                        <select class="form-control" name="index_font_size_split_top_b" id="index_font_size_split_top_b">
                             <?php for ($i = 1; $i <= 5; $i++) { ?>
              					<option value="h<?php echo $i; ?>" <?php echo ($einstellung['index_font_size_split_top_b'] == 'h'.$i)?'selected="selected"':'';?>>h<?php echo $i; ?></option>
                             <?php } ?>   
            				</select>					    
					      	<?php //if (!empty($emailError)): ?>
					      		<span class="help-block"><?php //echo $emailError;?></span>
					      	<?php //endif;?>
					    </div>
					  </div>
                      					  <div class="form-group <?php //echo !empty($emailError)?'has-error':'';?>">
					    <label class="control-label">TV-Seite Schriftgröße für unteren Boxenbereich</label>
					    <div class="controls">
                             <select class="form-control" name="index_font_size_bottom_b" id="index_font_size_bottom_b">
                             <?php for ($i = 1; $i <= 5; $i++) { ?>
              					<option value="h<?php echo $i; ?>" <?php echo ($einstellung['index_font_size_bottom_b'] == 'h'.$i)?'selected="selected"':'';?>>h<?php echo $i; ?></option>
                             <?php } ?>   
            				</select>	
					      	
					      	<?php //if (!empty($emailError)): ?>
					      		<span class="help-block"><?php //echo $emailError;?></span>
					      	<?php //endif;?>
					    </div>
					  </div>
                      
                      
                      
                                            
                       <div class="form-group <?php echo !empty($index_box_highError)?'has-error':'';?>">
					    <label class="control-label">Hohe der Boxen</label>
					    <div class="controls">
					      	<input name="index_box_high" class="form-control" type="text" placeholder="10" value="<?php echo !empty($einstellung['index_box_high'])?$einstellung['index_box_high']:'';?>">
					      	<?php if (!empty($index_box_highError)): ?>
					      		<span class="help-block"><?php echo $index_box_highError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
                      
                      
                      
                      
                      					  <div class="form-group <?php //echo !empty($emailError)?'has-error':'';?>">
					    <label class="control-label">TV-Seite Icon Farbe für Trenner</label>
					    <div class="controls">
					      	<input name="index_icon_split_color" class="form-control jscolor" type="text" placeholder="ffffff" value="<?php echo !empty($einstellung['index_icon_split_color'])?$einstellung['index_icon_split_color']:'';?>">
					      	<?php //if (!empty($emailError)): ?>
					      		<span class="help-block"><?php //echo $emailError;?></span>
					      	<?php //endif;?>
					    </div>
					  </div>
                      
                       <div class="form-group <?php //echo !empty($emailError)?'has-error':'';?>">
					    <label class="control-label">TV-Seite Farbe fuer Boxrahmen</label>
					    <div class="controls">
					      	<input name="index_back_color_frame" class="form-control jscolor" type="text" placeholder="ffffff" value="<?php echo !empty($einstellung['index_back_color_frame'])?$einstellung['index_back_color_frame']:'';?>">
					      	<?php //if (!empty($emailError)): ?>
					      		<span class="help-block"><?php //echo $emailError;?></span>
					      	<?php //endif;?>
					    </div>
					  </div>
                      
                      
                      					  <div class="form-group <?php //echo !empty($emailError)?'has-error':'';?>">
					    <label class="control-label">TV-Seite Hintergrundfrabe für Trenner</label>
					    <div class="controls">
					      	<input name="index_back_split_color" class="form-control jscolor" type="text" placeholder="000000" value="<?php echo !empty($einstellung['index_back_split_color'])?$einstellung['index_back_split_color']:'';?>">
					      	<?php //if (!empty($emailError)): ?>
					      		<span class="help-block"><?php //echo $emailError;?></span>
					      	<?php //endif;?>
					    </div>
					  </div>
                      					  <div class="form-group <?php //echo !empty($emailError)?'has-error':'';?>">
					    <label class="control-label">TV-Seite Wartezeit anzeigen ja/nein</label>
					    <div class="controls">
                        
                             <select class="form-control" name="index_wait_time" id="index_wait_time">
              					<option value="1" <?php echo ($einstellung['index_wait_time'] == 1)?'selected="selected"':'';?>>Ja</option>
                                <option value="2" <?php echo ($einstellung['index_wait_time'] == 2)?'selected="selected"':'';?>>Nein</option>
            				</select>	

					      	<?php //if (!empty($emailError)): ?>
					      		<span class="help-block"><?php //echo $emailError;?></span>
					      	<?php //endif;?>
					    </div>
					  </div>					  
                      
                      <div class="form-group <?php //echo !empty($emailError)?'has-error':'';?>">
					    <label class="control-label">TV-Seite Hintergrundfarbe Box 1 Position</label>
					    <div class="controls">
					      	<input name="index_back_color_first" class="form-control jscolor" type="text" placeholder="04b431" value="<?php echo !empty($einstellung['index_back_color_first'])?$einstellung['index_back_color_first']:'';?>">
					      	<?php //if (!empty($emailError)): ?>
					      		<span class="help-block"><?php //echo $emailError;?></span>
					      	<?php //endif;?>
					    </div>
					  </div>
                                          
                       <div class="form-group <?php //echo !empty($emailError)?'has-error':'';?>">
					    <label class="control-label">TV-Seite Hintergrundfarbe Box 2 Position</label>
					    <div class="controls">
					      	<input name="index_back_color_second" class="form-control jscolor" type="text" placeholder="FF8000" value="<?php echo !empty($einstellung['index_back_color_second'])?$einstellung['index_back_color_second']:'';?>">
					      	<?php //if (!empty($emailError)): ?>
					      		<span class="help-block"><?php //echo $emailError;?></span>
					      	<?php //endif;?>
					    </div>
					  </div>
                      
                       <div class="form-group <?php //echo !empty($emailError)?'has-error':'';?>">
					    <label class="control-label">TV-Seite Hintergrundfarbe Box 3 Position</label>
					    <div class="controls">
					      	<input name="index_back_color_third" class="form-control jscolor" type="text" placeholder="FF8000" value="<?php echo !empty($einstellung['index_back_color_third'])?$einstellung['index_back_color_third']:'';?>">
					      	<?php //if (!empty($emailError)): ?>
					      		<span class="help-block"><?php //echo $emailError;?></span>
					      	<?php //endif;?>
					    </div>
					  </div>
                      
                       <div class="form-group <?php //echo !empty($emailError)?'has-error':'';?>">
					    <label class="control-label">TV-Seite Hintergrundfarbe Box alle anderen</label>
					    <div class="controls">
					      	<input name="index_back_color_other" class="form-control jscolor" type="text" placeholder="ffffff" value="<?php echo !empty($einstellung['index_back_color_other'])?$einstellung['index_back_color_other']:'';?>">
					      	<?php //if (!empty($emailError)): ?>
					      		<span class="help-block"><?php //echo $emailError;?></span>
					      	<?php //endif;?>
					    </div>
					  </div>
                      
                       <div class="form-group <?php echo !empty($global_max_flight_timeError)?'has-error':'';?>">
					    <label class="control-label">Flugzeiten die größer sind werden nicht berücksichtigt (sec.)</label>
					    <div class="controls">
					      	<input name="global_max_flight_time" class="form-control" type="text" placeholder="900" value="<?php echo !empty($einstellung['global_max_flight_time'])?$einstellung['global_max_flight_time']:'';?>">
					      	<?php if (!empty($global_max_flight_timeError)): ?>
					      		<span class="help-block"><?php echo $global_max_flight_timeError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
                      
                       <div class="form-group <?php echo !empty($index_round_waittimeError)?'has-error':'';?>">
					    <label class="control-label">TV-Seite Zeiten runden (Min.)</label>
					    <div class="controls">
					      	<input name="index_round_waittime" class="form-control" type="text" placeholder="5" value="<?php echo !empty($einstellung['index_round_waittime'])?$einstellung['index_round_waittime']:'';?>">
					      	<?php if (!empty($index_round_waittimeError)): ?>
					      		<span class="help-block"><?php echo $index_round_waittimeError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>

                                                        
                      
                      
					  <div class="form-actions">
				      
                         <button type="submit" class="btn btn-success" name="save">Speichern</button>  
                         
						  <a class="btn btn-info" href="index.php">Zurück</a>
						
                        </div>
					</form>
				</div>
				
    </div> <!-- /container -->

 <?php
 Database::disconnect();
 ?>  
  </body>
</html>
