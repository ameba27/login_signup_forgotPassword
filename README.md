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
Dans la page index se trouve le formulaire d'inscription fait avec du htlm, css et du boostrap et le script permettant d'envoyer les données à la base de donnée précisément dans la table "users".

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

            