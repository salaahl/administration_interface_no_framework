$(document).ready(function () {

  // Va lancer mes scripts de création de tables
  $.ajax({
    url: "index.php",
  });

  $("form").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
      type: "post",
      url: "index.php",
      dataType: "JSON",
      data: $(this).serialize(),
      success: function (response) {
        function changerMdp() {
          return location.replace("./changer_mdp.php?mail=" + response.mail);
        }

        if (response.droits == 3) {
          console.log(response);
          location.replace("./front-end/liste_part.php");
        } else if (response.droits == 2) {
          if (response.premiere_connexion == 1) {
            location.replace(
              "./front-end/partenaire.php?mail_p=" + response.mail
            );
          } else {
            changerMdp();
          }
        } else if (response.droits == 1) {
          if (response.premiere_connexion == 1) {
            location.replace(
              "./front-end/structure.php?mail_s=" +
                response.mail +
                "&mail_p=" +
                response.mail_part
            );
          } else {
            changerMdp();
          }
        } else if (response.droits == 0) {
          $(".id_incorrects").text(
            "Profil désactivé. Veuillez contacter un administrateur."
          );
        } else {
          // Peut-être préciser si c'est le mail ou le mdp le fautif...
          $(".id_incorrects").text(response.droits);
        }
      },
      error: function (xhr) {
        var err = JSON.parse(xhr.responseText);
        console.log(err.message);
      },
    });
  });
});
