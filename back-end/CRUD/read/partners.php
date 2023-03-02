<?php

// LISTE DES PARTENAIRES :
if (isset($_POST['partners'])) {

  $partners = null;
  $response = [];

  if (isset($_POST['active_only']) && $_POST['active_only'] === "true") {
    $partners = $db->query(
      "SELECT city, mail, rights, number_of_structures
      FROM partner 
      WHERE rights > 0"
    );
  } else {
    $partners = $db->query(
      "SELECT city, mail, rights, number_of_structures
      FROM partner"
    );
  }

  $partner_city = [];
  $partner_mail = [];
  $partner_rights = [];
  $partner_structures_number = [];

  foreach ($partners as $partner) {
    $partner_city[] = htmlspecialchars($partner['city']);
    $partner_mail[] = htmlspecialchars($partner['mail']);
    $partner_rights[] = htmlspecialchars($partner['rights']);
    $partner_structures_number[] = htmlspecialchars($partner['number_of_structures']);
  }

  $response['partner_city'] = $partner_city;
  $response['partner_mail'] = $partner_mail;
  $response['partner_rights'] = $partner_rights;
  $response['partner_structures_number'] = $partner_structures_number;

  echo json_encode($response);
}
