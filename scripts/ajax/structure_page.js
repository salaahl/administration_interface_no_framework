$(document).ready(function () {
  var searchParams = new URLSearchParams(window.location.search);
  var structureMail = searchParams.get("structure_mail");
  var partnerMail = searchParams.get("partner_mail");

  $.ajax({
    type: "POST",
    url: "../index.php",
    data: { structure_page: "initialize", structure_mail: structureMail },
    dataType: "JSON",
    success: function (data) {
      $("#structure-delete").val(structureMail);
      $("#structure-mail").append(structureMail);
      $("#partner-page").attr("href",
        "../front-end/partner_page.php?partner_mail=" + partnerMail
      );
      $("#city").append(data.city);
      $("#structure-address").append(data.address);
      $("#status").prop("checked", data.status);
      $("#drinks-permission").prop("checked", data.drinks_permission);
      $("#newsletter-permission").prop("checked", data.newsletter_permission);
      $("#planning-permission").prop("checked", data.planning_permission);
    },
    error: function () {
      alert("L'initialisation du profil a échouée. Veuillez contacter un administrateur.");
    },
  });
});
