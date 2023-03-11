<?php

// ACTIVER/DESACTIVER PARTENAIRE ET SES STRUCTURES :
if (isset($_POST['partner_activate']) && isset($_POST['city'])) {

  $city = mysqli_real_escape_string($db, $_POST['city']);
  $partner_rights = null;
  $structures_rights = null;

  if ($_POST['partner_activate'] == "true") {
    $partner_rights = 2;
    $structures_rights = 1;
  } else {
    $partner_rights = 0;
    $structures_rights = 0;
  }

  $status_partner = $db->prepare(
    "UPDATE partner
      SET rights = ?
      WHERE city = ?"
  );
  $status_partner->bind_param("is", $partner_rights, $city);
  $status_partner->execute();
  $status_partner->close();

  $status_structures = $db->prepare(
    "UPDATE structure
      SET rights = ?
      WHERE city = ?"
  );
  $status_structures->bind_param("is", $structures_rights, $city);
  $status_structures->execute();
  $status_structures->close();
}
