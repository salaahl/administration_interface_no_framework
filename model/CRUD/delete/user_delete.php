<?php

// PARTNER
if (isset($_POST['partner_delete'])) {
  $mail = mysqli_real_escape_string($db, $_POST['partner_delete']);

  $partner = $db->prepare(
    "DELETE FROM partner
    WHERE mail = ?"
  );

  $partner->bind_param("s", $mail);
  $partner->execute();

  $structure = $db->prepare(
    "DELETE FROM structure
    WHERE mail = ?"
  );

  $structure->bind_param("s", $mail);
  $structure->execute();

  header("Location: ../partners.php");
  die();
}

// STRUCTURE
if (isset($_POST['structure_delete']) && isset($_POST['structure_city'])) {
  $mail = mysqli_real_escape_string($db, $_POST['structure_delete']);
  $city = $_POST['structure_city'];

  $structure = $db->prepare(
    "DELETE FROM structure
    WHERE mail = ?"
  );

  $structure->bind_param("s", $mail);
  $structure->execute();

  header("Location: ../partner.php?city=" . $city);
  die();
}
