<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../static/css/main.css">
    <link rel="stylesheet" href="./../static/css/node_modules/bulma/css/bulma.min.css">
    <link rel="icon" href="./../static/img/Eputy Logo.ico" type="image/icon">
    
    <link href="./../static/css/fontawesome-free-6.3.0-web/css/all.css" rel="stylesheet" />
    <link href="./../static/css/fontawesome-free-6.3.0-web/css/all.min.css" rel="stylesheet" />
    <script src="./../static/js/main.js"></script>
    <title>
        Eputy App
    </title>
    <style>
        body{
            min-height: 100vh;
            background-color: #D8E6F2;
        }
    </style>
    <nav class="navbar has-shadow" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
                <img src="./../static/img/Eputy Logo.png" alt="Logo Eputy" class="navbar-item" width="50px" height="50px">
            <div class="navbar-burger" role="button" aria-label="menu" aria-expanded="false" data-target="navMenu">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div class="navbar-menu is-active" id="navMenu">
            <div class="navbar-start">
                <a href="./../index.php" class="navbar-item">Accueil</a>
                <a href="./../list_ca.php" class="navbar-item">Liste des candidats</a>
            </div>
            <div class="navbar-end">
                <div class="navbar-item">
                    <label for="" class="has-text-primary" style=""><i class="fa-solid fa-user"></i> <u><?php echo $_SESSION['id']; ?>
                        </u></label>
                </div>
                <div class="navbar-item">
                    <a href="logout.php" class="button" style="background-color:#8C3F3F; color:white">Déconnexion</a>
                </div>
            </div>
        </div>
    </nav>
</head>