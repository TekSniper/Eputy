<?php
session_start();
if ($_SESSION['profile'] == 'Administrateur') {
    include 'shared/header-admin.php';
} else {
    include 'shared/header.php';
    header('Location: score.php');
}

?>

<body>
    <div class="container">
        <h3 class="title" style="color:#1C3D59; margin-top:25px">
            Identification du Candidat
        </h3>
        <form action="" class="box">
            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label for="nom" class="label">Nom</label>
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="text" placeholder="Nom" id="nom" name="nom">
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
                            <input class="input" type="text" placeholder="Post-Nom" id="postnom" name="postnom">
                            <span class="icon is-small is-left">
                                <i class="fas fa-user"></i>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label for="prenom" class="label">Nom</label>
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="text" placeholder="Prénom" id="prenom" name="prenom">
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
                            <input type="email" name="email" id="email" class="input" placeholder="lorem@exemple.com">
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
                            <input type="tel" name="phone_1" id="phone_1" class="input"
                                placeholder="Numéro de téléphone">
                            <span class="icon is-small is-left">
                                <i class="fa-solid fa-phone"></i>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="column">
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
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label for="lieu_naissance" class="label">Lieu de naissance</label>
                        <p class="control is-expanded has-icons-left">
                            <input type="text" name="lieu_naissance" id="lieu_naissance" class="input"
                                placeholder="Lieu de naissance">
                        </p>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label for="date_naissance" class="label">Date de naissance</label>
                        <p class="control is-expanded has-icons-left">
                            <input type="date" name="date_naissance" id="date_naissance" class="input">
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
                                placeholder="Nationalité">
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
                            <input type="text" name="profession" id="profession" class="input"
                                placeholder="Profession">
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
                                placeholder="Parti politique">
                            <span class="icon is-small is-left">
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
                            <input type="text" name="rue" id="rue" class="input"
                                placeholder="Rue (Avenue)">
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
                            <input type="text" name="numero" id="numero" class="input"
                                placeholder="Numéro">
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
                            <input type="text" name="quartier" id="quartier" class="input"
                                placeholder="Quartier">
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
                            <input type="text" name="commune" id="commune" class="input"
                                placeholder="Commune">
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
                        <label for="ville" class="label">Ville</label>
                        <p class="control is-expanded has-icons-left">
                            <input type="text" name="ville" id="ville" class="input"
                                placeholder="Ville de résidence">
                            <span class="icon is-small is-left">
                                <i class="fa-solid fa-city"></i>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label for="pays" class="label">Pays</label>
                        <p class="control is-expanded has-icons-left">
                            <input type="text" name="pays" id="pays" class="input"
                                placeholder="Pays de résidence">
                            <span class="icon is-small is-left">
                                <i class="fa-solid fa-globe"></i>
                            </span>
                        </p>
                    </div>
                </div>
            </div><br>
            <div class="columns">
                <div class="column">
                    <input type="submit" value="Valider" class="button" style="color:#1C3D59;background-color:#D8E6F2;width:250px">
                </div>
            </div>
        </form>
    </div>
</body>
