<?php
session_start();
require './database/lien.php';

if(!$_SESSION['id'] && !$_SESSION['email'] && !$_SESSION['pass']){
    header('Location: login.php');
}else {
    $req = $bd->prepare("SELECT * FROM users WHERE id = ?");
    $req->execute(array($_SESSION['id']));
    $recup = $req->fetch();

    $_SESSION['id'] =  $recup['id'];
    $_SESSION['nom'] =  $recup['nom'];
    $_SESSION['prenom'] =  $recup['prenom'];
    $_SESSION['genre'] =  $recup['genre'];
    $_SESSION['email'] =  $recup['email'];

}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./style/profil.css">
    <link rel="stylesheet" href="./database/W3CSS/fontawesome/css/all.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div id="user"class="dropdown">
    <i class="fa fa-user "></i>
    <span><?= $_SESSION['prenom']?>&nbsp;&nbsp;<?= $_SESSION['nom']?></span>
    <button data-bs-toggle="dropdown"></button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="deconnexion.php">Se déconnecter</a></li>
    </ul>
</div>
<div id="info">
<h3>INFORMATIONS</h3>
<h2><span><strong>Nom &nbsp;:</strong></span>&nbsp;<?= $_SESSION['nom']?></h2>
<h2><span><strong>Prénom &nbsp;:</strong></span>&nbsp;<?= $_SESSION['prenom']?></h2>
<h2><span><strong>Email &nbsp;:</strong></span>&nbsp;<?= $_SESSION['email']?></h2>
<h2><span><strong>Genre &nbsp;:</strong></span>&nbsp;<?= $_SESSION['genre']?></h2>
<p>Si vous voulez vous déconnecter, veuillez appuyer sur la bande de couleur jaune moutarde</p>
</div>
</body>
</html>