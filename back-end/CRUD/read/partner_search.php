<?php

// RECHERCHE D'UN PARTENAIRE :
if (isset($_POST['partner_search'])) {

  $filter = mysqli_real_escape_string($db, $_POST['partner_search']);
  $input = (string) trim($filter);

  $response = [];
  $partner_city = [];
  $partner_mail = [];
  $partner_rights = [];
  $partner_structures = [];

  $partenaireQ = $db->prepare(
    "SELECT nom, mail, niveau_droits, nombre_de_structures
          FROM FitnessP_Partenaire
          WHERE nom LIKE CONCAT(?, '%')
          LIMIT 3"
  );

  $partenaireQ->bind_param("s", $input);
  $partenaireQ->execute();
  $partenaireQ->store_result();
  $partenaireQ->bind_result($city, $mail, $rights, $structures_number);
  
  while ($partenaireQ->fetch()) {
    $partner_city[] = htmlspecialchars($city);
    $partner_mail[] = htmlspecialchars($mail);
    $partner_rights[] = htmlspecialchars($rights);
    $partner_structures[] = htmlspecialchars($structures_number);
  }
  $partenaireQ->close();

  $reponse['$partner_city'] = $partner_city;
  $reponse['$partner_mail'] = $partner_mail;
  $reponse['$partner_rights'] = $partner_rights;
  $reponse['$partner_structures'] = $partner_structures;

  echo json_encode($response);
}
