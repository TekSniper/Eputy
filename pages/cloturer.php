<?php
if ($_SESSION['profile'] == 'Administrateur') {
    
} else {    
    header('Location: list_ca.php');
}
include_once 'shared/DatabaseConnection.php';
function cloturerElection(){
    $db = new DatabaseConnection();
    $cnx = $db->GetConnectionString();
    $update = $cnx->prepare("update election set etat =:status where id_election=(select max(id_election) from election)");
    if($update->execute(
        array('status' => 'Clôturée')
    )){
        return true;
    }
    else{
        return false;
    }
}

if(cloturerElection()){
        echo "Elections clôturées";
        header('location:elections.php');
    }
    else{
        echo "Erreur clôture des élections !";
    }

