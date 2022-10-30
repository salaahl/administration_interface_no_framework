var motDePasse = document.getElementById("changer_mot_de_passe"),
  confirmerMotDePasse = document.getElementById("confirmer_mot_de_passe");

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
