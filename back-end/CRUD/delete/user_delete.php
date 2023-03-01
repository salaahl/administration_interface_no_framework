<?php

// PARTNER
if (isset($_POST['partner_delete'])) {
  $mail = mysqli_real_escape_string($db, $_POST['partner_delete']);

  $partnerD = $db->prepare(
    "DELETE FROM partner
    WHERE mail = ?"
  );

  $partnerD->bind_param("s", $mail);
  $partnerD->execute();
  
  $structureD = $db->prepare(
    "DELETE FROM structure
    WHERE mail = ?"
  );

  $structureD->bind_param("s", $mail);
  $structureD->execute();
}

// STRUCTURE
if (isset($_POST['structure_delete'])) {
  $mail = mysqli_real_escape_string($db, $_POST['structure_delete']);

  $structureD = $db->prepare(
    "DELETE FROM structure
    WHERE mail = ?"
  );

  $structureD->bind_param("s", $mail);
  $structureD->execute();
}
