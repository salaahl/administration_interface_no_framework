<?php session_start();


// Niveau 3 : admin
if (!isset($_SESSION['admin'])) {
  echo '<script>alert("Accès non autorisé.");
          window.location.href="../login.html"</script>';
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8" />
  <meta name="author" lang="fr" content="Salaha SOKHONA">
  <meta name="copyright" content="Salaha SOKHONA." />
  <meta name="description" content="Interface d'administration à destination des franchisés de la marque Fitness P." />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Liste des partenaires</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link href="../css/partners.css" rel="stylesheet" type="text/css" />
  <link href="../css/sidebar.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <aside>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="menu-text">MENU</span><span class="navbar-toggler-icon"></span>
    </button>
    <div id="sidebar" class="collapse"></div>
  </aside>
  <main>
    <h1 class="display-6">Liste de mes partenaires</h1>
    <!-- Switch des actifs -->
    <div class="form-check form-switch">
      <input type="checkbox" role="switch" class="form-check-input" id="partners-active" />
      <label class="form-check-label" for="partners-active">Actifs uniquement</label>
    </div>
    <div class="partner-add">
      <a href="../new/partner.php">
        Ajouter un nouveau partenaire
      </a>
    </div>
    <div id="partners-list"></div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
  <script src="../scripts/composants/sidebar.js"></script>
  <script src="../scripts/ajax/post_data.js"></script>
  <script src="../scripts/ajax/partners.js"></script>
</body>

</html>