SET NAMES utf8;

DROP DATABASE IF EXISTS CAFOMABD;
CREATE DATABASE CAFOMABD CHARACTER SET 'utf8';
USE CAFOMABD;

CREATE TABLE Partenaire (
    idPart INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT
);

CREATE TABLE Formation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    type VARCHAR(100),
    description TEXT,
    contenu TEXT,
    image VARCHAR(255),
    fichiers TEXT,
    partenaire_id INT,
    FOREIGN KEY (partenaire_id) REFERENCES Partenaire(idPart) ON DELETE SET NULL
);

CREATE TABLE Utilisateur (
    login VARCHAR(50) PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    mail VARCHAR(255) UNIQUE NOT NULL,
    role VARCHAR(100) NOT NULL,
    image VARCHAR(255),
    est_valide tinyint(1) NOT NULL,
    clef varchar(50) 
);

CREATE TABLE Inscription (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_login VARCHAR(50),
    formation_id INT,
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_login) REFERENCES Utilisateur(login) ON DELETE CASCADE,
    FOREIGN KEY (formation_id) REFERENCES Formation(id) ON DELETE CASCADE
);

INSERT INTO Partenaire (nom, description) VALUES
('Tech Academy', 'Centre de formation en technologies'),
('Business School', 'École de commerce spécialisée');

INSERT INTO Formation (nom, description, type, image, fichiers, partenaire_id) VALUES
('Développement Web', 'Formation complète en HTML, CSS, JavaScript et PHP', 'MOOC', 'form-dev-web.jpg', 'cours_web.pdf', 1),
('Marketing Digital', 'Stratégies et outils pour le marketing en ligne', 'FOAD', 'form-marketing.jpg', 'marketing_tools.pdf', 2);

