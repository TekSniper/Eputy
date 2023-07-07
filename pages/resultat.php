<?php
session_start();
$error_message = "";
$success_message = "";
$designationTour = "";
$result_message = "";
include_once 'shared/DatabaseConnection.php';


if ($_SESSION['profile'] == 'Administrateur') {
    include 'shared/header-admin.php';
} else {
    include ('shared/header.php');
    header('Location: list_ca.php');
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
//Verification si le second tour existe
$existSecondTour=function(){
        $db = new DatabaseConnection();
        $cnx = $db->GetConnectionString();
        $rq = $cnx->prepare("select * from tour,election where designation=:design and etat=:status");
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
        $i = 0;
        $rq = $cnx->prepare("select count(*) from tour tr,participer pa,candidat ca,election el where designation='2nd Tour' and etat='En cours'
                            and tr.id_tour=pa.id_tour and ca.num_cand=pa.num_cand and tr.id_election=el.id_election");
        $rq->execute();
        if($rows = $rq->fetch()){
            $i = $rows[0];
        }
        
        return $i;
    };    

//Nombre de candidat dont les scores sont validés au second tour
    $countCandSndScore=function($designation){
        $db = new DatabaseConnection();
        $cnx = $db->GetConnectionString();
        $i = 0;
        $rq = $cnx->prepare("select count(*) from tour tr,participer pa,candidat ca,election el, score sc where designation='2nd Tour' and etat='En cours'
                            and tr.id_tour=pa.id_tour and ca.num_cand=pa.num_cand and tr.id_election=el.id_election and
							sc.id_tour=tr.id_tour and ca.num_cand=sc.num_cand");
        $rq->execute();
        if($row= $rq->fetch()){
            $i = $row[0];
        }
        return $i;
    };

    //Nombre de candidat au premier tour
    $countCandFirst=function(){
        $db = new DatabaseConnection();
        $cnx = $db->GetConnectionString();
        $i = 0;
        $rq = $cnx->prepare("select count(*) from tour tr,participer pa,candidat ca,election el where designation='1er Tour' and etat='En cours'
                            and tr.id_tour=pa.id_tour and ca.num_cand=pa.num_cand and tr.id_election=el.id_election");
        $rq->execute();
        if($rows = $rq->fetch()){
            $i = $rows[0];
        }
        
        return $i;
    };

    //Nombre de candidat dont les scores sont validés au premier tour
    $countCandFirstScore=function(){
        $db = new DatabaseConnection();
        $cnx = $db->GetConnectionString();
        $i = 0;
        $rq = $cnx->prepare("select count(*) from tour tr,participer pa,candidat ca,election el, score sc where designation='1er Tour' and etat='En cours'
                            and tr.id_tour=pa.id_tour and ca.num_cand=pa.num_cand and tr.id_election=el.id_election and
							sc.id_tour=tr.id_tour and ca.num_cand=sc.num_cand");
        $rq->execute();
        if($row= $rq->fetch()){
            $i = $row[0];
        }
        return $i;
    };
function VoirResultat($designation, $etat){
    $db = new DatabaseConnection();
    $cnx = $db->GetConnectionString();
    $numCand = 0;
    $nomCand = '';
    $postnomCand = '';
    $prenomCand = '';
    $score = 0;
    $detailResultat = '';
    $rq = $cnx->prepare("select sc.valeur,ca.num_cand,ca.nom,ca.postnom,ca.prenom from tour tr,participer pa,candidat ca,
							election el, score sc where designation=:design and etat=:status
                            and tr.id_tour=pa.id_tour and ca.num_cand=pa.num_cand and tr.id_election=el.id_election and
							sc.id_tour=tr.id_tour and ca.num_cand=sc.num_cand and ca.num_cand=(select min(num_cand) from candidat)");
    $rq->execute(
        array('design'=>$designation, 'status'=>$etat)
    );

    if($row = $rq->fetch()){
        $score = $row[0];
        $numCand = $row[1];
        $nomCand = $row[2];
        $postnomCand = $row[3];
        $prenomCand = $row[4];
    }

    //Verification si le premier candidat est en ballotage favorable ou non
    $compareScore = function($designation,$etat){
        $db = new DatabaseConnection();
        $cnx = $db->GetConnectionString();
        $val_1=0;
        $val_2=0;

        //Requete de recherche du score du premier candidat
        $requete_1 = $cnx->prepare("select sc.valeur,ca.num_cand,ca.nom,ca.postnom,ca.prenom from tour tr,participer pa,candidat ca,
							election el, score sc where designation=:design and etat=:status
                            and tr.id_tour=pa.id_tour and ca.num_cand=pa.num_cand and tr.id_election=el.id_election and
							sc.id_tour=tr.id_tour and ca.num_cand=sc.num_cand and ca.num_cand=(select min(num_cand) from candidat)");

        //Requete de recherche du plus grand score en cas de ballotage
        $requete_2 = $cnx->prepare("select max(sc.valeur) from tour tr,participer pa,candidat ca,election el, score sc where 
							designation=:design and etat=:status
                            and tr.id_tour=pa.id_tour and ca.num_cand=pa.num_cand and tr.id_election=el.id_election and
							sc.id_tour=tr.id_tour and ca.num_cand=sc.num_cand");
        
        //Recupération du score du premier candidat
        $requete_1->execute(
            array('design'=>$designation, 'status'=>$etat)
        );
        if($rows1 = $requete_1->fetch()){
            $val_1 = $rows1[0];
        }

        //Recupération du plus grand score
        $requete_2->execute(
            array('design'=>$designation, 'status'=>$etat)
        );
        if($rows2 = $requete_2->fetch()){
            $val_2 = $rows2[0];
        }
        
        if($val_1==$val_2){
            return true;
        }
        elseif($val_1<$val_2){
            return false;
        }
    };

    /***
        RETOURNER LES DETAILS DU RESULTAT

        Deux possibilités :
        *Avec Swicth case
        *Avec if() else
    ***/
    
    
    switch($score){
        case $score>=50:
            $detailResultat = "Le candidat N° ".$numCand.", ".$nomCand." ".$postnomCand." ".$prenomCand." est élu avec ".$score." %";
            break;
        case ($score<50 && $score>=12.5):{
            if($compareScore($designation,$etat)){
                $detailResultat = "Le candidat N° ".$numCand.", ".$nomCand." ".$postnomCand." ".$prenomCand." participe au second tour en ballotage favorable avec ".$score." %";
            }
            else{
                $detailResultat = "Le candidat N° ".$numCand.", ".$nomCand." ".$postnomCand." ".$prenomCand." participe au second tour en ballotage défavorable avec ".$score." %";
            }
        }
            break;
        case $score<12.5:
            $detailResultat = "Le candidat N° ".$numCand.", ".$nomCand." ".$postnomCand." ".$prenomCand." est battu avec ".$score." %";
            break;
    }

    /*if($score>=50){
        $detailResultat = "Le candidat N° ".$numCand.", ".$nomCand." ".$postnomCand." ".$prenomCand." est élu avec ".$score." %";
    }
    elseif($score<50 && $score>=12.5){
        if($compareScore($designation,$etat)){
                $detailResultat = "Le candidat N° ".$numCand.", ".$nomCand." ".$postnomCand." ".$prenomCand." participe au second tour en ballotage favorable avec ".$score." %";
            }
            else{
                $detailResultat = "Le candidat N° ".$numCand.", ".$nomCand." ".$postnomCand." ".$prenomCand." participe au second tour en ballotage défavorable avec ".$score." %";
            }
    }
    elseif($score<12.5){
        $detailResultat = "Le candidat N° ".$numCand.", ".$nomCand." ".$postnomCand." ".$prenomCand." est battu avec ".$score." %";
    }
*/
    return $detailResultat;

    /*
        FIN RETOUR LES DETAILS DU RESULTAT
    */
}


/*** 
 * 
 * Résultats des élections
 * 
 *  ***/
if($existSecondTour()){
    if($countCandSnd()!=$countCandSndScore()){
        if($countCandSndScore==0){
            $designationTour = "1er Tour";
            $result_message = VoirResultat('1er Tour','En cours');
        }
        else{
            $error_message = "Les résultats ne sont pas encore disponibles pour l'instant !";
            $designationTour = "2nd Tour";
        }        
    }
    else{
        $designationTour = "2nd Tour";
        $result_message = VoirResultat('2nd Tour','En cours');
    }
}else{
    if($countCandFirst()!=$countCandFirstScore()){
        $error_message = "Les résultats ne sont pas encore disponibles pour l'instant !";
        $designationTour = "1er Tour";
    }
    else{
        $designationTour = "1er Tour";
        $result_message = VoirResultat('1er Tour','En cours');
    }
}

?>

<body>
    <div class="container">
        <?php
        
        

        if(strlen($error_message)>0){ ?>
        <div class="notification is-danger is-light">
            <button class="delete"></button>
            <h4 class="title">Attention !</h4>
            <?php echo $error_message; ?>
        </div>
        <?php }
        if(strlen($success_message)>0){ ?>
        <div class="notification is-success is-light">
            <button class="delete"></button>
            <h4 class="title">Success !</h4>
            <?php echo $success_message; ?>
        </div>
        <?php }

?>
        <h3 class="title" style="color:#1C3D59; margin-top:25px">Résultat du <?php echo $designationTour; ?></h3>
        <div class="box columns is-centered">
            <div class="column">
                <p class="is-size-4">
                    <?php echo $result_message; ?>
                </p>
            </div>
        </div>
        <div class="columns is-centered">
            <div class="column">
                <a href="cloturer.php" class="button is-medium is-light is-success">Clôturer les élections</a>
            </div>
        </div>
    </div>
</body>