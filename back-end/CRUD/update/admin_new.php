<?php

// Va gérer la logique des formulaires de création d'admins
if (isset($_POST['admin_mail']) && isset($_POST['password'])) {

  $mail = mysqli_real_escape_string($db, $_POST['admin_mail']);
  $password = mysqli_real_escape_string($db, $_POST['password']);
  $passwordHash = password_hash($password, PASSWORD_DEFAULT);
  $brand = 'fitnessp';

  // Je vérifie que le mail est dispo dans mes différents tableaux SQL
  $check = $db->prepare(
    "SELECT EXISTS(
      SELECT admin.mail, partner.mail, structure.mail
      FROM admin, partner, structure
      WHERE 
      admin.mail = ?
      OR
      partner.mail = ?
      OR
      structure.mail = ?
    )"
  );

  $check->bind_param("sss", $mail, $mail, $mail);
  $check->execute();
  $check->store_result();
  $check->bind_result($exist);
  $check->fetch();
  $check->close();

  if ($exist == false) {
    $new_admin = $db->prepare(
      "INSERT INTO admin (brand_name, mail, password)
    VALUES (?, ?, ?)"
    );

    $new_admin->bind_param("sss", $brand, $mail, $passwordHash);
    $new_admin->execute();
    $new_admin->close();
  }
}