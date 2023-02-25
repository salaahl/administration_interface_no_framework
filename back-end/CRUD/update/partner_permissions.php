<?php

// PERMISSIONS GLOBALES D'UN PARTENAIRE :
if (isset($_POST['id']) && isset($_POST['partner_toggle'])) {
  if ($_POST['id'] == 'drink_permission' || $_POST['id'] == 'planning_permission' || $_POST['id'] == 'newsletter_permission') {

    $permission_id = $_POST['id'];
    $mail = htmlspecialchars($_POST['mail']);
    $toggle = mysqli_real_escape_string($db, $_POST['partner_toggle']);

    if ($toggle == true) {
      $toggle = 1;
    } else {
      $toggle = 0;
    }

    $permP = $db->prepare(
      "UPDATE FitnessP_Partenaire
        SET $permission_id = ?
        WHERE mail = ?"
    );

    $permP->bind_param("is", $toggle, $mail);
    $permP->execute();
    $permP->close();

    $permS = $db->prepare(
      "UPDATE FitnessP_Structure
        SET $permission_id = ?
        WHERE mail_part = ?"
    );

    $permS->bind_param("is", $toggle, $mail);
    $permS->execute();
    $permS->close();


    // Confirmer au partenaire que la permission a bien été changée :
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
      min-width: 50vw;
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
        <td colspan='2'>Bonjour partenaire de " . htmlspecialchars($_POST['nom']) . ",
        <br>Votre modification de la permission globale - " . htmlspecialchars($_POST['permission']) . " - a bien été prise en compte.
        <br>Cordialement,
        <br>Votre club FitnessP</td>
      </tr>
    </tbody>
  </table>
</body>
</html>";

    // Envoyer un mail...
    // Initialisation des données. Méthode de récup différente selon l'environnemment
    $from_email = $_SERVER["SERVER_NAME"] == "localhost" ? FROM_EMAIL : getenv("FROM_EMAIL");
    $from_name = $_SERVER["SERVER_NAME"] == "localhost" ? FROM_NAME : getenv("FROM_NAME");
    $key = $_SERVER["SERVER_NAME"] == "localhost" ? SENDGRID_API_KEY : getenv("SENDGRID_API_KEY");
    $to_email = $_SERVER["SERVER_NAME"] == "localhost" ? TO_EMAIL : $mail;

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom($from_email, $from_name);
    $email->setSubject("Permission modifiée !");

    $email->addTo($to_email);
    $email->addContent("text/plain", "Texte de substitution. Ne s'affichera pas normalement.");
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
      try {
        $response = $sendgrid->send($email);
      } catch (Exception $e) {
        echo "Erreur. Veuillez contacter un administrateur.";
      }
    }
  }
}
