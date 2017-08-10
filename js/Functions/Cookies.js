function WriteCookie(name, value, expirytime){
  var date = new Date();
  var expiry = expirytime*24*60*60*1000; // will last for 24 hours if expiry time = 1
  date.setTime(date.getTime() + (expiry);
  var expires = "expires=" + date.toUTCString();
  document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

function readCookie(Cookiename){
  var name = Cookiename + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var cookieArray = decodedCookie.split(';');
  for (var i = 0; i < cookieArray.length; i += 1){
    var cookie = cookieArray[i];
    while(cookie.charAt(0) == ' '){
      cookie = cookie.substring(1, cookie.length);
    }
    if (cookie.indexOf(name) == 0){
      return cookie.substring(name.length, cookie.length);
    }
  }
}

function CheckCookie(name){
  return (readCookie(name) != '');
}

function ClearCookie(name){
  document.cookie = name + "=;expires=" + Date() + ";";
}
