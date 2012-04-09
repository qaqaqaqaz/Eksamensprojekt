<?php
	$nyBruger= "";//hvorfor?					asdsadsa

	// Tjekker at ingen felter er tomme
	if(!$_POST['brugernavn'] || !$_POST['password1'] || !$_POST['password2'] || !$_POST['fornavn'] || !$_POST['efternavn'] || !$_POST['efternavn']/* øh?*/ || !$_POST['email']) {
		header('Location: register.php?error=1');
		exit;
	} else if($_POST['password1'] != $_POST['password2']) {
		header('Location: register.php?error=2');
		exit;
	}

	if($conn = mysql_connect('localhost','misite','kummefryser')) {
		mysql_select_db('bytOnline') or die(mysql_error());

		//Arrays of which chars that should be replaced with what
		$search = array('<', '>');
		$replace = array('&lt;', '&gt;');
		
		// Sanitize input
		$brugernavn = mysql_real_escape_string(str_replace($search, $replace, $_POST['brugernavn']));
		$password = md5(mysql_real_escape_string($_POST['password1']));
		$fornavn = mysql_real_escape_string(str_replace($search, $replace, $_POST['fornavn']));
		$efternavn = mysql_real_escape_string(str_replace($search, $replace, $_POST['efternavn']));
		$email = mysql_real_escape_string(str_replace($search, $replace, $_POST['email']));

		$tjekBrugernavn = "SELECT * FROM brugere WHERE bruger='".$brugernavn."';";
		$tjek = mysql_query($tjekBrugernavn) or die(mysql_error());
		if(mysql_num_rows($tjek) > 0) {
			header('Location: register.php?error=3');
			exit;
		}
		$nyBruger = "INSERT INTO users (user,password,firstname,lastname,email) VALUES ('".$username."','".$password."','".$firstname."','".$lastname."','".$email."');";
	}	

	require_once('util.php');
	top();
	
	if(mysql_query($nyBruger)) {// tjekker om query er kørt rigtigt
		echo "Bruger oprettet";
	}
	bund();
?>
