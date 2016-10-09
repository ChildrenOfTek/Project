Etapes d'installation
=====================
Si accès SSH
------------

1. composer install
    * A la génération du parameters.yml,
    entrer les informations relatives au serveur
    et a la base de données de l'hebergement
        * database_host: **Adresse du SQL serveur**
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
3. php app/console doctrine:fixtures:load
4. php app/console assets:install
5. composer dump-autoload --optimize
6. 