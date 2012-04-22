<?php
	// denne fil skaber forbindelse til databasen med den bruger der blev oprettet i config.php
	$dbhost = 'localhost';
	$dbuser = 'eksamensprojekt';
	$dbpass = 'kummefryser';

	$conn = mysql_connect($dbhost,$dbuser,$dbpass) or die(mysql_error()); // her conecter den mysql

	if(!isset($conn)) {
		die("kan ikke skabe forbindelse til databasen");
	} else {
		mysql_select_db('bytOnline') or die (mysql_error()); // her vælger den databasen
	}
?>
