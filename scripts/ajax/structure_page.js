$(document).ready(function () {
  var searchParams = new URLSearchParams(window.location.search);
  var mail = searchParams.get("structure_mail");
  var partnerMail = searchParams.get("city");

  $.ajax({
    type: "POST",
    url: "../index.php",
    data: { structure_page: "initialize", mail: mail },
    dataType: "JSON",
    success: function (data) {
      $("#structure-delete").val(mail);
      $("#structure-mail").append(mail);
      $("#partner-page").attr("href",
        "../front-end/partner_page.php?city=" + partnerMail
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
