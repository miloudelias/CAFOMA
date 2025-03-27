SET NAMES utf8;

DROP DATABASE IF EXISTS CAFOMABD;
CREATE DATABASE CAFOMABD CHARACTER SET 'utf8';
USE CAFOMABD;

CREATE TABLE Partenaire (
    idPartenaire INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT
);

CREATE TABLE Formation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    type VARCHAR(100),
    description TEXT,
    contenu TEXT,
    duree INT,
    niveau VARCHAR(50),
    mode VARCHAR(50)
    image VARCHAR(255),
    fichiers TEXT,
    idPart INT,
    FOREIGN KEY (idPart) REFERENCES Partenaire(idPart) ON DELETE SET NULL
);

CREATE TABLE Utilisateur (
    login VARCHAR(50) PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    mail VARCHAR(255) UNIQUE NOT NULL,
    role VARCHAR(100) NOT NULL,
    image VARCHAR(255),
    est_valide tinyint(1) NOT NULL,
    clef varchar(50),
    idPart INT,
    FOREIGN KEY (idPart) REFERENCES Partenaire(idPart) ON DELETE SET NULL
);

CREATE TABLE Inscription (
    idInscription INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50),
    idFormation INT,
    dateInscription DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_login) REFERENCES Utilisateur(login) ON DELETE CASCADE,
    FOREIGN KEY (formation_id) REFERENCES Formation(id) ON DELETE CASCADE
);

CREATE TABLE Ressources (
    idRessource INT AUTO_INCREMENT PRIMARY KEY,
    nomFichier VARCHAR(255) NOT NULL,
    typeFichier VARCHAR(100) NOT NULL,
    idFormation INT NOT NULL,
    FOREIGN KEY (idFormation) REFERENCES formation(id) ON DELETE CASCADE
);

INSERT INTO Partenaire (nom, description) VALUES
('Tech Academy', 'Centre de formation en technologies'),
('Business School', 'École de commerce spécialisée');

INSERT INTO Formation (nom, description, type, image, fichiers, partenaire_id) VALUES
('Développement Web', 'Formation complète en HTML, CSS, JavaScript et PHP', 'MOOC', 'form-dev-web.jpg', 'cours_web.pdf', 1, 30,'Débutant' ,'Formation initiale'),
('Marketing Digital', 'Stratégies et outils pour le marketing en ligne', 'FOAD', 'form-marketing.jpg', 'marketing_tools.pdf', 2, 45, 'Avancé','Formation en apprentissage');

INSERT INTO Utilisateur (login, password, mail, nom, prenom, role, image, est_valide, clef) VALUES
('etud1', '$2y$10$EasQR.L.CwIGKUotLQk6KO2K5dAuIWjM1bj1wd5X5uO/IeBF/mlva', 'eliaszaina13@gmail.com', 'Etudiant', 'Test', 'Etudiant', 'etudiant.png', 1, '67c07c7868df2')

