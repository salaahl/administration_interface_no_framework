$(document).ready(function () {
  var pageP = "ok";
  var searchParams = new URLSearchParams(window.location.search);
  var mail = searchParams.get("mail_p");

  $.ajax({
    type: "post",
    url: "../index.php",
    data: { page_partenaire: pageP, mail: mail },
    dataType: "JSON",
    success: function (data) {
      // Structures
      if (data.mails_s != "") {
        for (let c = 0; data.adresses_s.length > c; c++) {
          $("#structures").append(
            '<div class="structure">' +
              '<a id="lien_s_' +
              c +
              '" href="structure.php?mail_s=' +
              data.mails_s[c] +
              "&mail_p=" +
              data.mails_p[c] +
              '">' +
              '<div class="structure_adresse">' +
              data.adresses_s[c] +
              "</div>" +
              '<div class="structure_mail">' +
              data.mails_s[c] +
              "</div>" +
              "</a>" +
              "</div>"
          );
        }
      }

      // Données du partenaire et permissions
      $("h1").append(data.nom);
      $("#mail").append(mail);
      $("#delete_partner").val(mail);
      $("#statut_part").prop("checked", data.statut);
      $("#perm_boissons").prop("checked", data.perm_boissons);
      $("#perm_newsletter").prop("checked", data.perm_newsletter);
      $("#perm_planning").prop("checked", data.perm_planning);
    },
    error: function (xhr) {
      var err = JSON.parse(xhr.responseText);
      alert(err.message);
    },
  });
});
