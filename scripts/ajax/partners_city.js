$(document).ready(function () {
  $.ajax({
    type: "post",
    url: "../index.php",
    data: { cities_list: 'initialize' },
    dataType: "JSON",
    success: function (data) {
      let city = data;
      city.forEach((city) => {
        $("#city").append("<option>" + city + "</option>");
      });
    },
    error: function () {
      alert('Erreur. Impossible d\'initialiser la liste des villes.');
    },
  });
});
