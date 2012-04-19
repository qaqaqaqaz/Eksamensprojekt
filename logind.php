<!-- denne fil styrre login hvis man er bruger, ellers kan man gå til oprettelse af bruger-->
<?php
	require_once('util.php');
	top('Log ind');
	if(!isset($_GET['redirect'])){
		$_GET['redirect'] = '/eksamensprojekt/index.php';
	}
	// sørger for man ikke kan se login side når man er logget ind.
	if(isset($_SESSION['LoggedIn'])){
		header('Location: index.php?redirect='.$_GET['redirect']);
		exit;
	}
	echo "<div class='justering'>";
	//tjekker om loginQuery har opdaget nogle fejl og giver en tilsvarende fejlmeddelelse
	if(isset($_GET['error'])){
		switch($_GET['error']){
		
			case 1:
				echo "<span style='color:red;'>Du mangler at skrive brugernavn og/eller adgangskode.</span><br /><br />";
				break;
			
			case 2:
				echo "<span style='color:red;'>Dit brugernavn eller adgangskode er forkert.</span><br /><br />";
				break;
			
			case 3:
				echo "<span style='color:red;'>Hov, du skal logge ind for at udfører denne handling.</span><br /><br />";
				break;
				
			default:
				echo "<span style='color:red;'>UKENDT FEJL.</span><br /><br />";
				break;
		}
	}

?>

<!-- Loging form -->

<form action="loginQuery.php?redirect=<?php echo $_GET['redirect']?>" method="post" >
	Brugernavn:<br />
	<input type="text" name="brugernavn" />
	<br />

	Adgangskode:<br />
	<input type="password" name="password" />
	<br />
	
	<input type="Submit" value="Log ind" />

</form>

Har du ikke en bruger? <a href="registrer.php?redirect<?php echo $_GET['redirect']?>">Registrer dig her!</a>
</div>

<?php
	bund();
?>
