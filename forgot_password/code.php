<?php
session_start();
require '../database/lien.php';
$sms="";
$_SESSION['email'];
$email = $_SESSION['email'];
$_SESSION['code'];
$code = $_SESSION['code'];


if(isset($_POST)){
    $time = time();
    if(isset($_POST['code_m']) && !empty($_POST['code_m'])){
        $code_m = $_POST['code_m'];
        $req = $bd->prepare("SELECT * FROM codes WHERE code = ?");
        $req->execute(array($code_m));
        
        
        if($code_m == $code){
            if($req->rowCount() > 0){
                $row = $req->fetch();
                if($row['time_expire'] > $time){
                    $sms = "<p style=\"text-align: center;\" class=\"alert alert-danger\">Le code a expirer</p>"; 
                }
                header('Location: pass.php');
            }
        }else {
            $sms = "<p style=\"text-align: center;\" class=\"alert alert-danger\">Le code est incorrect</p>";
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
    <form action="" method="POST" class="conteneur">
        <h3>Mot de Passe Oublié</h3>
        <h4>Entrez le code reçu par email</h4>
        <?= $sms?>
        <input type="text" name="code_m" class="form-control" placeholder="12345">
        <input type="submit" class="btn w3-black" value="Suivant">
        <div id="dernier">
            <a href="forgot.php"><input type="button" class="btn w3-blue" value="Retour"></a>
            <a href="code.php"><input type="button" class="btn w3-purple" value="Restaurer"></a>
        </div>
    </form>
</body>
</html>
