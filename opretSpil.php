<?php
	require_once('connect.php');
	require_once('logindTjek.php');
	require_once('util.php');
	$nytSpil = "";
	
	// Tjekker at ingen felter er tomme
	if(!$_POST['spilNavn'] || !$_POST['spilKategori'] || !$_POST['prisKategori'] || 
	!$_POST['spilBeskrivelse']) {
		header('Location: profil.php?error=1');
		exit;
	}
	//Array som erstartter alle symbolerne '<' og '>' med '&lt;' og '&gt;'
	$soeg = array('<', '>');
	$erstat = array('&lt;', '&gt;');
	
	// Beskyttelse med Sanitize input
	$spilNavn = mysql_real_escape_string(str_replace($soeg, $erstat, $_POST['spilNavn']));
	$spilKategori = mysql_real_escape_string($_POST['spilKategori']);
	$prisKategori = mysql_real_escape_string($_POST['prisKategori']);
	$spilBeskrivelse = mysql_real_escape_string(str_replace($soeg, $erstat,
	$_POST['spilBeskrivelse']));
	$brugerID = mysql_real_escape_string($_POST['brugerID']);
	
	$nytSpil = "INSERT INTO spil (spilnavn,spilbeskrivelse,spilkategori,priskategori,brugerID)
	VALUES ('".$spilNavn."','".$spilBeskrivelse."','".$spilKategori."','".$prisKategori."','".
	$brugerID."');";
	top();
	// værdier bliver indsat via $nytSpil og service besked gives, samt tilbagelink
	if(mysql_query($nytSpil) or die(mysql_error())){
		echo "<div class='justering'><h2>Dit spil er nu oprettet.<br />
		Du vil få besked hvis nogle ønsker at bytte med dig.</h2></div>";
		echo "<div class='justering'><a href='profil.php'>
		<h2>Tilbage</h2></a></div>";
	}
	bund();
?>