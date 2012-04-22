<?php
	//Dette søreger for at man ikke kan gå in på sider man skal være logget ind for at se
	session_start();
	if(!isset($_SESSION['LoggedIn'])){
		header('Location: logind.php?error=3&redirect='.$_SERVER['PHP_SELF']);// PHP_SELF sørger for at returnere den fil der lige er blevet kørt
	}
?>
