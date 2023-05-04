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
            Création Edition des élections
        </h3>
        <form action="" method="post" class="box">
            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label for="edition" class="label">Edition</label>
                        <p class="control is-expanded has-icons-left">
                            <input class="input" type="text" placeholder="Edition (Ex: Ed. 2018)" id="edition" name="edition" required>
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