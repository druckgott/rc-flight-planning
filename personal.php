<?php

require 'admin/database.php';
$pdo = Database::connect();
require 'admin/config_file.php';
Database::disconnect();

$uid = null;

if ( !empty($_GET['uid'])) {
	$uid = $_REQUEST['uid'];
}
						
						
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <link   href="css/fontello.css" rel="stylesheet">
    <link   href="css/list.css" rel="stylesheet">
	<!-- dynamitable --> 
	<script src="js/dynamitable.jquery.min.js"></script> 
	<script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>    

  
  
  
       
   <script>
   <!-- Javascript fuer Auto Reload -->
      function auto_load(){
        $.ajax({
          url: "personal_data.php?uid=<?php echo $uid; ?>",
          cache: false,
          success: function(data){
             $("#auto_load_div").html(data);
          } 
        });
      }
 
      $(document).ready(function(){
 
        auto_load(); //Call auto_load() function when DOM is Ready
 
      });
 
      //Refresh auto_load() function after 3000 milliseconds
      setInterval(auto_load,10000);
 
 
      </script>
      
	


	<title>Flugplanung MFC-Dachau e.V.</title>



<style>
<!--
.glyphicon { cursor: pointer; }
input,
select { width: 100%; }
-->
body, a {
color:#<?php echo $einstellung['index_text_color']; ?>;
}
 
</style>

</head>


<body >

    <div class="container-fluid" style="background-color:#<?php echo $einstellung['index_background']; ?>" >
        <div class="container container-pad" id="property-listings" >
           
            <div class="row" >
              <div class="col-md-12" >
                <h1>MFC-Dachau Flugplanung</h1>
              </div>
            </div>

			<div id="auto_load_div" ></div>


 
	 </div><!-- End container -->
</div>
 
 
    



   
  </body>
  
 


</html>
