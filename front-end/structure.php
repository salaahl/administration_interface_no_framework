<?php session_start();

// Page de niveau 1 : structure
// 1è vérification : attribution d'un passe-droit pour l'admin
if (!isset($_SESSION['admin'])) {

  // 2è vérification : les droits
  if (isset($_SESSION['niveau_droits']) && $_SESSION['niveau_droits'] < 1) {
    echo '<script>alert("Connectez-vous pour accéder à cette page.");
          window.location.href="../login.html"</script>';
  }

  // 3è vérification : empêcher une structure de se rendre sur la page d'une autre structure :

  // Cas de figure 1 : accès depuis un login structure
  if (isset($_SESSION['mail_s'])) {
    if ($_SESSION['mail_s'] !== $_GET['mail_s']) {
      echo '<script>window.location.href="./structure.php?mail_s=' . $_SESSION['mail_s'] . '&mail_p=' . $_GET['mail_p'] . '"</script>';
    }
  }
  // Cas de figure 2 : accès depuis un login partenaire
  if (isset($_SESSION['mail_p'])) {
    if ($_SESSION['mail_p'] !== $_GET['mail_p']) {
      echo '<script>window.location.href="./partner.php?mail_p=' . $_SESSION['mail_p'] . '"</script>';
    }
  }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Page structure</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link href="../css/structure.css" rel="stylesheet" type="text/css" />
  <link href="../css/bouton_desac.css" rel="stylesheet" type="text/css" />
  <link href="../css/sidebar.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <div class="row">
    <div class="col-4 col-md-4 col-lg-3" id="sidebar"></div>
    <div class="body col-8 col-md-8 col-lg-9 pt-2 px-5">
      <?php
      if (isset($_SESSION['mail_p']) or isset($_SESSION['admin'])) { ?>
        <a href="" id="retour_page_partenaire"><svg xmlns="http://www.w3.org/2000/svg" width="3rem" height="3rem" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
          </svg></a>
      <?php } ?>
      <div class="en_tete">
        <div id="nom_structure">
          <h1 id="nom_partenaire" class="display-6">Structure du partenaire : </h1>
        </div>
        <div id="mail_structure">Mail : </div>
        <div id="adresse_structure">Adresse : </div>

        <?php if (isset($_SESSION['niveau_droits']) && $_SESSION['niveau_droits'] >= 2) { ?>

          <div class="statut_structure">
            <label for="">Structure active : </label>
            <label class="switch">
              <input id="statut_structure" type="checkbox">
              <div class="slider"></div>
            </label>
          </div>
          <div class="delete-structure">
            <form action="../index.php" method="POST">
              <input type="hidden" id="delete_structure" name="structure_delete" value="" />
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

      <!-- Permissions globales -->
      <div class="permissions">
        <h6>Permissions de la structure : </h6>
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
  <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
    integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"
    integrity="sha512-6S5LYNn3ZJCIm0f9L6BCerqFlQ4f5MwNKq+EthDXabtaJvg3TuFLhpno9pcm+5Ynm6jdA9xfpQoMz2fcjVMk9g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <?php if (isset($_SESSION['niveau_droits']) && $_SESSION['niveau_droits'] > 2) { ?>
    <script src="../scripts/composants/sidebar.js"></script>
  <?php } else { ?>
    <script src="../scripts/composants/sidebar_part_struc.js"></script>
  <?php } ?>
  <script src="../scripts/ajax/structure.js"></script>
  <script src="../scripts/ajax/structure_toggle.js"></script>
  <script src="../scripts/ajax/structure_status.js"></script>
</body>

</html>
