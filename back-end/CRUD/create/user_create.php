<?php

$brand = $db->query(
  "CREATE TABLE IF NOT EXISTS brand (
  name VARCHAR(10) NOT NULL,
  PRIMARY KEY (name)
  )"
);

$admin = $db->query(
  "CREATE TABLE IF NOT EXISTS admin (
  brand_name VARCHAR(10) NOT NULL,
  mail VARCHAR(100) NOT NULL,
  password VARCHAR(100) NOT NULL,
  rights TINYINT(1) DEFAULT 3 NOT NULL,
  PRIMARY KEY (mail),
  FOREIGN KEY (brand_name) REFERENCES brand(name)
  )"
);

$partner = $db->query(
  "CREATE TABLE IF NOT EXISTS partner (
  brand_name VARCHAR(10) NOT NULL,
  city VARCHAR(100) NOT NULL UNIQUE,
  mail VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL,
  rights TINYINT(1) NOT NULL DEFAULT 2,
  first_connection TINYINT(1) NOT NULL DEFAULT -1,
  number_of_structures TINYINT(1) NOT NULL DEFAULT 0,
  drinks_permission TINYINT(1) NOT NULL DEFAULT 0,
  newsletter_permission TINYINT(1) NOT NULL DEFAULT 0,
  planning_permission TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (mail),
  FOREIGN KEY (brand_name) REFERENCES brand(name)
  )"
);

$structure = $db->query(
  "CREATE TABLE IF NOT EXISTS structure (
  brand_name VARCHAR(10) NOT NULL,
  city VARCHAR(100) NOT NULL,
  address VARCHAR(100) NOT NULL,
  mail VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL,
  rights TINYINT(1) NOT NULL DEFAULT 1,
  first_connection TINYINT(1) NOT NULL DEFAULT -1,
  drinks_permission TINYINT(1) NOT NULL DEFAULT 0,
  newsletter_permission TINYINT(1) NOT NULL DEFAULT 0,
  planning_permission TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (mail),
  FOREIGN KEY (brand_name) REFERENCES brand(name),
  FOREIGN KEY (city) REFERENCES partner(city)
  )"
);

$brand_check = $db->query(
  "SELECT * FROM brand"
);

if (mysqli_num_rows($brand_check) < 1) {
  $brand_insert = $db->query(
    "INSERT INTO brand VALUES('fitnessp')"
  );
};
