$(".toggle").change(function () {
  let partnerToggle = $(this).prop("checked");
  let toggleName = $(this).attr("name");
  let partnerCity = document.getElementById("nom_partenaire").textContent.slice(13);
  let searchParams = new URLSearchParams(window.location.search);
  let partnerMail = searchParams.get("partner_mail");

  if (confirm("Veuillez confirmer votre choix") == true) {
    $.ajax({
      url: "../index.php",
      method: "POST",
      data: {
        partner_toggle: partnerToggle,
        toggle_name: toggleName,
        partner_mail: partnerMail,
        partner_city: partnerCity
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
