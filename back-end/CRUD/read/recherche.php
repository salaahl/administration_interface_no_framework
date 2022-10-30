<?php


// RECHERCHE D'UN PARTENAIRE :
if (isset($_POST['rech_partenaire'])) {

  $filtre = mysqli_real_escape_string($db, $_POST['rech_partenaire']);
  $saisie = (string) trim($filtre);

  $reponse = [];
  $noms = [];
  $mails = [];
  $niveau_droits_partenaires = [];
  $nombre_de_structures_partenaires = [];

  $partenaireQ = $db->prepare(
    "SELECT nom, mail, niveau_droits, nombre_de_structures
          FROM FitnessP_Partenaire
          WHERE nom LIKE CONCAT(?, '%')
          LIMIT 3"
  );

  $partenaireQ->bind_param("s", $saisie);
  $partenaireQ->execute();
  $partenaireQ->store_result();
  $partenaireQ->bind_result($nom, $mail, $niveau_droits, $nombre_de_structures);
  while ($partenaireQ->fetch()) {
    $noms[] = htmlspecialchars($nom);
    $mails[] = htmlspecialchars($mail);
    $niveau_droits_partenaires[] = htmlspecialchars($niveau_droits);
    $nombre_de_structures_partenaires[] = htmlspecialchars($nombre_de_structures);
  }
  $partenaireQ->close();

  $reponse['noms'] = $noms;
  $reponse['mails'] = $mails;
  $reponse['niveau_droits'] = $niveau_droits_partenaires;
  $reponse['nombre_de_structures'] = $nombre_de_structures_partenaires;

  echo json_encode($reponse);
}
