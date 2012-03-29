<?php
	require_once('connect.php'); 
	require_once('util.php');
	session_start();
	
	// tjekker om brugernavn og password er sat og hvis ikke, sender den en fejlmeddelse
	if(!$_POST['brugernavn'] || !$_POST['password']) { //skal der ikke real escapes her?                                  sadfasddsaasdf
		header('Location: login.php?error=1');
		unset($_SESSION['LoggedIn']);// afslutter LoggedIn session ved fejl log-ind(se util menu)
		exit;
	}
	
	//Arrays of which chars that should be replaced with what ???????????????????????????????????????????????????????????????????????
	$search = array('<', '>');
	$replace = array('&lt;', '&gt;');
	
	$checkLogin = "SELECT * FROM brugere WHERE brugernavn='".mysql_real_escape_string(str_replace($search, $replace, $_POST['brugernavn']))."' AND password='".md5(mysql_real_escape_string($_POST['password']))."';";
	$result = mysql_query($checkLogin) or die(mysql_error());
	if(mysql_num_rows($result) < 1) { //??????????????????+
		header('Location: login.php?error=2');
		unset($_SESSION['LoggedIn']);
		exit;
	}
	$row = mysql_fetch_array($result); //Henter valgte data fra databasen
	$_SESSION['LoggedIn'] = $row['userID'];
	
	top();
	
	header('Location: index.php');
	exit;
	
	bund();
?>