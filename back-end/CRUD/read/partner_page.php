<?php

// PAGE PARTENAIRES :
if (isset($_POST['partner_page']) && isset($_POST['partner_mail'])) {
  
  $partner_mail = $_POST['partner_mail'];
  $response = [];

  $structureQ = $db->prepare(
    "SELECT adresse, s.mail
    FROM FitnessP_Structure s
    JOIN FitnessP_Partenaire p
    ON s.mail_part = p.mail
    WHERE s.mail_part = ?"
  );

  $structureQ->bind_param("s", $mail);
  $structureQ->execute();
  $structureQ->store_result();
  $structureQ->bind_result($structure_adress, $mail);

  $address = [];
  $structure_mail = [];
  
  while ($structureQ->fetch()) {
    $address[] = htmlspecialchars($structure_adress);
    $structure_mail[] = htmlspecialchars($mail);
  }

  $response['address'] = $address;
  $response['structure_mail'] = $structure_mail;

  $structureQ->close();

  $partenaireQ = $db->prepare(
    "SELECT nom, perm_boissons, perm_newsletter, perm_planning
    FROM FitnessP_Partenaire
    WHERE mail = ?"
  );
  
  $partenaireQ->bind_param("s", $mail);
  $partenaireQ->execute();
  $partenaireQ->store_result();
  $partenaireQ->bind_result($city, $drinks_permission, $newsletter_permission, $planning_permission);
  $partenaireQ->fetch();

  $response['city'] = htmlspecialchars($city);
  $response['drinks_permission'] = $drinks_permission;
  $response['newsletter_permission'] = $newsletter_permission;
  $response['planning_permission'] = $planning_permission;

  $partenaireQ->close();

  // Conversion de mon niveau de droits en boolean
  if ($droits == 2) {
    $response['status'] = true;
  } else {
    $response['status'] = false;
  }

  echo json_encode($response);
}
