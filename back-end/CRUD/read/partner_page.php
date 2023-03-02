<?php

// PAGE PARTENAIRES :
if (isset($_POST['partner_page']) && isset($_POST['city'])) {
  
  $city = $_POST['city'];
  $response = [];
  
  $partenaireQ = $db->prepare(
    "SELECT mail, rights, drinks_permission, newsletter_permission, planning_permission
    FROM partner
    WHERE city = ?"
  );
  
  $partenaireQ->bind_param("s", $city);
  $partenaireQ->execute();
  $partenaireQ->store_result();
  $partenaireQ->bind_result($mail, $rights, $drinks_permission, $newsletter_permission, $planning_permission);
  $partenaireQ->fetch();

  $response['mail'] = htmlspecialchars($mail);
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
    $addresses[] = htmlspecialchars($structure_address);
    $structures_mails[] = htmlspecialchars($structure_mail);
  }

  $response['addresses'] = $addresses;
  $response['structures_mails'] = $structures_mails;

  $structureQ->close();

  echo json_encode($response);
}
