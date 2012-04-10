<?php
	require_once('connect.php');
	require_once('util.php');
	session_start();// sørger for at en session er sat på alle sider
	if(!isset($_GET['redirect'])){
		$_GET['redirect'] = '/eksamensprojekt/index.php';
	}
	if(isset($_SESSION['LoggedIn'])){
		header('Location: index.php?redirect='.$_GET['redirect']);
		exit;
	}
	// tjekker om brugernavn og password er sat og hvis ikke, sender den en fejlmeddelse
	if(!$_POST['brugernavn'] || !$_POST['password']) {
		header('Location: logind.php?error=1&redirect='.$_GET['redirect']);
		unset($_SESSION['LoggedIn']);// afslutter LoggedIn session ved fejl log-ind(se util menu)
		exit;
	}
	
	//Array som erstartter alle symbolerne '<' og '>' med '&lt;' og '&gt;'
	$search = array('<', '>');
	$replace = array('&lt;', '&gt;');
	
	// undersøg andre hash kryteringsformer !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	$checkLogin = "SELECT * FROM brugere WHERE brugernavn='".mysql_real_escape_string(str_replace($search, $replace, $_POST['brugernavn']))."' AND password='".md5(mysql_real_escape_string($_POST['password']))."';";
	$result = mysql_query($checkLogin) or die(mysql_error());
	if(mysql_num_rows($result) < 1) { // tjeker om brugernavn og password er rigtig
		header('Location: logind.php?error=2&redirect='.$_GET['redirect']);
		unset($_SESSION['LoggedIn']);
		exit;
	}
	$row = mysql_fetch_array($result); //Henter valgte data fra databasen
	$_SESSION['LoggedIn'] = $row['brugerID'];
	
	top();

	header('Location: '.$_GET['redirect']);
	exit;
	
	bund();
?>