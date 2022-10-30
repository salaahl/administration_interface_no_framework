$(function () {
  $("form").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      type: "post",
      url: "../index.php",
      data: $(this).serialize(),
      success: function (data) {
        if(data == '') {
          alert("Profil crée !");
          location.replace("../front-end/liste_part.php");
          } else {
            alert(data);
          }
      },
      error: function (xhr) {
        alert(
          "Erreur : le nom et/ou le mail sont déjà utilisés par un autre partenaire."
        );
      },
    });
  });
});