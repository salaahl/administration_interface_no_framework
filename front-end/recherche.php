<?php session_start();


$timeout = 600;

if (isset($_SESSION['timeout'])) {
  // See if the number of seconds since the last
  // visit is larger than the timeout period.
  $duration = time() - (int)$_SESSION['timeout'];
  if ($duration > $timeout) {
    session_destroy();
    session_start();
  }

  $_SESSION['timeout'] = time();
}



// Niveau 3 : admin
if (!isset($_SESSION['admin'])) {
  echo '<script>alert("Vous n\'avez pas les droits requis pour accéder à cette page.");
          window.location.href="../login.html"</script>';
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Recherche d'un partenaire</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <link href="../css/recherche.css" rel="stylesheet" type="text/css" />
  <link href="../css/sidebar.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <div class="row">
    <div class="col-4 col-md-4 col-lg-3" id="sidebar"></div>
    <main class="ui-widget col-8 col-md-8 col-lg-9 pt-2 px-5">
      <h1 class="display-6">Rechercher un partenaire :</h1>
      <input id="recherche_part" placeholder="Rechercher un partenaire">
      <div id="resultat_part"></div>
    </main>
  </div>
  <script src="../scripts/ajax/recherche.js"></script>
  <script src="../scripts/composants/sidebar.js"></script>
</body>

</html>