$(document).ready(function () {
  let searchParams = new URLSearchParams(window.location.search);
  let partnerMail = searchParams.get("partner_mail");

  $.ajax({
    type: "post",
    url: "../index.php",
    data: { partner_page: "initialize", partner_mail: partnerMail },
    dataType: "JSON",
    success: function (data) {
      if (data.structure_mail != "") {
        for (let c = 0; data.adress.length > c; c++) {
          $("#structures").append(
            '<div class="structure">' +
              '<a id="structure_' +
              c +
              '" href="structure_page.php?structure_mail=' +
              data.structure_mail[c] +
              "&partner_mail=" +
              data.partner_mail[c] +
              '">' +
              '<div class="structure_address">' +
              data.address[c] +
              "</div>" +
              '<div class="structure_mail">' +
              data.structure_mail[c] +
              "</div>" +
              "</a>" +
              "</div>"
          );
        }
      }
      $("#city").append(data.city);
      $("#mail").append(partnerMail);
      $("#partner-delete").val(partnerMail);
      $("#status").prop("checked", data.status);
      $("#drinks-permission").prop("checked", data.drinks_permission);
      $("#newsletter-permission").prop("checked", data.newsletter_permission);
      $("#planning-permission").prop("checked", data.planning_permission);
    },
    error: function () {
      alert('Impossible de charger correctement la page. Veuillez contacter un administrateur.');
    },
  });
});
