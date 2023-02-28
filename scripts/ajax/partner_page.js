$(document).ready(function () {
  var searchParams = new URLSearchParams(window.location.search);
  var partner_mail = searchParams.get("partner_mail");

  $.ajax({
    type: "post",
    url: "../index.php",
    data: { partner_page: "initialize", partner_mail: partner_mail },
    dataType: "JSON",
    success: function (data) {
      if (data.structure_mail != "") {
        for (let c = 0; data.adress.length > c; c++) {
          $("#structures").append(
            '<div class="structure">' +
              '<a id="structure_' +
              c +
              '" href="structure.php?structure_mail=' +
              data.structure_mail[c] +
              "&partner_mail=" +
              data.partner_mail[c] +
              '">' +
              '<div class="structure_adresse">' +
              data.adress[c] +
              "</div>" +
              '<div class="structure_mail">' +
              data.structure_mail[c] +
              "</div>" +
              "</a>" +
              "</div>"
          );
        }
      }

      $("h1").append(data.city);
      $("#mail").append(partner_mail);
      $("#partner_delete").val(partner_mail);
      $("#status").prop("checked", data.status);
      $("#drinks_permission").prop("checked", data.drinks_permission);
      $("#newsletter_permission").prop("checked", data.newsletter_permission);
      $("#planning_permission").prop("checked", data.planning_permission);
    },
    error: function () {
      alert('Impossible de charger correctement la page. Veuillez contacter un administrateur.');
    },
  });
});
