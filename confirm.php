<?php
session_start();
require './database/lien.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    
</head>
<body>
    <div class="contenaire">
    <?php
    $_SESSION['email'];
     $email =  $_SESSION['email'];
    $_SESSION['clef'];
    $key = $_SESSION['clef'];

    $req= $bd->prepare("SELECT * FROM users WHERE email = ? AND clef = ?");
    $req->execute(array($email, $key));

    if($req->rowCount() == 1){
        $take = $req->fetch();
        if($take['confirm'] == 0){
            $change = $bd->prepare("UPDATE users SET confirm = 1 WHERE email = ? AND clef = ?");
            $change->execute(array($email, $key));
            ?>
            <p id="conteneur" class="alert alert-success">
               Félicitation! Votre compte a été bien confirmé. Cliquer <a href="./login.php">ici</a> pour vous connecter.
            </p>
            <?php
        }else {
            ?>
            <p id="conteneur" class="alert alert-primary">
            Votre compte a été déjà confirmé. Cliquer <a href="./login.php">ici</a> pour vous connecter.
            </p>
            <?php
        }

    }else{
        ?>
        <p id="conteneur" class="alert alert-danger">
           L'utilisateur n'existe pas. 
        </p>
    <?php
    }

    ?>
    </div>
</body>
</html>