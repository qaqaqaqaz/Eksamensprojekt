<?php
	require_once('connect.php');
	require_once('util.php');
	$nytSpil = "";
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
	$brugerID = mysql_real_escape_string($_POST['brugerID']);
	
	$nytSpil = "INSERT INTO spil (spilnavn,spilbeskrivelse,spilkategori,priskategori,brugerID) VALUES ('".$spilNavn."','".$spilBeskrivelse."','".$spilKategori."','".$prisKategori."','".$brugerID."');";
	top();
	if(mysql_query($nytSpil) or die(mysql_error())){
		echo "<div class='justering'><h2>Dit spil er nu oprettet.<br />Du vil få besked hvis nogle ønsker at bytte med dig.</h2></div>";
		echo "<div class='justering'><a href='profil.php?redirect=".$_GET['redirect']."'><h2>Tilbage</h2></a></div>";
		//echo "<a href='redcat.php?catID=".$id."'>tilbage</a>";
	//header('Location: profil.php?error=2&redirect='.$_GET['redirect']); 
	}
	bund();
	

	/*$sql="INSERT INTO fora (name, description, categoryID)
				VALUES ('".$overskrift."','".$description."','".$id."');";
				echo($sql);
				mysql_query($sql);
				echo "<a href='redcat.php?catID=".$id."'>tilbage</a>";*/
				
?>