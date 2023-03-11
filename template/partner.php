<?php session_start();

// Niveau 2 : partenaire
// 1è vérification : attribution d'un passe-droit pour l'admin
if (!isset($_SESSION['admin'])) {

  // 2è vérification : les droits
  if ($_SESSION['rights'] < 2) {
    echo '<script>alert("Connectez-vous pour accéder à cette page.");
          window.location.href="../login.html"</script>';
  }

  // 3è vérification : empêcher un partenaire de se rendre sur la page d'un autre partenaire
  else if ($_SESSION['city'] !== $_GET['city']) {
    echo '<script>window.location.href="./partner.php?city=' . $_SESSION['city'] . '"</script>';
  }
}
?>

<html lang="fr">

<head>
  <meta charset="utf-8" />
  <meta name="author" lang="fr" content="Salaha SOKHONA">
  <meta name="copyright" content="Salaha SOKHONA." />
  <meta name="description" content="Interface d'administration à destination des franchisés de la marque Fitness P." />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Page partenaire</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link href="../css/partner.css" rel="stylesheet" type="text/css" />
  <link href="../css/sidebar.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <aside class="col-4 col-md-4 col-lg-3">
    <div id="sidebar"></div>
  </aside>
  <main class="col-8 col-md-8 col-lg-9">
    <div class="en-tete">
      <div id="city">
        <h1 class="display-6">Partenaire : </h1>
      </div>
      <div id="mail">Mail : </div>

      <?php if (isset($_SESSION['rights']) && $_SESSION['rights'] > 2) { ?>

        <div class="partner-status form-check form-switch">
          <label class="form-check-label" for="partner-status">Partenaire actif : </label>
          <input type="checkbox" role="switch" class="form-check-input" id="partner-status" />
        </div>
        <div class="partner-delete">
          <form action="../index.php" method="POST">
            <input type="hidden" id="delete-user" name="partner_delete" />
            <button class="btn btn-danger" type="submit" onclick="return confirm(
                'Etes-vous sûr ? Cette action est irréversible.'
              )">
              Supprimer ce partenaire
            </button>
          </form>
        </div>
      <?php } ?>
    </div>

    <div class="label-structures">
      <h3>Mes structures</h3>
    </div>
    <div id="structures">
      <?php if (isset($_SESSION['admin'])) { ?>
        <div class="structure">
          <a href="../ajouter/structure_new.php" style="text-align: center;">
            <h4>Ajouter une structure</h4>
          </a>
        </div>
      <?php } ?>
    </div>

    <!-- Permissions globales -->
    <div class="permissions">
      <h6>Permissions globales : </h6>
      <!-- Switch 1 -->
      <div class="form-check form-switch">
        <input type="checkbox" role="switch" class="form-check-input toggle" id="drinks-permission" name="drinks_permission" />
        <label class="form-check-label" for="drinks_permission">Vente de boissons</label>
      </div>
      <!-- Switch 2 -->
      <div class="form-check form-switch">
        <input type="checkbox" role="switch" class="form-check-input toggle" id="newsletter-permission" name="newsletter_permission" />
        <label class="form-check-label" for="newsletter_permission">Envoyer une newsletter</label>
      </div>
      <!-- Switch 3 -->
      <div class="form-check form-switch">
        <input type="checkbox" role="switch" class="form-check-input toggle" id="planning-permission" name="planning_permission" />
        <label class="form-check-label" for="planning_permission">Gérer le planning d'une équipe</label>
      </div>
    </div>
      </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
  <?php if (isset($_SESSION['rights']) && $_SESSION['rights'] > 2) { ?>
    <script src="../scripts/composants/sidebar.js"></script>
  <?php } else { ?>
    <script src="../scripts/composants/sidebar_part_struc.js"></script>
  <?php } ?>

  <script src="../scripts/ajax/partner.js"></script>
  <script src="../scripts/ajax/partner_status.js"></script>
  <script src="../scripts/ajax/partner_toggle.js"></script>
</body>

</html>