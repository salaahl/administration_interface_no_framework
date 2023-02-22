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
  <link href="./css/changer_mdp.css" rel="stylesheet" type="text/css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
  <div class="container">
    <form>

      <h2 class="formTitle">
        Veuillez modifier votre mot de passe
      </h2>

      <div class="inputDiv">
        <label class="inputLabel" for="changer_mot_de_passe">Nouveau mot de passe :</label>
        <label id="niveau_mot_de_passe" name="niveau_mot_de_passe" style="color: red"></label>
        <input type="password" id="changer_mot_de_passe" name="changer_mot_de_passe" required>
      </div>

      <div class="inputDiv">
        <label class="inputLabel" for="confirmer_mot_de_passe">Confirmez le nouveau mot de passe :</label>
        <input type="password" id="confirmer_mot_de_passe" name="confirmer_mot_de_passe" required>
      </div>

      <button type="submit" class="btn btn-dark">Valider</button>
    </form>
  </div>
  <script src="./scripts/composants/nbp.min.js"></script>
  <script src="./scripts/ajax/changer_mdp.js"></script>
</body>

</html>
