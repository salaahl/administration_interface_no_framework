<?php session_start();


// Niveau 2 : partenaire
// 1è vérification : attribution d'un passe-droit pour l'admin
if (!isset($_SESSION['admin'])) {

  // 2è vérification : les droits
  if ($_SESSION['niveau_droits'] < 2) {
    echo '<script>alert("Connectez-vous pour accéder à cette page.");
          window.location.href="../login.html"</script>';
  }

  // 3è vérification : empêcher un partenaire de se rendre sur la page d'un autre partenaire
  else if ($_SESSION['mail_p'] !== $_GET['mail_p']) {
    echo '<script>window.location.href="./partenaire.php?mail=' . $_SESSION['mail'] . '"</script>';
  }
}
?>

<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Page partenaire</title>
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link href="../css/partenaire.css" rel="stylesheet" type="text/css" />
  <link href="../css/bouton_desac.css" rel="stylesheet" type="text/css" />
  <link href="../css/sidebar.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <div class="row">
    <div class="col-4 col-md-4 col-lg-3" id="sidebar"></div>
    <div class="body col-8 col-md-8 col-lg-9">
      <div class="en_tete">
        <div id="nom_part">
          <h1 id="nom_partenaire" class="display-6">Partenaire : </h1>
        </div>
        <div id="mail">Mail : </div>

        <?php if (isset($_SESSION['niveau_droits']) && $_SESSION['niveau_droits'] > 2) { ?>

          <div class="statut_partenaire">
            <label for="">Partenaire actif : </label>
            <label class="switch">
              <input id="statut_part" type="checkbox">
              <div class="slider"></div>
            </label>
          </div>
          <div class="delete-partner">
            <form action="../index.php" method="POST">
              <input type="hidden" id="delete_partner" name="delete_partner" value="" />
              <button class="btn btn-danger" 
              type="submit" 
              onclick="return confirm(
                'Etes-vous sûr ? Cette action est irréversible.'
              )">
              Supprimer ce partenaire
              </button>
            </form>
          </div>

        <?php } ?>

      </div>

      <!-- Structures du partenaire -->
      <div class="label_structures">
        <h3>Mes structures</h3>
      </div>
      <div id="structures">
        <?php if (isset($_SESSION['admin'])) { ?>
          <div class="structure">
            <a href="../ajouter/structure.php" style="text-align: center;">
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
          <input class="form-check-input toggle" type="checkbox" role="switch" id="perm_boissons" />
          <label class="form-check-label" for="toggle_boissons">Vente de boissons</label>
        </div>
        <!-- Switch 2 -->
        <div class="form-check form-switch">
          <input class="form-check-input toggle" type="checkbox" role="switch" id="perm_newsletter" />
          <label class="form-check-label" for="toggle_newsletter">Envoyer une newsletter</label>
        </div>
        <!-- Switch 3 -->
        <div class="form-check form-switch">
          <input class="form-check-input toggle" type="checkbox" role="switch" id="perm_planning" />
          <label class="form-check-label" for="toggle_planning">Gérer le planning d'une équipe</label>
        </div>
      </div>
    </div>
  </div>
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  
  <?php if (isset($_SESSION['niveau_droits']) && $_SESSION['niveau_droits'] > 2) { ?>
    <script src="../scripts/composants/sidebar.js"></script>
  <?php } else { ?>
    <script src="../scripts/composants/sidebar_part_struc.js"></script>
  <?php } ?>

  <script src="../scripts/ajax/toggle_partenaire.js"></script>
  <script src="../scripts/ajax/partenaire.js"></script>
  <script src="../scripts/ajax/statut_part.js"></script>
</body>

</html>
