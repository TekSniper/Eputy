<?php 
include_once 'shared/DatabaseConnection.php';
session_start();
/*try {
    $db = new PDO('pgsql:host=localhost;port=5432;dbname=eputy_base','postgres','secret');
}
catch (Exception $e){
    die('Erreur :'.$e->getMessage());
}*/
$clDb = new DatabaseConnection();
$db = $clDb->GetConnectionString();
if($_SESSION['profile']=='Administrateur'){
    include 'shared/header-admin.php';
}
 else{
    include 'shared/header.php';
    header('Location: score.php');
 }

 $requete = $db->query('select * from utilisateur');

?>
<div class="container">
    <h3 class="title" style="color:#1C3D59; margin-top:25px">
        Mini Gestion Utilisateur
    </h3>
    <div class="columns is-centered" style="background-color:white">
        <div class="column is-8-tablet is-8-desktop is-8-widescreen">
            <table class="table">
                <thead>
                    <th><abbr title="Numéro">N°</abbr></th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Identifiant</th>
                    <th>Profile</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    <?php while ($row = $requete->fetch()):; ?>
                        <tr>
                            <th><?php echo $row[0]; ?></th>
                            <td><?php echo $row[1]; ?></td>
                            <td><?php echo $row[2]; ?></td>
                            <td><?php echo $row[3]; ?></td>
                            <td><?php echo $row[5]; ?></td>
                            <td>
                                <a href="#" class="button is-info">Modifier</a>
                                <a href="#" class="button is-danger">Désactiver</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>