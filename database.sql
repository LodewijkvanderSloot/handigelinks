DROP DATABASE IF EXISTS HandigeLinks;
CREATE DATABASE IF NOT EXISTS HandigeLinks DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE HandigeLinks;
DROP TABLE IF EXISTS tblLinks;
CREATE TABLE tblLinks (
  LinkID INT NOT NULL AUTO_INCREMENT,
  Linknaam CHAR (255) NOT NULL,
  Link CHAR (255) NOT NULL,
  Favicon CHAR (255) NOT NULL,
  CategorieID INT NOT NULL,
  PRIMARY KEY (LinkID)
);

DROP TABLE IF EXISTS tblCategorien;
CREATE TABLE tblCategorien (
  CategorieID INT NOT NULL AUTO_INCREMENT,
  CategorieNaam CHAR (255) NOT NULL,
  PersoonID INT NOT NULL,
  PRIMARY KEY (CategorieID)
);

DROP TABLE IF EXISTS tblPersonen;
CREATE TABLE tblPersonen (
  PersoonID INT NOT NULL AUTO_INCREMENT,
  PersoonLoginnaam CHAR (255) NOT NULL UNIQUE,
  PersoonWachtwoord CHAR (255) NOT NULL,
  IsAdmin BOOLEAN NULL,
  PRIMARY KEY (PersoonID)
);
CREATE USER 'handigelinks'@'localhost' IDENTIFIED BY 'wachtwoord';
GRANT USAGE ON *.* TO 'handigelinks'@'localhost';
GRANT ALL PRIVILEGES ON HandigeLinks.* TO 'handigelinks'@'localhost' WITH GRANT OPTION;
FLUSH PRIVILEGES;
