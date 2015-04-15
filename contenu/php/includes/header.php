<header>
    <img src="/mpb/contenu/img/logo.png" alt="" id="logoImg"/>
            </div>
            <?php
            
                # Si l'utilisateur est connecté
                
                if(isset($_SESSION['id'])) {
					echo '<p id="msgAccueil">'.$_SESSION['prenom'].' '.$_SESSION['nom'].'</p>';
                    echo '<a href="/mpb/contenu/php/deconnexion.php" id="deconnexion"><img src="../img/deconnexion.png" alt="" title="Se déconnecter"/></a>';
                }
            ?>
        </header>