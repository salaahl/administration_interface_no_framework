<?php

// LISTE DES PARTENAIRES :
if (isset($_POST['partners'])) {

  $response = [];

  $partenairesQ = $db->query(
    "SELECT nom, mail, niveau_droits, nombre_de_structures
     FROM FitnessP_Partenaire"
  );

  $partner_city = [];
  $partner_mail = [];
  $partner_rights = [];
  $partner_structures_number = [];

  foreach ($partenairesQ as $partenaire) {
    $partner_city[] = htmlspecialchars($partenaire['nom']);
    $partner_mail[] = htmlspecialchars($partenaire['mail']);
    $partner_rights[] = htmlspecialchars($partenaire['niveau_droits']);
    $partner_structures_number[] = htmlspecialchars($partenaire['nombre_de_structures']);
  }

  $response['partner_city'] = $partner_city;
  $response['partner_mail'] = $partner_mail;
  $response['partner_rights'] = $partner_rights;
  $response['partner_structures_number'] = $partner_structures_number;

  echo json_encode($response);
}


// LISTE DES PARTENAIRES ACTIFS UNIQUEMENT :
if (isset($_POST['partner_status'])) {
  
  $toggle = $_POST['partner_status'];
  
  $response = [];
  $partner_city = [];
  $partner_mail = [];
  $partner_rights = [];
  $partner_structures_number = [];
  $partenairesQ = NULL;

  // Si le switch est activé...
  if ($toggle == "true") {
    $partenairesQ = $db->query(
      "SELECT nom, mail, niveau_droits, nombre_de_structures
      FROM FitnessP_Partenaire WHERE niveau_droits > 0"
    );
  } else {
    $partenairesQ = $db->query(
      "SELECT nom, mail, niveau_droits, nombre_de_structures
      FROM FitnessP_Partenaire"
    );
  }
  
  foreach ($partenairesQ as $partenaire) {
    $partner_city[] = htmlspecialchars($partenaire['nom']);
    $partner_mail[] = htmlspecialchars($partenaire['mail']);
    $partner_rights[] = htmlspecialchars($partenaire['niveau_droits']);
    $partner_structures_number[] = htmlspecialchars($partenaire['nombre_de_structures']);
  }
  
  $response['partner_city'] = $partner_city;
  $response['partner_mail'] = $partner_mail;
  $response['partner_rights'] = $partner_rights;
  $response['partner_structures_number'] = $partner_structures_number;

  echo json_encode($response);
}
