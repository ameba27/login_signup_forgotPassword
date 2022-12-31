<?php
session_start();
require './database/lien.php';


$message="";
if(isset($_POST)){
    $mail;
    if(isset($_POST['email']) && !empty($_POST['email'])
    && isset($_POST['pass']) && !empty($_POST['pass'])){
    $mail = $_POST['email'];
    $pass = sha1($_POST['pass']);
    $req = $bd->prepare("SELECT * FROM users WHERE email = ? AND pass = ?");
    $req->execute(array($mail, $pass));

        if($req->rowCount() > 0){
            $_SESSION['nom'];
            $nom = $_SESSION['nom'];
            $_SESSION['prenom'];
            $prenom = $_SESSION['prenom'];
            $_SESSION['genre'];
            $genre = $_SESSION['genre'];
            $_SESSION['pass'] = $pass;
            $_SESSION['pass'] = $pass;
            $_SESSION['id'] = $req->fetch()['id'];

            header('Location: profil.php');

            

        }else{
            $message= "<p style=\"width: 100%; text-align: center\" class=\"alert alert-danger\">Mot de passe ou adresse email incorrect</p>";
        }
    }
            
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./style/login.css">
    <link rel="stylesheet" href="./database/W3CSS/fontawesome/css/all.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <form action="" method="POST">
        <h3>LOGIN</h3>
            <?= $message?>
        <div class="form-floating input">
        <input type="email"class="form-control" name="email" placeholder="Email">
        <label for="Email"><i class="fa fa-user"></i> Email</label>
        </div>
        <div class="form-floating input">
        <input type="password"class="form-control" name="pass" placeholder="Mot de passe">
        <label for="Password"><i class="fa fa-lock"></i> Mot de passe</label>
        </div>
        <input type="submit" class="btn w3-black" value="Se connecter" id="bouton">
        <div id="lien">
           <a href="index.php">Sign up</a>
           <a href="./forgot_password/forgot.php">Mot De Passe Oublié ?</a>
        </div>
    </form>
</body>
</html>