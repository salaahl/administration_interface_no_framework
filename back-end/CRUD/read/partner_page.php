<?php

// PAGE PARTENAIRES :
if (isset($_POST['partner_page']) && isset($_POST['partner_mail'])) {
  
  $partner_mail = $_POST['partner_mail'];
  $response = [];
  
  $partenaireQ = $db->prepare(
    "SELECT nom, niveau_droits, perm_boissons, perm_newsletter, perm_planning
    FROM FitnessP_Partenaire
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
    "SELECT adresse, mail
    FROM FitnessP_Structure
    WHERE mail_part = ?"
  );

  $structureQ->bind_param("s", $partner_mail);
  $structureQ->execute();
  $structureQ->store_result();
  $structureQ->bind_result($structure_adress, $structure_mail);

  $address = [];
  $structure_mail = [];
  
  while ($structureQ->fetch()) {
    $address[] = htmlspecialchars($structure_adress);
    $structure_mail[] = htmlspecialchars($structure_mail);
  }

  $response['address'] = $address;
  $response['structure_mail'] = $structure_mail;

  $structureQ->close();

  echo json_encode($response);
}
