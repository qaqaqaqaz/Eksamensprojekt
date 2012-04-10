<?php
	/*
		Det her er headeren (skal kaldes i starten på alle sider! hvor menuen skal vises)
	*/
	function top($tittel = 'bytOnline', $cssdir = '') { //cssdir kan kaldes i f. eks en undermappe hvis nødvendigt
		$dir = $cssdir.'stylesheet.css';
		echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.1//EN' 'http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd'>";
		echo "<html xmlns='http://www.w3.org/1999/xhtml'>";
		
		echo "<head>";//starter header
		echo "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />"; // sætter charset
		echo "<title>".$tittel."</title>";//sætter tittel
		echo "<link rel='stylesheet' type='text/css' href='".$dir."' />";//link til stylesheet
		echo "</head>";//slutter header
		
		echo "<body><div class='content'>";// starter body
		echo "<div style='margin: 5px;'><img src='billeder/logo4.jpg' /></div>";//logo
		menu($cssdir);
	}
	
	/*
		Afslutter body og html tag, (skal kaldes i slutningen af alle sider)
	*/
	function bund() {
		
		if(isset($conn)) mysql_close($conn);// hvis der er conetcted til databasen så lukkes den
		echo "</div>";
		echo "</body>";
		echo "</html>";
	}
	
	function menu($cssdir = '') {
		
		@session_start();
		$loginT = 'Log ind';
		$loginL = 'logind.php';

		if(isset($_SESSION['LoggedIn'])) { // session sættes i loginQuery
			$loginT = 'Log af';
			$loginL = 'logud.php';
		}
		
		$mainPages = array(	'Forside' => 'index.php', 
					'Spil-liste' => 'spilListe.php',
					'Profil' => 'profil.php',
					$loginT => $loginL.'?redirect='.$_SERVER['PHP_SELF']);//											???????

		echo "<div class='menu'>";

		foreach ($mainPages as $name => $page) {
			echo "<a class='menulink' href='".$cssdir.$page."'>".$name."</a>";
		}
		echo "</div>";
	}
?>
