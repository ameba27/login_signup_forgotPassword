<?php
 
?>
<!DOCTYPE html>
<htlm lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <form action="" method="post">
        <h3>INSCRIPTION</h3>
        <input type="text" name="nom" placeholder="Nom" class="form-control input">
        <input type="text" name="prenom" placeholder="Prénom" class="form-control input">
        <input type="email" name="email" placeholder="Email" class="form-control input">
        <select name="genre" id=""class="form-select input" multiariel-label="multiple select exemple">
            <option value="genre" selected disabled>Genre</option>
            <option value="homme">Homme</option>
            <option value="femme">Femme</option>
        </select>
        <input type="password" name="pass" placeholder="Mot de passe" class="form-control input">
        <input type="password" name="pass1" placeholder="Confirmer votre mot de passe" class="form-control input">
        <input type="submit" class="btn btn-success">
    </form>
</body>
</htlm>