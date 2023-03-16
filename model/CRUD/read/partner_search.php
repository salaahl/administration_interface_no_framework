<?php

if (isset($_POST['partner_search'])) {

  $filter = mysqli_real_escape_string($db, $_POST['partner_search']);
  $input = (string) trim($filter);

  $response = [];
  $partner_city = [];
  $partner_mail = [];
  $partner_rights = [];
  $partner_structures_number = [];

  $partner = $db->prepare(
    "SELECT city, mail, rights
    FROM partner
    WHERE city LIKE CONCAT(?, '%')
    LIMIT 3"
  );

  $partner->bind_param("s", $input);
  $partner->execute();
  $partner->store_result();
  $partner->bind_result($city, $mail, $rights);

  while ($partner->fetch()) {
    $structures_number = $db->query(
      "SELECT COUNT(*) FROM structure WHERE city = '$city'"
    );
    $partner_city[] = htmlspecialchars($city);
    $partner_mail[] = htmlspecialchars($mail);
    $partner_rights[] = htmlspecialchars($rights);
    $partner_structures_number[] = $structures_number->fetch_row();
  }
  $partner->close();

  $response['partner_city'] = $partner_city;
  $response['partner_mail'] = $partner_mail;
  $response['partner_rights'] = $partner_rights;
  $response['partner_structures_number'] = $partner_structures_number;

  echo json_encode($response);
}
