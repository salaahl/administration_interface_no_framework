<?php session_start();

// Niveau 3 : accessible uniquement aux admins
if (!isset($_SESSION['admin'])) {

  echo '<script>alert("Vous n\'avez pas les droits requis pour accéder à cette page.");
          window.location.href="../login.html"</script>';
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Ajouter une structure</title>
  <link href="../css/ajouter_partenaire.css" rel="stylesheet" type="text/css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
  <div class="container">
    <form>

      <h2 class="formTitle">
        Ajouter une nouvelle structure :
      </h2>

      <div class="inputDiv">
        <label class="inputLabel" for="partner_name">Partenaire affilié :</label>
        <select class="form-select" id="partenaire_name" name="partenaire_name">
          <option selected disabled>Ville</option>
        </select>
      </div>

      <div class="inputDiv">
        <label class="inputLabel" for="structure_name">Adresse de la structure :</label>
        <input type="text" id="structure_name" name="structure_name">
      </div>

      <div class="inputDiv">
        <label class="inputLabel" for="structure_mail">Entrez votre mail :</label>
        <input type="email" id="structure_mail" name="structure_mail">
      </div>

      <div class="inputDiv">
        <label class="inputLabel" for="structure_password">Entrez votre mot de passe :</label>
        <input type="password" id="structure_password" name="structure_password">
      </div>

      <div class="inputDiv">
        <label class="inputLabel" for="confirm_password">Confirmez votre mot de passe :</label>
        <input type="password" id="confirm_password" name="confirm_password">
      </div>

      <button type="submit" class="btn btn-dark">Valider</button>
    </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
    integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"
    integrity="sha512-6S5LYNn3ZJCIm0f9L6BCerqFlQ4f5MwNKq+EthDXabtaJvg3TuFLhpno9pcm+5Ynm6jdA9xfpQoMz2fcjVMk9g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="../scripts/ajax/partner_affiliate.js"></script>
  <script src="../scripts/ajax/new_structure.js"></script>
</body>

</html>
