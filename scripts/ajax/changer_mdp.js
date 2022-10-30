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
  // Enlever ?
  motDePasse.onchange = validerMotDePasse;
  confirmerMotDePasse.onkeyup = validerMotDePasse;
}

// FONCTION
motDePasse.addEventListener("keyup", function (evt) {
  NBP.init("mostcommon_100", "./ajouter/collections", true);

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
  var searchParams = new URLSearchParams(window.location.search);
  var mail = searchParams.get("mail");
  var nouveauMdp = $("#changer_mot_de_passe").val();

  if (status_msg.textContent !== "Ok") {
    alert(
      "Votre mot de passe est faible. Il ne doit pas être commun et avoir au minimum 5 caractères. Veuillez le changer."
    );
  } else {
    $.ajax({
      type: "post",
      url: "index.php",
      data: { mail: mail, nouveau_mdp: nouveauMdp },
      success: function (data) {
        alert("Nouveau mot de passe enregistré. Veuillez vous reconnecter.");
        location.replace("./login.html");
      },
      error: function () {
        alert("Erreur");
      },
    });
  }
});
