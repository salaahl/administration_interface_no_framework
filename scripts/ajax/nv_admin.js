var motDePasse = document.getElementById("changer_mot_de_passe"),
  confirmerMotDePasse = document.getElementById("confirmer_mot_de_passe"),
  status_msg = document.getElementById("niveau_mot_de_passe");

NBP.init("mostcommon_10000", "./collections", true);

var confirm = confirm();

// FONCTION
function confirm() {
  function validerMotDePasse() {
    if (motDePasse.value != confirmerMotDePasse.value) {
      confirmerMotDePasse.setCustomValidity(
        "Les mots de passe ne correspondent pas"
      );
      return false;
    } else {
      confirmerMotDePasse.setCustomValidity("");
      return true;
    }
  }
  
  motDePasse.onchange = validerMotDePasse;
  confirmerMotDePasse.onkeyup = validerMotDePasse;
}

// FONCTION
motDePasse.addEventListener("keyup", function (evt) {
  NBP.init("mostcommon_10000", "../../collections", true);

  var pwd = document.getElementById("changer_mot_de_passe").value;

  if (pwd.length < 1) {
    status_msg.innerHTML = "";
  } else if (NBP.isCommonPassword(pwd) || pwd.length < 5) {
    status_msg.innerHTML = "Faible";
    status_msg.style.color = "red";
  } else {
    status_msg.innerHTML = "Ok";
    status_msg.style.color = "green";
  }
});

// SUBMIT
$("form").on("submit", function (e) {
  e.preventDefault();

  if (status_msg.textContent !== "Ok") {
    alert(
      "Votre mot de passe est faible. Il ne doit pas être commun et avoir au minimum 5 caractères. Veuillez le changer."
    );
  } else {
    $.ajax({
      type: "post",
      url: "../../index.php",
      data: $(this).serialize(),
      success: function (data) {
        if(data == '') {
        alert("Administrateur enregistré ! Veuillez vous connecter.");
        location.replace("../../login.html");
        } else {
          alert(data);
        }
      },
      error: function () {
        alert("Erreur. L'administrateur n'a pas été créé.");
      },
    });
  }
});
