$(document).ready(function () {
  let searchParams = new URLSearchParams(window.location.search);
  let city = searchParams.get("city");

  $.ajax({
    type: "post",
    url: "../index.php",
    data: { partner_page: "initialize", city: city },
    dataType: "JSON",
    success: function (data) {
      if (data.structures_mails != "") {
        for (let c = 0; data.structures_mails.length > c; c++) {
          $("#structures").append(
            '<div class="structure">' +
              '<a id="structure_' +
              c +
              '" href="structure_page.php?structure_mail=' +
              data.structures_mails[c] +
              "&city=" +
              city +
              '">' +
              '<div class="structure_address">' +
              data.addresses[c] +
              "</div>" +
              '<div class="structure_mail">' +
              data.structures_mails[c] +
              "</div>" +
              "</a>" +
              "</div>"
          );
        }
      }
      $("#city").append(city);
      $("#mail").append(data.mail);
      $("#partner-delete").val(data.mail);
      $("#status").prop("checked", data.status);
      $("#drinks-permission").prop("checked", data.drinks_permission);
      $("#newsletter-permission").prop("checked", data.newsletter_permission);
      $("#planning-permission").prop("checked", data.planning_permission);
    },
    error: function () {
      alert(
        "Impossible de charger correctement la page. Veuillez contacter un administrateur."
      );
    },
  });
});
