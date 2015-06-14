<?php
session_start();

if (empty($_SESSION['ult_id'])) {
    header('Location:/mpb_web/index.php');
}
include 'includes/bdd.php';
$_SESSION['bnq_id'] = $_GET['bnq_id'];

$sql = 'SELECT bnq_id FROM banques WHERE bnq_utlId =' . $_SESSION['ult_id'] . ' AND bnq_id = ' . $_SESSION['bnq_id'] . '';
$req = mysqli_query($bdd, $sql);
$rlt = mysqli_num_rows($req);
if ($rlt == 0) {
    header('Location:deconnexion.php');
}
$_SESSION['cpt_id'] = 0;

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
            <div id="arborescence"><a href="banques.php">Banques</a> ► <a href="comptes.php?bnq_id=<?php echo $_SESSION['bnq_id']; ?>">Comptes</a></div>
            <div id="identification">
                <?php
                print('<p id="identifiants">'.$_SESSION['ult_prenom'].' '.$_SESSION['ult_nom'].'</p>');
                ?>
                <a href="/mpb_web/contenu/php/deconnexion.php" id="lien_deconnexion"><img src="../img/deconnexion.png" alt="" title="Se déconnecter"/></a>
            </div>
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
                if (isset($_POST['creer_compte'])) {
                    if (empty($_POST['intitule']) || empty($_POST['type']) || empty($_POST['montant']) || empty($_POST['numero'])) {
                        echo '<p>Vous devez remplir tous les champs !</p>';
                    } else {
                        $sql = 'INSERT INTO comptes VALUES("","' . $_GET["bnq_id"] . '","' . $_POST["intitule"] . '","' . $_POST["type"] . '","' . $_POST["montant"] . '","' . $_POST["numero"] . '")';
                        $req = mysqli_query($bdd, $sql);
                        header('Location:#');
                    }
                }
                ?>
            </div>
            <div id="bt_comptes">
                <?php
                $sql = 'SELECT * FROM comptes WHERE cpt_bnqId =' . $_SESSION['bnq_id'] . '';
                $req = mysqli_query($bdd, $sql);
                while ($rlt = mysqli_fetch_assoc($req)) {
                    echo '<a title="' . $rlt['cpt_intitule'] . '" href="interface.php?cpt_id=' . $rlt['cpt_id'] . '" class="bloc_compte"><img src="../img/monnaie.png" alt=""/><p>' . $rlt['cpt_intitule'] . '</p>';
                    if ($rlt["cpt_montant"] > 0) {
                        echo '<p class="montantpos">' . $rlt['cpt_montant'] . ' €</p></a>';
                    } else {
                        echo '<p class="montantneg">' . $rlt['cpt_montant'] . ' €</p></a>';
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
        if (isset($_POST['supp_banque'])) { {
                $sql1 = 'DELETE FROM operations WHERE op_bnqId = ' .$_GET["bnq_id"] .'';
                $sql2 = 'DELETE FROM comptes WHERE cpt_bnqId =' . $_GET["bnq_id"] . '';
                $sql3 = 'DELETE FROM banques WHERE bnq_id = ' . $_GET["bnq_id"] . '';
                $req1 = mysqli_query($bdd, $sql1);
                $req2 = mysqli_query($bdd, $sql2);
                $req3 = mysqli_query($bdd, $sql3);
                header('Location:banques.php');
                echo $_GET["bnq_id"];
            }
        }
        ?>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>