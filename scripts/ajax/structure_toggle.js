$(".toggle").change(function () {
  let structureToggle = $(this).prop("checked");
  let toggleName = $(this).attr("name");
  let structureCity = document.getElementById("city").textContent.slice(26);
  let structureAddress = document
    .getElementById("structure_address")
    .textContent.slice(10);
  let searchParams = new URLSearchParams(window.location.search);
  let structureMail = searchParams.get("structure_mail");

  if (confirm("Veuillez confirmer votre choix") == true) {
    $.ajax({
      url: "../index.php",
      method: "POST",
      data: {
        structure_toggle: structureToggle,
        toggle_name: toggleName,
        structure_mail: structureMail,
        structure_city: structureCity,
        structure_address: structureAddress,
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
