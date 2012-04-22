<?php 
	require_once('util.php');
	require_once('connect.php');
	top();
	echo "<div class='mulighedsboks'>";
	echo "<b>Valgmuligheder:</b>";
?>
<!-- søgeliste efter kategori-->
<form action="spilListe.php" method="get" >
Søg efter kategori og pris:
<select name="spilKategori">
	<option value="action">Action</option>
	<option value="adventure">Adventure</option>
	<option value="fps">FPS</option>
	<option value="racing">Racing</option>
</select>
<select name="prisKategori">
	<option value="green">0 til 150 kr</option>
	<option value="yellow">150 til 300 kr</option>
	<option value="red">Over 300 kr</option>
	</select>
<input type="submit" value="Søg" />
<input type="button" value="Vis alle spil" onclick="location.href='spilListe.php'">
</form>

<?php
	echo "</div>";
	// hvis variabler er sat via knappen søg, så sorteres der i spil listen
	if (isset($_GET['spilKategori']) && $_GET['prisKategori']) {
		$spilKategori = mysql_real_escape_string($_GET['spilKategori']);
		$prisKategori = mysql_real_escape_string($_GET['prisKategori']);
		
		$resultat = mysql_query("SELECT spilnavn,spilbeskrivelse FROM spil WHERE 
		spilkategori='".$spilKategori."' AND priskategori='".$prisKategori."' 
		ORDER BY spilnavn")or die(mysql_error());
		while($row=mysql_fetch_array($resultat)){
		echo "<div class='spilboks'><h3><span>".$row["spilnavn"]."</span></h3>";
		echo "<p>".$row["spilbeskrivelse"]."</p></div>";
		}
	} else { // hvis ingen variabler er sat så vises alle spil
		$resultat = mysql_query("SELECT spilnavn,spilbeskrivelse FROM spil ORDER
		BY spilnavn")or die(mysql_error());
		while($row=mysql_fetch_array($resultat)){
		echo "<div class='spilboks'><h3><span>".$row["spilnavn"]."</span></h3>";
		echo "<p>".$row["spilbeskrivelse"]."</p></div>";
		}
	}
	bund();
?>
