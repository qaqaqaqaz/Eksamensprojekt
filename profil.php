<?php
	require_once('util.php');
	require_once('logindTjek.php');
	require_once('connect.php');
	if(!isset($_GET['redirect'])){
		$_GET['redirect'] = '/eksamensprojekt/index.php';
	}
	top();
	// Kode der finder brugers navn
	$velgBruger = 'SELECT fornavn FROM brugere WHERE brugerID = "'.@$_SESSION['LoggedIn'].'";';
	$resultat = mysql_query($velgBruger) or die(mysql_error());
	$row = mysql_fetch_array($resultat);
	echo  "<div class='justering'>Hej ".$row['fornavn']."<br />Der er @ntal der gerne vil bytte med dig</div>";
	
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
<form action="opretSpil.php?redirect=<?php echo $_GET['redirect']?>" method="post" >
<input type="hidden" name="brugerID" value="<?php echo $brugerID;?>"/>
	<b>Spillets navn:</b><br />
	<input maxlength="30" type="text" name="spilNavn" /><br /><br />
	
	<b>Spillets kategori </b><br />
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
	echo"</div>";
	bund();
?>