<?php
session_start();
$error_message = "";
$success_message = "";
$warning_message = "";
try {
    $db = new PDO('mysql:host=localhost;dbname=eputy_base', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if ($_SESSION['profile'] == 'Administrateur') {
    include 'shared/header-admin.php';
} else {
    include 'shared/header.php';
    header('Location: score.php');
}

$rep = $db->query("select * from pays");



?>

<body>
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-6-tablet is-5-desktop is-4-widescreen">
                <h3 class="title" style="color:#1C3D59; margin-top:25px">
                    Création utilisateur
                </h3>
                <?php
                if(!isset($_POST['prenom']) && !isset($_POST['nom']) && !isset($_POST['identifiant']) && !isset($_POST['pwd'])){
                    echo '';
                }
                else{
                    if($_POST['pwd'] != $_POST['confirm']){ 
                        $warning_message = 'Les mots de passe doivent être identiques';
                    }
                }

                if(strlen($warning_message)>0){ ?>
                    <div class="notification is-warning is-light">
                    <button class="delete"></button>
                    <h2 class="title"><strong><i class="fa-solid fa-circle-exclamation"></i> Attention !</strong></h2>
                    <?php echo $warning_message; ?>
                </div>
                <?php }
                else if(strlen($error_message)>0){ ?>
                    <div class="notification is-danger is-light">
                    <button class="delete"></button>
                    <h2 class="title"><strong><i class="fa-solid fa-circle-exclamation"></i> Erreur ! !</strong></h2>
                    <?php echo $error_message; ?>
                </div>
                <?php }
                else if(strlen($success_message)>0){ ?>
                <div class="notification is-success is-light">
                    <button class="delete"></button>
                    <h2 class="title"><strong><i class="fa-solid fa-circle-exclamation"></i> Succes ! !</strong></h2>
                    <?php echo $success_message; ?>
                </div>
                <?php } ?>
                <form action="" method="post" class="box">
                    <div class="field">
                        <label class="label" for="prenom">Prénom</label>
                        <div class="control has-icons-left">
                            <input type="text" name="prenom" id="prenom" class="input" required placeholder="Prénom"
                                focused>
                            <span class="icon is-small is-left">
                                <i class="fa-solid fa-user"></i>
                            </span>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="nom">Nom</label>
                        <div class="control has-icons-left">
                            <input type="text" name="nom" id="nom" class="input" required placeholder="Nom" focused>
                            <span class="icon is-small is-left">
                                <i class="fa-solid fa-user"></i>
                            </span>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="identifiant">Identifiant</label>
                        <div class="control has-icons-left">
                            <input type="text" name="identifiant" id="identifiant" class="input" required
                                placeholder="Identifiant" focused>
                            <span class="icon is-small is-left">
                                <i class="fa-solid fa-user"></i>
                            </span>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="pwd">Mot de passe</label>
                        <div class="control has-icons-left">
                            <input type="password" name="pwd" id="pwd" class="input" required
                                placeholder="Mot de passe">
                            <span class="icon is-small is-left">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="confirm">Confirmez mot de passe</label>
                        <div class="control has-icons-left">
                            <input type="password" name="confirm" id="confirm" class="input" required
                                placeholder="Saisissez à nouveau le mot de passe">
                            <span class="icon is-small is-left">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                        </div>
                    </div>
                    <div class="field">
                        <label for="" class="label">Profile</label>
                        <div class="control">
                            <label class="radio">
                                <input type="radio" name="profile" value="Administrateur">
                                Administrateur
                            </label>
                            <label class="radio">
                                <input type="radio" name="profile" value="Standard">
                                Standard
                            </label>
                        </div>
                    </div>
                    <div class="field is-grouped">
                        <div class="control">
                            <input type="submit" class="button" value="Créer l'utilisateur"
                                style="background-color:#D8E6F2;color:#1C3D59;width:250px">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
