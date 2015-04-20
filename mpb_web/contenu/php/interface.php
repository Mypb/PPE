<?php
    session_start();
    if(empty($_SESSION['id'])) {
        header('Location:/mpb/index.php');
    }
    else {
		$bdd = mysqli_connect('localhost','root','','mpb');
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Accueil - MyPersonalBank</title>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <link href="../css/normalize.css" rel="stylesheet">
        <link href="../css/commun.css" rel="stylesheet">
        <link href="../css/comptes.css" rel="stylesheet">
    </head>
    <body>
        <?php include 'includes/header.php'; ?>
        <section>
			
        </section>
        <?php include 'includes/footer.php'; ?>
    </body>
</html>