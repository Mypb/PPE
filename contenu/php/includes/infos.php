<div id="infos">
	<?php
		$sql = 'SELECT * FROM utilisateurs WHERE utl_id ='.$_SESSION['id'].'';
		$req = mysqli_query($bdd,$sql);
		$rlt = mysqli_fetch_assoc($req);
		echo '<p id="prenom_nom">'.$rlt['utl_prenom'].' '.$rlt['utl_nom'].'</p>';
	?>
	<a href="#" id="deconnexion"><img src="../img/deconnexion.png" alt=""/></a>
</div>