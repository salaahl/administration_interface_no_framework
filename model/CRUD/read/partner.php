<?php

if (isset($_POST['partner_page']) && isset($_POST['city'])) {

  $city = $_POST['city'];
  $response = [];

  $partner = $db->prepare(
    "SELECT mail, rights, drinks_permission, newsletter_permission, planning_permission
    FROM partner
    WHERE city = ?"
  );

  $partner->bind_param("s", $city);
  $partner->execute();
  $partner->store_result();
  $partner->bind_result($mail, $rights, $drinks_permission, $newsletter_permission, $planning_permission);
  $partner->fetch();

  $response['mail'] = htmlspecialchars($mail);
  $response['drinks_permission'] = $drinks_permission;
  $response['newsletter_permission'] = $newsletter_permission;
  $response['planning_permission'] = $planning_permission;

  $partner->close();

  // Conversion de mon niveau de droits en boolean
  if ($rights == 2) {
    $response['status'] = true;
  } else {
    $response['status'] = false;
  }

  // Structures du partenaire
  $structure = $db->prepare(
    "SELECT address, mail
    FROM structure
    WHERE city = ?"
  );

  $structure->bind_param("s", $city);
  $structure->execute();
  $structure->store_result();
  $structure->bind_result($structure_address, $structure_mail);

  $addresses = [];
  $structures_mails = [];

  while ($structure->fetch()) {
    $addresses[] = htmlspecialchars($structure_address);
    $structures_mails[] = htmlspecialchars($structure_mail);
  }

  $response['addresses'] = $addresses;
  $response['structures_mails'] = $structures_mails;

  $structure->close();

  echo json_encode($response);
}
