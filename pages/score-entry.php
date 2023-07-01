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

/*$requete = $cnx->prepare("select ca.num_cand,ca.nom,ca.postnom,ca.prenom,ca.sexe,ca.parti_politique from candidat ca,tour tr,participer pa,election el where pa.num_cand=ca.num_cand and pa.id_tour=tr.id_tour and tr.id_election=el.id_election and el.etat=:status");

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
};*/

$id_tour = function(){
    $db = new DatabaseConnection();
    $cnx = $db->GetConnectionString();
    $id = 0;
    $rq = $cnx->prepare("select max(id_tour) from tour,election where tour.id_election=election.id_election and election.etat=:status");
    $rq->execute(array('status' =>'En cours'));
    if($rows=$rq->fetch()){
        $id = $rows[0];
    }

    return $id;
};

//Verification s'il existe déjà un score pour le candidat sélectionné
function VerifNumCandScore(){
    $db = new DatabaseConnection();
    $cnx = $db->GetConnectionString();
    $rq = $cnx->prepare("select * from tour,election,score where score.num_cand=:num and tour.id_tour=(select max(id_tour) from tour)");
    $rq->execute(array('num' =>$_GET['num']));
    if($rq->fetch()){
        return true;
    }
    else {
        return false;
    }
}

//Enregistrement des candidats qui doivent participer au second tour
function CandidatsSecondTour(){
    $db = new DatabaseConnection();
    $cnx = $db->GetConnectionString();
    //Recuperation de l'identifiant du second tour
    $idTour = function(){
        $db = new DatabaseConnection();
        $cnx = $db->GetConnectionString();
        $id_tour = 0;
        $rq = $cnx->prepare("select max(id_tour) from tour,election where tour.id_election=election.id_election and election.etat=:status");
        $rq->execute(array('status' => 'En cours'));
        if($rw=$rq->fetch()){
            $id_tour = $rw[0];
        }
        return $id_tour;
    };

    //Recuperation des numeros des candidats qui participent au second tour
    $numCandList = function(){
        $tb_numCand = [];
        $db = new DatabaseConnection();
        $cnx = $db->GetConnectionString();
        $rq = $cnx->prepare("
            select ca.num_cand from candidat ca,postuler po,election el, participer pa, tour tr, score sc where ".
            "ca.num_cand=po.num_cand and el.id_election=po.id_election and el.etat =:satus and ".
            "pa.num_cand=ca.num_cand and tr.id_tour=pa.id_tour and sc.num_cand=ca.num_cand and ".
            "sc.valeur>:value and sc.id_tour=tr.id_tour
        ");
        $rq->execute(array(
            "status" => "En cours",
            "value" => 12,5
            )
        );
        while ($row = $rq->fetch()){
            array_push($tb_numCand,$row[0]);
        }

        return $tb_numCand;
    };

    foreach ($numCandList() as $num){
        $update = $cnx->prepare("insert into participer values(:num_cand,:id_tour)");
        $update->execute(
            array('num_cand' => $num, 'id_tour' => $idTour())
        );

        $i = $update->rowCount();
        if ($i!=0) {
            return true;
        }
        else{
            return false;
        }
    }
    
}

//Creation 2è tour au cas où aucun candidat n'obtient plus de 50%
function CreateTourElection($designation,$id_election){
    $ClDb = new DatabaseConnection();
    $db = $ClDb->GetConnectionString();    
    

    $insert = $db->prepare("insert into tour(designation,id_election) values(:designation,:idelection)");
    $insert->execute(
        array('designation' => $designation, 'idelection' => $id_election)
    );
    $i = $insert->rowCount();
    if($i!=0){
        return true;
    }
    else{
        return false;
    }
}
//Validation de score du candidat
function ScoreEntry($num_cand,$id_tour,$value){
    $db = new DatabaseConnection();
    $cnx = $db->GetConnectionString();

    //
    $rq = $cnx->prepare("insert into score(num_cand,id_tour,valeur) values(:num_cand,:id_tour,:value)");
    $rq->execute(array('num_cand' => $num_cand, 'id_tour'=>$id_tour, 'value' => $value));
    $i = $rq->rowCount();
    if($i!=0){
        return true;
    }
    else {
        return false;
    }
}


//Verification du nombre de candidat dont les scores sont validés sur base du nombre total des candidats ayant postulés
function VerifNombreCandidat(){
    $db = new DatabaseConnection();
    $cnx = $db->GetConnectionString();
    $rq_nb_cand = $cnx->prepare("select count(ca.num_cand) from candidat ca,tour tr,participer pa,election el where pa.num_cand=ca.num_cand and pa.id_tour=tr.id_tour and tr.id_election=el.id_election and el.etat=:status and tr.id_tour=(select max(id_tour) from tour)");
    $rq_nb_cand->execute(array("status"=>'En cours'));
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

?>

<body>
    <div class="container">
        <?php
        if(!isset($_POST['score'])){
            echo '';
        }
        else{
            /*$requete = $cnx->query("select * from election");


            $reponse = $requete->fetch();
            if(!$reponse){
                $c = CreationElection($_POST['score']);
                if($c > 0){
                    $success_message="Election créée avec succès";
                }
                else{
                    $error_message="Erreur créeation élection !";
                }
            }
            else{
                $etat = $cnx->prepare("select * from election where etat=:etat");
                $etat->execute(
                    array('etat' => 'En cours')
                );
                $isTrue = $etat->fetch();
                if($isTrue){
                    $error_message = 'Les élections sont en cours ! Vous ne pouvez pas créer une nouvelle édition !';
                }
                else{
                    $c = CreationElection($_POST['score']);
                    if($c > 0){
                        $success_message="Election créée avec succès";
                    }
                    else{
                        $error_message="Erreur créeation élection !";
                    }
                }
            }*/
            $verifCand = VerifNombreCandidat();
            if($verifCand){
                $error_message = "Le score de tous les candidats sont validés. Vous ne pouvez plus enregistrer d'autres scores !";
                header('location:list_ca.php');
            }
            else{
                $verif_num_cand = VerifNumCandScore();
                if($verif_num_cand){
                    $error_message = "Vous ne pouvez pas valider le score d'un candidat dont le score est déjà validé !";
                    //header('location:list_ca.php');
                }
                else{
                    $entry = ScoreEntry($_POST['num_cand'],$id_tour(),$_POST['score']);
                    if($entry){
                        $success_message = "Score validé avec succès !";
                        $verifCand_1 = VerifNombreCandidat();
                        if($verifCand_1){
                            $verif_score = $cnx->prepare("select count(ca.num_cand) 
                                from candidat ca,tour tr,participer pa,election el, score sc 
                                where pa.num_cand=ca.num_cand and pa.id_tour=tr.id_tour and tr.id_election=el.id_election 
                                and el.etat=:status and tr.id_tour=(select max(id_tour) from tour) and 
                                sc.id_tour=tr.id_tour and ca.num_cand=sc.num_cand and sc.valeur>=:value");
                            $verif_score->execute(array('status' => 'En cours','value' => 50));
                            $n = 0;
                            if($ver=$verif_score->fetch()){
                                $n = $ver;
                                if($n==0){
                                    $id_election = function(){
                                        $db = new DatabaseConnection();
                                        $cnx = $db->GetConnectionString();
                                        $rqt = $cnx->prepare("select * from election where etat=:status");
                                        $rqt->execute(array('status' => 'En cours'));
                                        $el = 0;
                                        if($rw = $rqt->fetch()){
                                            $el = $rw[0];
                                        }

                                        return $el;
                                    };
                                    //Appel de la fonction de creation du second tour
                                    $createTour = CreateTourElection('2nd Tour',$id_election);
                                    if($createTour){
                                        $addCandSecond = CandidatsSecondTour();
                                        if($addCandSecond){
                                            $success_message = "Creation du second tour avec succès !";
                                        }
                                        else{
                                            $error_message = "Erreur d'ajout de candidat";
                                        }
                                    }
                                    else{
                                        $error_message = "Erreur de création du second tour";
                                    }
                                }
                                else{

                                }
                            }
                        }
                        header('location:list_ca.php');
                    }
                    else{
                        $error_message = "Erreur enregistrement du score !";
                    }
                }                
            }            
        }
        

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

        <h3 class="title" style="color:#1C3D59; margin-top:25px">
            Mise à jour du score du candidat <label class="" style="color:#8C3F3F">N° <?php echo $_GET['num'] ?></label>
        </h3>

        <form action="" method="post" class="box">
            <input type="hidden" name="num_cand" value="<?php echo $_GET['num'] ?>">
            <div class="columns is-centered">
                <div class="column">
                    <div class="field">
                        <label for="nom" class="label">Nom</label>
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="text" placeholder="Nom" id="nom" name="nom" 
                            required value="<?php echo $_GET['name'] ?>" readonly>
                            <span class="icon is-small is-left">
                                <i class="fas fa-user"></i>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label for="postnom" class="label">Post-Nom</label>
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="text" placeholder="Post-Nom" id="postnom" name="postnom"
                                required value="<?php echo $_GET['postn'] ?>" readonly>
                            <span class="icon is-small is-left">
                                <i class="fas fa-user"></i>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label for="prenom" class="label">Prénom</label>
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="text" placeholder="Prénom" id="prenom" name="prenom" 
                            required value="<?php echo $_GET['pren'] ?>" readonly>
                            <span class="icon is-small is-left">
                                <i class="fas fa-user"></i>
                            </span>
                        </p>
                    </div>
                </div>
            </div><hr>
            <div class="columns is-centered">
                <div class="column">
                    <h5 class="title">Score obtenu &nbsp;<i class="fa-solid fa-star" style="color:#FDD360"></i></h5>
                </div>
                
                <div class="column is-6">
                    <div class="field">
                        <label for="score" class="label">Saisissez le score</label>
                        <p class="control is-expanded has-icons-left">
                            <input type="text" class="input" id="score" name="score">
                            <span class="icon is-small is-left">
                                <i class="fa-solid fa-star"></i>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <input type="submit" value="Valider" class="button"
                        style="color:#1C3D59;background-color:#D8E6F2;width:250px">
                </div>
            </div>
        </form>
    </div>
</body>