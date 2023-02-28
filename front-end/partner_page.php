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
  else if ($_SESSION['partner_mail'] !== $_GET['partner_mail']) {
    echo '<script>window.location.href="./partner.php?partner_mail=' . $_SESSION['partner_mail'] . '"</script>';
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
  <link href="../css/partner.css" rel="stylesheet" type="text/css" />
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
              <input type="hidden" id="partner_delete" name="partner_delete" />
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
          <input type="checkbox" role="switch" class="form-check-input toggle" id="drinks_permission" name="drinks_permission" />
          <label class="form-check-label" for="drinks_permission">Vente de boissons</label>
        </div>
        <!-- Switch 2 -->
        <div class="form-check form-switch">
          <input type="checkbox" role="switch" class="form-check-input toggle" id="newsletter_permission" name="newsletter_permission" />
          <label class="form-check-label" for="newsletter_permission">Envoyer une newsletter</label>
        </div>
        <!-- Switch 3 -->
        <div class="form-check form-switch">
          <input type="checkbox" role="switch" class="form-check-input toggle" id="planning_permission" name="planning_permission" />
          <label class="form-check-label" for="planning_permission">Gérer le planning d'une équipe</label>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
   <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
    integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"
    integrity="sha512-6S5LYNn3ZJCIm0f9L6BCerqFlQ4f5MwNKq+EthDXabtaJvg3TuFLhpno9pcm+5Ynm6jdA9xfpQoMz2fcjVMk9g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  
  <?php if (isset($_SESSION['rights']) && $_SESSION['rights'] > 2) { ?>
    <script src="../scripts/composants/sidebar.js"></script>
  <?php } else { ?>
    <script src="../scripts/composants/sidebar_part_struc.js"></script>
  <?php } ?>
  
  <script src="../scripts/ajax/partner_page.js"></script>
  <script src="../scripts/ajax/partner_status.js"></script>
  <script src="../scripts/ajax/partner_toggle.js"></script>
</body>

</html>
