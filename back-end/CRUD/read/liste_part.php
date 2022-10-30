<?php


// LISTE DES PARTENAIRES :
if (isset($_POST['liste_part'])) {

  $reponse = [];

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




// LISTE DES PARTENAIRES ACTIFS UNIQUEMENT :
if (isset($_POST['statut_du_partenaire'])) {
  $toggle = $_POST['statut_du_partenaire'];

  // Si le bouton est sur true...
  if ($toggle == "true") {

    $reponse = [];

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
