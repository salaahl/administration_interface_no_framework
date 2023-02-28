$(document).ready(function () {
  $("#partner_search").keyup(function () {
    $("#search_result").html("");
    let saisie = $(this).val();
    if (saisie != "") {
      $.ajax({
        type: "POST",
        url: "../index.php",
        data: { partner_search: encodeURIComponent(saisie) },
        dataType: "JSON",
        success: function (data) {
          if (data.city.length !== 0) {
            for (let c = 0; data.city.length > c; c++) {
              if (data.rights[c] == 2) {
                var status = "Partenaire activé";
                var classe = "partner_active";
              } else {
                var status = "Partenaire désactivé";
                var classe = "partner_inactive";
              }
              $("#search_result").append(
                '<div class="partner_list">' +
                  '<div class="partner-about">' +
                  "<div>" +
                  data.city[c] +
                  "</div>" +
                  "<div>" +
                  data.mail[c] +
                  "</div>" +
                  "<div>Nombre de structures : " +
                  data.structures[c] +
                  "</div>" +
                  '<div class="' +
                  classe +
                  ' px-2">' +
                  status +
                  "</div>" +
                  "</div>" +
                  '<div class="partner-link">' +
                  '<a href="partner_page.php?partner_mail=' +
                  data.mail[c] +
                  '">Détails</a>' +
                  "</div>" +
                  "</div>"
              );
              $(".partner-list").animate({ opacity: 1 }, 500);
            }
          } else {
            document.getElementById("search_result").innerHTML =
              "<div style='font-size: 20px; text-align: center;'>Aucun partenaire trouvé</div>";
          }
        },
      });
    }
  });
});
