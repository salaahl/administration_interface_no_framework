$(document).ready(function () {
  $.ajax({
    type: "POST",
    url: "../index.php",
    data: { liste_part: "initialize" },
    dataType: "JSON",
    success: function (data) {
      for (let c = 0; data.city.length > c; c++) {
        if (data.rights[c] == 2) {
          var statut = "Partenaire activé";
          var classe = "partner-active";
        } else {
          var statut = "Partenaire désactivé";
          var classe = "partner-inactive";
        }
        $("#liste_part").append(
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
            classe +
            ' px-2">' +
            statut +
            "</div>" +
            "</div>" +
            '<div class="partner_link">' +
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
