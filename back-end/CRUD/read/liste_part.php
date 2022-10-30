<?php


// LISTE PARTENAIRES :
if (isset($_POST['liste_part'])) {

  $reponse = [];
  // A remplacer par une requête préparée et des champs pour le tri ?
  // (lorsque je clique sur tel bouton ça injecte ASC ou DESC à la fin etc...)
  // Je pense qu'il vaut mieux laisser cette partie à Javascript...
  $partenairesQ = $db->query(
    "SELECT nom, mail, niveau_droits, nombre_de_structures
     FROM FitnessP_Partenaire"
  );

  $nom = [];
  $mail = [];
  $niveau_droits = [];
  $nombre_de_structures = [];


  foreach ($partenairesQ as $partenaire) {
    $nom[] = htmlspecialchars($partenaire['nom']);
    $mail[] = htmlspecialchars($partenaire['mail']);
    $niveau_droits[] = htmlspecialchars($partenaire['niveau_droits']);
    $nombre_de_structures[] = htmlspecialchars($partenaire['nombre_de_structures']);
  }


  $reponse['noms'] = $nom;
  $reponse['mails'] = $mail;
  $reponse['niveau_droits'] = $niveau_droits;
  $reponse['nombre_de_structures'] = $nombre_de_structures;

  echo json_encode($reponse);
}




// LISTE PARTENAIRES ACTIFS UNIQUEMENT :
if (isset($_POST['statut_du_partenaire'])) {
  $toggle = $_POST['statut_du_partenaire'];

  // Si le bouton est sur true...
  if ($toggle == "true") {
    $reponse = [];
    // A remplacer par une requête préparée et des champs pour le tri ?
    // (lorsque je clique sur tel bouton ça injecte ASC ou DESC à la fin etc...)
    // Je pense qu'il vaut mieux laisser cette partie à Javascript...
    $partenairesQ = $db->query(
      "SELECT nom, mail, niveau_droits, nombre_de_structures
      FROM FitnessP_Partenaire WHERE niveau_droits > 0"
    );


    $nom = [];
    $mail = [];
    $niveau_droits = [];
    $nombre_de_structures = [];

    foreach ($partenairesQ as $partenaire) {
      $nom[] = htmlspecialchars($partenaire['nom']);
      $mail[] = htmlspecialchars($partenaire['mail']);
      $niveau_droits[] = htmlspecialchars($partenaire['niveau_droits']);
      $nombre_de_structures[] = htmlspecialchars($partenaire['nombre_de_structures']);
    }

    $reponse['noms'] = $nom;
    $reponse['mails'] = $mail;
    $reponse['niveau_droits'] = $niveau_droits;
    $reponse['nombre_de_structures'] = $nombre_de_structures;
  }
  //
  else {
    $reponse = [];
    // A remplacer par une requête préparée et des champs pour le tri ?
    // (lorsque je clique sur tel bouton ça injecte ASC ou DESC à la fin etc...)
    // Je pense qu'il vaut mieux laisser cette partie à Javascript...
    $partenairesQ = $db->query(
      "SELECT nom, mail, niveau_droits, nombre_de_structures
      FROM FitnessP_Partenaire"
    );


    $nom = [];
    $mail = [];
    $niveau_droits = [];
    $nombre_de_structures = [];

    foreach ($partenairesQ as $partenaire) {
      $nom[] = htmlspecialchars($partenaire['nom']);
      $mail[] = htmlspecialchars($partenaire['mail']);
      $niveau_droits[] = htmlspecialchars($partenaire['niveau_droits']);
      $nombre_de_structures[] = htmlspecialchars($partenaire['nombre_de_structures']);
    }

    $reponse['noms'] = $nom;
    $reponse['mails'] = $mail;
    $reponse['niveau_droits'] = $niveau_droits;
    $reponse['nombre_de_structures'] = $nombre_de_structures;
  }

  echo json_encode($reponse);
}
