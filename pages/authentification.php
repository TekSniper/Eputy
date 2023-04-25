<!DOCTYPE html>
<html lang="en">
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
                                    <input type="text" name="identifiant" id="identifiant" class="input" placeholder="Identifiant" focused>
                                    <span class="icon is-small is-left">
                                        <i class="fa-solid fa-user"></i>
                                    </span>
                                </div>
                                </div><div class="field">
                                    <div class="label" for="pwd">Mot de passe</div>
                                    <div class="control has-icons-left">
                                        <input type="password" name="pwd" id="pwd" class="input" placeholder="Mot de passe">
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
                    </div>
                </div>
            </div>
        </div>        
    </section>
</body>
</html>