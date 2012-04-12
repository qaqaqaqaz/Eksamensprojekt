<?php 
	require_once('util.php');
	require_once('connect.php');
	if(!isset($_GET['redirect'])){
		$_GET['redirect'] = '/eksamensprojekt/index.php';
	}
	top();
	echo "<div class='mulighedsboks'>";
	echo "<b>Valgmuligheder:</b>";

?>
<!-- søgeliste efter kategori-->
<form action="spilListe.php?redirect=<?php echo $_GET['redirect']?>" method="post" >
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
</form>
<?php
	
	if (isset($_POST['spilKategori']) && $_POST['prisKategori']) {
		$spilKategori = mysql_real_escape_string($_POST['spilKategori']);
		$prisKategori = mysql_real_escape_string($_POST['prisKategori']);
		
		
		$resultat = mysql_query("SELECT spilnavn FROM spil WHERE spilkategori='".$spilKategori."' AND priskategori='".$prisKategori."' ORDER BY spilnavn")or die(mysql_error());
			while($row=mysql_fetch_array($resultat)){
			echo "<h3>".$row["spilnavn"]."</h3><br />";
			}
	}
	/*
	$resultat = mysql_query("SELECT ,categoryID FROM categories ORDER BY categoryID DESC;") or die(mysql_error());
		while($row=mysql_fetch_array($resultat)){
			echo '<h3><a href="redcat.php?catID='.$row["categoryID"].'">';
			echo $row["categoryName"];
			echo '</a>';
			echo'<span style="float:right; margin-right:5px; cursor:pointer;" onclick="confirmation('.$row["categoryID"].')">Slet</span></h3>';//slet kategori
			echo'<br/>';
			}*/
	echo "</div>";
	bund();
?>
