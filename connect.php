<?php
	
	$dbhost = 'localhost';
	$dbuser = 'eksamensprojekt';
	$dbpass = 'kummefryser';

	$conn = mysql_connect($dbhost,$dbuser,$dbpass) or die(mysql_error()); // her conecter den mysql

	if(!isset($conn)) {
		die("Couldn't connect to database.");
	} else {
		mysql_select_db('miForum') or die (mysql_error()); // her vælger den databasen
	}
?>
