<?php

// PAGE D'UNE STRUCTURE :
if (isset($_POST['structure_page']) && isset($_POST['mail'])) {

  $mail = $_POST['mail'];
  $response = [];

  $structure = $db->prepare(
    "SELECT city, address, mail, rights, drinks_permission, newsletter_permission, planning_permission
    FROM structure
    WHERE mail = ?"
  );

  $structure->bind_param("s", $mail);
  $structure->execute();
  $structure->store_result();
  $structure->bind_result($city, $address, $mail, $rights, $drinks_permission, $newsletter_permission, $planning_permission);
  $structure->fetch();

  $response['city'] = htmlspecialchars($city);
  $response['address'] = htmlspecialchars($address);
  $response['structure_mail'] = htmlspecialchars($mail);
  $response['drinks_permission'] = $drinks_permission;
  $response['newsletter_permission'] = $newsletter_permission;
  $response['planning_permission'] = $planning_permission;

  // Conversion de mon niveau de droits en boolean
  if ($rights == 1) {
    $reponse['status'] = true;
  } else {
    $reponse['status'] = false;
  }

  $structure->close();

  echo json_encode($response);
}
