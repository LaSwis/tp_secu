

login.php :

login.php est un script PHP qui permet aux utilisateurs de se connecter à une application Web. Il fournit une interface où les utilisateurs peuvent saisir leur nom d'utilisateur et leur mot de passe ou créer un compte.

Exigences :
    -PHP 
    -Une base de données pour stocker les informations des utilisateurs (MySQL)
    -Apache-Server

Bouton :
    LogIn : pour se connecter 
    Reset : pour réintialiser  les champs
    SignUp : pour créez un compte

Caractéristiques:
    -Authentification de l'utilisateur à l'aide d'un nom d'utilisateur et d'un mot de passe
    -Gestion de session : le programme utilise la fonction "session_start()"" pour démarrer une nouvelle session s'il n'en existe pas déjà une, 
    et stocke un jeton CSRF généré aléatoirement dans la variable $_SESSION pour des raisons de sécurité.
    -Cryptage des mots de passe à l'aide d'une fonction de hachage ("password_hash")
    -Validation des entrées pour empêcher les attaques par injection SQL
    -Gestion des erreurs pour les tentatives de connexion incorrectes

Comment utiliser :
    -Créez une base de données pour stocker les informations des utilisateurs.
    -Mettez à jour la configuration de la base de données dans Login.php (par exemple, le nom de la base de données, le nom d'utilisateur et le mot de passe).
    -Placez le contenu du répertoire "tp_secu-main.zip" sur votre serveur Web et accédez-y via votre navigateur.
    -Accedez a "login.php"
    -Créez un compte a l'aide du bouton "Sign Up" 
    -Entrez votre nom d'utilisateur et votre mot de passe et cliquez sur le bouton "LogIn".

Remarques : 
Le script suppose que la base de données "db_users" contient une table nommée "users" avec les colonnes suivantes : "un", "pw" .


create_account.php:

create_account.php est un script PHP qui permet aux utilisateurs de créer un nouveau compte. Il fournit une interface où les utilisateurs peuvent saisir leur nom d'utilisateur et leur mot de passe pour créer un nouveau compte.

Bouton :
    Create : pour valider l'insription
    Reset : pour réintialiser  les champs
    Cancel : pour annuler

Caractéristiques:
    -Enregistrement de l'utilisateur à l'aide d'un nom d'utilisateur et d'un mot de passe
    -Gestion de session pour maintenir le statut de connexion de l'utilisateur
    -Validation des entrées pour empêcher les attaques par injection SQL
    -Cryptage des mots de passe à l'aide d'une fonction de hachage 
    -Gestion des erreurs pour les entrées non valides et les comptes en double


