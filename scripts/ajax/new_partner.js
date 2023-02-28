$(function () {
  $("form").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      type: "post",
      url: "../index.php",
      data: $(this).serialize(),
      success: function (data) {
        if(data == '') {
          alert("Profil partenaire crée ! Un mail lui a été automatiquement envoyé avec ses informations d'identification.");
          location.replace("../front-end/liste_part.php");
          } else {
            alert(data);
          }
      },
      error: function () {
        alert(
          "Erreur. Le partenaire n'a pas été créé."
        );
      },
    });
  });
});
