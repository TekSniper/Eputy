<?php
session_start();
$error_message = "";
$success_message = "";
try {
    $db = new PDO('mysql:host=localhost;dbname=eputy_base', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if(!empty($_SESSION['id'])){
    if ($_SESSION['profile'] == 'Administrateur') {
    include 'shared/header-admin.php';
} else {
    include 'shared/header.php';
    header('Location: score.php');
}
}
else{
    header('location:authentification.php');
}


//$rep = $db->query("select * from pays");

function CreationElection($edition,$date){
    $num_user = 0;
            $requete = $db->prepare("select * from utilisateur where identifiant = :identifiant");
            $requete->execute(
                array('identifiant' => $_SESSION['id'])
            );
            if($rows=$requete->fetch()) {
                $num_user = $rows[0];
            }
            $insert = $db->prepare("insert into election(edition,date_election,num_user) values(:edition,:date,:num_user)");
            if($insert->execute(
                array('edition' => $edition, 'date' => $date, 'num_user' => $num_user)
            )){
                $success_message = "Election créée avec succès";
            }
            else{
                $error_message = "Erreur créeation élection !";
            }
}


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
            CreationElection($_POST['edition'],$_POST['date_elect']);
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
                CreationElection($_POST['edition'],$_POST['date_elect']);
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
            Création Edition des élections
        </h3>
        <form action="" method="post" class="box">
            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label for="edition" class="label">Edition</label>
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="text" placeholder="Edition (Ex: Ed. 2018)" id="edition"
                                name="edition" required>
                            <span class="icon is-small is-left">
                                <i class="fa-solid fa-sliders"></i>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label for="date" class="label">Date</label>
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="date" id="date" name="date_elect" required>
                            <span class="icon is-small is-left">
                                <i class="fa-solid fa-calendar"></i>
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