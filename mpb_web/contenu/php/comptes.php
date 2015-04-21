<?php
    session_start();
	
    if(empty($_SESSION['id'])) {
        header('Location:index.php');
    }
	
    else {
		$erreur = True;
		include 'includes/bdd.php';
		$sql = 'SELECT bnq_id FROM banques WHERE bnq_utlId ='.$_SESSION['id'].'';
		$req = mysqli_query($bdd,$sql);
		while($rlt = mysqli_fetch_assoc($req)) {
			if($rlt['bnq_id'] == $_GET['id']) {
				$erreur = False;
			}
		}
		if($erreur == True) {
			header('Location:deconnexion.php');
		}
	}
	
	include 'includes/bdd.php';
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
						<div id="div_formCpt_montant">
							<label>Montant</label>
								<input id="formCpt_montant" name="montant" type="text" maxlength="10"/>
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
                    if(empty($_POST['intitule']) || empty($_POST['type']) || empty($_POST['montant']) || empty($_POST['numero'])) {
                        echo '<p>Vous devez remplir tous les champs !</p>';
                    }
                    else {
                        $sql = 'INSERT INTO comptes VALUES("","'.$_GET["id"].'","'.$_POST["intitule"].'","'.$_POST["type"].'","'.$_POST["montant"].'","'.$_POST["numero"].'")';
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
					if ($rlt["cpt_montant"]>0) {
						echo '<a title="'.$rlt['cpt_intitule'].'" href="interface.php?id='.$rlt['cpt_id'].'" class="bloc_compte"><img src="../img/monnaie.png" alt=""/><p>'.$rlt['cpt_intitule'].'</p><p class="montantpos">'.$rlt['cpt_montant'].' €</p></a>';
					}
					else {
						echo '<a title="'.$rlt['cpt_intitule'].'" href="interface.php?id='.$rlt['cpt_id'].'" class="bloc_compte"><img src="../img/monnaie.png" alt=""/><p>'.$rlt['cpt_intitule'].'</p><p class="montantneg">'.$rlt['cpt_montant'].' €</p></a>';
					}
				}
				echo '</div>';
				
            ?>
			</div>
			</div>
        </section>
		<div id="bt_suppBnq">
			<h2>Supprimer la banque</h2>
				<form id="formBnq" method="post" action="#">
					<div id="div_suppBnq_sup">
						<input type="submit" id="formBnq_supp" name="supp_banque" value="Supprimer la banque"/>
					</div>
				</form>
			 <?php
                if(isset($_POST['supp_banque'])) {
                    {
                        $sql = 'DELETE FROM comptes WHERE cpt_bnqId =' .$_GET["id"].'';
						$sql2 = 'DELETE FROM banques WHERE bnq_id = '.$_GET["id"].'';
                        $req = mysqli_query($bdd,$sql);
						$req2 = mysqli_query($bdd,$sql2);
                        header('Location:banques.php');
                    }
                }
			?>
		</div>
        <?php include 'includes/footer.php'; ?>
    </body>
</html>