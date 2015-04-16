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
            <form id="formCpt" method="post" action="#">
                <div id="div_formCpt"><label>Intitulé :</label><input name="intitule" type="text"/><label>Type :</label><input name="type" type="text"/><label>Numéro :</label><input name="numero" type="text"/><input type="submit" name="creer_compte" value="Créer un compte"/></div>
            </form>
            <?php
			$bdd = mysqli_connect('localhost','root','','mpb');
                if(isset($_POST['creer_compte'])) {
                    if(empty($_POST['intitule']) || empty($_POST['type']) || empty($_POST['numero'])) {
                        echo '<p>Vous devez remplir tout les champs !</p>';
                    }
                    else {
                        $sql = 'INSERT INTO comptes VALUES("","'.$_SESSION['id'].'","'.$_GET["id"].'","'.$_POST["intitule"].'","'.$_POST["type"].'","'.$_POST["numero"].'","0")';
                        $req = mysqli_query($bdd,$sql);
                        header('Location:#');
                    }
                }
                $sql = 'SELECT * FROM comptes WHERE cpt_bnqId ='.$_GET["id"].'';
                $req = mysqli_query($bdd,$sql);
                while($rlt = mysqli_fetch_assoc($req)) {
				echo '<a href="interface.php?id='.$rlt['cpt_id'].'">'.$rlt['cpt_intitule'].'</a><br/>';
                }
            ?>
        </section>
        <?php include 'includes/footer.php'; ?>
    </body>
</html>