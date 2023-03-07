<?php

if (
  isset($_POST["address"]) && isset($_POST["structure_mail"])
  && isset($_POST["password"]) && isset($_POST["city"])
) {

  $brand = "fitnessp";
  $address = mysqli_real_escape_string($db, $_POST["address"]);
  $mail = mysqli_real_escape_string($db, $_POST["structure_mail"]);
  $password = mysqli_real_escape_string($db, $_POST["password"]);
  $city = mysqli_real_escape_string($db, $_POST["city"]);

  $passwordHash = password_hash($password, PASSWORD_DEFAULT);

  // Je récupère les permissions globales du partenaire à injecter dans la structure :
  $partner = $db->prepare(
    "SELECT drinks_permission, newsletter_permission, planning_permission
    FROM partner
    WHERE city = ?"
  );

  $partner->bind_param("s", $city);
  $partner->execute();
  $partner->store_result();
  $partner->bind_result($drinks_permission, $newsletter_permission, $planning_permission);
  $partner->fetch();
  $partner->close();

  // Je vérifie que le mail est dispo dans mes différents tableaux SQL :
  $check = $db->prepare(
    "SELECT EXISTS(
      SELECT admin.mail, partner.mail, structure.mail
      FROM admin, partner, structure
      WHERE 
      admin.mail = ?
      OR
      partner.mail = ?
      OR
      structure.mail = ?
    )"
  );
  $check->bind_param("sss", $mail, $mail, $mail);
  $check->execute();
  $check->store_result();
  $check->bind_result($result);
  $check->fetch();
  $check->close();

  if ($result == false) {

    $structure_new = $db->prepare(
      "INSERT INTO structure (brand_name, address, mail, password, city, drinks_permission, planning_permission, newsletter_permission)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $structure_new->bind_param("sssssiii", $brand, $address, $mail, $passwordHash, $city, $drinks_permission, $planning_permission, $newsletter_permission);
    $structure_new->execute();

    // Si la requête aboutit... Evite que le mail ne soit envoyé pour rien si la requête échoue
    if (mysqli_affected_rows($db) > 0) {
      $structure_new->close();

      // Incrémentation de la colonne "number_of_structures" :
      $partner_update = $db->prepare(
        "UPDATE partner
        SET number_of_structures = number_of_structures + 1
        WHERE city = ?"
      );

      $partner_update->bind_param("s", $city);
      $partner_update->execute();
      $partner_update->close();

      $mailConfirmation = "
      <html>

  <head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width'>
    <style>
      body
      {
        display: flex;
        justify-content: center;
        align-items: center;
      }

      table
      {
        width: 50vw;
        border: 1rem solid highlight;
        background-color: lightgray;
      }

      th
      {
        background-color: gray;
      }

      td
      {
        border: 1px solid gray;
      }
    </style>
    
  </head>

  <body>
    <table>
      <thead>
        <tr>
          <th colspan='2'>Bienvenue sur Fitness P !</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan='2'>Bonjour partenaire de " . htmlspecialchars($city) . ",<br>Voici les identifiants de connexion de la structure située au " . htmlspecialchars($address) . ".<br>Notez que le mot de passe n'est valable que pour la première connexion. Il
            devra être changé lors de la première connexion au site.</td>
        </tr>
        <tr>
          <td>mail :</td>
          <td>" . htmlspecialchars($mail) . "</td>
        </tr>
        <tr>
          <td>mot de passe :</td>
          <td>" . htmlspecialchars($password) . "</td>
        </tr>
        <tr>
          <td colspan='2'><a href='https://ecf-salaha.herokuapp.com/login.html' class='btn btn-primary'>Se connecter</a></td>
        </tr>
      </tbody>
    </table>
  </body>
  </html>";

      // Etape 4 : Envoyer un mail...
      // Initialisation des données. Méthode de récup différente selon l'environnemment
      $from_email = $_SERVER["SERVER_NAME"] == "localhost" ? FROM_EMAIL : getenv("FROM_EMAIL");
      $from_name = $_SERVER["SERVER_NAME"] == "localhost" ? FROM_NAME : getenv("FROM_NAME");
      $key = $_SERVER["SERVER_NAME"] == "localhost" ? SENDGRID_API_KEY : getenv("SENDGRID_API_KEY");
      $to_email = $_SERVER["SERVER_NAME"] == "localhost" ? TO_EMAIL : $mail;
      $mail_cc = $_SERVER["SERVER_NAME"] == "localhost" ? EMAIL_CC : $mail_partenaire;

      $email = new \SendGrid\Mail\Mail();
      $email->setFrom($from_email, $from_name);
      $email->setSubject("Vos identifiants");

      $email->addTo($to_email);
      $email->addCc($mail_cc);
      $email->addContent("text/plain", "Texte de substitution.");
      $email->addContent("text/html", $mailConfirmation);

      $sendgrid = new \SendGrid($key);
      // Mode developpement :
      if ($_SERVER["SERVER_NAME"] == "localhost") {
        try {
          $response = $sendgrid->send($email);

          print $response->statusCode() . "\n";
          print_r($response->headers());
          print $response->body() . "\n";
        } catch (Exception $e) {
          echo "Caught exception: " . $e->getMessage() . "\n";
          die();
        }
      } else {
        // Mode production :
        try {
          $response = $sendgrid->send($email);
        } catch (Exception $e) {
          echo "Erreur. Veuillez contacter un administrateur.";
          die();
        }
      }
    } else {
      $structure_new->close();
      echo "Erreur. Le mail est déjà pris.";
      die();
    }
  } else {
    echo 'Ce mail est déjà utilisé. Veuillez en choisir un autre';
    die();
  }
}
