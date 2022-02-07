<?php
	session_start();

	if(!isset($_SESSION['dentro'])){
		header('Location: errorLogin.html');
	}

?>