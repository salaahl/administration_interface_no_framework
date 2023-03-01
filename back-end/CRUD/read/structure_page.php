<?php

// PAGE D'UNE STRUCTURE :
if (isset($_POST['structure_page']) && isset($_POST['mail'])) {

  $mail = $_POST['mail'];
  $response = [];

  $structureQ = $db->prepare(
    "SELECT city, address, mail, drinks_permission, newsletter_permission, planning_permission
    FROM structure
    WHERE mail = ?"
  );
  
  $structureQ->bind_param("s", $mail);
  $structureQ->execute();
  $structureQ->store_result();
  $structureQ->bind_result($city, $address, $structure_mail, $drinks_permission, $newsletter_permission, $planning_permission);
  $structureQ->fetch();

  $response['city'] = htmlspecialchars($city);
  $response['address'] = htmlspecialchars($address);
  $response['structure_mail'] = htmlspecialchars($structure_mail);
  $response['drinks_permission'] = $drinks_permission;
  $response['newsletter_permission'] = $newsletter_permission;
  $response['planning_permission'] = $planning_permission;

  // Conversion de mon niveau de droits en boolean
  if ($droits == 1) {
    $reponse['status'] = true;
  } else {
    $reponse['status'] = false;
  }

  $structureQ->close();

  echo json_encode($response);
}
