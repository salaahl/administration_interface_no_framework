<?php session_start();

// Page de niveau 1 : structure
// 1è vérification : attribution d'un "passe-droit" pour l'admin
if (!isset($_SESSION['admin'])) {

  // 2è vérification : les droits
  if ($_SESSION['rights'] < 1) {
    echo '<script>alert("Connectez-vous pour accéder à cette page.");
          window.location.href="../login.html"</script>';
  }

  // 3è vérification : empêcher une structure de se rendre sur la page d'une autre structure :

  // Cas de figure 1 : accès depuis un login structure
  if (isset($_SESSION['structure_mail'])) {
    if ($_SESSION['structure_mail'] !== $_GET['structure_mail']) {
      echo '<script>window.location.href="./structure_page.php?structure_mail=' . $_SESSION['structure_mail'] . '&partner_mail=' . $_GET['partner_mail'] . '"</script>';
    }
  }
  // Cas de figure 2 : accès depuis un login partenaire
  if (isset($_SESSION['city'])) {
    if ($_SESSION['city'] !== $_GET['city']) {
      echo '<script>window.location.href="./partner_page.php?city=' . $_SESSION['city'] . '"</script>';
    }
  }
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
  <title>Page structure</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link href="../css/structure.css" rel="stylesheet" type="text/css" />
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
    <?php
    if (isset($_SESSION['city']) or isset($_SESSION['admin'])) { ?>
      <a id="back-partner-page"><svg xmlns="http://www.w3.org/2000/svg" width="3rem" height="3rem" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
          <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
        </svg></a>
    <?php } ?>
    <div class="en-tete">
      <div>
        <h1 id="city" class="display-6">Structure du partenaire : </h1>
      </div>
      <div id="structure-mail">Mail : </div>
      <div id="structure-address">Adresse : </div>

      <?php if (isset($_SESSION['rights']) && $_SESSION['rights'] >= 2) { ?>

        <div class="structure-status form-check form-switch">
          <label class="form-check-label" for="structure-status">Structure actif : </label>
          <input type="checkbox" role="switch" class="form-check-input" id="structure-status" />
        </div>
        <div class="structure-delete">
          <form action="../index.php" method="POST">
            <input type="hidden" id="structure-delete" name="structure_delete" />
            <input type="hidden" id="structure-city" name="structure_city" />
            <button class="btn btn-danger" type="submit" onclick="return confirm(
                'Etes-vous sûr ? Cette action est irréversible.'
              )">
              Supprimer cette structure
            </button>
          </form>
        </div>
      <?php } ?>
    </div>

    <!-- Permissions globales -->
    <div class="permissions">
      <h6>Permissions de la structure : </h6>
      <!-- Switch 1 -->
      <div class="form-check form-switch">
        <input type="checkbox" role="switch" class="form-check-input toggle" id="drinks-permission" name="drinks_permission" />
        <label class="form-check-label" for="toggle_boissons">Vente de boissons</label>
      </div>
      <!-- Switch 2 -->
      <div class="form-check form-switch">
        <input type="checkbox" role="switch" class="form-check-input toggle" id="newsletter-permission" name="newsletter_permission" />
        <label class="form-check-label" for="toggle_newsletter">Envoyer une newsletter</label>
      </div>
      <!-- Switch 3 -->
      <div class="form-check form-switch">
        <input type="checkbox" role="switch" class="form-check-input toggle" id="planning-permission" name="planning_permission" />
        <label class="form-check-label" for="toggle_planning">Gérer le planning d'une équipe</label>
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
  <script src="../scripts/ajax/structure.js"></script>
  <script src="../scripts/ajax/structure_toggle.js"></script>
  <script src="../scripts/ajax/structure_status.js"></script>
</body>

</html>