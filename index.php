<?php
	require_once('util.php');
	require_once('connect.php');
	top();
	// forside billede og velkomst tekst.
	echo "<div style='margin:0; margin-left: 5px;'><img src='billeder/drake.jpg' alt='Drake'></img></div>";//forsidebillede: alt = alternativ tekst hvis billede ikke virker
	echo "<div class='justering'>";
	echo "<h2>Velkommen til bytOnline!</h2>";
	echo "<h3>Stedet hvor du kan skaffe nye spil, for dine gamle!</h2><br/>";
	
	// Visning af de 3 nyeste spil starter her
	echo "<h2>Her er en liste over de nyeste spil</h2>";
	echo "</div>";
	
	// Finder de nyste spil ved at sortere fra ide
	$hentSpil = "SELECT * FROM spil ORDER BY spilID DESC";
	$spil = mysql_query($hentSpil) or die(mysql_error());
	
	// Ligger de 3 nyeste spil der er oprettet i et array
	$spilArray = array();
	$spilArray[0] = mysql_fetch_array($spil);
	$spilArray[1] = mysql_fetch_array($spil);
	$spilArray[2] = mysql_fetch_array($spil);
	
	// simpel while-løkke der tæller i op til 2, så jeg kan vise de første 3 spil
	$i = 0;
	while ($i <= 2) {
	echo "<div class='spilboks'><h3><span>".$spilArray[$i]['spilnavn']."</span></h3>";
	echo "<p>".$spilArray[$i]['spilbeskrivelse']."</p></div>";
	$i++;
	}
	bund();
?>