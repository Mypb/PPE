<?php
session_start();

if (empty($_SESSION['ult_id'])) {
    header('Location:/mpb/index.php');
}
include 'includes/bdd.php';
$_SESSION['cpt_id'] = $_GET['cpt_id'];
$sql = 'SELECT cpt_id FROM comptes WHERE cpt_bnqId =' . $_SESSION['bnq_id'] . ' AND cpt_id = ' . $_SESSION['cpt_id'] . '';
$req = mysqli_query($bdd, $sql);
$rlt = mysqli_num_rows($req);
if ($rlt == 0) {
    header('Location:deconnexion.php');
}

$dateDuJour = date("Y-m-d");

$sql = 'SELECT * FROM comptes INNER JOIN operations ON comptes.cpt_id = operations.op_cptId WHERE op_fait = 0';
$req = mysqli_query($bdd, $sql);

while($rlt = mysqli_fetch_assoc($req)){
    if($rlt['op_date'] <= $dateDuJour){
        $montantCalcule = $rlt['op_montant'] + $rlt['cpt_montant'];
        $sql = 'UPDATE comptes SET cpt_montant = '.$montantCalcule.' WHERE cpt_id = '.$rlt['cpt_id'];
        $req = mysqli_query($bdd, $sql);
        $sql = 'UPDATE operations SET op_fait = 1 WHERE op_id = '.$rlt['op_id'];
        $req = mysqli_query($bdd, $sql);
        header('Location:#');
    }
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
        <link href="../css/interface.css" rel="stylesheet">
    </head>
    <body>
<?php include 'includes/header.php'; ?>
        <div id="navigation">
            <a href="banques.php">Banques</a> ► <a href="comptes.php?bnq_id=<?php echo $_SESSION['bnq_id']; ?>">Comptes</a> ► <a href="#">Interface</a>
        </div>
        <section>
            <div id="bt_formOp">
                <h2>Créer une opération</h2>
                <form id="formOp" method="post" action="#">
                    <div id="div_formOp_type">
                        <label>Type</label>
                        <select id="formOp_type" name="type" size="1">
                            <option value="1">Entrant</option>
                            <option value="2">Sortant</option>
                        </select>
                    </div>
                    <div id="div_formOp_reglement">
                        <label>Reglement</label>
                        <select id="formOp_reglement" name="reglement" size="1">
                            <option value="1">Carte Bancaire</option>
                            <option value="2">Virement</option>
                            <option value="3">Cheque</option>
                        </select>
                    </div>
                    <div id="div_formOp_montant">
                        <label>Montant</label>
                        <input id="formOp_montant" name="montant" type="text"/>
                    </div>
                    <div id="div_formOp_motif">
                        <label>Motif</label>
                        <input id="formOp_motif" name="motif" type="text"/>
                    </div>
                    <div id="div_formOp_tiers">
                        <label>Tiers</label>
                        <input id="formOp_tiers" name="tiers" type="text" maxlength="10"/>
                    </div>
                    <div id="div_formOp_date">
                        <label>Date</label>
                        <input id="formOp_date" type="date" name="date" placeholder="aaaa-mm-jj"/>
                    </div>
                    <div id="div_formOp_cre">
                        <input type="submit" id="formOp_cre" name="creer_operation" value="Créer une operation"/>
                    </div>
                </form>
<?php
$bdd = mysqli_connect('localhost', 'root', '', 'mpb');
if (isset($_POST['creer_operation'])) {
    if (empty($_POST['montant']) || empty($_POST['motif']) || empty($_POST['tiers']) || empty($_POST['date'])) {
        echo '<p>Vous devez remplir tous les champs !</p>';
    } else {
        $sql = 'INSERT INTO operations VALUES("","' . $_POST["montant"] . '","' . $_POST["motif"] . '","' . $_POST["tiers"] . '","' . $_POST["date"] . '","' . 0 . '","' . $_SESSION['cpt_id'] . '","' . $_POST["type"] . '","' . $_POST["reglement"] . '")';
        $req = mysqli_query($bdd, $sql);
        header('Location:#');
    }
}
?>
            </div>
        </section>
<?php include 'includes/footer.php'; ?>
    </body>
</html>