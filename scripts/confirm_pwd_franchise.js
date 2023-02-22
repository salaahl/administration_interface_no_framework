$(function() {

  $("form").validate({
    rules: {
      changer_mot_de_passe: {
        required: true,
        minlength: 5
      },
      confirmer_mot_de_passe: {
        required: true,
        equalTo: "#changer_mot_de_passe"
      }
    },
    messages: {
      changer_mot_de_passe: {
        required: "Veuillez remplir ce champ",
        minlength: "Le mot de passe doit faire plus de cinq caractères"
      },
      confirmer_mot_de_passe: {
        required: "Veuillez remplir ce champ",
        equalTo: "Le mot de passe ne correspond pas"
      }
    },
    submitHandler: function(form) {
      form.submit();
    }
  });
});
