<?php

session_start();
$error_message = "";
$success_message = "";
include_once "shared/DatabaseConnection.php";

if($_SESSION['profile']=='Administrateur'){
    include 'shared/header-admin.php';
}
 else{
    include 'shared/header.php';
 }

 //Connexion à la base de données
$db = new DatabaseConnection();//Création de l'objet $db...
$cnx = $db->GetConnectionString();//Recupération de la chaine de connexion

$requete = $cnx->prepare("select ca.num_cand,ca.nom,ca.postnom,ca.prenom,ca.sexe,ca.parti_politique from candidat ca,tour tr,participer pa,election el where pa.num_cand=ca.num_cand and pa.id_tour=tr.id_tour and tr.id_election=el.id_election and el.etat=:status");

$edition = function($status){
    $db = new DatabaseConnection();
    $cnx = $db->GetConnectionString();
    $ed = '';
    $rq = $cnx->prepare("select * from election where etat=:status");
    $rq->execute(array('status' => $status));
    if($row=$rq->fetch()){
        $ed = $row['edition'];
    }

    return $ed;
};

?>