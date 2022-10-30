$("#statut_structure").change(function () {
  var toggle = $(this).prop("checked");
  var searchParams = new URLSearchParams(window.location.search);
  var mail = searchParams.get("mail_s");

  if (confirm("Veuillez confirmer votre action") == true) {
    $.ajax({
      url: "../index.php",
      method: "POST",
      data: { activer_structure: toggle, mail: mail },
      success: function (data) {},
      error: function () {},
    });
  } else {
    return toggle
      ? $(this).prop("checked", false)
      : $(this).prop("checked", true);
  }
});
