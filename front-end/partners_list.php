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
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Liste des partenaires</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link href="../css/partners_list.css" rel="stylesheet" type="text/css" />
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
   <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
    integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"
    integrity="sha512-6S5LYNn3ZJCIm0f9L6BCerqFlQ4f5MwNKq+EthDXabtaJvg3TuFLhpno9pcm+5Ynm6jdA9xfpQoMz2fcjVMk9g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="../scripts/composants/sidebar.js"></script>
  <script src="../scripts/ajax/partners_list.js"></script>
  <script src="../scripts/ajax/partners_filter.js"></script>
</body>

</html>
