<?php

// LOGIN :
if (isset($_POST['login_mail']) && isset($_POST['password'])) {

  $mail = mysqli_real_escape_string($db, $_POST['login_mail']);
  $password = $_POST['password'];
  $response = [];

  $adminsQ = $db->prepare(
    "SELECT password, rights FROM admin WHERE mail = ?"
  );
  $adminsQ->bind_param("s", $mail);
  $adminsQ->execute();
  $adminsQ->store_result();
  $adminsQ->bind_result($admin_password, $admin_rights);
  
  if (isset($adminsQ)) {
    $adminsQ->fetch();
  }

  $partenairesQ = $db->prepare(
    "SELECT city, password, rights, first_connection FROM partner WHERE mail = ?"
  );
  $partenairesQ->bind_param("s", $mail);
  $partenairesQ->execute();
  $partenairesQ->store_result();
  $partenairesQ->bind_result($partner_city, $partner_password, $partner_rights, $partner_first_connection);
  
  if (isset($partenairesQ)) {
    $partenairesQ->fetch();
  }

  $structuresQ = $db->prepare(
    "SELECT city, password, rights, first_connection FROM structure WHERE mail = ?"
  );
  $structuresQ->bind_param("s", $mail);
  $structuresQ->execute();
  $structuresQ->store_result();
  $structuresQ->bind_result($structure_city, $structure_password, $structure_rights, $structure_first_connection);
  
  if (isset($structuresQ)) {
    $structuresQ->fetch();
  }

  $adminsQ->close();
  $partenairesQ->close();
  $structuresQ->close();

  // LOGIN ADMIN :
  if (isset($admin_password) && password_verify($password, $admin_password)) {
    session_start();
    $_SESSION['admin_mail'] = htmlspecialchars($mail);
    $_SESSION['admin'] = 'initialize';
    $_SESSION['rights'] = htmlspecialchars($admin_rights);
    $response['rights'] = htmlspecialchars($admin_rights);
    echo json_encode($response);
    die();
  }
  
  // LOGIN PARTENAIRE :
  if (isset($partner_password) && password_verify($password, $partner_password)) {
    session_start();
    $_SESSION['city'] = htmlspecialchars($partner_city);
    $_SESSION['rights'] = htmlspecialchars($partner_rights);
    $response['rights'] = htmlspecialchars($partner_rights);
    $response['city'] = htmlspecialchars($partner_city);
    $response['first_connection'] = htmlspecialchars($partner_first_connection);
    echo json_encode($response);
    die();
  }
  
  // LOGIN STRUCTURE :
  if (isset($structure_password) && password_verify($password, $structure_password)) {
    session_start();
    $_SESSION['structure_mail'] = htmlspecialchars($mail);
    $_SESSION['rights'] = htmlspecialchars($structure_rights);
    $response['rights'] = htmlspecialchars($structure_rights);
    $response['mail'] = htmlspecialchars($mail);
    $response['city'] = htmlspecialchars($structure_city);
    $response['first_connection'] = htmlspecialchars($structure_first_connection);
    echo json_encode($response);
    die();
  }

  $response['droits'] = 'Identifiants inconnus. Veuillez réessayer.';
  echo json_encode($response);
}
