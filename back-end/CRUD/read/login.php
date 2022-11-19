<?php

// LOGIN :
if (isset($_POST['login_mail']) && isset($_POST['login_mdp'])) {

  $mail = mysqli_real_escape_string($db, $_POST['login_mail']);
  $mdp = $_POST['login_mdp'];
  $reponse = [];

  $adminsQ = $db->prepare(
    "SELECT mot_de_passe_admin, niveau_droits FROM FitnessP_Admin WHERE mail_admin = ?"
  );
  $adminsQ->bind_param("s", $mail);
  $adminsQ->execute();
  $adminsQ->store_result();
  $adminsQ->bind_result($mot_de_passe_admin, $niveau_droits_admin);
  if (isset($adminsQ)) {
    $adminsQ->fetch();
  }


  $partenairesQ = $db->prepare(
    "SELECT mot_de_passe, niveau_droits, premiere_connexion FROM FitnessP_Partenaire WHERE mail = ?"
  );
  $partenairesQ->bind_param("s", $mail);
  $partenairesQ->execute();
  $partenairesQ->store_result();
  $partenairesQ->bind_result($mot_de_passe_partenaire, $niveau_droits_partenaire, $premiere_connexion_partenaire);
  if (isset($partenairesQ)) {
    $partenairesQ->fetch();
  }

  $structuresQ = $db->prepare(
    "SELECT mail_part, mot_de_passe, niveau_droits, premiere_connexion FROM FitnessP_Structure WHERE mail = ?"
  );
  $structuresQ->bind_param("s", $mail);
  $structuresQ->execute();
  $structuresQ->store_result();
  $structuresQ->bind_result($mail_part, $mot_de_passe_structure, $niveau_droits_structure, $premiere_connexion_structure);
  if (isset($structuresQ)) {
    $structuresQ->fetch();
  }



  $adminsQ->close();
  $partenairesQ->close();
  $structuresQ->close();



  // LOGIN ADMIN :
  if (isset($mot_de_passe_admin) && password_verify($mdp, $mot_de_passe_admin)) {
    session_start();
    $_SESSION['mail'] = htmlspecialchars($mail);
    $_SESSION['admin'] = 'admin';
    $_SESSION['niveau_droits'] = htmlspecialchars($niveau_droits_admin);
    $reponse['droits'] = htmlspecialchars($niveau_droits_admin);
    echo json_encode($reponse);
    die();
  }
  // LOGIN PARTENAIRE :
  if (isset($mot_de_passe_partenaire) && password_verify($mdp, $mot_de_passe_partenaire)) {
    session_start();
    $_SESSION['mail_p'] = htmlspecialchars($mail);
    $_SESSION['niveau_droits'] = htmlspecialchars($niveau_droits_partenaire);
    $reponse['droits'] = htmlspecialchars($niveau_droits_partenaire);
    $reponse['mail'] = htmlspecialchars($mail);
    $reponse['premiere_connexion'] = htmlspecialchars($premiere_connexion_partenaire);
    echo json_encode($reponse);
    die();
  }
  // LOGIN STRUCTURE :
  if (isset($mot_de_passe_structure) && password_verify($mdp, $mot_de_passe_structure)) {
    session_start();
    $_SESSION['mail_s'] = htmlspecialchars($mail);
    $_SESSION['niveau_droits'] = htmlspecialchars($niveau_droits_structure);
    $reponse['droits'] = htmlspecialchars($niveau_droits_structure);
    $reponse['mail'] = htmlspecialchars($mail);
    $reponse['mail_part'] = htmlspecialchars($mail_part);
    $reponse['premiere_connexion'] = htmlspecialchars($premiere_connexion_structure);
    echo json_encode($reponse);
    die();
  }


  $reponse['droits'] = 'Identifiants non reconnus. Veuillez réessayer.';
  echo json_encode($reponse);
}
