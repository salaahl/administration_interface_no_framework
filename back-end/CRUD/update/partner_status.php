<?php

// ACTIVER/DESACTIVER PARTENAIRE ET SES STRUCTURES :
if (isset($_POST['partner_activate']) && isset($_POST['city'])) {

  $city = mysqli_real_escape_string($db, $_POST['city']);
  $statusPartner = null;
  $statusStructure = null;
  
  if ($_POST['partner_activate'] == "true") {
    $statusPartner = 2;
    $statusStructure = 1;
  } else {
    $statusPartner = 0;
    $statusStructure = 0;
  }

  $statutP = $db->prepare(
    "UPDATE partner
      SET rights = ?
      WHERE city = ?"
  );
  $statutP->bind_param("is", $statusPartner, $city);
  $statutP->execute();
  $statutP->close();

  $statutS = $db->prepare(
    "UPDATE structure
      SET rights = ?
      WHERE city = ?"
  );
  $statutS->bind_param("is", $statusStructure, $city);
  $statutS->execute();
  $statutS->close();
}
