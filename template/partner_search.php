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
  <title>Recherche d'un partenaire</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link href="../css/partner_search.css" rel="stylesheet" type="text/css" />
  <link href="../css/sidebar.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <aside>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="menu-text">MENU</span><span class="navbar-toggler-icon"></span>
    </button>
    <div id="sidebar" class="collapse"></div>
  </aside>
  <main class="ui-widget">
    <h1 class="display-6">Rechercher un partenaire :</h1>
    <input id="search-bar" placeholder="Rechercher un partenaire">
    <div id="search-result"></div>
  </main>
  <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js" integrity="sha512-6S5LYNn3ZJCIm0f9L6BCerqFlQ4f5MwNKq+EthDXabtaJvg3TuFLhpno9pcm+5Ynm6jdA9xfpQoMz2fcjVMk9g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <script src="../scripts/composants/sidebar.js"></script>
  <script src="../scripts/ajax/partner_search.js"></script>
</body>

</html>