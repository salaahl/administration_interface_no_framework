<?php



// PAGE STRUCTURES :
if (isset($_POST['page_structure'])) {

  $mail = $_POST['mail'];
  $reponse = [];

  // ----- Structure
  $structureQ = $db->prepare(
    "SELECT *
    FROM FitnessP_Structure
    WHERE mail = ?"
  );
  $structureQ->bind_param("s", $mail);
  $structureQ->execute();
  $structureQ->store_result();
  $structureQ->bind_result($mailP, $adresse, $mailS, $mdp, $droits, $premiereConnexion, $permB, $permN, $permP);
  $structureQ->fetch();

  $reponse['mail_partenaire'] = htmlspecialchars($mailP);
  $reponse['adresse'] = htmlspecialchars($adresse);
  $reponse['mail'] = htmlspecialchars($mailS);
  $reponse['perm_boissons'] = $permB;
  $reponse['perm_newsletter'] = $permN;
  $reponse['perm_planning'] = $permP;

  // Conversion de mon niveau de droits en boolean
  if ($droits == 1) {
    $reponse['statut'] = true;
  } else {
    $reponse['statut'] = false;
  }

  $structureQ->close();

  $PartenaireQ = $db->prepare(
    "SELECT nom
      FROM FitnessP_Partenaire
      WHERE mail = ?"
  );
  $PartenaireQ->bind_param("s", $mailP);
  $PartenaireQ->execute();
  $PartenaireQ->store_result();
  $PartenaireQ->bind_result($nom);
  $PartenaireQ->fetch();

  $reponse['nom_partenaire'] = htmlspecialchars($nom);

  echo json_encode($reponse);
}
