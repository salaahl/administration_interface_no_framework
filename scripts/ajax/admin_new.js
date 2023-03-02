$(function() {

  $.validator.addMethod(
    "noCommonPassword",
    function() {
      return commonPassword('#password');
    },
    "Votre mot de passe n'est pas assez sécurisé. Veuillez le modifier."
  );

  $("form").validate({
    rules: {
      admin_mail: {
        required: true
      },
      admin_password: {
        required: true,
        minlength: 5,
        noCommonPassword: true
      },
      confirm_password: {
        required: true,
        equalTo: "#admin_password"
      }
    },
    messages: {
      admin_mail: {
        required: "Ce champ est obligatoire."
      },
      admin_password: {
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
        
        $.ajax({
          type: "post",
          url: "../../index.php",
          data: $(this).serialize(),
          success: function(data) {
            if (data == '') {
              alert("Administrateur enregistré ! Veuillez vous connecter.");
              location.replace("../../login.html");
            } else {
              alert(data);
            }
          },
          error: function() {
            alert("Erreur. L'administrateur n'a pas été créé.");
          },
        });
      })
    }
  })
});
