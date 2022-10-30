<?php

// Va gérer la logique des formulaires de création d'admins
if (isset($_POST['mot_de_passe_admin'])) {
  $mail = mysqli_real_escape_string($db, $_POST['mail_admin']);
  $password = mysqli_real_escape_string($db, $_POST['mot_de_passe_admin']);

  $passwordHash = password_hash($password, PASSWORD_DEFAULT);

  $adminR = $db->prepare(
    "INSERT INTO FitnessP_Admin (mail_admin, mot_de_passe_admin)
    VALUES (?, ?)"
  );
  
  $adminR->bind_param("ss", $mail, $passwordHash);
  $adminR->execute();
  $adminR->close();
}
