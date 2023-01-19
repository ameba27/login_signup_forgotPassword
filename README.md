# login_signup_forgotPassword
Le projet a pour but de tester le systéme de connexion, de déconnexion et de réinialisation de mot de passe avec quelques astuces comme l'envoi de message de confirmation après inscription ou encore celui d'un code afin de changer un mot de passe.  Pour réaliser un tel projet, trois étapes ont suffi :
  - La première étape constitue la création d'une base de donnée exemple.sql, création du dossier database et des pages suivantes : lien.php, index.php, confirm.php et login.php.
  - La deuxième étape qui est la suite de la première constitue la création  des pages suivantes: profil.php et deconnexion.php.
  - La troisième et dernière étape c'est celle de la création du dossier forgot_password et ses composants et de confirm.php.

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
        

- La page confirm.php :
Après avoir terminé l'inscription, un message est envoyé l'adresse email de l'utilisateur qui vient de s'inscrire pour confirmer son inscription afin qu'il puisse accéder à son profil en passant par la page login.php.

        Exemple : confirm.php

                        session_start();
                        require './database/lien.php';


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


# Deuxième étape
Dans cette étape qui est la suite de la précédente est constituée de la page profil.php et de deconnxeion.php.
     
- La page profil.php :
Cette page est celle que l'on doit accéder après avoir entré nos données sur le formulaire de login.php. Ce qui est intéressant ici est le fait de mettre les données dans la variable globale $_SESSION de la page login.php à celle de profil.php qui a permis l'accès à l'information de la première page à la seconde susmentionnées.

        Exemple: La structure de la page 

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


        Exemple: script 

                    // Commencer la session ou ouvrir la session.
                    session_start();
                    require './database/lien.php';

                    // Si les données entrées par l'utilisateur sont différentes de celles de la session alors revenir sur la page login.php
                    // Sinon accéder au profil (à la page profil.php).
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


- La page deconnexion.php : 
Cette page contient le script qui permet à l'utilisateur de sortir de son profil c'est-à-dire de détruire la session ou encore de la quitter pour être redirigé vers la page login.php.

    Exemple: deconnexion.php

                    session_start();
                    $_SESSION = array();
                    session_destroy();
                    header('Location: ./login.php?fdkflrfpfrfglktd');


# Troisième étape 
Cette dernière étape fait référence au mot de passe oublié. Pour créer ce système, trois (3) pages ont été utilisées (forgot.php, code.php et pass.php) en plus des pages CSS. Il faut savoir aussi qu'une autre table a été créée pour ce système. Il sagit de la table suivante:

    Exemple: exemple.sql

                    CREATE TABLE `codes` (
                    `id` int(11) NOT NULL,
                    `email` varchar(400) NOT NULL,
                    `code` int(5) NOT NULL,
                    `time_expire` int(11) NOT NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
                    

- La page forgot.php : 
Cette page a un formulaire qui a un champs permettant de recueillir l'adresse email qui recevera un message ayant un code dont l'utilisateur pour utiliser dans la page suivante. Pour cela fonctionne, c'est le script php et le système PHPMailer qui sont utilisés. En effet, quelques restrictions ont été mises afin de sécuriser et d'éviter les adresses emails ne se trouvant pas dans notre base de données. Ainsi lorsque l'utilisateur utilise une adresse email valide dans le formulaire, il sera dirigé vers une autre page qui a un autre formulaire. 

        Exemple: formulaire

                    <form action="" method="POST">
                        <h3>Mot de Passe Oublié</h3>
                        <h4>Entrez votre adresse email</h4>
                        <?= $sms ?>
                        <input type="email" name="email" class="form-control" placeholder="Email">
                        <input type="submit" class="btn w3-black" value="Suivant">
                    </form>


        Exemple :script PHP

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

                
- La page code.php :
Elle est la page dont l'utilisateur est redirigé lorsqu'il entre son email. C'est dans cette page contenant un formulaire avec un champs dans lequel il (l'utilisateur) mettra le code reçu sur son compte email. Pour ce faire, comme d'habitude un script php pour que le formulaire fonctionne et que l'utilisateur soit redirigé vers une autre page. 

            Exemple: formulaire

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

            
            Exemple : script

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


- La page pass.php :
Après avoir renseigné le code reçu, l'utilisateur est redirigé dans cette page nommée pass.php du fait que c'est ici que la modification du mot de passe se fera. Dans cette partie se trouve un formulaire avec deux champs dans lesquels il sera renseigné le nouveau mot de passe.

            Exemple : formulaire
                
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

            Exemple: script 

                        session_start();
                        require '../database/lien.php';

                        $_SESSION['email'];
                        $email= $_SESSION['email'];

                        $sms="";
                        if(isset($_POST)){
    

                            if(isset($_POST['pass']) && !empty($_POST['pass']) && isset($_POST['pass1']) && !empty($_POST['pass1'])){
                                $pass= sha1($_POST['pass']);
                                $pass1= sha1($_POST['pass1']);

                                // Si les mots de passe sont conformes
                                if($pass == $pass1){
                                    // Modifier le mot de passe
                                    $req = $bd->prepare("UPDATE users SET pass = ? WHERE email = ? ");
                                    $req->execute(array($pass, $email));
                                    header('Location: ../login.php'); 
                                }else{
                                    $sms = "<p style=\"text-align: center\" class=\"alert alert-danger\">Mots de passe non conformes</p>"; 
                                }

                            }
                        }



NB: Le CSS n'est pas mentionné car facile à faire. Par contre toutes informations sur le système d'envoi de message par email ,PHPMailer, il faut aller sur le repository sendMail.