<?php

// Va gérer la logique des formulaires de création d'admins
if (isset($_POST['admin_mail']) && isset($_POST['password'])) {
  
  $mail = mysqli_real_escape_string($db, $_POST['admin_mail']);
  $password = mysqli_real_escape_string($db, $_POST['password']);
  $passwordHash = password_hash($password, PASSWORD_DEFAULT);

  // Je vérifie que le mail est dispo dans mes différents tableaux SQL
  $check = $db->prepare(
    "SELECT EXISTS(
      SELECT FitnessP_Admin.mail_admin, FitnessP_Partenaire.mail, FitnessP_Structure.mail
      FROM FitnessP_Admin, FitnessP_Partenaire, FitnessP_Structure
      WHERE 
      FitnessP_Admin.mail = ?
      OR
      FitnessP_Partenaire.mail = ?
      OR
      FitnessP_Structure.mail = ?
    )"
  );

  $check->bind_param("sss", $mail, $mail, $mail);
  $check->execute();
  $check->store_result();
  $check->bind_result($exist);
  $check->fetch();
  $check->close();

  if ($exist == false) {
    $adminR = $db->prepare(
      "INSERT INTO FitnessP_Admin (mail_admin, mot_de_passe_admin)
    VALUES (?, ?)"
    );

    $adminR->bind_param("ss", $mail, $passwordHash);
    $adminR->execute();
    $adminR->close();
}
