<?php // logud.php
	session_start();
	//tjekker om redirect er sat, ellers s�ttes den
	if(!isset($_GET['redirect'])){
		$_GET['redirect'] = '/eksamensprojekt/index.php';
	}
	$_SESSION = array();
	session_destroy(); // destruer session og sender en til den side man var inde p� da man trykkede log ud.
	header('Location: '.$_GET['redirect']);
?>
