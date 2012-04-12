<?php
	require_once('util.php');
	require_once('connect.php');
	
	$spilKategori = mysql_real_escape_string($_POST['spilKategori']);
	$prisKategori = mysql_real_escape_string($_POST['prisKategori']);
	echo ($spilKategori);
	
	
?>