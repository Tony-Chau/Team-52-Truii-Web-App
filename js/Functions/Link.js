function GetLink(PageDirectory, Type, Value){
  var link = "" + PageDirectory;
  if (Type == null || Value == null || Type == "" || Value == ""){
    return link;
  }
  var length = Type.length;
  link += "?";
  if (length > 1){
    for (var i = 0; i < length; i += 1){
      link += str.replace(' ', '%20', Type[i]) + "=" + str.replace(' ', '_', Value[i]);
      if (i != length - 1){
        link += "&";
      }
    }
  }else if(length == 1){
    link += str.replace(' ', '%20', Type) + "=" + str.replace(' ', '_', Value);
  }
  return link;
}
function isset(val){
  if (typeof val === 'undefined'){
    return false;
  }
  return true;
}

function mail(){
  window.location.href = "mailto:team52.truii@gmail.com?subject=Truii Help";
}
