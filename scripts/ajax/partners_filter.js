$("#statut_du_partenaire").change(function () {
  var statutPartenaire = $(this).prop("checked");

  $.ajax({
    url: "../index.php",
    method: "POST",
    data: { statut_du_partenaire: statutPartenaire },
    dataType: "JSON",
    success: function (data) {
      $("#liste_part").html("");

      for (let c = 0; data.noms.length > c; c++) {
        if (data.niveau_droits[c] == 2) {
          var statut = "Partenaire activé";
          var classe = "part_actif";
        } else {
          var statut = "Partenaire désactivé";
          var classe = "part_non_actif";
        }
        $("#liste_part").append(
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
      }
    },
    error: function () {
      console.log("Erreur. Veuillez contacter un administrateur.");
    },
  });
});
