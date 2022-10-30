<?php session_start();


$timeout = 600;

if (isset($_SESSION['timeout'])) {

  $duration = time() - (int)$_SESSION['timeout'];
  if ($duration > $timeout) {
    session_destroy();
    session_start();
  }

  $_SESSION['timeout'] = time();
}



// Niveau 3 : admin
if (!isset($_SESSION['admin'])) {
  echo '<script>alert("Vous n\'avez pas les droits requis pour accéder à cette page. Veuillez vous connecter");
          window.location.href="../login.html"</script>';
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Liste des partenaires</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link href="../css/liste_part.css" rel="stylesheet" type="text/css" />
  <link href="../css/sidebar.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <div class="row">
    <div class="col-4 col-md-4 col-lg-3" id="sidebar"></div>
    <main class="col-8 col-md-8 col-lg-9 pt-2 px-5 pt-2 px-5">
      <div id="en_tete">
        <h1 class="display-6">Liste de mes partenaires :</h1>
        <!-- Switch des actifs -->
        <div class="switch_des_actifs form-check form-switch">
          <input class="form-check-input toggle" type="checkbox" role="switch" id="statut_du_partenaire" />
          <label class="form-check-label" for="statut_du_partenaire">Actifs uniquement</label>
        </div>
      </div>
      <div class="ajouter_partenaire">
        <a href="../ajouter/partenaire.php">
          Ajouter un nouveau partenaire
        </a>
      </div>
      <div id="liste_part"></div>
    </main>
  </div>
  <script src="../scripts/composants/sidebar.js"></script>
  <script src="../scripts/ajax/liste_part.js"></script>
  <script src="../scripts/ajax/filtre_actifs.js"></script>
</body>

</html>