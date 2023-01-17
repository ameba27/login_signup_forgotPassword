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
