<?php
	/*
		Det her er headeren (skal kaldes i starten på alle sider! hvor menuen skal vises)
	*/
	function top($tittel = 'bytOnline') { // tittel kan ændres på sider når top kaldes
		echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.1//EN' 'http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd'>";
		echo "<html xmlns='http://www.w3.org/1999/xhtml'>";
		echo "<head>";//starter header
		echo "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />"; // charset
		echo "<title>".$tittel."</title>";//tittel
		echo "<link rel='stylesheet' type='text/css' href='stylesheet.css' />";//link til stylesheet
		echo "</head>";//slutter header
		
		echo "<body><div class='content'>";// starter body
		echo "<div style='margin: 5px;'><img src='billeder/logo4.jpg' alt='logo'></img></div>";//logo: alt = alternativ tekst hvis billede ikke virker
		menu();// kalder menuen
	}
	
	/*
		Det her afslutter body og html tag, (skal kaldes i slutningen af alle sider)
	*/
	function bund() {
		if(isset($conn)) mysql_close($conn);// hvis der er conetcted til databasen så lukkes den
		echo "</div>"; // afslutter division
		echo "</body>";// slutter body
		echo "</html>";// afslutter html
	}
	
	/*
		Det her styre menuen og hvordan den bliver vist, samme med stylesheet.
	*/
	function menu() {
		
		@session_start(); // starter session så data kan sendes mellem siderne @sørger for ikke at give fejlmeddelser
		
		// styre login visningen i menuen, hvis man er loget ind skifter visningen til logud istedet.
		$loginT = 'Log ind';
		$loginL = 'logind.php';

		if(isset($_SESSION['LoggedIn'])) { // session sættes i loginQuery
			$loginT = 'Log af';
			$loginL = 'logud.php';
		}
		// laver et associative array hvor sidenavn og link defineres
		$menuSider = array(	'Forside' => 'index.php', 
					'Spil-liste' => 'spilListe.php',
					'Profil' => 'profil.php',
					$loginT => $loginL.'?redirect='.$_SERVER['PHP_SELF']); // PHP_SELF sørger for at returnere den fil der lige er blevet kørt

		echo "<div class='menu'>";
		foreach ($menuSider as $navn => $side) { // sørger for at navn og links bliver vist og fungerer i menuen.
			echo "<a class='menulink' href='".$side."'>".$navn."</a>";
		}
		echo "</div>";
	}
?>
