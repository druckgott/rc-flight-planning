		              <?php 
						
						require 'admin/database.php';
						$pdo = Database::connect();

						require 'admin/config_file.php';
						
						

					   #$sql = 'SELECT * FROM piloten WHERE aktivated = 1 AND published = 1 ORDER BY ordering asc;';
					   
					   $sql = 'SELECT piloten.*, flugzeug.*, flugzeug_typ.*, flugzeug_antrieb.* FROM piloten LEFT JOIN flugzeug ON piloten.id=flugzeug.piloten_id LEFT JOIN flugzeug_typ ON flugzeug.flugzeugtyp_id=flugzeug_typ.flugzeugtyp_id LEFT JOIN flugzeug_antrieb ON flugzeug.flugzeugantrieb_id=flugzeug_antrieb.id_fa WHERE ( piloten.aktivated = 1 AND piloten.published = 1 AND flugzeug.published = 1 ) OR ( piloten.name = "Trennung") ORDER BY piloten.ordering asc;';
					   					   
					   //maximale Zeilen erhalten
					   $del = $pdo->prepare($sql);
					   $del->execute();
					   $maxrows = $del->rowCount() - 1;
					   
					   $rowcounter=0;
					   $tablecounter=0;
					   //$blinkcounter=1;
					   $flag_split_oben_unten=0;
					   $flag_counter=1;

						echo 'Last Update: ';
						$datum = date("d.m.Y");
						$uhrzeit = date("H:i:s");
						echo $datum," - ",$uhrzeit," Uhr<p ></p>";

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
						
	
	
	
	
	
						echo '<div class="row">
                					<div class="col-sm-12" >
										<div class="brdr pad-10 box-shad btm-mrg-20 property-listing" style="background-color:#'. $einstellung['index_back_color_frame'].'">
                       						<div class="media" style="background-color:#'. $einstellung['index_back_color_other'].'">
												<div class="media-body">
													<span class="pull-left btn glyphicon glyphicon-plane " aria-hidden="true" style="padding: '. $einstellung['index_box_high'].'px;"></span>
													<'.$einstellung['index_font_size_top_b'].' class="media-heading"><a href="#" target="_parent">Pos. | Name | Flugzeug</a><span class="pull-right">Antrieb/Modelltyp</span></'.$einstellung['index_font_size_top_b'].'>
                           						</div>
                       						</div>
                    					</div><!-- End Listing-->';
					  echo '			</div><!-- End Col -->
            						</div><!-- End row -->';
						 
					
								
						echo '<div class="row">
                					<div class="col-sm-12" >';
					
								
	 				   foreach ($pdo->query($sql) as $row) {
						
						
						
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
									if(sizeof($array_flightime) == 0 ){
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
						   		if($tablecounter==0){ $table_class = "bg-success"; $icon_class = "btn glyphicon glyphicon-plane"; $table_style="background-color:#" . $einstellung['index_back_color_first']; }
								if($tablecounter==1){ $table_class = "bg-danger"; $icon_class = "btn glyphicon glyphicon-flash"; $table_style="background-color:#" . $einstellung['index_back_color_second']; }
								if($tablecounter==2){ $table_class = "bg-danger"; $icon_class = "btn glyphicon glyphicon-flash";  $table_style="background-color:#" . $einstellung['index_back_color_third']; }
								if($tablecounter>=3){ $table_class = "bg-active"; $icon_class = "btn glyphicon glyphicon-stop"; $table_style="background-color:#" . $einstellung['index_back_color_other']; }
								
						   		$published = ($row['published'] == 1)?'warten':'Hangar';
								
								//trennungen abfangen
								if($row['name'] == "Trennung"){
									$add_waittime_flag=1;
									
                  					echo '<div class="brdr pad-0 box-shad btm-mrg-20 property-listing " style="background-color:#'. $einstellung['index_back_color_frame'].'">';
                       				echo '<div class="media bg-info" style="background-color:#'.$einstellung['index_back_split_color'].'">';
									echo '<span class="pull-left btn btn-xs glyphicon glyphicon-random "aria-hidden="true" style="color:#'.$einstellung['index_icon_split_color'].'"></span>';
									if($tablecounter<$einstellung['index_num_top_b']){
										echo '<'.$einstellung['index_font_size_split_top_b'].' class="media-heading"><a href="#" target="_parent">&nbsp;</a></'.$einstellung['index_font_size_split_top_b'].'>';
									}else{
										echo '<'.$einstellung['index_font_size_bottom_b'].' class="media-heading"><a href="#" target="_parent">&nbsp;</a></'.$einstellung['index_font_size_bottom_b'].'>';
									}
                       				echo '</div>';
                   					echo '</div><!-- End Listing-->';
									
									
				   
								}else{
								

                  					echo '<div class="brdr pad-10 box-shad btm-mrg-20 property-listing " style="background-color:#'. $einstellung['index_back_color_frame'].'">';
                       				echo '<div class="media ' . $table_class .' " style="' . $table_style .'">';
                          			//echo '<div class="media-body fnt-smaller ">';
										
   									if($tablecounter<$einstellung['index_num_top_b']){
										echo '';
                          				echo '<'.$einstellung['index_font_size_top_b'].' class="media-heading ">
										<span class="pull-left ' . $icon_class . '" aria-hidden="true" style="padding: '. $einstellung['index_box_high'].'px;" ></span>
											  <a href="#" data-toggle="popover" title="Piloteninfo: '. $row['kommentar'] .'" data-content="Flugzeuginfo: '. $row['flugzeug_kommentar'] .'" target="_parent" >'. ($tablecounter+1) .' | '. $row['name'] . '&nbsp;'. $row['vorname'] . ' | '. $row['name_f'] . '</a>
<span class="pull-right '. $row['iconname_ft'] .'" aria-hidden="true" style="padding: 2px;" > 
                                                        <span class="pull-left " aria-hidden="true" style="' . $style . '">'. $row['name_fa'] . '</span>
                                                </span>';
												if($einstellung['index_wait_time'] == 1) {
													echo '&nbsp;(ca: ' . date("H:i",floor($waittime/(60*$einstellung['index_round_waittime']))*(60*$einstellung['index_round_waittime'])+strtotime("1970/1/1")) . ')';
												}
											 echo '</'.$einstellung['index_font_size_top_b'].'>';
											  
									}else{
                          				echo '<'.$einstellung['index_font_size_bottom_b'].' class="media-heading">
												<a href="#" target="_parent">' . ($tablecounter+1) .' - '. $row['name'] . '&nbsp;'. $row['vorname'] . '</a>';	
												if($einstellung['index_wait_time'] == 1) {
													echo '&nbsp;(ca: ' . date("H:i",floor($waittime/(60*$einstellung['index_round_waittime']))*(60*$einstellung['index_round_waittime'])+strtotime("1970/1/1")) . ')';	
												}
												echo '<span class="pull-right '. $row['iconname_ft'] .'" aria-hidden="true" ></span>
												</'.$einstellung['index_font_size_bottom_b'].'>';		
									}

                         			//echo '  </div>';
                       				echo ' </div>';
                   					echo ' </div><!-- End Listing-->';	
										
												
												

								}


							
														
							if($row['name'] == "Trennung"){
								$tablecounter++;
							}



							### hier wird die obere von den unterne boxbereich getrennt	
							if(	$tablecounter >= $einstellung['index_num_top_b'] ) {	
							
							echo ' </div><!-- End Col -->';
									
									### Wenn der Split mit dann immer gleich hoher row-eq-height aktiv ist, muss nach jeder dritten box eine neue Reihe erzeugt werden
									if(($flag_split_oben_unten == 1)){
											### Split bei jeder 3.ten Reihe (bzw. config variable)
											if($flag_counter == $einstellung['index_num_bottom_b']){
												echo ' </div><!-- End row -->';
												
												### Eine zwischenbox um die Zeilen zu trennen
												echo '<div class="row">';
												echo '<div class="col-sm-12" >';
												echo '<div class="" style="background-color:#'.$einstellung['index_back_split_color'].'">';
												
												echo '<div class="brdr pad-0 box-shad btm-mrg-20 property-listing " style="background-color:#'. $einstellung['index_back_color_frame'].'">'.$block_unten_trenner_text;
												echo '</div>';
                   								echo '</div><!-- End Listing-->';
												echo '</div><!-- End Col -->';
												echo '</div><!-- End row -->';
												
												
												 
												echo '<div class="row row-eq-height">';
												$flag_counter=0;
											}
											$flag_counter++;
									}		
									
									### Hier wird oben von unten getrennt und eine feste Hohe ab da eingestellt							
									if($flag_split_oben_unten == 0){
											$flag_split_oben_unten=1;
											echo ' </div><!-- End row -->';
											echo '<div class="row row-eq-height">';
									}	
																
						 		echo '<div class="col-sm-4" >';  
							}
						
												
							$rowcounter++;
								
                                
                                	
					   }
					  
					  
					  
					  
					  echo '			</div><!-- End Col -->
            						</div><!-- End row -->';



echo '			<script>';
echo '			$(document).ready(function(){';
echo '			    $(\'[data-toggle="popover"]\').popover();   ';
echo '			});';
echo '			</script>';

Database::disconnect();
					  ?>