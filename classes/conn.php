<?php
	
 
	$conn = new PDO( 'mysql:host=localhost;dbname=dgvc', 'root', '');
	if(!$conn){
		die("Error: Failed to connect to database!");
	}

?>