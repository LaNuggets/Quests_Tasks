# Gestion d'Habitudes de Groupe

## Description du Projet
Ce projet est une application de gestion d'habitudes collaboratives pour les groupes. Chaque utilisateur peut rejoindre ou créer un groupe, définir des habitudes (tâches récurrentes), et suivre leur réalisation. L'objectif est de motiver les membres en attribuant un score au groupe selon l'accomplissement ou l'omission des habitudes.

## Fonctionnalités Principales
- Inscription et connexion des utilisateurs.
- Gestion de profil utilisateur (pseudo, email, mot de passe, photo de profil).
- Gestion de groupe (création, ajout de membres, affichage des membres).
- Création et suivi des habitudes (description, difficulté, échéance, statut d'accomplissement, cible : individuelle ou groupe).
- Réduction de points pour le groupe si une habitude n'est pas réalisée à temps.

## Technologies Utilisées
- Symfony
- PHP
- MySQL

## Utilisation
- Accédez à `http://127.0.0.1:8000` pour voir l'application.
- Inscrivez-vous ou connectez-vous.
- Complétez votre profil (ajout de photo optionnel).
- Créez un groupe ou rejoignez-en un existant.
- Ajoutez des habitudes pour vous ou pour le groupe avec :
  - Texte
  - Difficulté (très facile, facile, moyen, difficile)
  - Périodicité (quotidienne, hebdomadaire)
  - Cible (individuel ou groupe)
  - Date d'échéance
  - Statut d'accomplissement

## Fonctionnement des Pénalités
- Chaque habitude non réalisée avant la date d'échéance fait perdre des points au groupe :
  - Très facile : -1 point
  - Facile : -2 points
  - Moyen : -5 points
  - Difficile : -10 points

## Structure Principale
```
src/
├── Controller/
│   ├── ProfilController.php
│   ├── GroupeController.php
│   └── HabitudeController.php
├── Entity/
│   ├── Utilisateur.php
│   ├── Groupe.php
│   └── Habitude.php
├── Form/
│   ├── UtilisateurType.php
│   ├── ProfilType.php
│   └── HabitudeType.php
```
## Conseils Pratiques
- Pour pouvoir faire fonctionner le projet il vous faudra un environnement de développement PHP complet. Installer au choix l'un des trois.
[XAMPP](https://www.apachefriends.org/download.html)
[WAMP](https://www.wampserver.com/)
[MAMP](https://www.mamp.info/en/windows/)
- Avant de Lancer le projet il faut bien s'assurer d'avoir toute les dépendances, pour ce faire aller à la racine du projet et faite la commande :
```composer install```
- Penser à exécuter les migrations après chaque modification de l'entité :
  ```bash
  php bin/console make:migration
  php bin/console doctrine:migrations:migrate
