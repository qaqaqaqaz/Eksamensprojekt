<?php
	session_start();
	if(!isset($_GET['redirect'])){
		$_GET['redirect'] = '/eksamensprojekt/index.php';
	}
	$_SESSION = array();
	session_destroy();
	header('Location: '.$_GET['redirect']);
?>
