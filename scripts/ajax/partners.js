window.addEventListener("DOMContentLoaded", (event) => {
  const partnerList = document.getElementById("partners-list");
  const partnerActive = document.getElementById("partners-active");

  postData("../index.php", { partners: "initialize" })
    .then((data) => {
      if (data != "") {
        for (let c = 0; data.partner_city.length > c; c++) {
          if (data.partner_rights[c] == 2) {
            var status = "Partenaire activé";
            var statusClass = "active";
          } else {
            var status = "Partenaire désactivé";
            var statusClass = "inactive";
          }
          partnerList.innerHTML +=
            '<div class="partner-card col-12 col-xl-6">' +
            '<div class="about">' +
            "<div>" +
            data.partner_city[c] +
            "</div>" +
            "<div>" +
            data.partner_mail[c] +
            "</div>" +
            "<div>Nombre de structures : " +
            data.partner_structures_number[c] +
            "</div>" +
            '<div class="' +
            statusClass +
            ' px-2">' +
            status +
            "</div>" +
            "</div>" +
            '<div class="link">' +
            '<a href="partner.php?city=' +
            data.partner_city[c] +
            '">Détails</a>' +
            "</div>" +
            "</div>";
        }
      }
    })
    .catch(() => {
      alert("Erreur. Impossible de charger la liste des partenaires");
    });

  // Partenaires actifs uniquement
  partnerActive.addEventListener("change", () => {
    partnerList.innerHTML = "";
    postData("../index.php", {
      partners: "initialize",
      active_only: partnerActive.checked,
    })
      .then((data) => {
        if (data != "") {
          for (let c = 0; data.partner_city.length > c; c++) {
            if (data.partner_rights[c] == 2) {
              var status = "Partenaire activé";
              var statusClass = "active";
            } else {
              var status = "Partenaire désactivé";
              var statusClass = "inactive";
            }
            partnerList.innerHTML +=
              '<div class="partner-card col-12 col-xl-6">' +
              '<div class="about">' +
              "<div>" +
              data.partner_city[c] +
              "</div>" +
              "<div>" +
              data.partner_mail[c] +
              "</div>" +
              "<div>Nombre de structures : " +
              data.partner_structures_number[c] +
              "</div>" +
              '<div class="' +
              statusClass +
              ' px-2">' +
              status +
              "</div>" +
              "</div>" +
              '<div class="link">' +
              '<a href="partner.php?city=' +
              data.partner_city[c] +
              '">Détails</a>' +
              "</div>" +
              "</div>";
          }
        }
      })
      .catch(() => {
        alert("Erreur. Impossible de charger la liste des partenaires");
      });
  });
});
