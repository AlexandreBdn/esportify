# 🎮 Esportify

**Esportify** est une plateforme web de gestion de tournois e-sport. Les utilisateurs peuvent créer ou rejoindre des équipes, s'inscrire à des tournois selon différents formats, et suivre les événements en temps réel. L'application est sécurisée et propose un système de rôles (joueur, organisateur, administrateur).

---

## 🚀 Déploiement local

### Prérequis

- PHP ≥ 7.4
- MySQL
- Serveur local (XAMPP, WAMP, MAMP, etc.)
- Navigateur web moderne

### Étapes

1. **Cloner le dépôt** :

   ```bash
   git clone https://github.com/ton-user/esportify.git

### 2.Placer le projet dans le dossier htdocs de XAMPP (ou équivalent).

### 3 Créer la base de données :

- Ouvrir phpMyAdmin.
- Créer une base appelée esportify_db.
- Importer le fichier sql/esportify_db.sql.
- Configurer la base de données dans config/database.php :

### 4 Configurer la base de données dans config/database.php 

- $pdo = new PDO('mysql:host=localhost;dbname=esportify_db', 'root', '');\

### 5 Lancer l’application dans le navigateur :

- http://localhost/esportify/pages/accueil.php


### ✨ Fonctionnalités principales :

- Création de compte, connexion sécurisée
- Gestion des rôles : joueur, organisateur, administrateur
- Création, validation et suppression de tournois
- Affichage dynamique des tournois à venir
- Création et gestion des équipes
- Inscriptions/désinscriptions aux événements
- Démarrage manuel des tournois par l’organisateur
- Restrictions selon le rôle et le temps
- Interface responsive pour mobile

### 🛡 Sécurité :

- Vérifications d’accès sur chaque page
- Restrictions selon les rôles en session ($_SESSION)
- Requêtes sécurisées via PDO + requêtes préparées
- Confirmation JavaScript pour les actions sensibles
- Protection contre les accès directs non autorisés


### 🛠 Stack technique :

- Front-end : HTML, CSS personnalisé, un petit peu de js
- Back-end : PHP natif (sans framework)
- Base de données : MySQL

### 📁 Structure du projet

esportify/
│
├── pages/                 → Pages principales (accueil, profil, événements…)
├── controllers/           → Traitement des formulaires et actions
├── includes/              → Fichiers partagés (header, footer…)
├── config/                → Connexion base de données
├── sql/                   → Dump SQL (fichier esportify_db.sql)
└── README.md              → Ce fichier

### 👤 Auteur :

- Alexandre – Projet réalisé dans le cadre de la formation Studi

### 📄 Licence :

- Projet réalisé dans un contexte éducatif. Toute reproduction ou diffusion non autorisée est interdite.