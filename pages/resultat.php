<?php
session_start();
$error_message = "";
$success_message = "";
include_once 'shared/DatabaseConnection.php';


if ($_SESSION['profile'] == 'Administrateur') {
    include 'shared/header-admin.php';
} else {
    include ('shared/header.php');
    header('Location: score.php');
}

$db = new DatabaseConnection();
$cnx = $db->GetConnectionString();
$rq_count_cand_tour = "select count(*) from election el,tour tr,score sc,candidat ca, postuler po, participer pa 
where etat=:status and el.id_election=tr.id_election and tr.id_tour=pa.id_tour and 
pa.num_cand=ca.num_cand and po.num_cand=ca.num_cand and el.id_election=po.id_election and 
tr.id_tour=sc.id_tour and sc.num_cand=ca.num_cand and tr.designation=:designation";

//Verification du nombre de candidat dont les scores sont validés sur base du nombre total des candidats ayant postulés
function VerifNombreCandidat($tour){
    $db = new DatabaseConnection();
    $cnx = $db->GetConnectionString();
    $rq_nb_cand = $cnx->prepare("select count(ca.num_cand) from candidat ca,tour tr,participer pa,election el where pa.num_cand=ca.num_cand and pa.id_tour=tr.id_tour and tr.id_election=el.id_election and tr.designation=:design and el.etat=:status and tr.id_tour=(select max(id_tour) from tour)");
    $rq_nb_cand->execute(array("status"=>'En cours',"design"=>$tour));
    $nb_1=0;
    if($rows=$rq_nb_cand->fetch()){
        $nb_1 = $rows[0];
    }
    $rq_nb_cand_sc = $cnx->prepare("select count(ca.num_cand) from candidat ca,tour tr,participer pa,election el, score sc 
                                            where pa.num_cand=ca.num_cand and pa.id_tour=tr.id_tour and tr.id_election=el.id_election 
                                            and el.etat=:status and tr.id_tour=(select max(id_tour) from tour) and 
                                            sc.id_tour=tr.id_tour and ca.num_cand=sc.num_cand");
    $rq_nb_cand_sc->execute(array("status" => "En cours"));
    $nb_2=0;
    if($rows=$rq_nb_cand_sc->fetch()) {
        $nb_2=$rows[0];
    }
    if($nb_1==$nb_2){
        return true;
    }
    else {
        return false;
    }
}

function VoirResultat(){
    $existSecondTour=function(){
        $db = new DatabaseConnection();
        $cnx = $db->GetConnectionString();
        $rq = $cnx->prepare("select * from tour,election where designation=:design and etat=status");
        $rq->execute(
            array('design'=>'2nd Tour','status'=>'En cours')
        );
        if($rq->fetch()){
            return true;
        }
        else {
            return false;
        }
    };
    //Nombre de candidat au second tour
    $countCandSnd=function($designation){
        $db = new DatabaseConnection();
        $cnx = $db->GetConnectionString();
        $rq = $cnx->prepare("select count(*) from tour tr,participer pa,candidat ca,election el where designation='2nd Tour' and etat='En cours'
                            and tr.id_tour=pa.id_tour and ca.num_cand=pa.num_cand and tr.id_election=el.id_election");
        
    };

    //Nombre de candidat dont les scores sont validés au second tour
    $countCandSndScore=function($designation){
        $db = new DatabaseConnection();
        $cnx = $db->GetConnectionString();
    };

    //Nombre de candidat au premier tour
    $countCandFirst=function($designation){
        $db = new DatabaseConnection();
        $cnx = $db->GetConnectionString();
    };

    //Nombre de candidat dont les scores sont validés au premier tour
    $countCandFirstScore=function($designation){
        $db = new DatabaseConnection();
        $cnx = $db->GetConnectionString();
    };
    if($existSecondTour){

    }
}
$str_tour = '';
/*if($existSecondTour()){
    $str_tour = 'Premier tour';
}
*/
?>

<body>
    <div class="container">
        <h3 class="title" style="color:#1C3D59; margin-top:25px">Résultat du</h3>

    </div>
</body>