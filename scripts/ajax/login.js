$(document).ready(function () {

  // Va lancer mes scripts de création de tables
  $.ajax({
    url: "index.php",
  });
  
  function changerMdp() {
    return location.replace("./change_password.php?mail=" + response.mail);
  }

  $("form").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
      type: "post",
      url: "index.php",
      dataType: "JSON",
      data: $(this).serialize(),
      success: function (response) {
        if (response.droits == 3) {
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
          $(".id_incorrects").text(response.droits);
        }
      },
      error: function () {
        alert('Connexion impossible. Veuillez contacter un administrateur.')
      },
    });
  });
});
