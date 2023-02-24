$(document).ready(function () {
  $.ajax({
    type: "post",
    url: "../index.php",
    data: { part_structure: 'Initialize' },
    dataType: "JSON",
    success: function (data) {
      let city = data;
      city.forEach((city) => {
        $("#city").append("<option>" + city + "</option>");
      });
    },
    error: function () {
      var err = JSON.parse(xhr.responseText);
      alert('Erreur. Impossible d\'initialiser la liste des villes.');
    },
  });
});
