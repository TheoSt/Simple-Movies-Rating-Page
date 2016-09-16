<?php
//Εδω συνδεόμαστε με την βάση
	define('DB_USER','root');
	define('DB_PASSWORD','');
	define('DB_HOST','localhost');
	define('DB_NAME','movies_rating_database');
	
	$dbc = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) 
			or die('Could not connect to database: '.mysqli_error());
			
?>