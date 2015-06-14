<?php
session_start();
ob_start();
if (empty($_SESSION['ult_id'])) {
    header('Location:/mpb_web/index.php');
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
$sql = 'SELECT * FROM comptes 
    INNER JOIN operations ON comptes.cpt_id = operations.op_cptId
    WHERE op_fait = 0';
$req = mysqli_query($bdd, $sql);

while($rlt = mysqli_fetch_assoc($req)){
    if($rlt['op_date'] <= $dateDuJour){
        if($rlt['op_typeOpId']==1){
            $montantCalcule = $rlt['op_montant'] + $rlt['cpt_montant'];
        }else{
            $montantCalcule = -$rlt['op_montant'] + $rlt['cpt_montant'];
        }
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
            <div id="arborescence"><a href="banques.php">Banques</a> ► <a href="comptes.php?bnq_id=<?php echo $_SESSION['bnq_id']; ?>">Comptes</a> ► <a href="#">Interface</a></div>
            <div id="identification">
                <?php
                print('<p id="identifiants">'.$_SESSION['ult_prenom'].' '.$_SESSION['ult_nom'].'</p>');
                ?>
                <a href="/mpb_web/contenu/php/deconnexion.php" id="lien_deconnexion"><img src="../img/deconnexion.png" alt="" title="Se déconnecter"/></a>
        </div>
        </div>
        <section>
            <div id="bt_gen">
            <div id="bt_opPlan">
                <h2>Opérations planifiées</h2>
                <table id="tabOpPlan"><?php 
                    $sql = 'SELECT * FROM comptes 
                        INNER JOIN operations ON comptes.cpt_id = operations.op_cptId 
                        INNER JOIN types_operations ON operations.op_typeOpId = types_operations.typOp_id 
                        INNER JOIN modes_reglements ON operations.op_rglId = modes_reglements.rgl_id
                        WHERE op_fait = 0 AND cpt_id='.$_SESSION['cpt_id'].' ORDER BY op_date DESC';
                    $req = mysqli_query($bdd,$sql);
                    $rlt = mysqli_num_rows($req);
                    if ($rlt != 0) {
                        print('<tr><th>Type</th><th>Reglement</th><th>Montant</th><th>Motif</th><th>Tiers</th><th>Date</th></tr>');
                    }
                    else{
                        print('Aucune opération programmé');
                    }
                    while($rlt = mysqli_fetch_assoc($req)){
                        if($rlt['op_typeOpId']==1){
                            echo "<tr class=montantpos>";
                        }else{
                            echo "<tr class=montantneg>";
                        }
                        print("<td>".$rlt['typOp_libelle']."</td>");
                        print("<td>".$rlt['rgl_libelle']."</td>");
                        print("<td>".$rlt['op_montant']."</td>");
                        print("<td>".$rlt['op_motif']."</td>");
                        print("<td>".$rlt['op_tiers']."</td>");
                        print("<td>".$rlt['op_date']."</td>");
                        print("<td><a href='suppression.php?op_id=".$rlt['op_id']."'>Supprimer</a></td>");
                        }
                    ?>
                </table>
            </div>
            
            <div id="bt_historique">
                <h2>Historique</h2>
                <table id="tabHist">
                    <?php
                    $sql = 'SELECT * FROM comptes 
                        INNER JOIN operations ON comptes.cpt_id = operations.op_cptId 
                        INNER JOIN types_operations ON operations.op_typeOpId = types_operations.typOp_id 
                        INNER JOIN modes_reglements ON operations.op_rglId = modes_reglements.rgl_id
                        WHERE op_fait = 1 AND cpt_id='.$_SESSION['cpt_id'].' ORDER BY op_date DESC';
                    $req = mysqli_query($bdd,$sql);
                    $rlt = mysqli_num_rows($req);
                    if ($rlt != 0) {
                        print('<tr><th>Type</th><th>Reglement</th><th>Montant</th><th>Motif</th><th>Tiers</th><th>Date</th></tr>');
                    }
                    else{
                        print('Aucune opération archivée');
                    }
                    while($rlt = mysqli_fetch_assoc($req)){
                        if($rlt['op_typeOpId']==1){
                            echo "<tr class=montantpos>";
                        }else{
                            echo "<tr class=montantneg>";
                        }
                        print("<td>".$rlt['typOp_libelle']."</td>");
                        print("<td>".$rlt['rgl_libelle']."</td>");
                        print("<td>".$rlt['op_montant']."</td>");
                        print("<td>".$rlt['op_motif']."</td>");
                        print("<td>".$rlt['op_tiers']."</td>");
                        print("<td>".$rlt['op_date']."</td>");
                        print("<td><a href='suppression.php?op_id=".$rlt['op_id']."'>Supprimer</a></td></tr>");
                    }
                    ?>
                </table>
            </div>
            </div>
            <div id="bt_droite">
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
if (isset($_POST['creer_operation'])) {
    if (empty($_POST['montant']) || empty($_POST['motif']) || empty($_POST['tiers']) || empty($_POST['date'])) {
        echo '<p>Vous devez remplir tous les champs !</p>';
    } else {
        $sql = 'INSERT INTO operations VALUES("","' . $_POST["montant"] . '","' . $_POST["motif"] . '","' . $_POST["tiers"] . '","' . $_POST["date"] . '","' . 0 . '","' . $_SESSION['cpt_id'] . '","' . $_SESSION['bnq_id'] . '","' . $_POST["type"] . '","' . $_POST["reglement"] . '")';
        $req = mysqli_query($bdd, $sql);
        header('Location:#');
    }
}
?>
            </div>
        
        <div id="bt_suppCpt">
        <h2>Supprimer le compte</h2>
            <form id="formBnq" method="post" action="#">
                <div id="div_suppCpt_sup">
                    <input type="submit" id="formBnq_supp" name="supp_compte" value="Supprimer le compte"/>
                </div>
            </form>
            <?php
            if (isset($_POST['supp_compte'])) { {
                    $sql = 'DELETE FROM operations WHERE op_cptId =' . $_GET["cpt_id"] . '';
                    $sql2 = 'DELETE FROM comptes WHERE cpt_id = ' . $_GET["cpt_id"] . '';
                    $req = mysqli_query($bdd, $sql);
                    $req2 = mysqli_query($bdd, $sql2);
                    header('Location:comptes.php?bnq_id='.$_SESSION['bnq_id'].'');
                }
            }
            ?>
        </div>
        </div>
        </section>
        
<?php include 'includes/footer.php'; ?>
    </body>
</html>
<?php ob_end_flush(); ?>