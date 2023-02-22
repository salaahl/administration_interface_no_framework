$(function() {

  $("#changer_mot_de_passe").keyup(function() {
    NBP.init("mostcommon_10000", "./collections", true);
    let status_msg = $("#niveau_mot_de_passe");
    let pwd = $(this).val();

    if (pwd.length < 1) {
      status_msg.html("");
    } else if (NBP.isCommonPassword(pwd)) {
      status_msg.html("Faible");
      status_msg.css("color", "red");
    } else {
      status_msg.html("Ok");
      status_msg.css("color", "green");
    }
  });

  $("#form-dish").validate({
    rules: {
      changer_mot_de_passe: {
        required: true,
        minlength: 5
      },
      confirmer_mot_de_passe: {
        required: true,
        equalTo: "#changer_mot_de_passe"
      },
      niveau_mot_de_passe: {
        equalTo: "Ok"
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
      },
      niveau_mot_de_passe: {
        equalTo: "Votre mot de passe est faible. Veuillez le changer"
      }
    },
    submitHandler: function() {
      // Peut-être faudra-il mettre cette partie dans le 'form.submit()'
      let searchParams = new URLSearchParams(window.location.search);
      let mail = searchParams.get("mail");
      let nouveauMdp = $("#changer_mot_de_passe").val();

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
          alert("Erreur");
        },
      });
    }
  });
});
