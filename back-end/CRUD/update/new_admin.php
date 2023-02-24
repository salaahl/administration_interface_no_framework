<?php

// Va gérer la logique des formulaires de création d'admins
if (isset($_POST['admin_mail'])) {
  $mail = mysqli_real_escape_string($db, $_POST['admin_mail']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  $passwordHash = password_hash($password, PASSWORD_DEFAULT);

  // Etape 1 : vérifie que le mail n'est pas déjà utilisé par une structure
  $mail_verif = $db->prepare("SELECT mail_admin
    FROM FitnessP_Admin
    WHERE mail_admin = ?");

  $mail_verif->bind_param("s", $mail);
  $mail_verif->execute();
  $mail_verif->store_result();
  $mail_verif->bind_result($verif);
  $mail_verif->fetch();
  $mail_verif->close();

  // Etape 2 : Si le résultat est positif...
  if ($verif == null) {

    $adminR = $db->prepare(
      "INSERT INTO FitnessP_Admin (mail_admin, mot_de_passe_admin)
    VALUES (?, ?)"
    );

    $adminR->bind_param("ss", $mail, $passwordHash);
    $adminR->execute();

    if (mysqli_affected_rows($db) > 0) {
      $adminR->close();
    } else {
      echo "Erreur. Le mail est déjà pris.";
    }
  } else {
    $adminR->close();
    echo "Erreur. Le mail est déjà pris.";
  }
}
