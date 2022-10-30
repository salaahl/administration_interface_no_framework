<?php



// PERMISSIONS STRUCTURE :
if (isset($_POST['toggle_structure'])) {
  if ($_POST['id'] == 'perm_boissons' || $_POST['id'] == 'perm_planning' || $_POST['id'] == 'perm_newsletter') {

    $perm = $_POST['id'];
    $mail = htmlspecialchars($_POST['mail']);
    $toggle = mysqli_real_escape_string($db, $_POST['toggle_structure']);

    if ($toggle == "true") {
      $toggle = 1;
    } else {
      $toggle = 0;
    }

    $permS = $db->prepare(
      "UPDATE FitnessP_Structure
        SET $perm = ?
        WHERE mail = ?"
    );

    $permS->bind_param("is", $toggle, $mail);
    $permS->execute();
    $permS->close();
  }

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
      <br>La modification de la permission - " . htmlspecialchars($_POST['permission']) . "
       - liée à la structure située au " . htmlspecialchars($_POST['adresse']) . " a bien été prise en compte.
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
  $mail_cc = $_SERVER["SERVER_NAME"] == "localhost" ? EMAIL_CC : $mail_partenaire;

  $email = new \SendGrid\Mail\Mail();
  $email->setFrom($from_email, $from_name);
  $email->setSubject("Permission modifiée !");

  $email->addTo($to_email);
  $email->addCc($mail_cc);
  $email->addContent("text/plain", "Texte de substitution. Ne s'affichera pas normalement.");
  $email->addContent("text/html", $mailConfirmation);

  $sendgrid = new \SendGrid($key);
  // Mode developpement :
  if ($_SERVER["SERVER_NAME"] == "localhost") {
    try {
      // try and send the email
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
    try {
      // try and send the email
      $response = $sendgrid->send($email);
    } catch (Exception $e) {
      // En cas d'erreur :
      echo "Erreur. Veuillez contacter un administrateur.";
    }
  }
}
