<?php
	require_once('util.php');
	require_once('logindTjek.php');
	require_once('connect.php');
	top();
	// Kode der finder brugers navn
	$velgBruger = 'SELECT fornavn FROM brugere WHERE brugerID = "'.$_SESSION['LoggedIn'].'";';
	$resultat = mysql_query($velgBruger) or die(mysql_error());
	$row = mysql_fetch_array($resultat);
	echo  "<div class='justering'><h2>Hej ".$row['fornavn']."</h2><b>Velkommen til din profil, her kan du oprette spil til bytning</b></div><br />";
	
	//Oprettelse af nyt spil
	echo "<div class='mulighedsboks'>";
	echo "<h2>Opret et nyt spil til bytning!</h2><br />";
	$brugerID = $_SESSION['LoggedIn'];//hiver fat i brugerID
	
	// fejlbeskeder
	if (isset($_GET['error'])){
		switch($_GET['error']){
		
		case 1:
				echo "<span style='color:red;'>Du mangler at udfylde nogle af formene.</span><br /><br />";
				break;
		default: 
				echo "<span style='color:red;'>UKENDT FEJL</span><br />";
				break;
		}
	}
?>
<!-- Oprettelse af spil -->
<form action="opretSpil.php" method="post" >
<input type="hidden" name="brugerID" value="<?php echo $brugerID;?>"/>
	<b>Spillets navn:</b><br />
	<input maxlength="70" type="text" name="spilNavn" /><br /><br />
	
	<b>Spillets kategori</b><br />
	<select name="spilKategori">
		<option value="action">Action</option>
		<option value="adventure">Adventure</option>
		<option value="fps">FPS</option>
		<option value="racing">Racing</option>
	</select><br /><br />
	
	<span class="label"><b>Beskrivelse af spil:</b><br /></span>
	<textarea textarea style="resize: none;" cols="74" rows="5" name="spilBeskrivelse"></textarea><br /><br />
	
	<b>Spillets Priskategori</b><br />
	<select name="prisKategori">
		<option value="green">0 til 150 kr</option>
		<option value="yellow">150 til 300 kr</option>
		<option value="red">Over 300 kr</option>
	</select><br /><br />
	<input type="Submit" value="Opret spil" />
</form>

<?php
	echo "</div>";
	echo "<div class='egnespil'>";
	echo "<h2>De spil du har oprettet</h2>";
?>
<!-- Funktion det beder om godkendelse, før den sletter en besked... -->
<script type="text/javascript">
	<!--
	function confirmation(id) {
		var answer = confirm("Sikker på du vil slette dette spil?")
		if (answer){
			window.location.href = "sletSpil.php?spilID="+id;
		}
	}
	//-->
</script>	
<?php
	//slet af spil
	$resultat = mysql_query("SELECT spilID,spilnavn,spilbeskrivelse FROM spil WHERE brugerID='".$brugerID."' ORDER BY spilnavn")or die(mysql_error());
		while($row=mysql_fetch_array($resultat)){
		echo "<h3><span style='margin-left:5px;'>".$row["spilnavn"]."</span>";
		echo'<span style="float:right; margin-right:5px; cursor:pointer;" onclick="confirmation('.$row["spilID"].')">Slet</span></h3>';
		}
	
	echo "</div>";
	bund();
?>