window.onload = function () {
  NBP.init("mostcommon_1000000", "./collections", true);

  var status_msg = document.getElementById("niveau_mot_de_passe");

  document
    .getElementById("changer_mot_de_passe")
    .addEventListener("keyup", function (evt) {
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
};
