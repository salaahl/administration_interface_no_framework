function commonPassword (input) 
{
    NBP.init("mostcommon_10000", "/app/collections", true);
    let password = $(input).val();

    if (NBP.isCommonPassword(password))
    {
      return false;
    } else {
      return true;
    }
};
