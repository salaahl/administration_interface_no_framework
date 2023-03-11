<?php

if (isset($_POST["partner_city"]) && isset($_POST["partner_mail"]) && isset($_POST["partner_password"])) {

  $brand = "fitnessp";
  $city = mysqli_real_escape_string($db, $_POST["partner_city"]);
  $mail = mysqli_real_escape_string($db, $_POST["partner_mail"]);
  $password = mysqli_real_escape_string($db, $_POST["partner_password"]);

  $passwordHash = password_hash($password, PASSWORD_DEFAULT);

  // Je vérifie que le mail est dispo dans mes différents tableaux SQL
  $check = $db->prepare(
    "SELECT EXISTS
    (
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

  if ($result == 0) {
    $partner = $db->prepare(
      "INSERT INTO partner (brand_name, city, mail, password)
      VALUES (?, ?, ?, ?)"
    );
    $partner->bind_param("ssss", $brand, $city, $mail, $passwordHash);
    $partner->execute();

    // Si la requête aboutit... Conditionne l'envoi du mail
    if (mysqli_affected_rows($db) > 0) {
      $partner->close();

      $mailConfirmation =
        "<html lang='fr'>
          <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width'>
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx' crossorigin='anonymous'>

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
                  <td colspan='2'>Bonjour partenaire de " . htmlspecialchars($city) . ",<br>Voici vos identifiants de connexion. Notez que le mot de passe n'est valable que pour la première connexion. Il
                    devra être changé lors de la première connexion au site.</td>
                </tr>
                <tr>
                  <td>mail :</td>
                  <td>" .
        htmlspecialchars($mail) .
        "</td>
                </tr>
                <tr>
                  <td>mot de passe :</td>
                  <td>" .
        htmlspecialchars($password) .
        "</td>
                </tr>
                <tr>
                  <td colspan='2'><a href='https://ecf-salaha.herokuapp.com/login.html' class='btn btn-primary'>Se connecter</a></td>
                </tr>
              </tbody>
            </table>
            <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js' integrity='sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa' crossorigin='anonymous'></script>
          </body>
         </html>";

      // Initialisation des données. Méthode de récup différente selon l'environnemment
      $from_email =
        $_SERVER["SERVER_NAME"] == "localhost"
        ? FROM_EMAIL
        : getenv("FROM_EMAIL");
      $from_name =
        $_SERVER["SERVER_NAME"] == "localhost"
        ? FROM_NAME
        : getenv("FROM_NAME");
      $key =
        $_SERVER["SERVER_NAME"] == "localhost"
        ? SENDGRID_API_KEY
        : getenv("SENDGRID_API_KEY");
      $to_email = $_SERVER["SERVER_NAME"] == "localhost" ? TO_EMAIL : $mail;

      $email = new \SendGrid\Mail\Mail();
      $email->setFrom($from_email, $from_name);
      $email->setSubject("Vos identifiants");

      $email->addTo($to_email);
      $email->addContent(
        "text/plain",
        "Texte de substitution."
      );
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
          echo "Erreur. La requête n'a pas aboutie.";
          die();
        }
      }
    } else {
      $partner->close();
      echo "Erreur. Le nom de ville est déjà pris.";
      die();
    }
  } else {
    echo "Ce mail est déjà utilisé. Veuillez en choisir un autre";
    die();
  }
}
