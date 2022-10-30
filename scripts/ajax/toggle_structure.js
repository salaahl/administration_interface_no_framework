// Se déclenchera chaque fois que N'IMPORTE QUEL switch de ma page sera modifié :
$(".toggle").change(function () {
  // Permet de connaître l'état du switch
  // coché = "true" / décoché = "false"
  var toggle = $(this).prop("checked");
  // Récupérera l'id du switch déclenché
  var id = $(this).attr("id");
  // Nom du partenaire
  var nom = document.getElementById("nom_partenaire").textContent.slice(26);
  // Adresse
  var adresse = document
    .getElementById("adresse_structure")
    .textContent.slice(10);
  // Nom de la permission
  var permission = id.slice(5);
  // Récupérera le mail
  var searchParams = new URLSearchParams(window.location.search);
  var mail = searchParams.get("mail_s");

  if (confirm("Veuillez confirmer votre choix") == true) {
    $.ajax({
      url: "../index.php",
      method: "POST",
      data: {
        toggle_structure: toggle,
        id: id,
        mail: mail,
        nom: nom,
        permission: permission,
        adresse: adresse,
      },
      success: function (data) {},
      error: function () {
        alert("Erreur");
      },
    });
  } else {
    return toggle
      ? $(this).prop("checked", false)
      : $(this).prop("checked", true);
  }
});
