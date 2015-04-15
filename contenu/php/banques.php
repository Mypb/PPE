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
			<link href="../css/banques.css" rel="stylesheet">
		</head>
		<body>
			<?php include 'includes/header.php'; ?>
			<section>
				<form id="formBanq" method="post" action="#">
						<fieldset>
							<legend>Intitulé</legend>
								<input type="text" name="intitule" id="formBanq_intitule" placeholder="..."/>
						</fieldset>
						<fieldset>
							<legend>C.Banque</legend>
								<input type="text" name="cBanque" id="formBanq_cBanque" maxlength="5" placeholder="..."/>
						</fieldset>
						<fieldset>
							<legend>C.Guichet</legend>
								<input type="text" name="cGuichet" id="formBanq_cGuichet" maxlength="5"><legend></legend</input>
						</fieldset>
						<input type="submit" name="creBanque" id="formBanq_cre" value="Créer une banque"/>
				</form>
				<?php
				
					# CREATION D'UNE BANQUE
				
					if(isset($_POST['creBanque'])) {
						if(empty($_POST['intitule']) || empty($_POST['cBanque']) || empty($_POST['cGuichet'])) {
							echo '<p id="errMsg">Vous devez remplir tout les champs !</p>';
						}
						else {
							$sql = 'INSERT INTO banques VALUES("","'.$_SESSION['id'].'","'.$_POST['intitule'].'","'.$_POST['cBanque'].'","'.$_POST['cGuichet'].'")';
							$req = mysqli_query($bdd,$sql);
							header('Location:#');
						}
					}
					
					# AFFICHAGE DES BANQUES
					
					$sql = 'SELECT * FROM banques WHERE bnq_utlId ='.$_SESSION['id'].'';
					$req = mysqli_query($bdd,$sql);
					echo '<div id="bloc_gen">';
					while($rlt = mysqli_fetch_assoc($req)) {
						echo '<a href="comptes.php?id='.$rlt['bnq_id'].'" class="bloc_banque"><img src="../img/banque.png" alt=""/><p>'.$rlt['bnq_intitule'].'</p></a>';
					}
					echo '</div>';
				?>
			</section>
			<?php include 'includes/footer.php'; ?>
		</body>
	</html>