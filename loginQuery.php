<?php
	// sætter redirect hvis ikke den er sat.
	if(!isset($_GET['redirect'])){
		$_GET['redirect'] = '/eksamensprojekt/index.php';
	}
	require_once('util.php');
	session_start();// starter session
	//hvis man er logget ind, bliver man sendt til index.
	
	if(isset($_SESSION['LoggedIn'])){
		header('Location: index.php');
		exit;
	}
	require_once('connect.php');
	

	
	
	// tjekker om brugernavn og password er sat og hvis ikke, sender den en fejlmeddelse
	if(!$_POST['brugernavn'] || !$_POST['password']) {
		header('Location: logind.php?error=1&redirect='.$_GET['redirect']);
		unset($_SESSION['LoggedIn']);// afslutter LoggedIn session ved fejl log-ind(se util menu)
		exit;
	}
	
	//Array som erstartter alle symbolerne '<' og '>' med '&lt;' og '&gt;'
	$soeg = array('<', '>');
	$erstat = array('&lt;', '&gt;');
	// undersøg andre hash kryteringsformer !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	$tjekLogind = "SELECT * FROM brugere WHERE brugernavn=
	'".mysql_real_escape_string(str_replace(
	$soeg, $erstat, $_POST['brugernavn']))."' AND password=
	'".md5(mysql_real_escape_string($_POST['password']))."';";
	$resultat = mysql_query($tjekLogind) or die(mysql_error());
	
	// tjeker om brugernavn og password er rigtig
	if(mysql_num_rows($resultat) < 1) { 
		header('Location: logind.php?error=2&redirect='.$_GET['redirect']);
		unset($_SESSION['LoggedIn']);
		exit;
	}
	$row = mysql_fetch_array($resultat); //Henter brugerID databasen
	$_SESSION['LoggedIn'] = $row['brugerID']; // brugerID bliver gemt i session loggedin
	
	top();

	header('Location: '.$_GET['redirect']);
	exit;
	
	bund();
?>