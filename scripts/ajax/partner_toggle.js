// Se déclenchera chaque fois que N'IMPORTE QUEL switch de ma page sera modifié :
$(".toggle").change(function () {

  let toggle = $(this).prop("checked");
  let id = $(this).attr("id");
  let nom = document.getElementById("nom_partenaire").textContent.slice(13);
  let permission = id.slice(5);
  let searchParams = new URLSearchParams(window.location.search);
  let mail = searchParams.get("mail_p");

  if (confirm("Veuillez confirmer votre choix") == true) {
    $.ajax({
      url: "../index.php",
      method: "POST",
      data: {
        toggle_partenaire: toggle,
        id: id,
        mail: mail,
        nom: nom,
        permission: permission,
      },
      error: function () {
        alert("Impossible de mettre à jour la permission. Veuillez contacter un administrateur.");
      },
    });
  } else {
    return toggle
      ? $(this).prop("checked", false)
      : $(this).prop("checked", true);
  }
});
