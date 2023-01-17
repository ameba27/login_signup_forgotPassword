# login_signup_forgotPassword
Le projet a pour but de tester le systéme de connexion, de déconnexion et de réinialisation de mot de passe avec quelques astuces comme l'envoi de message de confirmation après inscription ou encore celui d'un code afin de changer un mot de passe.  Pour réaliser un tel projet, trois étapes ont suffi :
  - La première étape constitue la création d'une base de donnée exemple.sql, création du dossier database et des pages suivantes : lien.php, index.php et login.php.
  - La deuxième étape qui est la suite de la première constitue la création  des pages suivantes: profil.php et deconnexion.php.
  - La troisième et dernière étape c'est celle de la création de confirm.php et du dossier forgot_password et ses composants.

NB:  dans chaque étape le CSS a été utilisé ainsi que le framework BOOTSTRAP. En outre, dans les première et dernière étapes le système PHPMailer est aussi utilisé.

# Première étape
Dans cette étape, la page index.php, suivie de la création de la base de données importée dans exemple.sql et la connexion à cette base de données aux différents formulaires grâce à la création de la page lien.php se trouvant dans le dossier database sont les éléments de notre première phase.

- Phase 1: index.php, exemple.sql et lien.php
   - index.php :
Dans la page index se trouve le formulaire d'inscription fait avec du htlm, css et du boostrap et le script permettant d'envoyer les données dans la base de données précisément dans la table "users".

       Exemple: formulaire d'inscription

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
                <input type="password" name="pass1" placeholder="Confirmer votre mot de passe" class="form-control      input">
                <input type="submit" class="btn btn-success">
            </form>


        Exemple : le script  d'insertion des données et d'envoi de message de confirmation

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
                i           f($pass == $pass1){
                                if(filter_var($email,FILTER_VALIDATE_EMAIL)){
                                    $select = $bd->prepare("SELECT * FROM users WHERE email = ?");
                                    $select->execute(array($email));
                        i           f($select->rowCount() == 0){
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


   - exemple.sql :
Afin de pouvoir stocker et gérer les données, la base de données "exemple" est créée avec comme première table "users" qui recevra les données entrées à partir du formulaire d'inscription.

        Exemple : base de données "exemple" et table "users" 

            -- phpMyAdmin SQL Dump
            -- version 5.2.0
            -- https://www.phpmyadmin.net/
            --
            -- Hôte : 127.0.0.1
            -- Généré le : sam. 31 déc. 2022 à 11:03
            -- Version du serveur : 10.4.25-MariaDB
            -- Version de PHP : 8.1.10

            SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
            START TRANSACTION;
            SET time_zone = "+00:00";


            /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
            /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
            /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
            /*!40101 SET NAMES utf8mb4 */;

            --
            -- Base de données : `exemple`
            -- Structure de la table `users`
            --

            CREATE TABLE `users` (
            `id` int(11) NOT NULL,
            `nom` varchar(200) NOT NULL,
            `prenom` varchar(200) NOT NULL,
            `email` varchar(700) NOT NULL,
            `genre` varchar(100) NOT NULL,
            `pass` varchar(700) NOT NULL,
            `clef` int(7) NOT NULL,
            `confirm` int(1) NOT NULL,
            `date_inscription` date NOT NULL DEFAULT current_timestamp()
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            --


   - lien.php :
Dans le but créer une connexion à la base de donnée pour manipuler les données et de voir fonctionner les formulaires lien.php se trouvant dans le dossier database est mise en place. Dans cette page est mise le script permettant de se connecter à la base de données "exemple".

        Exemple : lien.php

            $bd = new PDO('mysql:host=localhost; dbname=exemple', 'root', '');
            $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        

- Phase 2: login.php
   - login.php: 
Dans cette page on retrouve le formulaire permettant aux utilisateurs inscrits d'accéder à leur profil. Pour ce faire les données parmi elles l'email et le mot de passe qu'ils ont renseigné à partir du formulaire d'inscription vont être utiliées par eux pour accéder à leur profil.

        Exemple: formulaire

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


        Exemple : script

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
                                $_SESSION['email'] = $mail;
                                $_SESSION['pass'] = $pass;
                                $_SESSION['id'] = $req->fetch()['id'];

                                header('Location: profil.php');

            

                            }else{
                                $message= "<p style=\"width: 100%; text-align: center\" class=\"alert alert-danger\">Mot de passe ou adresse email incorrect</p>";
                            }
                        }
            
                    }
