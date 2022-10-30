$("#statut_part").change(function () {
  var toggle = $(this).prop("checked");
  var searchParams = new URLSearchParams(window.location.search);
  var mail = searchParams.get("mail_p");

  if (confirm("Veuillez confirmer votre action") == true) {
    $.ajax({
      url: "../index.php",
      method: "POST",
      // Données qui seront ensuite accéssibles dans                $_POST : l'état du switch (true/false) et son id
      data: { activer_partenaire: toggle, mail: mail },
      success: function (data) {},
      error: function () {},
    });
  } else {
    return toggle
      ? $(this).prop("checked", false)
      : $(this).prop("checked", true);
  }
});
