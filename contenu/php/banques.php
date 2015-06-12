<?php
session_start();

if (empty($_SESSION['ult_id'])) {
    header('Location:/mpb_web/index.php');
}
$_SESSION['bnq_id']=0;
$_SESSION['cpt_id']=0;
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
        <link href="../css/banques.css" rel="stylesheet">
    </head>
    <body>
        <?php include 'includes/header.php'; ?>
        <div id="navigation">
            <div id="arborescence"><a href="banques.php">Banques</a> ►</div>
            <div id="identification">
                <?php
                print('<p id="identifiants">'.$_SESSION['ult_prenom'].' '.$_SESSION['ult_nom'].'</p>');
                ?>
                <a href="/mpb_web/contenu/php/deconnexion.php" id="lien_deconnexion"><img src="../img/deconnexion.png" alt="" title="Se déconnecter"/></a>
            </div>
        </div>
        <section>
            <div id="bt_formBanq">
                <h2>Créer une banque</h2>
                <form id="formBanq" method="post" action="#">
                    <div id="div_formBanq_intitule"><label>Intitulé</label><input type="text" name="intitule" id="formBanq_intitule"/></div>
                    <div id="div_formBanq_cBanque"><label>Code banque</label><input type="text" name="cBanque" id="formBanq_cBanque"  maxlength="5"/></div>
                    <div id="div_formBanq_cGuichet"><label>Code guichet</label><input type="text" name="cGuichet" id="formBanq_cGuichet" maxlength="5"/></div>
                    <div id="div_formBanq_cre"><input type="submit" name="creBanque" id="formBanq_cre" value="Créer une banque"/></div>
                </form>
                <?php
                # CREATION D'UNE BANQUE

                if (isset($_POST['creBanque'])) {
                    if (empty($_POST['intitule']) || empty($_POST['cBanque']) || empty($_POST['cGuichet'])) {
                        echo '<p id="message_erreur">Vous devez remplir tous les champs !</p>';
                    } else {
                        $sql = 'INSERT INTO banques VALUES("","' . $_SESSION['ult_id'] . '","' . $_POST['intitule'] . '","' . $_POST['cBanque'] . '","' . $_POST['cGuichet'] . '")';
                        $req = mysqli_query($bdd, $sql);
                        header('Location:#');
                    }
                }
                ?>
            </div>
            <div id="bt_banques">
                <?php
                # AFFICHAGE DES BANQUES
                $sql = 'SELECT * FROM banques WHERE bnq_utlId =' . $_SESSION['ult_id'] . '';
                $req = mysqli_query($bdd, $sql);
                echo '<div id="bloc_gen">';
                while ($rlt = mysqli_fetch_assoc($req)) {
                    echo '<a title="' . $rlt['bnq_intitule'] . '" href="comptes.php?bnq_id=' . $rlt['bnq_id'] . '" class="bloc_banque"><img src="../img/banque2.png" alt=""/><p>' . $rlt['bnq_intitule'] . '</p></a>';
                }
                echo '</div>';
                ?>
            </div>
        </section>
        <?php include 'includes/footer.php'; ?>
    </body>
</html>