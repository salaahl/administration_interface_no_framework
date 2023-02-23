$(function() {

  $.getScript("../composants/common_password.js");

  $.validator.addMethod(
    "noCommonPassword",
    function() {
      return commonPassword('#change_password');
    },
    "Votre mot de passe n'est pas assez sécurisé. Veuillez le modifier."
  );

  $("form").validate({
    rules: {
      change_password: {
        required: true,
        minlength: 5,
        noCommonPassword: true
      },
      confirm_password: {
        required: true,
        equalTo: "#change_password"
      }
    },
    messages: {
      change_password: {
        required: "Ce champ est obligatoire.",
        minlength: "Veuillez saisir au moins 5 caractères."
      },
      confirm_password: {
        required: "Ce champ est obligatoire.",
        equalTo: "Veuillez entrer à nouveau la même valeur."
      }
    },
    submitHandler: function() {
      $("form").on("submit", function(e) {
        e.preventDefault();
        
        let searchParams = new URLSearchParams(window.location.search);
        let mail = searchParams.get("mail");
        let nouveauMdp = $("#change_password").val();

        $.ajax({
          type: "post",
          url: "index.php",
          data: { mail: mail, nouveau_mdp: nouveauMdp },
          success: function(data) {
            if (data == "") {
              alert("Nouveau mot de passe enregistré. Veuillez vous reconnecter.");
              location.replace("./login.html");
            } else {
              alert(data);
            }
          },
          error: function() {
            alert("Erreur. Veuillez contacter un administrateur.");
          },
        });
      })
    }
  })
});
