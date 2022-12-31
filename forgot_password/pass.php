<?php
session_start();
require '../database/lien.php';

$_SESSION['email'];
$email= $_SESSION['email'];

$sms="";
if(isset($_POST)){
    

    if(isset($_POST['pass']) && !empty($_POST['pass']) && isset($_POST['pass1']) && !empty($_POST['pass1'])){
        $pass= sha1($_POST['pass']);
        $pass1= sha1($_POST['pass1']);

        if($pass == $pass1){
            $req = $bd->prepare("UPDATE users SET pass = ? WHERE email = ? ");
            $req->execute(array($pass, $email));
            header('Location: ../login.php'); 
        }else{
            $sms = "<p style=\"text-align: center\" class=\"alert alert-danger\">Mots de passe non conformes</p>"; 
        }

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./style/forgot.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <form action="" method="POST" class="detenteur">
        <h3>Mot de Passe Oublié</h3>
        <h4>Modifiez votre mot de passe</h4>
        <?= $sms?>
        <input type="password" name="pass" class="form-control" placeholder="Mot de passe">
        <input type="password" name="pass1" class="form-control" placeholder="Confirmer le mot de passe ">
        <input type="submit" class="btn w3-green" value="Suivant">
        <div id="dernier">
            <a href="code.php"><input type="button" class="btn w3-blue" value="Retour"></a>
            <a href="pass.php"><input type="button" class="btn w3-purple" value="Restaurer"></a>
        </div>
    </form>
</body>
</html>