-- Active: 1741886326213@@localhost@3306@esportify_db

CREATE DATABASE IF NOT EXISTS esportify_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE esportify_db;

CREATE TABLE Utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(45) NOT NULL,
    email VARCHAR(45) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('joueur', 'organisateur', 'admin') NOT NULL,
    est_valide TINYINT(1) DEFAULT 1
);

CREATE Table Evenement (
    idEvenement INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(50) NOT NULL,
    date_debut DATETIME NOT NULL,
    date_fin DATETIME NOT NULL,
    visible TINYINT(1) DEFAULT 1,
    id_organisateur INT NOT NULL,
    nb_joueurs_par_equipe INT NOT NULL DEFAULT 2,
    nb_equipes_max INT NOT NULL DEFAULT 8,
    est_commence TINYINT(1) DEFAULT 0,
    Foreign Key (id_organisateur) REFERENCES Utilisateur(id)
        ON DELETE CASCADE
);


CREATE TABLE Equipe (
    idEquipe INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL
);

CREATE TABLE InscriptionEquipe (
    idInscriptionEquipe INT PRIMARY KEY AUTO_INCREMENT,
    id_evenement INT NOT NULL,
    id_equipe INT NOT NULL,
    FOREIGN KEY (id_evenement) REFERENCES Evenement(idEvenement),
    FOREIGN KEY (id_equipe) REFERENCES Equipe(idEquipe)
);


CREATE TABLE Message (
    idMessage INT PRIMARY KEY AUTO_INCREMENT,
    contenu VARCHAR(255) NOT NULL,
    date DATETIME NOT NULL,
    id_utilisateur INT NOT NULL,
    id_evenement INT NOT NULL,
    Foreign Key (id_utilisateur) REFERENCES Utilisateur(id),
    Foreign Key (id_evenement) REFERENCES Evenement(idEvenement)
);



CREATE TABLE MembreEquipe (
  idUtilisateur INT NOT NULL,
  idEquipe INT NOT NULL,
  FOREIGN KEY (idUtilisateur) REFERENCES Utilisateur(id),
  FOREIGN KEY (idEquipe) REFERENCES Equipe(idEquipe),
  PRIMARY KEY (idUtilisateur, idEquipe)
);

CREATE TABLE MatchEquipe (
    idMatch INT AUTO_INCREMENT PRIMARY KEY,
    id_evenement INT NOT NULL,
    id_equipe1 INT NOT NULL,
    id_equipe2 INT NOT NULL,
    date_heure DATETIME,
    score_equipe1 INT DEFAULT 0,
    score_equipe2 INT DEFAULT 0,
    FOREIGN KEY (id_evenement) REFERENCES Evenement(idEvenement),
    FOREIGN KEY (id_equipe1) REFERENCES Equipe(idEquipe),
    FOREIGN KEY (id_equipe2) REFERENCES Equipe(idEquipe)
);
