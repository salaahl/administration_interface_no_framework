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
    "SELECT city, mail, rights, number_of_structures
    FROM partner
    WHERE city LIKE CONCAT(?, '%')
    LIMIT 3"
  );

  $partenaireQ->bind_param("s", $input);
  $partenaireQ->execute();
  $partenaireQ->store_result();
  $partenaireQ->bind_result($city, $mail, $rights, $number_of_structures);
  
  while ($partenaireQ->fetch()) {
    $partner_city[] = htmlspecialchars($city);
    $partner_mail[] = htmlspecialchars($mail);
    $partner_rights[] = htmlspecialchars($rights);
    $partner_structures[] = htmlspecialchars($number_of_structures);
  }
  $partenaireQ->close();

  $reponse['city'] = $partner_city;
  $reponse['mail'] = $partner_mail;
  $reponse['rights'] = $partner_rights;
  $reponse['number_of_structures'] = $partner_structures;

  echo json_encode($response);
}
