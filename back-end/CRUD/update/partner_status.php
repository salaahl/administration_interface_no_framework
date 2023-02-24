<?php


// ACTIVER/DESACTIVER PARTENAIRE ET SES STRUCTURES :
if (isset($_POST['partner_activate'])) {

  $mail = mysqli_real_escape_string($db, $_POST['mail']);

  if ($_POST['partner_activate'] == 'true') {
    $statutPrt = 2;
    $statutStc = 1;
  } else {
    $statutPrt = 0;
    $statutStc = 0;
  }

  $statutP = $db->prepare(
    "UPDATE FitnessP_Partenaire
      SET niveau_droits = ?
      WHERE mail = ?"
  );
  $statutP->bind_param("is", $statutPrt, $mail);
  $statutP->execute();
  $statutP->close();

  $statutS = $db->prepare(
    "UPDATE FitnessP_Structure
      SET niveau_droits = ?
      WHERE mail_part = ?"
  );
  $statutS->bind_param("is", $statutStc, $mail);
  $statutS->execute();
  $statutS->close();
}
