<?php

// PAGE PARTENAIRES :
if (isset($_POST['partner_page']) && isset($_POST['partner_mail'])) {
  
  $partner_mail = $_POST['partner_mail'];
  $response = [];
  
  $partenaireQ = $db->prepare(
    "SELECT city, rights, drinks_permission, newsletter_permission, planning_permission
    FROM partner
    WHERE mail = ?"
  );
  
  $partenaireQ->bind_param("s", $partner_mail);
  $partenaireQ->execute();
  $partenaireQ->store_result();
  $partenaireQ->bind_result($city, $rights, $drinks_permission, $newsletter_permission, $planning_permission);
  $partenaireQ->fetch();

  $response['city'] = htmlspecialchars($city);
  $response['drinks_permission'] = $drinks_permission;
  $response['newsletter_permission'] = $newsletter_permission;
  $response['planning_permission'] = $planning_permission;

  $partenaireQ->close();

  // Conversion de mon niveau de droits en boolean
  if ($rights == 2) {
    $response['status'] = true;
  } else {
    $response['status'] = false;
  }

  // Structures du partenaire
  $structureQ = $db->prepare(
    "SELECT address, mail
    FROM structure
    WHERE city = ?"
  );

  $structureQ->bind_param("s", $city);
  $structureQ->execute();
  $structureQ->store_result();
  $structureQ->bind_result($structure_address, $structure_mail);

  $addresses = [];
  $structures_mails = [];
  
  while ($structureQ->fetch()) {
    $address[] = htmlspecialchars($structure_address);
    $structures_mails[] = htmlspecialchars($structure_mail);
  }

  $response['addresses'] = $addresses;
  $response['structures_mails'] = $structures_mails;

  $structureQ->close();

  echo json_encode($response);
}
