<?php

if (isset($_POST['partners'])) {

  $partners = null;
  $response = [];

  if (isset($_POST['active_only']) && $_POST['active_only'] === "true") {
    $partners = $db->query(
      "SELECT city, mail, rights
      FROM partner 
      WHERE rights > 0
      ORDER BY city ASC"
    );
  } else {
    $partners = $db->query(
      "SELECT city, mail, rights
      FROM partner
      ORDER BY city ASC"
    );
  }

  $partner_city = [];
  $partner_mail = [];
  $partner_rights = [];
  $partner_structures_number = [];

  foreach ($partners as $partner) {
    $city = $partner['city'];
    $structures_number = $db->query(
      "SELECT COUNT(*) FROM structure WHERE city = '$city'"
    );
    $partner_city[] = htmlspecialchars($city);
    $partner_mail[] = htmlspecialchars($partner['mail']);
    $partner_rights[] = htmlspecialchars($partner['rights']);
    $partner_structures_number[] = $structures_number->fetch_row();
  }

  $response['partner_city'] = $partner_city;
  $response['partner_mail'] = $partner_mail;
  $response['partner_rights'] = $partner_rights;
  $response['partner_structures_number'] = $partner_structures_number;

  echo json_encode($response);
}
