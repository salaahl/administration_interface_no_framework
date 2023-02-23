<?php
session_start();

// Cas de figure 1 : accès depuis un login structure
if (isset($_SESSION['mail_s'])) {
  if ($_SESSION['mail_s'] !== $_GET['mail']) {
    echo '<script>window.location.href="./login.html"</script>';
  }
}
// Cas de figure 2 : accès depuis un login partenaire
if (isset($_SESSION['mail_p'])) {
  if ($_SESSION['mail_p'] !== $_GET['mail']) {
    echo '<script>window.location.href="./login.html"</script>';
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Changer de mot de passe</title>
  <link href="./css/change_password.css" rel="stylesheet" type="text/css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
  <div class="container">
    <form>

      <h2 class="formTitle">
        Veuillez modifier votre mot de passe
      </h2>

      <div class="inputDiv">
        <label class="inputLabel" for="change_password">Nouveau mot de passe :</label>
        <input type="password" id="change_password" name="change_password" required>
      </div>

      <div class="inputDiv">
        <label class="inputLabel" for="change_password">Confirmez le nouveau mot de passe :</label>
        <input type="password" id="change_password" name="change_password" required>
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
  <script src="./scripts/ajax/change_password.js"></script>
</body>

</html>
