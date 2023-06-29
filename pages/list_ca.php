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

$requete = $cnx->prepare("select ca.num_cand,ca.nom,ca.postnom,ca.prenom,ca.sexe,ca.parti_politique from candidat ca,tour tr,participer pa,election el where pa.num_cand=ca.num_cand and pa.id_tour=tr.id_tour and tr.id_election=el.id_election and el.etat=:status and tr.id_tour=(select max(id_tour) from tour)");

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
        <h3 class="title" style="color:#1C3D59; margin-top:25px">
            Liste des candidats
        </h3>
        <marquee behavior="alternate" direction="" width="20%" class="has-text-info"><?php echo $edition('En cours'); ?></marquee>
        <div class="box columns is-centered" style="background-color:white;margin-top:15px">
            <div class="column is-8-tablet is-8-widescreen is-8 desktop">
                <table class="table">
                    <thead>
                        <th><abbr title="Numéro Candidat">N° Candidat</abbr></th>
                        <th>Nom</th>
                        <th>Post-Nom</th>
                        <th>Prénom</th>
                        <th>Sexe</th>
                        <th>Parti politique</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php
                            $requete->execute(array('status' => 'En cours'));
                            while ($rows=$requete->fetch()):;

                        ?>
                        <tr>
                            <td><?php echo $rows[0]; ?></td>
                            <td><?php echo $rows[1]; ?></td>
                            <td><?php echo $rows[2]; ?></td>
                            <td><?php echo $rows[3]; ?></td>
                            <td><?php echo $rows[4]; ?></td>
                            <td><?php echo $rows[5]; ?></td>
                            <td>
                                <a href="score-entry.php?num=<?php echo $rows[0]; ?>&postn=<?php echo $rows[2]; ?>&pren=<?php echo $rows[3]; ?>&name=<?php echo $rows[1]; ?>&sex=<?php echo $rows[4]; ?>" class="button is-info is-outlined">Score</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
