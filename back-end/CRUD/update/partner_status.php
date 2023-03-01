<?php

// ACTIVER/DESACTIVER PARTENAIRE ET SES STRUCTURES :
if (isset($_POST['partner_activate']) && isset($_POST['partner_mail'])) {

  $partner_mail = mysqli_real_escape_string($db, $_POST['partner_mail']);

  if ($_POST['partner_activate'] == 'true') {
    $statutPrt = 2;
    $statutStc = 1;
  } else {
    $statutPrt = 0;
    $statutStc = 0;
  }

  $statutP = $db->prepare(
    "UPDATE partner
      SET rights = ?
      WHERE mail = ?"
  );
  $statutP->bind_param("is", $statutPrt, $partner_mail);
  $statutP->execute();
  $statutP->close();

  $statutS = $db->prepare(
    "UPDATE structure
      SET rights = ?
      WHERE city = ?"
  );
  $statutS->bind_param("is", $statutStc, $city);
  $statutS->execute();
  $statutS->close();
}
