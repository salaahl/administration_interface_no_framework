$(function () {
  // 'form' pour la balise "form"
  // "on submit" est un event listener
  // 'e' est rattaché au 'form'
  $("form").on("submit", function (e) {
    // "preventDefaut" casse le comportement par défaut du bouton "submit" (qui est de rafraîchir la page)
    e.preventDefault();
    // "action = post/get" et "method = index.php" sont à renseigner ici visiblement et pas dans la balise de form
    $.ajax({
      type: "post",
      url: "../index.php",
      // Je dis à mon code de prendre les données contenues dans le formulaire. This fait référence au 'form' que j'ai renseigné avant.
      // "serialize" a l'air de formater le texte
      data: $(this).serialize(),
      success: function () {
        alert("Données enregistrées !");
      },
      error: function () {
        alert("Erreur");
      },
    });
  });
});
