<?php
session_start();
if (isset($_SESSION['id'])) {
    header('Location:contenu/php/banques.php');
} else {
    $bdd = mysqli_connect('localhost', 'root', '', 'mpb');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Accueil - MyPersonalBank</title>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <link href="contenu/css/normalize.css" rel="stylesheet">
        <link href="contenu/css/commun.css" rel="stylesheet">
        <link href="contenu/css/index.css" rel="stylesheet">
    </head>
    <body>
        <?php include 'contenu/php/includes/header.php'; ?>
        <section>
            <div id="bt_global">
                <div id="bt_inscription">
                    <h2>Inscrivez-vous !</h2>
                    <form method="post" action="#" id="formCre">
                        <div id="div_formCre_nom">
                            <label>Nom</label>
                            <input type="text" name="creNom" id="formCre_nom"/>
                        </div>
                        <div id="div_formCre_prenom">
                            <label>Prénom</label>
                            <input type="text" name="crePrenom" id="formCre_prenom"/>
                        </div>
                        <div id="div_formCre_mdp1">
                            <label>Mot de passe</label>
                            <input type="password" name="creMdp1" id="formCre_mdp"/>
                        </div>
                        <div id="div_formCre_mdp2">
                            <label>Confirmation</label>
                            <input type="password" name="creMdp2" id="formCre_mdp2"/>
                        </div>
                        <div id="div_formCre_mail">
                            <label>Adresse mail</label>
                            <input type="text" name="creMail" id="formCre_mail"/>
                        </div>
                        <div id="div_formCre_cre">
                            <input type="submit" name="creCre" id="formCre_cre" value="Créer un compte"/>
                        </div>
                    </form>
                    <?php
                    # CREATION D'UN COMPTE UTILISATEUR

                    if (isset($_POST['creCre'])) {
                        if (empty($_POST['creNom']) || empty($_POST['crePrenom']) || empty($_POST['creMdp1']) || empty($_POST['creMdp2']) || empty($_POST['creMail'])) {
                            echo '<p id="message_erreur">Vous devez remplir tout les champs !</p>';
                        } else {
                            $sql = "SELECT utl_mail FROM utilisateurs WHERE utl_mail =  '" . $_POST['creMail'] . "'";
                            $req = mysqli_query($bdd, $sql);
                            $rlt = mysqli_num_rows($req);
                            if ($_POST['creMdp1'] != $_POST['creMdp2']) {
                                echo '<p id="message_erreur">Les mots de passe ne correspondent pas.</p>';
                            } elseif ($rlt > 0) {
                                echo '<p id="message_erreur">L\'adresse mail est déjà utilisée.</p>';
                            } else {
                                $sql = 'INSERT INTO utilisateurs VALUES("","' . utf8_encode(mysqli_real_escape_string($bdd, $_POST['creNom'])) . '","' . utf8_encode(mysqli_real_escape_string($bdd, $_POST['crePrenom'])) . '","' . mysqli_real_escape_string($bdd, sha1($_POST['creMdp1'])) . '","' . mysqli_real_escape_string($bdd, $_POST['creMail']) . '");';
                                $req = mysqli_query($bdd, $sql);
                                header('Location:index.php');
                            }
                        }
                    }
                    ?>
                </div>
                <div id="bt_connexion">
                    <h2>Connectez-vous !</h2>
                    <form method="post" action="#" id="formCnx">
                        <div id="div_formCnx_mail">
                            <label>Adresse mail</label>
                            <input type="text" name="cnxMail" id="formCnx_mail" autofocus/>
                        </div>
                        <div id="div_formCnx_mdp">
                            <label>Mot de passe</label>
                            <input type="password" name="cnxMdp" id="formCnx_mdp"/>
                        </div>
                        <div id="div_formCnx_cnx">
                            <input type="submit" name="cnxCnx" id="formCnx_cnx" value="Se connecter"/>
                        </div>
                    </form>
                    <?php
# CONNEXION A UN COMPTE UTILISATEUR

                    if (isset($_POST['cnxCnx'])) {
                        if (empty($_POST['cnxMail']) || empty($_POST['cnxMdp'])) {
                            echo '<p id="message_erreur">Vous devez remplir tout les champs !</p>';
                        } else {
                            $sql = 'SELECT * FROM utilisateurs WHERE utl_mail ="' . mysqli_real_escape_string($bdd, $_POST["cnxMail"]) . '";';
                            $req = mysqli_query($bdd, $sql);
                            $rlt = mysqli_fetch_assoc($req);
                            if (mysqli_real_escape_string($bdd, sha1($_POST['cnxMdp'])) == $rlt['utl_motDePasse']) {
                                $_SESSION['ult_id'] = $rlt['utl_id'];
                                $_SESSION['ult_nom'] = $rlt['utl_nom'];
                                $_SESSION['ult_prenom'] = $rlt['utl_prenom'];
                                header('Location:contenu/php/banques.php');
                            } else {
                                echo '<p id="message_erreur">Les identifiants sont incorrects !</p>';
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </section>
        <?php include 'contenu/php/includes/footer.php'; ?>
    </body>
</html>