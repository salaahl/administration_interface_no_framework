$(document).ready(function () {
  var partenaire_structure = "ok";

  $.ajax({
    type: "post",
    url: "../index.php",
    data: { part_structure: partenaire_structure },
    dataType: "JSON",
    success: function (data) {
      let partenaires = data;
      partenaires.forEach((partenaire) => {
        $("#partenaire").append("<option>" + partenaire + "</option>");
      });
    },
    error: function (xhr) {
      var err = JSON.parse(xhr.responseText);
      alert(err.message);
    },
  });
});
