<?php

// Va gérer la logique des formulaires de création de partenaires
if (isset($_POST["nom_partenaire"])) {
  $nom = mysqli_real_escape_string($db, $_POST["nom_partenaire"]);
  $mail = mysqli_real_escape_string($db, $_POST["mail_partenaire"]);
  $password = mysqli_real_escape_string($db, $_POST["mot_de_passe_partenaire"]);

  $passwordHash = password_hash($password, PASSWORD_DEFAULT);

  $partenaireR = $db->prepare(
    "INSERT INTO FitnessP_Partenaire (nom, mail, mot_de_passe)
      VALUES (?, ?, ?)"
  );

  // Si la requête aboutit... Evite que le mail ne soit envoyé pour rien si la requête échoue
  if ($partenaireR) {
    // Le triple 's' indique 'string, string, string' pour chacune de mes entrées.
    // https://www.php.net/manual/fr/mysqli-stmt.bind-param.php
    $partenaireR->bind_param("sss", $nom, $mail, $passwordHash);
    $partenaireR->execute();
    $partenaireR->close();

    $mailConfirmation =
      "
    <html lang='fr'>
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
      width: 20vw;
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
        <td colspan='2'>Bonjour partenaire de" . htmlspecialchars($nom) . ",<br>Voici vos identifiants de connexion. Notez que le mot de passe n'est valable que pour la première connexion. Il
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

    // Envoyer un mail...
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

    // Destinataire
    $email->addTo($to_email);
    $email->addContent(
      "text/plain",
      "Texte de substitution. Ne s'affichera pas normalement."
    );
    $email->addContent("text/html", $mailConfirmation);

    $sendgrid = new \SendGrid($key);
    // Mode developpement :
    if ($_SERVER["SERVER_NAME"] == "localhost") {
      try {
        $response = $sendgrid->send($email);

        // C'est l'espèce de texte en forme de tableau qui s'affiche lorsque mon mail est envoyé
        print $response->statusCode() . "\n";
        print_r($response->headers());
        print $response->body() . "\n";
      } catch (Exception $e) {
        // En cas d'erreur :
        echo "Caught exception: " . $e->getMessage() . "\n";
      }
    } else {
      // Mode production
      try {
        $response = $sendgrid->send($email);
        echo "<script>alert('Liste des partenaires mise à jour.');
              location.replace('./front-end/liste_part.php');</script>";
      } catch (Exception $e) {
        // En cas d'erreur :
        echo "Erreur. Veuillez contacter un administrateur.";
      }
    }
  }
}
