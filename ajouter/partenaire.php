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
  <title>Ajouter un partenaire</title>
  <link href="../css/ajouter_partenaire.css" rel="stylesheet" type="text/css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
  <div class="container">
    <form>

      <h2 class="formTitle">
        Ajouter un nouveau partenaire :
      </h2>

      <div class="inputDiv">
        <label class="inputLabel">Nom de la ville :</label>
        <input type="text" name="nom_partenaire" required>
      </div>

      <div class="inputDiv">
        <label class="inputLabel">Entrez votre mail :</label>
        <input type="email" name="mail_partenaire" required>
      </div>

      <div class="inputDiv">
        <label class="inputLabel">Entrez votre mot de passe :</label>
        <label id="niveau_mot_de_passe" style="color: red"></label>
        <input type="password" id="changer_mot_de_passe" name="mot_de_passe_partenaire" required>
      </div>

      <div class="inputDiv">
        <label class="inputLabel">Confirmez votre mot de passe :</label>
        <input type="password" id="confirmer_mot_de_passe" required>
      </div>

      <button type="submit" class="btn btn-dark">Valider</button>
    </form>
  </div>
  <script src="../scripts/confirm_pwd_franchise.js"></script>
  <script src="../scripts/ajax/nv_part.js"></script>
</body>

</html>