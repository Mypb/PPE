<?php
session_start();

if (empty($_SESSION['utl_id'])) {
    header('Location:/mpb/index.php');
}
include 'includes/bdd.php';

$sql = 'SELECT * FROM comptes
    INNER JOIN operations ON comptes.cpt_id = operations.op_cptId
    WHERE op_id =' . $_GET['op_id'].'';
$req = mysqli_query($bdd, $sql);
while($rlt = mysqli_fetch_assoc($req)){
    if($rlt['op_fait']==1){
        if($rlt['op_typeOpId']==1){
            $montantCalcule = -$rlt['op_montant'] + $rlt['cpt_montant'];
        }else{
            $montantCalcule = $rlt['op_montant'] + $rlt['cpt_montant'];
        }
        $sql = 'UPDATE comptes SET cpt_montant = '.$montantCalcule.' WHERE cpt_id = '.$rlt['cpt_id'];
        $req = mysqli_query($bdd, $sql);
        $sql = 'UPDATE operations SET op_fait = 1 WHERE op_id = '.$rlt['op_id'];
        $req = mysqli_query($bdd, $sql);
        header('Location:#');
    }
}

$sql = 'DELETE FROM operations WHERE op_id=' . $_GET['op_id'] . '';
$req = mysqli_query($bdd, $sql);

header("Location:interface.php?cpt_id=" . $_SESSION['cpt_id'] . "");
?>