<?php
session_start();

if (isset($_POST['login']) AND isset($_POST['passwd'])) {
	$username = $_POST['login'];
	$password = $_POST['passwd'];

	$_SESSION['username'] = $username;
	$_SESSION['password'] = $password;
		
	//On redirige a la fin vers la page affect
	header("location: index.php");		
}
?>


<!doctype html>
<html class="no-js" lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>IMT Notes - Connexion</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/selectFX/css/cs-skin-elastic.css">

    <link rel="stylesheet" href="assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>



</head>

<body class="bg-dark">


    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <img class="align-content" src="images/logo.png" alt="">
                </div>
                <div class="login-form">
                    <form method="post" action="page-login.php">
                        <div class="form-group">
                            <label>Login IMT</label>
                            <input name="login" type="text" class="form-control" placeholder="Veuillez entrer votre login IMT (ex. bonhomme)">
                        </div>
                        <div class="form-group">
                            <label>Mot de Passe IMT</label>
                            <input name="passwd" type="password" class="form-control" placeholder="Veuillez entrer votre mot de passe">
                        </div>
						<button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Se connecter</button>
                    </form>
                </div>
				<br>
				<br>

                <p class="text-center">Aucune conservation des données n'est faite.</p>

            </div>
        </div>
    </div>


	<!--<script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>-->


</body>
</html>

