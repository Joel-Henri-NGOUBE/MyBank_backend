### Lancement de API

#### Préréquis
- Git

- Xampp/Mamp/Lamp ou Docker

- php

- composer

- OpenSSL disponible à cette adresse: `https://slproweb.com/products/Win32OpenSSL.html`

- Cloner le dépôt depuis votre dossier de travail avec la commande `git clone https://github.com/Joel-Henri-NGOUBE/MyBank_backend`


#### En local sans Docker-Compose

Vous devez:

- Activer les ports d'Apache et de Mysql qui seront utiles pour le backend

- Vous déplacer vers le dossier cloné

- Installer les dépendances grâce à la commande `composer install`

- Générer une paire de clé pour la création des tokens avec la commande: `php bin/console lexik:jwt:generate-keypair`. C'est pour cette étape qu'il vous faut au préalable OpenSSL.

- Créer la base de données avec la commande: `php bin/console doctrine:database:create`

- Créer les migrations de la base de données avec la commande: `php bin/console make:migration`

- Exécuter les migrations de la base de donées avec la commande: `php bin/console doctrine:migrations:migrate`

- Pour lancer l'application, vous devez exécuter la commande `php -S 127.0.0.1:8000 -t public`

##### Tests de l'API

Pour réaliser les tests sur les méthodes et les routes de l'API, vous devez:

- Créer la base de données dans l'environnement de test avec la commande: `php bin/console doctrine:database:create --env=test`

- Si des modifications ont été effectuées dans les entités, créer de nouvelles migrations de la base de données avec la commande: `php bin/console make:migration`

- Exécuter les migrations de la base de donées avec la commande: `php bin/console doctrine:migrations:migrate --env=test`

- Réaliser l'exécution des tests avec la commande `./vendor/bin/phpunit tests`

#### Avec Docker-Compose

Vous devez:

- Exécuter la commande `docker compose up -d`

L'API écoute les requêtes à l'adresse: http://127.0.0.1:8000

### Documentation

La documentation de l'API est disponible à l'adresse: `http://127.0.0.1:8000/api`

*<b>NOTE</b>*

Le serveur de l'API et la base de données mettent entre <b>2 minutes</b> et <b>5 minutes</b> pour se connecter. 

#### TOUTES LES CONFIGURATIONS DOCKER ONT ETE DEFINIES DANS LE FICHIER DOCKER-COMPOSE