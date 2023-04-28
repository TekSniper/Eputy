<?php 
session_start();
if($_SESSION['profile']=='Administrateur'){
    include 'shared/header-admin.php';
}
 else{
    include 'shared/header.php';
 }

?>
<div class="container">

</div>