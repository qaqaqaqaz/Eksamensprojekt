<?php
	require_once('connect.php');
	require_once('util.php');
	if(!isset($_GET['redirect'])){
		$_GET['redirect'] = '/eksamensprojekt/index.php';
	}
	// Tjekker at ingen felter er tomme
	if(!$_POST['spilNavn'] || !$_POST['spilKategori'] || !$_POST['prisKategori'] || !$_POST['spilBeskrivelse']) {
		header('Location: profil.php?error=1&redirect='.$_GET['redirect']);
		exit;
	}
	//Array som erstartter alle symbolerne '<' og '>' med '&lt;' og '&gt;'
	$search = array('<', '>');
	$replace = array('&lt;', '&gt;');
	
	// Beskyttelse med Sanitize input
	$spilNavn = mysql_real_escape_string(str_replace($search, $replace, $_POST['spilNavn']));
	$spilKategori = mysql_real_escape_string($_POST['spilKategori']);
	$prisKategori = mysql_real_escape_string($_POST['prisKategori']);
	$spilBeskrivelse = mysql_real_escape_string(str_replace($search, $replace, $_POST['spilBeskrivelse']));
	
	$nytSpil = "INSERT INTO spil (spilnavn,spilbeskrivelse,spilkategori,priskategori) VALUES ('".$spilNavn."','".$spilBeskrivelse."','".$spilKategori."','".$prisKategori."');";
	
	/*
	if(mysql_query($nytSpil)) {
		header('Location: profil.php?error=2&redirect='.$_GET['redirect']); // er egentlig ikke en error, men for at sige spillet er oprettet
	}
	*/
	
	
?>