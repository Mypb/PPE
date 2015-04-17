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
		<div id="navigation">
				<a href="banques.php">Banques</a> ► <a href="comptes.php?id=<?php echo $_GET['id']; ?>">Comptes</a>
			</div>
        <section>
			<div id="bt_formCpt">
				<h2>Créer un compte</h2>
					<form id="formCpt" method="post" action="#">
						<div id="div_formCpt_intitule">
							<label>Intitulé</label>
								<input id="formCpt_intitule" name="intitule" type="text"/>
						</div>
						<div id="div_formCpt_type">
							<label>Type</label>
								<input id="formCpt_type" name="type" type="text"/>
						</div>
						<div id="div_formCpt_numero">
							<label>Numéro</label>
								<input id="formCpt_numero" name="numero" type="text" maxlength="11"/>
						</div>
						<div id="div_formCpt_cre">
							<input type="submit" id="formCpt_cre" name="creer_compte" value="Créer un compte"/>
						</div>
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
			?>
			</div>
			<div id="bt_comptes">
			<?php
                $sql = 'SELECT * FROM comptes WHERE cpt_bnqId ='.$_GET["id"].'';
                $req = mysqli_query($bdd,$sql);
                while($rlt = mysqli_fetch_assoc($req)) {
					echo '<a href="interface.php?id='.$rlt['cpt_id'].'">'.$rlt['cpt_intitule'].'</a><br/>';
                }
            ?>
			</div>
			</div>
        </section>
        <?php include 'includes/footer.php'; ?>
    </body>
</html>