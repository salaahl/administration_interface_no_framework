$("#statut_part").change(function () {
  var toggle = $(this).prop("checked");
  var searchParams = new URLSearchParams(window.location.search);
  var mail = searchParams.get("mail_p");

  if (confirm("Veuillez confirmer votre action") == true) {
    $.ajax({
      url: "../index.php",
      method: "POST",
      data: { activer_partenaire: toggle, mail: mail },
      error: function () {
        alert('Impossible de mettre à jour le statut. Veuillez contacter un administrateur.')
      },
    });
  } else {
    return toggle
      ? $(this).prop("checked", false)
      : $(this).prop("checked", true);
  }
});
