<?php

if (isset($_POST['partner_delete'])) {
  $mail = mysqli_real_escape_string($db, $_POST['mail_partenaire']);

  $partnerD = $db->prepare(
    "DELETE FROM FitnessP_Partenaire
    WHERE mail = ?"
  );

  $partnerD->bind_param("s", $mail);
  $partnerD->execute();
}

if (isset($_POST['structure_delete'])) {
  $mail = mysqli_real_escape_string($db, $_POST['mail_partenaire']);

  $structureD = $db->prepare(
    "DELETE FROM FitnessP_Structure
    WHERE mail = ?"
  );

  $structureD->bind_param("s", $mail);
  $structureD->execute();
}
