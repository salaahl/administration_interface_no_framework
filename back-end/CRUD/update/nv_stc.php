<?php
// Va gérer la logique des formulaires de création de structures
if (isset($_POST["adresse_structure"])) {

  $adresse = mysqli_real_escape_string($db, $_POST["adresse_structure"]);
  $mail = mysqli_real_escape_string($db, $_POST["mail_structure"]);
  $password = mysqli_real_escape_string($db, $_POST["mot_de_passe_structure"]);
  $nom_partenaire = mysqli_real_escape_string($db, $_POST["partenaire"]);

  $passwordHash = password_hash($password, PASSWORD_DEFAULT);

  // Etape 1 : récupérer les infos du partenaire à injecter dans la structure grâce à son nom
  $partenaireQ = $db->prepare("SELECT mail, perm_boissons, perm_newsletter, perm_planning
    FROM FitnessP_Partenaire
    WHERE nom = ?");

  $partenaireQ->bind_param("s", $nom_partenaire);
  $partenaireQ->execute();
  $partenaireQ->store_result();
  $partenaireQ->bind_result($mail_partenaire, $perm_boissons_p, $perm_newsletter_p, $perm_planning_p);
  $partenaireQ->fetch();
  $partenaireQ->close();

  // Etape 2 : vérifie que le mail n'est pas déjà utilisé par un partenaire
  $mail_verif = $db->prepare("SELECT mail
    FROM FitnessP_Partenaire
    WHERE mail = ?");

  $mail_verif->bind_param("s", $mail);
  $mail_verif->execute();
  $mail_verif->store_result();
  $mail_verif->bind_result($verif);
  $mail_verif->fetch();
  $mail_verif->close();

  // Si le résultat est positif :
  if ($verif == null) {

    $structureR = $db->prepare(
      "INSERT IGNORE INTO FitnessP_Structure (adresse, mail, mot_de_passe, mail_part, perm_boissons, perm_planning, perm_newsletter)
      VALUES (?, ?, ?, ?, ?, ?, ?)"
    );

    $structureR->bind_param("ssssiii", $adresse, $mail, $passwordHash, $mail_partenaire, $perm_boissons_p, $perm_planning_p, $perm_newsletter_p);
    $structureR->execute();

    // Si la requête aboutit... Evite que le mail ne soit envoyé pour rien si la requête échoue
    if (mysqli_affected_rows($db) > 0) {

      $structureR->close();

      // Etape 3 : incrémentation de la colonne "nombre_de_structures"
      $partenaireU = $db->prepare("UPDATE FitnessP_Partenaire
      SET nombre_de_structures = nombre_de_structures + 1
      WHERE mail = ?");

      $partenaireU->bind_param("s", $mail_partenaire);
      $partenaireU->execute();
      $partenaireU->close();

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
          <td colspan='2'>Bonjour partenaire de " . htmlspecialchars($nom_partenaire) . ",<br>Voici les identifiants de connexion de la structure située au " . htmlspecialchars($adresse) . ".<br>Notez que le mot de passe n'est valable que pour la première connexion. Il
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
        }
      } else {
        // Mode production :
        try {
          $response = $sendgrid->send($email);
        } catch (Exception $e) {
          echo "Erreur. Veuillez contacter un administrateur.";
        }
      }
    } else {
      $structureR->close();
      echo "Erreur. Le mail est déjà pris.";
    }
  } else {
    echo 'Ce mail est déjà utilisé. Veuillez en choisir un autre';
  }
}
