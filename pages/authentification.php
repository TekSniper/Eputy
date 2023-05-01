<?php

$err_message;

session_start();
try{
    $db = new PDO('mysql:host=localhost;dbname=eputy_base', 'root', '');
}
catch(Exception $e){
    die('Erreur : ' . $e->getMessage());
}

if(!empty($_SESSION['id'])){
    if($_SESSION['profile']=='Administrateur'){
        header('Location:utilisateurs.php');
    }
    else{
        header('Location:score.php');
    }
}
else{
    echo '';
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/css/main.css">
    <link rel="stylesheet" href="../static/css/node_modules/bulma/css/bulma.min.css">
    <link rel="icon" href="../static/img/Eputy Logo.ico" type="image/icon">
    
    <link href="../static/css/fontawesome-free-6.3.0-web/css/all.css" rel="stylesheet" />
    <link href="../static/css/fontawesome-free-6.3.0-web/css/all.min.css" rel="stylesheet" />
    <title>Authentification - Eputy</title>
</head>
<body>
    <section class="hero is-fullheight" style="background-color:#D8E6F2">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-centered">
                    <div class="column is-6-tablet is-5-desktop is-4-widescreen">
                        <form action="" class="box" method="POST">
                            <div class="field has-text-centered">
                                <img src="../static/img/Eputy Logo.png" alt="Logo Eputy" height="50px" width="50px">
                            </div>
                            <div class="field">
                                <div class="label" for="identifiant">Identifiant</div>
                                <div class="control has-icons-left">
                                    <input type="text" name="identifiant" id="identifiant" class="input" required placeholder="Identifiant" focused>
                                    <span class="icon is-small is-left">
                                        <i class="fa-solid fa-user"></i>
                                    </span>
                                </div>
                                </div><div class="field">
                                    <div class="label" for="pwd">Mot de passe</div>
                                    <div class="control has-icons-left">
                                        <input type="password" name="pwd" id="pwd" class="input" required placeholder="Mot de passe">
                                        <span class="icon is-small is-left">
                                            <i class="fa-solid fa-lock"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="field is-grouped">
                                    <div class="control">
                                        <input type="submit" class="button" value="Se connecter" style="background-color:#1C3D59;color:white;">
                                    </div>
                                </div>
                        </form>
                        <?php
                        if(!isset($_POST['identifiant']) && !isset($_POST['pwd'])){
                            echo '';
                        }
                        else{
                        $id_user = $_POST['identifiant'];
                        $pwd = $_POST['pwd'];
                        $req = $db->prepare('select * from utilisateur where identifiant=:identi and mot_de_passe=:pwd');
                        $req->execute(
                            array(
                                'identi' => $id_user,
                                'pwd' => $pwd
                            )
                        );
                        $result = $req->fetch();
                        if (!$result) {?>
                        <div class="notification is-danger is-light">
                            <h2 class="title"><strong><i class="fa-solid fa-circle-exclamation"></i> Attention !</strong></h2>
                            Connexion impossible<br>Identifiant ou mot de passe incorrect
                        </div>
                        <?php } else {
                            $_SESSION['id'] = $result['identifiant'];
                            $_SESSION['pwd'] = $result['mot_de_passe'];
                            $_SESSION['profile'] = $result['user_profile'];
                            if($_SESSION['profile'] == 'Administrateur'){
                                header('location:utilisateurs.php');
                            }
                            else{
                                header('location:score.php');
                            }
                        }
                    }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
