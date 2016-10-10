Etapes d'installation
=====================
Si accès SSH
------------

1. composer install
    * A la génération du parameters.yml,
    entrer les informations relatives au serveur
    et a la base de données de l'hebergement
        * database_host: **Adresse du serveur SQL**
        * database_port: **Port**
        * database_name: **Nom base de donnée (ex:ehs)**
        * database_user: **Nom de l'administrateur**
        * database_password: **Mot de passe de connexion**
        * mailer_transport: **smtp**
        * mailer_host: **smtp.gmail.com**
        * mailer_user: **Adresse mail choisie**
        * mailer_password: **Mot de passe de l'adrese mail**
        * secret: **Changer le token par defaut**
2. php app/console doctrine:schema:update --force
    * permet de mettre à jour la BDD
3. php app/console doctrine:fixtures:load
    * charge le lot de données pour la marche du site
4. php app/console assets:install
    * installe les assets dans le dossier web
5. composer dump-autoload --optimize
    * optimise l'autoloader de composer pour la production
6. verifier le php.ini
    * upload limit pour les fichiers
    * extension intl à decommenter