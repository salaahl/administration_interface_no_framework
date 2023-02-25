<?php


$brand = $db->query(
  "CREATE TABLE IF NOT EXISTS FitnessP (
  marque VARCHAR(10) NOT NULL DEFAULT 'FitnessP',
  PRIMARY KEY (marque)
  )"
);

$admin = $db->query(
  "CREATE TABLE IF NOT EXISTS FitnessP_Admin (
  nom_marque VARCHAR(10) NOT NULL DEFAULT 'FitnessP',
  mail_admin VARCHAR(100) NOT NULL,
  mot_de_passe_admin VARCHAR(255) NOT NULL,
  niveau_droits TINYINT(1) DEFAULT 3 NOT NULL,
  PRIMARY KEY (mail_admin),
  FOREIGN KEY (nom_marque) REFERENCES FitnessP(marque)
  )"
);

$partner = $db->query(
  "CREATE TABLE IF NOT EXISTS FitnessP_Partenaire (
  nom_marque VARCHAR(10) NOT NULL DEFAULT 'FitnessP',
  nom VARCHAR(100) NOT NULL UNIQUE,
  mail VARCHAR(100) NOT NULL,
  mot_de_passe VARCHAR(255) NOT NULL,
  niveau_droits TINYINT(1) NOT NULL DEFAULT 2,
  premiere_connexion TINYINT(1) NOT NULL DEFAULT -1,
  nombre_de_structures TINYINT(1) NOT NULL DEFAULT 0,
  perm_boissons TINYINT(1) DEFAULT 0,
  perm_newsletter TINYINT(1) DEFAULT 0,
  perm_planning TINYINT(1) DEFAULT 0,
  PRIMARY KEY (mail),
  FOREIGN KEY (nom_marque) REFERENCES FitnessP(marque)
  )"
);

$structure = $db->query(
  "CREATE TABLE IF NOT EXISTS FitnessP_Structure (
  mail_part VARCHAR(100) NOT NULL,
  adresse VARCHAR(100) NOT NULL,
  mail VARCHAR(100) NOT NULL,
  mot_de_passe VARCHAR(255) NOT NULL,
  niveau_droits TINYINT(1) NOT NULL DEFAULT 1,
  premiere_connexion TINYINT(1) NOT NULL DEFAULT -1,
  perm_boissons TINYINT(1) DEFAULT 0,
  perm_newsletter TINYINT(1) DEFAULT 0,
  perm_planning TINYINT(1) DEFAULT 0,
  PRIMARY KEY (mail),
  FOREIGN KEY (mail_part) REFERENCES FitnessP_Partenaire(mail)
  )"
);

$brand_check = $db->query(
  "SELECT * FROM FitnessP"
);

if (mysqli_num_rows($brand_check) < 1) {
  $brand_insert = $db->query(
    "INSERT INTO FitnessP VALUES()"
  );
};
