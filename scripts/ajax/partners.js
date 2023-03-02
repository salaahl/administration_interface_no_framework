$(document).ready(function () {
  $.ajax({
    type: "POST",
    url: "../index.php",
    data: {
      partners: "initialize",
      partners_active: $("#partner-active").prop("checked"),
    },
    dataType: "JSON",
    success: function (data) {
      for (let c = 0; data.city.length > c; c++) {
        if (data.rights[c] == 2) {
          var status = "Partenaire activé";
          var statusClass = "partner-active";
        } else {
          var status = "Partenaire désactivé";
          var statusClass = "partner-inactive";
        }
        $("#partners-list").append(
          '<div class="liste_part col-12 col-xl-5">' +
            '<div class="partner-about">' +
            "<div>" +
            data.cities[c] +
            "</div>" +
            "<div>" +
            data.mails[c] +
            "</div>" +
            "<div>Nombre de structures : " +
            data.number_of_structures[c] +
            "</div>" +
            '<div class="' +
            statusClass +
            ' px-2">' +
            status +
            "</div>" +
            "</div>" +
            '<div class="partner-link">' +
            '<a href="partner_page.php?partner_mail=' +
            data.mails[c] +
            '">Détails</a>' +
            "</div>" +
            "</div>"
        );
      }
    },
  });
});
