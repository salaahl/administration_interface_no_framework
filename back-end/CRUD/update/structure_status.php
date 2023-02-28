<?php

// ACTIVER/DESACTIVER STRUCTURES :
if (isset($_POST['structure_activate']) && isset($_POST['structure_mail'])) {

  $structure_mail = mysqli_real_escape_string($db, $_POST['structure_mail']);

  if ($_POST['structure_activate'] == 'true') {
    $statutStc = 1;
  } else {
    $statutStc = 0;
  }

  $statutS = $db->prepare(
    "UPDATE FitnessP_Structure
      SET niveau_droits = ?
      WHERE mail = ?"
  );
  $statutS->bind_param("is", $statutStc, $structure_mail);
  $statutS->execute();
  $statutS->close();
}
