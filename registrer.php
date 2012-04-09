<!--oprettelse af bruger-->
¨<?php
	require_once('util.php');
	top('Registrer');
	if(!empty($_GET['error'])) {
		if($_GET['error'] == 1){
			echo "<span style='color:red;'>Du mangler at udfylde nogle af formene.</span><br /><br />";
		} else if($_GET['error'] == 2) {
			echo "<span style='color:red;'>Adgangkoderne er ikke ens!</span><br /><br />";
		} else if ($_GET['error'] == 3) {
			echo "<span style='color:red;'>Brugernavn eksisterer allerede.</span><br /><br />";
		}
	}
?>
<div class='justering'>
<form method="post" action="registrerQuery.php">
	Brugernavn: <br />
	<input maxlength="15" type="text" name="brugernavn" /><br /><br />
	Adgangskode: <br />
	<input type="password" name="password1" /><br /><br />
	Gentag Adgangskode: <br />
	<input type="password" name="password2" /><br /><br />
	Fornavn: <br />
	<input maxlength="30" type="text" name="fornavn" /><br /><br />
	Efternavn: <br />
	<input maxlength="30" type="text" name="efternavn" /><br /><br />
	E-mail: <br />
	<input maxlength="30" type="text" name="email" /><br /><br />
	<input type="submit" value"Registrer" name="registrer" />
</form>
</div>
<?php
	bund();
?>
