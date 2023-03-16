<?php

// ACTIVER/DESACTIVER STRUCTURES :
if (isset($_POST['structure_activate']) && isset($_POST['structure_mail'])) {

  $structure_mail = mysqli_real_escape_string($db, $_POST['structure_mail']);
  $rights = null;

  if ($_POST['structure_activate'] == true) {
    $rights = 1;
  } else {
    $rights = 0;
  }

  $status = $db->prepare(
    "UPDATE structure
      SET rights = ?
      WHERE mail = ?"
  );
  $status->bind_param("is", $rights, $structure_mail);
  $status->execute();
  $status->close();
}
