<header>
    <img src="/mpb_web/contenu/img/mpb.png" alt="" id="logo"/>
    <?php
        if(isset($_SESSION['bnq_id'])) {
            if($_SESSION['bnq_id']!=0) {
                print("<div id='intGene'>");
                $sql = 'SELECT * FROM banques WHERE bnq_id = '.$_SESSION['bnq_id'].'';
                $req = mysqli_query($bdd, $sql);
                $rlt = mysqli_fetch_assoc($req);
                print("<div id='intBanque'>".$rlt['bnq_intitule']."</div>");
            }
        }
        if(isset($_SESSION['cpt_id'])) {
            if($_SESSION['cpt_id']!=0){
                $sql = 'SELECT * FROM comptes WHERE cpt_id = '.$_SESSION['cpt_id'].'';
                $req = mysqli_query($bdd, $sql);
                $rlt = mysqli_fetch_assoc($req);
                print("<div id='intCompte'>".$rlt['cpt_intitule']."</div>");
                print("</div>");
            }
        }
        if(isset($_SESSION['cpt_id'])) {
            if($_SESSION['cpt_id']!=0){
                $sql = 'SELECT * FROM comptes WHERE cpt_id =' . $_SESSION['cpt_id'] . '';
                $req = mysqli_query($bdd, $sql);
                $rlt = mysqli_fetch_assoc($req);
                echo "<div id=montantActu><p id='titreMont'>Montant actuel</p>";
                if ($rlt["cpt_montant"] > 0) {
                    echo '<p id="montantposh">'. $rlt['cpt_montant'] . ' €</p></a>';
                } else {
                    echo '<p id="montantnegh">' . $rlt['cpt_montant'] . ' €</p></a>';
                }
                echo "</div>";
            }
        }
    ?>
</header>