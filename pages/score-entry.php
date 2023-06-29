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

<body>
    <div class="container">
        <?php
        if(!isset($_POST['edition']) or !isset($_POST['date_elect'])){
            echo '';
        }
        else{
            $requete = $db->query("select * from election");

        $reponse = $requete->fetch();
        if(!$reponse){
            $c = CreationElection($_POST['edition'],$_POST['date_elect']);
            if($c > 0){
                $success_message="Election créée avec succès";
            }
            else{
                $error_message="Erreur créeation élection !";
            }
        }
        else{
            $etat = $db->prepare("select * from election where etat=:etat");
            $etat->execute(
                array('etat' => 'En cours')
            );
            $isTrue = $etat->fetch();
            if($isTrue){
                $error_message = 'Les élections sont en cours ! Vous ne pouvez pas créer une nouvelle édition !';
            }
            else{
                $c = CreationElection($_POST['edition'],$_POST['date_elect']);
                if($c > 0){
                    $success_message="Election créée avec succès";
                }
                else{
                    $error_message="Erreur créeation élection !";
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
            <div class="columns is-centered">
                <div class="column">
                    <div class="field">
                        <label for="nom" class="label">Nom</label>
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="text" placeholder="Nom" id="nom" name="nom" 
                            required value="<?php echo $_GET['name'] ?>">
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
                                required value="<?php echo $_GET['postn'] ?>">
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
                            required value="<?php echo $_GET['pren'] ?>">
                            <span class="icon is-small is-left">
                                <i class="fas fa-user"></i>
                            </span>
                        </p>
                    </div>
                </div>
            </div><hr>
            <div class="columns is-centered">
                <h5 class="title">Score obtenu</h5><hr>
                <div class="column">
                    <div class="field">
                        <label for="score" class="label">Saisissez le score</label>
                        <p class="control is-expanded has-icons-left">
                            <input type="text" class="input">
                            <span class="icons is-small is-left">
                                
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>