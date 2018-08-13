<?php

require 'database.php';

//Function to generate unique alpha numeric code
function generateRandomNumer($pdo){
	
	$len=8;
	
    $randomString = substr(MD5(time()),$len);
	
	$sql = 'SELECT * FROM test WHERE col_name = "'.$randomString.'";';
 
	 //Check newly generated Code exist in DB table or not.
     $del = $pdo->prepare($sql);
	 $del->execute();
	 $resultCount = $del->rowCount();


    if($resultCount>0){
        //IF code is already exist then function will call it self until unique code has been generated and inserted in Db.
		generateRandomNumer($pdo);
    }else{
        //Unique generated code will be inserted in DB.
		$sql2 = "INSERT INTO test (col_name) values( ?)";			   
		$q = $pdo->prepare($sql2);
		$q->execute(array($randomString));
		echo "eingetragen";
    }
	
	return $randomString;
	
	
}




$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$randomString = generateRandomNumer($pdo);

print "$randomString";

Database::disconnect();


?>