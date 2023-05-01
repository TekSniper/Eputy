<?php 
session_start();
if($_SESSION['profile']=='Administrateur'){
    include 'shared/header-admin.php';
}
 else{
    include 'shared/header.php';
    header('Location: score.php');
 }

?>
<div class="container">

</div>