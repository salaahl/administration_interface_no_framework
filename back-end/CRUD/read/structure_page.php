<?php

// PAGE D'UNE STRUCTURE :
if (isset($_POST['structure_page']) && isset($_POST['mail'])) {

  $mail = $_POST['mail'];
  $response = [];

  $structureQ = $db->prepare(
    "SELECT mail_part, adresse, mail, perm_boissons, perm_newsletter, perm_boissons
    FROM FitnessP_Structure
    WHERE mail = ?"
  );
  
  $structureQ->bind_param("s", $mail);
  $structureQ->execute();
  $structureQ->store_result();
  $structureQ->bind_result($partner_mail, $address, $structure_mail, $drinks_permission, $newsletter_permission, $planning_permission);
  $structureQ->fetch();

  $response['partner_mail'] = htmlspecialchars($partner_mail);
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

  $PartenaireQ = $db->prepare(
    "SELECT nom
      FROM FitnessP_Partenaire
      WHERE mail = ?"
  );
  
  $PartenaireQ->bind_param("s", $mailP);
  $PartenaireQ->execute();
  $PartenaireQ->store_result();
  $PartenaireQ->bind_result($city);
  $PartenaireQ->fetch();

  $response['city'] = htmlspecialchars($city);

  echo json_encode($response);
}
