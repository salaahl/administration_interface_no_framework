function commonPassword (passwordInput, messageStatus) 
{
  $(passwordInput).keyup(function() 
  {
    NBP.init("mostcommon_10000", "./collections", true);
    let status = $(messageStatus);
    let password = $(passwordInput).val();

    if (password.length < 1) {
      status.html("");
    } else if (NBP.isCommonPassword(password) || password.length < 5) {
      status.html("Faible");
      status.css("color", "red");
    } else {
      status.html("Ok");
      status.css("color", "green");
    }
  })
};
