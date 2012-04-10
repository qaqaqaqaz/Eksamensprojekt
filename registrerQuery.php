<?php
	require_once('connect.php');
	$nyBruger = "";
	if(!isset($_GET['redirect'])){
		$_GET['redirect'] = '/eksamensprojekt/index.php';
	}
		
	// Tjekker at ingen felter er tomme og at pasword 1 og 2 matcher hindanden.
	if(!$_POST['brugernavn'] || !$_POST['password1'] || !$_POST['password2'] || !$_POST['fornavn'] || !$_POST['efternavn'] || !$_POST['email']) {
		header('Location: registrer.php?error=1&redirect='.$_GET['redirect']);
		exit;
	} else if($_POST['password1'] != $_POST['password2']) {
		header('Location: registrer.php?error=2&redirect='.$_GET['redirect']);
		exit;
	}
	
	//Array som erstartter alle symbolerne '<' og '>' med '&lt;' og '&gt;'
	$search = array('<', '>');
	$replace = array('&lt;', '&gt;');
	
	// Beskyttelse med Sanitize input
	$brugernavn = mysql_real_escape_string(str_replace($search, $replace, $_POST['brugernavn']));
	$password = md5(mysql_real_escape_string($_POST['password1']));
	$fornavn = mysql_real_escape_string(str_replace($search, $replace, $_POST['fornavn']));
	$efternavn = mysql_real_escape_string(str_replace($search, $replace, $_POST['efternavn']));
	$email = mysql_real_escape_string(str_replace($search, $replace, $_POST['email']));
	
	$nyBruger = "INSERT INTO brugere (brugernavn,password,fornavn,efternavn,email) VALUES ('".$brugernavn."','".$password."','".$fornavn."','".$efternavn."','".$email."');";
	
	//tjekker at brugernavnet ikke allerede eksistere
	$tjekBrugernavn = "SELECT * FROM brugere WHERE brugernavn='".$brugernavn."';";
	$tjek = mysql_query($tjekBrugernavn) or die(mysql_error());
	if(mysql_num_rows($tjek) > 0) {
		header('Location: registrer.php?error=3&redirect='.$_GET['redirect']);
		exit;
	}
	
	//opretter bruger
	require_once('util.php');
	top();
	if(mysql_query($nyBruger)) {
	
		echo "<div class='justering'>Brugeren er oprettet.</div>";
	}
	bund();
?>
