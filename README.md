### Lancement de l'application

#### Préréquis
- Git

- Xampp/Mamp/Lamp ou Docker

- php

- composer

- Cloner le dépôt depuis votre dossier de travail avec la commande `git clone https://github.com/Joel-Henri-NGOUBE/MyBank_backend`


#### En local sans Docker

Vous devez:

- Activer les ports d'Apache et de Mysql qui seront utiles pour le backend

- Vous déplacer vers le dossier cloné

- Installer les dépendances grâce à la commande `composer install`

- Pour lancer l'application, vous devez exécuter la commande `php -S 127.0.0.1:8000 -t public`

#### Avec Docker

Vous devez:

- Activer les ports d'Apache et de Mysql qui seront utiles pour le backend

- Vous déplacer vers le dossier cloné

- Réaliser la commande `docker build -t api .`

- Créer un container et le mettre en marche avec la commande `docker run --name front -p 8000:8000 symfony-api`

#### Avec Docker-compose

Vous devez:

- Exécuter la commande `docker compose up -d`

L'API écoute les requêtes à l'adresse: http://127.0.0.1:8000

### Documentation

La documentation de l'API est disponible à l'adresse: `http://127.0.0.1:8000/api`