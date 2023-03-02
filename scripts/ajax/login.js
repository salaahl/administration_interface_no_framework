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
        function changePassword() {
          return location.replace("./change_password.php?mail=" + response.mail);
        }
        if (response.rights == 3) {
          location.replace("./front-end/partners.php");
        } else if (response.rights == 2) {
          if (response.first_connection == 1) {
            location.replace(
              "./front-end/partner_page.php?city=" + response.city
            );
          } else {
            changePassword();
          }
        } else if (response.rights == 1) {
          if (response.first_connection == 1) {
            location.replace(
              "./front-end/structure_page.php?structure_mail=" +
                response.structure_mail +
                "&city=" +
                response.city
            );
          } else {
            changePassword();
          }
        } else if (response.rights == 0) {
          $(".id_incorrects").text(
            "Profil désactivé. Veuillez contacter un administrateur."
          );
        } else {
          $(".id_incorrects").text(response.rights);
        }
      },
      error: function () {
        alert('Connexion impossible. Veuillez contacter un administrateur.')
      },
    });
  });

});
