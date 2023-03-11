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
  <meta name= "author" lang="fr" content= "Salaha SOKHONA" >
  <meta name="copyright" content="Salaha SOKHONA." />
  <meta name="description" content="Interface d'administration à destination des franchisés de la marque Fitness P."/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Liste des partenaires</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link href="../css/partners.css" rel="stylesheet" type="text/css" />
  <link href="../css/sidebar.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <div class="row">
    <div class="col-4 col-md-4 col-lg-3" id="sidebar"></div>
    <main class="col-8 col-md-8 col-lg-9 pt-2 px-5 pt-2 px-5">
      <div>
        <h1 class="display-6">Liste de mes partenaires :</h1>
        <!-- Switch des actifs -->
        <div class="form-check form-switch">
          <input type="checkbox" role="switch" class="form-check-input" id="partners-active" />
          <label class="form-check-label" for="partners-active">Actifs uniquement</label>
        </div>
      </div>
      <div class="partner-add">
        <a href="../ajouter/partner_new.php">
          Ajouter un nouveau partenaire
        </a>
      </div>
      <div id="partners-list"></div>
    </main>
  </div>
   <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
    crossorigin="anonymous"></script>
  <script src="../scripts/composants/sidebar.js"></script>
  <script src="../scripts/ajax/partners.js"></script>
</body>

</html>
