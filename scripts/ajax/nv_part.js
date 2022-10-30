$(function () {
  $("form").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      type: "post",
      url: "../index.php",
      data: $(this).serialize(),
      success: function () {
        alert("Profil crée !");
        location.replace("../front-end/liste_part.php");
      },
      error: function (xhr) {
        alert(
          "Erreur : le nom et/ou le mail sont déjà utilisés par un autre partenaire."
        );
      },
    });
  });
});
