<header>
    <img src="/mpb_web/contenu/img/mpb.png" alt="" id="logo"/>
            </div>
            <?php
            
                # Si l'utilisateur est connecté
                
				
                if(isset($_SESSION['ult_id'])) {
					echo '<p id="identifiants">'.$_SESSION['ult_prenom'].' '.$_SESSION['ult_nom'].'</p>';
                    echo '<a href="/mpb_web/contenu/php/deconnexion.php" id="lien_deconnexion"><img src="../img/deconnexion.png" alt="" title="Se déconnecter"/></a>';
                }
            ?>
        </header>