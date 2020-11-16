# Structure de Projet PHP

Ce projet fournit une structure de base pour le développement d'une application web en PHP. La structure est en MVCR.

## Pour commencer

- Consultez les fichiers pour prendre la connaissance de la structure du projet.
- Lisez la documentation pour vous aider à comprendre le rôle des fichiers.

## Pré-requis

- Une version PHP 7 ou plus

## Installation 

- Copiez l'ensemble du projet dans un répertoire local.(si vous utilisez WAMP, copiez les dans le répertoire de développement)
- Installez la base de données à l'aide du fichier BDD.sql qui contient les requêtes pour mettre en place les tables
- (optionnel) Changez la valeur du mode dans le constructeur de Models/Managers/AbstractManager.php pour passer sur un base de données 
locale ou distante
- (optionnel) Changez les identifiants de connexion et le nom de la base de de données dans le fichier Models/Database.php 
pour la connexion à une base de données locale ou distante
- (optionnel) Modifiez le fichier htaccess en fonction de la configuration du serveur sur lequel il tournera

## Sources utilisées 

- Un tutoriel sur les routeurs de Grafikart, accessible <a href="https://www.grafikart.fr/tutoriels/router-628">ici</a>
- Des exemples de générateurs de vues
