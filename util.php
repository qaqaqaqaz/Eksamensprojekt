<?php
	/*
		Det her er headeren (skal kaldes i starten p� alle sider! hvor menuen skal vises)
	*/
	function top($tittel = 'bytOnline') { // tittel kan �ndres p� sider n�r top kaldes
		echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.1//EN' 'http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd'>";
		echo "<html xmlns='http://www.w3.org/1999/xhtml'>";
		echo "<head>";//starter header
		echo "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />"; // s�tter charset
		echo "<title>".$tittel."</title>";//s�tter tittel
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
		if(isset($conn)) mysql_close($conn);// hvis der er conetcted til databasen s� lukkes den
		echo "</div>"; // afslutter division
		echo "</body>";// slutter body
		echo "</html>";
	}
	
	/*
		Det her styre menuen og hvordan den bliver vist, samme med stylesheet.
	*/
	function menu() {
		
		@session_start(); // starter session s� data kan sendes mellem siderne @ s�rger for ikke at give
		
		// styre login visningen i menuen, hvis man er loget ind skifter visningen til logud istedet.
		$loginT = 'Log ind';
		$loginL = 'logind.php';

		if(isset($_SESSION['LoggedIn'])) { // session s�ttes i loginQuery
			$loginT = 'Log af';
			$loginL = 'logud.php';
		}
		
		$mainPages = array(	'Forside' => 'index.php', 
					'Spil-liste' => 'spilListe.php',
					'Profil' => 'profil.php',
					$loginT => $loginL.'?redirect='.$_SERVER['PHP_SELF']); // PHP_SELF s�rger for at returnere den fil der lige er blevet k�rt

		echo "<div class='menu'>";
		foreach ($mainPages as $name => $page) { // s�rger for at navn og links bliver vist og fungerer i menuen.
			echo "<a class='menulink' href='".$page."'>".$name."</a>";
		}
		echo "</div>";
	}
?>
