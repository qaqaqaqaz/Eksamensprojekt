<?php
    // sletSpil.php
	require_once('util.php');
	require_once('logindTjek.php');
	require_once('connect.php');

	if(!isset($_GET['spilID'])){
		header('Location: index.php');
	}
	
	$spilID = mysql_real_escape_string($_GET['spilID']);
	//test om man må slettes spillet, sammenligner brugerID med brugerID i spil tabel
	$tjekBruger = "SELECT brugerID FROM spil WHERE spilID='".$spilID."';";
	$tjekBrugerQuery = mysql_query($tjekBruger) or die(mysql_error());
	$row = mysql_fetch_array($tjekBrugerQuery);
	if($row['brugerID'] !== $_SESSION['LoggedIn']){
		header('Location: index.php');
		exit();
	} else {
	//spil slettes og service besked samt tilbagelink gives.
	top();
	$sletSpil = "DELETE FROM spil WHERE spilID = ".$spilID.";";
	mysql_query($sletSpil) or die(mysql_error());
	echo "<div class='justering'><h2>Dit spil er slettet.<br /></h2></div>";
	echo "<div class='justering'><a href='profil.php'><h2>Tilbage</h2></a></div>";
	bund();
	}
?>