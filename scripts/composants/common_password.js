function commonPassword (passwordInput) 
{
    NBP.init("mostcommon_10000", "collections/", true);
    let password = $(passwordInput).val();

    if (NBP.isCommonPassword(password))
    {
      return false;
    } else {
      return true;
    }
};
