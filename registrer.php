<!--oprettelse af bruger-->
¨<?php
	require_once('util.php');
	top('Registrer');
	echo "<div class='justering'>";
	if(!isset($_GET['redirect'])){
		$_GET['redirect'] = '/eksamensprojekt/index.php';
	}
	// sørger for at man ikke kan se registrer siden når man er logget ind
	if(isset($_SESSION['LoggedIn'])){
		header('Location: index.php?redirect='.$_GET['redirect']);
		exit;
	}
	
	if (isset($_GET['error'])){
		switch($_GET['error']){
		
		case 1:
				echo "<span style='color:red;'>Du mangler at udfylde nogle af formene.</span><br /><br />";
				break;
				
		case 2:
				echo "<span style='color:red;'>Adgangkoderne er ikke ens!</span><br /><br />";
				break;
				
		case 3:
				echo "<span style='color:red;'>Brugernavn eksisterer allerede.</span><br /><br />";
				break;
		
		default: 
				echo "<span style='color:red;'>UKENDT FEJL</span><br />";
				break;
		}
	}
?>

<form action="registrerQuery.php?redirect=<?php echo $_GET['redirect']?>" method="post">
	Brugernavn: <br />
	<input maxlength="16" type="text" name="brugernavn" /><br /><br />
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
