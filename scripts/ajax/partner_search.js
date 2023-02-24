$(document).ready(function () {
  $("#recherche_part").keyup(function () {
    $("#resultat_part").html("");

    let saisie = $(this).val();

    if (saisie != "") {
      $.ajax({
        type: "POST",
        url: "../index.php",
        data: { rech_partenaire: encodeURIComponent(saisie) },
        dataType: "JSON",
        success: function (data) {
          if (data.noms.length !== 0) {
            for (let c = 0; data.noms.length > c; c++) {
              if (data.niveau_droits[c] == 2) {
                var statut = "Partenaire activé";
                var classe = "part_actif";
              } else {
                var statut = "Partenaire désactivé";
                var classe = "part_non_actif";
              }
              $("#resultat_part").append(
                '<div class="liste_part">' +
                  '<div class="infos_part">' +
                  "<div>" +
                  data.noms[c] +
                  "</div>" +
                  "<div>" +
                  data.mails[c] +
                  "</div>" +
                  "<div>Nombre de structures : " +
                  data.nombre_de_structures[c] +
                  "</div>" +
                  '<div class="' +
                  classe +
                  ' px-2">' +
                  statut +
                  "</div>" +
                  "</div>" +
                  '<div class="lien">' +
                  '<a href="partenaire.php?mail_p=' +
                  data.mails[c] +
                  '">Détails</a>' +
                  "</div>" +
                  "</div>"
              );
              $(".liste_part").animate({ opacity: 1 }, 500);
            }
          } else {
            document.getElementById("resultat_part").innerHTML =
              "<div style='font-size: 20px; text-align: center;'>Aucun partenaire trouvé</div>";
          }
        },
      });
    }
  });
});
