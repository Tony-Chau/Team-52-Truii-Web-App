<?php
function gotoPage($page){
  echo "<script>window.location.href = '$page.php'; </script>";
}
function navBarCreate($ColorCode, $currentpage){
  $distance = '-5px';
  $nav = " <nav class='navbar navbar-default' style='width: 100%;position:fixed;background-color:$ColorCode;padding-bottom:2%;height:40px;z-index: 1002;margin-left:-20px;margin-right:-20px;list-style-type:none;'>
              <div class='container-fluid'>";
              if ($currentpage != 'Home'){
                $nav .= "<div>
                <a href='' onclick='window.history.back();return false;'>
                        <ul><li style='margin-top:-5px' class='fa fa-angle-left fa-3x'></li></ul></a></div>
                        <div style='margin-left:22.5%;margin-bottom:1%;'>
                        <a href='recorddatapageAddDelete.php'>
                                <ul><li style='margin-top:-3px;' class='fa fa-table fa-3x'></br></li></ul></a>
                        </div>
                        <div style='margin-left:55%;'>
                        <a href='previousgraphpage.php'>
                                <ul><li style='margin-top:-3px;' class='fa fa-bar-chart fa-3x'></br></li></ul></a>
                      </div>";
                $distance = '-15px';
              }
  $nav .= "<div style='margin-top:$distance;float:right;margin-right:2%;'>
  <a href='settings.php'>
          <ul><li class='fa fa-gear fa-3x'></br></li></ul></a></div>
          <form method=POST>
            <div align='center'>
              <input type='submit' id='logsub' name='logout' style='display:none;'>
            </div>
          </form></a>
  </div>
  </nav>";
  echo $nav;
}
function CallTestAlert($message){
  echo "<script>alert('".$message."');</script>";
}
function ConvertDatatoCSV($FieldName_Array, $Value_Array){
  $csv = '';
  $Fieldlength =  count($FieldName_Array);
  for($i = 0; $i < $Fieldlength; $i += 1){
    if ($i == $Fieldlength - 1){
      $csv .= checkWord($FieldName_Array[$i]) . "\n";
    }else{
      $csv .= checkWord($FieldName_Array[$i]) . ",";
    }
  }
  for ($i = 1; $i < count($Value_Array); $i += 1){
    for ($j = 0; $j < $Fieldlength; $j += 1){
      $word = $Value_Array[$i][$j];
      if ($j == $Fieldlength - 1){
        $csv .= checkWord($word) . "\n";
      }else{
        $csv .= checkWord($word) . ",";
      }
    }
  }
  return $csv;
}
function checkWord($word){
  if (!is_numeric($word)){
    $sub = 0;
    $check = false;
    for ($i = 0; $i < strlen($word); $i += 1){
      if ($word[$i] != ' ' && !$check){
        $sub = $i;
        $check = true;
      }
    }
    return substr($word, $sub);
  }
  return $word;
}
function CheckMobile($ismobile = null){
  //Code from Detect Mobile Browsers
  $useragent=$_SERVER['HTTP_USER_AGENT'];
  if(!(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
){
    //Create error page
    if ($ismobile == null){
      gotoPage('browserError');
    }
  }else{
    if ($ismobile != null){
        gotoPage('Index');
    }
  }
}
function RandomColourGenerator(){
  return "rgb(".rand(0,255).", ".rand(0,255).", ".rand(0,255).")";
}
function checkPhone(){
  $useragent = $_SERVER['HTTP_USER_AGENT'];
  $iPod    = stripos($useragent,"iPod");
  $iPhone  = stripos($useragent,"iPhone");
  $iPad    = stripos($useragent,"iPad");
  if ($iPod || $iPhone || $iPad){
    return 'ios';
  }else{
    return 'android';
  }
}

function sendmail($sendto, $header, $subject, $message){
  mail($sendto, $subject, $message, $header);
}

function generatekey(){
  $str = '';
  for ($i = 0; $i < 10; $i += 1){
    $str .= rand(0, 9);
  }
  return $str;
}

function createlink($purpose, $key){
  $str = 'https://www.team52truii.heliohost.org/confirmaccount?';
  if ((is_array($purpose) && is_array($key)) && (count($purpose) == count($key))){
    for ($i = 0; i < count($purpose); $i += 1){
      $str .= $purpose[$i] . '=' . $key[$i];
      if (i < count($purpose) - 1){
        $str .= '&';
      }
      return $str;
    }
  }else{
    return $str . $purpose . '=' . $key;
  }
}

function createCookie($name, $value){
  setcookie($name, $value, time() + (60*60*24*2), '/');
  //set to 2 days
}

function checkCookie($name, $value){
  if (isset($_COOKIE[$name]) && $_COOKIE[$name] == $value){
    return true;
  }
  return false;
}
 ?>
