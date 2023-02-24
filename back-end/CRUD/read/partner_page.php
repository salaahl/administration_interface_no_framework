<?php


// PAGE PARTENAIRES :
if (isset($_POST['partner_page']) && isset($_POST['mail'])) {
  
  $mail = $_POST['mail'];
  $reponse = [];

  $structureQ = $db->prepare(
    "SELECT adresse, s.mail, mail_part
    FROM FitnessP_Structure s
    JOIN FitnessP_Partenaire p
    ON s.mail_part = p.mail
    WHERE s.mail_part = ?"
  );

  $structureQ->bind_param("s", $mail);
  $structureQ->execute();
  $structureQ->store_result();
  $structureQ->bind_result($adresseS, $mailS, $mail_part);

  $c = 0;

  $mes_adresses = [];
  $mes_mails = [];
  $mes_mails_part = [];
  
  while ($structureQ->fetch()) {
    $mes_adresses[] = htmlspecialchars($adresseS);
    $mes_mails[] = htmlspecialchars($mailS);
    $mes_mails_part[] = htmlspecialchars($mail_part);
  }

  $reponse['adresses_s'] = $mes_adresses;
  $reponse['mails_s'] = $mes_mails;
  $reponse['mails_p'] = $mes_mails_part;

  $structureQ->close();

  $partenaireQ = $db->prepare(
    "SELECT *
    FROM FitnessP_Partenaire
    WHERE mail = ?"
  );
  
  $partenaireQ->bind_param("s", $mail);
  $partenaireQ->execute();
  $partenaireQ->store_result();
  $partenaireQ->bind_result($nom_marque, $nom, $mail, $mdp, $droits, $premiere_connexion, $nombre_de_structures, $permB, $permN, $permP);
  $partenaireQ->fetch();

  $reponse['nom'] = htmlspecialchars($nom);
  $reponse['perm_boissons'] = $permB;
  $reponse['perm_newsletter'] = $permN;
  $reponse['perm_planning'] = $permP;

  $partenaireQ->close();

  // Conversion de mon niveau de droits en boolean
  if ($droits == 2) {
    $reponse['statut'] = true;
  } else {
    $reponse['statut'] = false;
  }

  echo json_encode($reponse);
}
