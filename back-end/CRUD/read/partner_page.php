<?php

// PAGE PARTENAIRES :
if (isset($_POST['partner_page']) && isset($_POST['mail'])) {
  
  $mail = $_POST['mail'];
  $response = [];

  $structureQ = $db->prepare(
    "SELECT adresse, s.mail, mail_part
    FROM FitnessP_Structure s
    JOIN FitnessP_Partenaire p
    ON s.mail_part = p.mail
    WHERE s.mail_part = ?"
  );

  $structureQ->bind_param("s", $mail);
  $structureQ->execute();
  $structureQ->store_result();
  $structureQ->bind_result($structure_adress, $structure_mail, $partner_mail);

  $addresses = [];
  $structures_mails = [];
  
  while ($structureQ->fetch()) {
    $addresses[] = htmlspecialchars($structure_adress);
    $structures_mails[] = htmlspecialchars($structure_mail);
  }

  $response['addresses'] = $addresses;
  $response['structures_mails'] = $structures_mails;
  $response['partner_mail'] = htmlspecialchars($partner_mail);

  $structureQ->close();

  $partenaireQ = $db->prepare(
    "SELECT nom, perm_boissons, perm_newsletter, perm_planning
    FROM FitnessP_Partenaire
    WHERE mail = ?"
  );
  
  $partenaireQ->bind_param("s", $mail);
  $partenaireQ->execute();
  $partenaireQ->store_result();
  $partenaireQ->bind_result($city, $boisson_permission, $newsletter_permission, $planning_permission);
  $partenaireQ->fetch();

  $response['city'] = htmlspecialchars($city);
  $response['boisson_permission'] = $boisson_permission;
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
