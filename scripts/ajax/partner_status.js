$("#partner_status").change(function () {
  var toggle = $(this).prop("checked");
  var searchParams = new URLSearchParams(window.location.search);
  var partnerMail = searchParams.get("partner_mail");

  if (confirm("Veuillez confirmer votre action") == true) {
    $.ajax({
      url: "../index.php",
      method: "POST",
      data: { partner_activate: toggle, partner_mail: partnerMail },
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
