<?php
/**************************************************************
*	S.D.I.S A4L
*	logout.php
*	
*	Deconnexion de l'utilisateur et redirection sur page login
*************************************************************/


	// Initialisation de la session.
	session_start();
	
	// Détruit toutes les variables de session
	$_SESSION = array();

	session_destroy();
	header("location: page-login.php");
?>
