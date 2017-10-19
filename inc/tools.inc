<?php
function gotoPage($page){
  echo "<script>window.location.href = '$page.php'; </script>";
}

function navBarCreate($ColorCode, $currentpage){
  $distance = '0%';
  $nav = " <nav class='navbar navbar-default' style='width: 100%; position: absolute; background-color:$ColorCode;padding-bottom:1.5%;height:12%; z-index: 5;margin-left:-20px;margin-right:-20px; list-style-type: none;'>
              <div class='container-fluid'>";
              if ($currentpage != 'Home'){
                $nav .= "<div>
                <a href='' onclick='window.history.back();return false;'>
                        <ul><li style='margin-top:-0.5%;' class='fa fa-angle-left fa-3x'></li></ul></a></div>
                        <div style='margin-left:22.5%;margin-bottom:1%;'>
                        <a href='recorddatapageAddDelete'>
                                <ul><li style='margin-top:0.5%;' class='fa fa-table fa-3x'></br></li></ul></a>
                        </div>
                        <div style='margin-left:55%;'>
                        <a href='chartmaker'>
                                <ul><li style='margin-top:0.5%;' class='fa fa-bar-chart fa-3x'></br></li></ul></a>
                      </div>";
                $distance = '-2.5%';
              }
  $nav .= "<div style='margin-top:$distance;float:right;margin-right:2%;'>
  <a href='' onClick='logout();'>
          <ul><li class='fa fa-gear fa-3x'></br></li></ul></a></div>
          <form method=POST>
            <div align='center'>
              <input type='submit' id='logsub' name='logout' style='display:none;'>
            </div>
          </form></a>
  </div>
  </nav>
  <script>
  function logout(){
    $('#logsub').click();
  }
</script>
  ";
  echo $nav;
}

function CallTestAlert($message){
  echo "<script>alert('".$message."');</script>";
}

function ConvertDatatoCSV($FieldName_Array, $Value_Array){
  $csv = '';
  $length =  count($FieldName_Array);
  for ($i = 0; $i < $length; $i += 1){
    if ($i == $length - 1){
      $csv .= $FieldName_Array[$i] . "\n";
    }else{
      $csv .= $FieldName_Array[$i] . ', ';
    }
  }
  for ($i = 0; $i < $length; $i += 1){
    for ($j = 0; $j < $length; $j += 1){
      if ($j == $length - 1){
        $csv .= $Value_Array[$i][$j];
      }else{
        $csv .= $Value_Array[$i][$j] . ', ';
      }
    }
  }
  return $csv;
}
 ?>
