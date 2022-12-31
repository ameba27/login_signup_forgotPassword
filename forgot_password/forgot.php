<?php
session_start();
require '../database/lien.php';
require "../phpMailer/mail.php";
$sms ="";
if($_POST){
    if(isset($_POST['email']) && !empty($_POST['email'])){
        $mail = $_POST['email'];
        if(filter_var($mail, FILTER_VALIDATE_EMAIL)){
            $select= $bd->prepare("SELECT * FROM users WHERE email = ?");
            $select->execute(array($mail));

            if($select->rowCount() > 0){
                $code = rand(10000, 99999); // Il va générer des chiffres aléatoires utilisés comme code
                $time = time() + (60 * 3); // Si le temps dépasse 3 minutes alors $code expire;

                $req = $bd->prepare("INSERT INTO codes (email, code, time_expire) VALUES (?,?,?)");
                $req->execute(array($mail, $code, $time));
                header('Location: code.php');

                $_SESSION['code'] = $code;
                $_SESSION['email'] = $mail;
                $_SESSION['time_expire'] = $time;
                
                $head = "MIME-Version: 1.0\r\n";
                $head .= "Content-Type: text/htlm, charset: UTF-8\r\n";
                $head .= "Content-Transfer-Encoding: 8bit";
                 $sujet="Modification de Mot de passe"; 
                    
                 
                $message = " 
                <htlm>
                <body>
                    <div>
                     <p style=\"font-size: 1.2em\">Cher utilisateur voici le code qui vous permettra de modifier votre mot de passe : <span style=\"font-size: 1.3em\"><strong>$code</strong></span></p>
                    </div>
                </body>
                </htlm>"; 

                send_mail($mail, $sujet, $message, $head);
               
            } 
        }else {
            $sms ="<p style=\"text-align: center;\" class=\"alert alert-danger\">Email invalide</p>"; 
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
    <form action="" method="POST">
        <h3>Mot de Passe Oublié</h3>
        <h4>Entrez votre adresse email</h4>
        <?= $sms ?>
        <input type="email" name="email" class="form-control" placeholder="Email">
        <input type="submit" class="btn w3-black" value="Suivant">
    </form>
</body>
</html>
