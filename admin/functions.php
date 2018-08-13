<?php


//Function to generate unique alpha numeric code
function generateRandomNumer($pdo){
	
	$len=8;
	
    $randomString = substr(MD5(time()),$len);
	$sql_uniqu_id = 'SELECT * FROM unique_ids WHERE number = "'.$randomString.'";';
 
	 //Check newly generated Code exist in DB table or not.
     $uniqu_id = $pdo->prepare($sql_uniqu_id);
	 $uniqu_id->execute();
	 $resultCount_uniqu_id = $uniqu_id->rowCount();


    if($resultCount_uniqu_id>0){
        //IF code is already exist then function will call it self until unique code has been generated and inserted in Db.
		generateRandomNumer($pdo);
    }else{
        //Unique generated code will be inserted in DB.
		$sql_uniqu_id_2 = "INSERT INTO unique_ids (number) values( ?)";			   
		$q = $pdo->prepare($sql_uniqu_id_2);
		$q->execute(array($randomString));
    }
	
	return $randomString;
	
}
?>