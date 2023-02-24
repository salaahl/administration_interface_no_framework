$(".toggle").change(function () {
  let toggle = $(this).prop("checked");
  let id = $(this).attr("id");
  let nom = document.getElementById("nom_partenaire").textContent.slice(26);
  let adresse = document
    .getElementById("adresse_structure")
    .textContent.slice(10);
  let permission = id.slice(5);
  let searchParams = new URLSearchParams(window.location.search);
  let mail = searchParams.get("mail_s");

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
      error: function() {
        alert("Impossible de mettre à jour la permission. Veuillez contacter un administrateur.")
      }
    });
  } else {
    return toggle
      ? $(this).prop("checked", false)
      : $(this).prop("checked", true);
  }
});
