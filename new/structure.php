<?php
session_start();

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
  <link href="../css/add_user.css" rel="stylesheet" type="text/css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
  <div class="container">
    <form>
      <h2 class="formTitle">
        Ajouter une nouvelle structure :
      </h2>

      <div class="inputDiv">
        <label class="inputLabel" for="city">Partenaire affilié :</label>
        <select class="form-select" id="city" name="city" required>
          <option selected disabled>Ville</option>
        </select>
      </div>

      <div class="inputDiv">
        <label class="inputLabel" for="address">Adresse de la structure :</label>
        <input type="text" id="address" name="address" required>
      </div>

      <div class="inputDiv">
        <label class="inputLabel" for="structure-mail">Entrez votre mail :</label>
        <input type="email" id="structure-mail" name="structure_mail" required>
      </div>
      <button type="submit" class="btn btn-dark">Valider</button>
      <input type="hidden" name="structure_new" value="new" />
    </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
  <script src="../scripts/ajax/structure_new.js"></script>
</body>

</html>