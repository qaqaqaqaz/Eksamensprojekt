<?php
    function make_box($header,$text,$url) {
		/*
			Creates a pretty link-box with a header and some 
			content - you can put whatever you want in the 
			content, as long as it's no larger than 200x150 px.
		*/
		
		echo "<a class='box_link' href='".$url."'>";
		echo "<div class='box'>";
		echo "<h3><span>".$header."</span></h3>";
		echo "<p>".$text."</p>";
		echo "</div>";
        echo "</a>";
		return true;
	}
	function fora_menu($header,$text,$url) {
		/*
			description
		*/
		
		//echo'<span style="float:right; margin-right:5px; cursor:pointer;"</span>';
		//echo "<a class='line' href='".$url."'>";
		echo "<a href='".$url."'>";
		echo "<div class='forabox'>";
		echo "<h3><span>".$header."</span></h3>";
		echo "<p>".$text."</p>";
		echo "</br>";
		echo "</div>";
        echo "</a>";
		return true;
	}
	
		
	function top($title = 'bytOnline', $cssdir = '') { //cssdir kan kaldes i f. eks en undermappe hvis nødvendigt
		/*
			Det her er headeren (skal kaldes i starten på alle sider)
		*/
		$dir = $cssdir.'stylesheet.css';
		echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.1//EN' 'http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd'>";
		echo "<html xmlns='http://www.w3.org/1999/xhtml'>";
		
		echo "<head>";//starter header
		echo "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />"; // sætter charset
		echo "<title>".$title."</title>";//sætter tittel
		echo "<link rel='stylesheet' type='text/css' href='".$dir."' /><link rel='stylesheet' type='text/css' href='".$cssdir."style.css' /><link href='".$cssdir."google-code-prettify/src/prettify.css' type='text/css' rel='stylesheet' />";//links til stylesheets
		echo "</head>";//slutter header
		
		echo "<body><div class='content'>";// starter body
							// Klar til logo echo "<div style='margin: 5px;'><img src='images/logo.jpg' /></div>";
		menu($cssdir);

	}
	
	function menu($cssdir = '') {
		
		@session_start();
		$loginT = 'Login';
		$loginL = 'login.php';
		$redirect = selfURL();

		if(isset($_SESSION['LoggedIn'])) {
			$loginT = 'Log out';
			$loginL = 'logout.php?redirect='.$redirect;
		}
		//slå associative array op
		$mainPages = array(	'Forside' => 'index.php', 
					'Forum' => 'forum.php',
					'Artikler' => 'articles.php',
					$loginT => $loginL);

		echo "<div class='menu'>";

		foreach ($mainPages as $name => $page) {
			echo "<a class='menulink' href='".$cssdir.$page."'>".$name."</a>";
		}

		echo "</div>";
	}
	
		
	function bottom() {
		/*
			Afslutter body og html tag, (skal kaldes i slutningen af alle sider)
		*/
		if(isset($conn)) mysql_close($conn);// hvis der er conetcted til databasen så lukkes den

		echo "</div>";
		echo "</body>";
		echo "</html>";
	}
	
	function text_editor ($prevTextForEditor="") { // Parameter is optional - will be shown in the textarea.
		include('text_editor.php');
	}

	function selfURL() {
		$s = empty($_SERVER["HTTPS"]) ? ''
			: ($_SERVER["HTTPS"] == "on") ? "s"
			: "";
		$protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
		$port = ($_SERVER["SERVER_PORT"] == "80") ? ""
			: (":".$_SERVER["SERVER_PORT"]);
		return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
	}
	function strleft($s1, $s2) {
		return substr($s1, 0, strpos($s1, $s2));
	}
?>
