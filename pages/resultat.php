<?php
session_start();
$error_message = "";
$success_message = "";
include_once 'shared/DatabaseConnection.php';


if ($_SESSION['profile'] == 'Administrateur') {
    include 'shared/header-admin.php';
} else {
    include ('shared/header.php');
    header('Location: score.php');
}

$db = new DatabaseConnection();
$cnx = $db->GetConnectionString();
?>

<body>
    
</body>