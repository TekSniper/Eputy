<?php
session_start();
$error_message = "";
$success_message = "";
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
        <h3 class="title" style="color:#1C3D59; margin-top:25px">
            Identification du Candidat
        </h3>
        <form action="" class="box" method="POST">
            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label for="nom" class="label">Nom</label>
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="text" placeholder="Nom" id="nom" name="nom" required>
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
                                required>
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
                            <input class="input" type="text" placeholder="Prénom" id="prenom" name="prenom" required>
                            <span class="icon is-small is-left">
                                <i class="fas fa-user"></i>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-half">
                    <div class="field">
                        <label for="email" class="label">Email</label>
                        <p class="control is-expanded has-icons-left">
                            <input type="email" name="email" id="email" class="input" placeholder="lorem@exemple.com"
                                required>
                            <span class="icon is-small is-left">
                                <i class="fa-solid fa-envelope"></i>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label for="" class="label">Sexe</label>
                        <div class="control">
                            <label class="radio">
                                <input type="radio" name="sexe" value="M">
                                Homme
                            </label>
                            <label class="radio">
                                <input type="radio" name="sexe" value="F">
                                Femme
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label for="phone_1" class="label">N° Téléphone</label>
                        <p class="control is-expanded has-icons-left">
                            <input type="tel" name="telephone_1" id="phone_1" class="input"
                                placeholder="Numéro de téléphone" required>
                            <span class="icon is-small is-left">
                                <i class="fa-solid fa-phone"></i>
                            </span>
                        </p>
                    </div>
                </div>
                <!--<div class="column">
                    <div class="field">
                        <label for="phone_2" class="label">N° Téléphone</label>
                        <p class="control is-expanded has-icons-left">
                            <input type="tel" name="phone_2" id="phone_2" class="input"
                                placeholder="Numéro de téléphone (facultatif)">
                            <span class="icon is-small is-left">
                                <i class="fa-solid fa-phone"></i>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label for="phone_3" class="label">N° Téléphone</label>
                        <p class="control is-expanded has-icons-left">
                            <input type="tel" name="phone_3" id="phone_3" class="input"
                                placeholder="Numéro de téléphone (facultatif)">
                            <span class="icon is-small is-left">
                                <i class="fa-solid fa-phone"></i>
                            </span>
                        </p>
                    </div>
                </div>-->
            </div>
            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label for="lieu_naissance" class="label">Lieu de naissance</label>
                        <p class="control is-expanded has-icons-left">
                            <input type="text" name="lieu_naissance" id="lieu_naissance" class="input"
                                placeholder="Lieu de naissance" required>
                        </p>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label for="date_naissance" class="label">Date de naissance</label>
                        <p class="control is-expanded has-icons-left">
                            <input type="date" name="date_naissance" id="date_naissance" class="input" required>
                            <span class="icon is-small is-left">
                                <i class="fa-solid fa-calendar"></i>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label for="nationalite" class="label">Nationalité</label>
                        <p class="control is-expanded has-icons-left">
                            <input type="text" name="nationalite" id="nationalite" class="input"
                                placeholder="Nationalité" required>
                            <span class="icon is-small is-left">
                                <i class="fa-solid fa-location-dot"></i>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label for="profession" class="label">Profession</label>
                        <p class="control is-expanded has-icons-left">
                            <input type="text" name="profession" id="profession" class="input" placeholder="Profession"
                                required>
                            <span class="icon is-small is-left">
                                <i class="fa-solid fa-user-tie"></i>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label for="parti" class="label">Parti politique</label>
                        <p class="control is-expanded has-icons-left">
                            <input type="text" name="parti" id="parti" class="input"
                                placeholder="Parti politique ou Indépendant">
                            <span class="icon is-small is-left" required>
                                <i class="fa-solid fa-people-group"></i>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label for="rue" class="label">Rue</label>
                        <p class="control is-expanded has-icons-left">
                            <input type="text" name="rue" id="rue" class="input" placeholder="Rue (Avenue)" required>
                            <span class="icon is-small is-left">
                                <i class="fa-solid fa-home"></i>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="column is-one-fifth">
                    <div class="field">
                        <label for="numero" class="label">Numéro</label>
                        <p class="control is-expanded has-icons-left">
                            <input type="text" name="numero" id="numero" class="input" placeholder="Numéro" required>
                            <span class="icon is-small is-left">
                                <i class="fa-solid fa-hashtag"></i>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label for="quartier" class="label">Quartier</label>
                        <p class="control is-expanded has-icons-left">
                            <input type="text" name="quartier" id="quartier" class="input" placeholder="Quartier"
                                required>
                            <span class="icon is-small is-left">
                                <i class="fa-solid fa-map-location"></i>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label for="commune" class="label">Commune</label>
                        <p class="control is-expanded has-icons-left">
                            <input type="text" name="commune" id="commune" class="input" placeholder="Commune" required>
                            <span class="icon is-small is-left">
                                <i class="fa-solid fa-map-location-dot"></i>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label for="ville" class="label">Ville de résidence</label>
                        <p class="control is-expanded has-icons-left">
                            <input type="text" name="ville" id="ville" class="input" placeholder="Ville de résidence"
                                required>
                            <span class="icon is-small is-left">
                                <i class="fa-solid fa-city"></i>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label for="pays" class="label">Pays de résidence</label>
                        <p class="control has-icons-left">
                            <span class="select">
                                <select name="pays" id="pays">
                                    <option value="" selected>Pays--------------</option>
                                    <?php while($rows = $rep->fetch()):; ?>
                                    <option value="<?php echo $rows[5]; ?>">
                                        <?php echo $rows[5]; ?>
                                    </option>
                                    <?php endwhile; ?>
                                </select>
                            </span>
                            <span class="icon is-small is-left">
                                <i class="fas fa-globe"></i>
                            </span>
                        </p>
                    </div>
                </div>
            </div><br>
            <div class="columns">
                <div class="column">
                    <input type="submit" value="Valider" class="button"
                        style="color:#1C3D59;background-color:#D8E6F2;width:250px">
                </div>
            </div>
        </form>
        <?php
            $request = "";
            /*if(isset($_POST['telephone_2']) or isset($_POST['telephone_3'])){
            $request = "insert into candidat(nom,postnom,prenom,email,telephone_1,telephone_2,telephone_3,sexe,lieu_de_naissance,date_de_naissance,nationalite,profession,parti_politique,rue,numero,quartier,commune,ville,pays) values (:nom,:postnom,:prenom,:email,:tel1,:tel2,:tel3,:sexe,:lieu_naiss,:date_naiss,:nationalite,:profession,:parti,:rue,:numero,:quartier,:commune,:ville,:pays)";
            } 
            else{
            
            }*/
            $request = "insert into candidat(nom,postnom,prenom,email,telephone_1,sexe,lieu_de_naissance,date_de_naissance,nationalite,profession,parti_politique,rue,numero,quartier,commune,ville,pays) values (:nom,:postnom,:prenom,:email,:tel,:sexe,:lieu_naiss,:date_naiss,:nationalite,:profession,:parti,:rue,:numero,:quartier,:commune,:ville,:pays)";
            $insert=$db->prepare($request);
            if(!isset($_POST['nom']) && !isset($_POST['postnom']) && !isset($_POST['prenom']) && !isset($_POST['email']) && !isset($_POST['telephone_1']) && !isset($_POST['sexe']) && !isset($_POST['lieu_naissance']) && !isset($_POST['date_naissance']) && !isset($_POST['nationalite']) && !isset($_POST['profession']) && !isset($_POST['parti']) && !isset($_POST['rue']) && !isset($_POST['numero']) && !isset($_POST['quartier']) && !isset($_POST['commune']) && !isset($_POST['ville']) && !isset($_POST['pays'])){
                echo '';
            }
            else{
                if(
                $insert->execute(
                    array(
                        'nom' => $_POST['nom'],
                        'postnom' => $_POST['postnom'],
                        'prenom' => $_POST['prenom'],
                        'email' => $_POST['email'],
                        'tel' => $_POST['telephone_1'],
                        'sexe' => $_POST['sexe'],
                        'lieu_naiss' => $_POST['lieu_naissance'],
                        'date_naiss' => $_POST['date_naissance'],
                        'nationalite' => $_POST['nationalite'],
                        'profession' => $_POST['profession'],
                        'parti' => $_POST['parti'],
                        'rue' => $_POST['rue'],
                        'numero' => $_POST['numero'],
                        'quartier' => $_POST['quartier'],
                        'commune' => $_POST['commune'],
                        'ville' => $_POST['ville'],
                        'pays' => $_POST['pays'],
                    )
                )
                ){
                    $success_message = 'Le candidat est enregistré avec succès';
                }
                else{
                    $error_message = 'Echec enregistrement du candidat';
                }
                
        }
        if (strlen($error_message) > 0) { ?>
                <div class="notification is-danger is-light">
                    <h2 class="title"><strong><i class="fa-solid fa-circle-exclamation"></i> Attention !</strong></h2>
                    <?php echo $error_message; ?>
                </div>
        <?php }

        if (strlen($success_message) > 0) { ?>
                <div class="notification is-success is-light">
                    <h2 class="title"><strong><i class="fa-solid fa-badge-check"></i> Succès !</strong></h2>
                    <?php echo $success_message; ?>
                </div>
        <?php }
        
        ?>
    </div>
</body>
