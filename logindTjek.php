<?php
	//Dette s�reger for at man ikke kan g� in p� sider man skal v�re logget ind for at se
	session_start();
	if(!isset($_SESSION['LoggedIn'])){
		header('Location: logind.php?error=3&redirect='.$_SERVER['PHP_SELF']);// PHP_SELF s�rger for at returnere den fil der lige er blevet k�rt
	}
?>
