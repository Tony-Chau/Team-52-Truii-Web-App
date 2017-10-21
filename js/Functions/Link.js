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

function ConvertDatatoCSV(FieldName_Array, Value_Array){
  var csv = '';
  var length = FieldName_Array.length;
  for (var i = 0; i < length; i += 1){
    if (i == length - 1){
      csv += FieldName_Array[i] + "\n";
    }else{
      csv += FieldName_Array[i] + ", ";
    }
  }
  for (var i = 0; i < length; i += 1){
    for (var j = 0; j < length; j += 1){
      if (j == length - 1){
        csv += Value_Array[i][j];
      }else{
        csv += Value_Array[i][j] + ', ';
      }
    }
  }
  return csv;
}
