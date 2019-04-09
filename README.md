# DreamTeach

### Configurer la base de données depuis le projet Symfony

Modifier le fichier .env (à la racine du projet), et configurer la ligne `DATABASE_URL`

### Mettre les dépendances du projet à jour

`composer install`

### Créer la base de données en fonction des entités présentes dans le projet

`php bin/console make:migration` puis `php bin/console doctrine:migrations:migrate`

### Mettre à jour la base de données en fonction des entités présentes dans le projet

`php bin/console doctrine:schema:update --force`

### Lancement du serveur en console

`php -S localhost:8000 -t public`

### Créer les entités depuis une base de données existante 

`php bin/console doctrine:mapping:import 'App\Entity' annotation --path=src/Entityclear`

### Générer les getters et setters des entités

`php bin/console make:entity --regenerate App`

### La super doc à lire à la place de demander toutes les 3 secondes comment fonctionne telle ou telle fonction :heart:

https://symfony.com/doc/current/index.html#gsc.tab=0 

### Merci de mettre des gitmoji sur vos messages de commit

:art: Pour des changement de front 
:ambulance: pour les bugs critique
:zap: Ajout d'une petite fonctionnalité 
:construction: WIP

https://gitmoji.carloscuesta.me/

Courage :kissing_heart:
