<?php
session_start();
require './database/lien.php';
require "./phpMailer/mail.php";

 $message ="";
 if(isset($_POST)){
    if(isset($_POST['nom']) && !empty($_POST['nom']) 
    && isset($_POST['prenom']) && !empty($_POST['prenom']) 
    && isset($_POST['email']) && !empty($_POST['email']) 
    && isset($_POST['genre']) && !empty($_POST['genre']) 
    && isset($_POST['pass']) && !empty($_POST['pass'])
    && isset($_POST['pass1']) && !empty($_POST['pass1'])){
        $nom = strip_tags($_POST['nom']);
        $prenom = strip_tags($_POST['prenom']);
        $email = strip_tags($_POST['email']);
        $genre = strip_tags($_POST['genre']);
        $pass = sha1($_POST['pass']);
        $pass1 = sha1($_POST['pass1']);

        $key = rand(10000, 99999);
        

        $carac_nom = strlen($nom);
        $carac_prenom = strlen($prenom);


        if($carac_nom > 1){
            if($carac_prenom > 2){
                if($pass == $pass1){
                    if(filter_var($email,FILTER_VALIDATE_EMAIL)){
                        $select = $bd->prepare("SELECT * FROM users WHERE email = ?");
                        $select->execute(array($email));
                        if($select->rowCount() == 0){
                            $req = $bd->prepare("INSERT INTO users (nom, prenom, email, genre, pass, clef) VALUES (?,?,?,?,?,?)");
                            $req->execute(array($nom, $prenom, $email, $genre, $pass, $key));

                            $_SESSION['email'] = $email;
                            $_SESSION['prenom'] = $prenom;
                            $_SESSION['nom'] = $nom;
                            $_SESSION['genre'] = $genre;
                            $_SESSION['pass'] = $pass;
                            $_SESSION['clef'] = $key;

                            $head = "MIME-Version: 1.0\r\n";
                            $head = "Content-Type: text/html; charset=UTF-8\r\n";
                            $head = "Content-Transfer-Encoding: 8bit";

                            $sms = " <html>
                            <body>
                                <div;>
                                <h3>Salut $prenom $nom</h3>
                                <p>Merci de votre inscription, veuillez la <a href=\"http://localhost/login_singup_forgotPassword/confirm.php?mail=".urlencode($email)."&key=".$key."djfdklsk\">confirmer</a> afin de pouvoir accéder à votre compte</p><br>
                                <br><br>
                                Cordialement 
                                </div>
                            </body>
                            </html>";
                            

                            send_mail($email, 'Confirmation Email', $sms, $head);
                              
                            
                         $message ="<p class=\"alert alert-success\" style=\"text-align: center;\">Inscription réussie. Veuillez vérifier votre compte email un message de confirmation vous a été envoyé. </p>";

                           
                           
                    }else{
                        $message ="<p class=\"alert alert-danger\">Votre adresse email existe déjà !</p>"; 
                    }
                    }else {
                        $message ="<p class=\"alert alert-danger\">Votre email est invalide</p>"; 
                    }

                }else{
                    $message ="<p class=\"alert alert-danger\">Vos mots de passe ne sont pas conformes </p>"; 
                }
            }else{
                $message ="<p style=\"text-align: center\" class=\"alert alert-danger\">Veuillez entrer votre prénom</p>"; 
            }
        }else{
            $message ="<p style=\"text-align: center\" class=\"alert alert-danger\">Veuillez entrer votre nom</p>"; 
        }
    }
 }
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
           <?= $message ?>
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