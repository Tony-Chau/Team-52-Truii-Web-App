<?php
function gotoPage($page){
  echo "<script>window.location.href = '". $page .".php'; </script>";
}

function navBarCreate($ColorCode, $currentpage){
  $distance = '0%';
  $nav = " <nav class='navbar navbar-default' style='background-color:".$ColorCode.";padding-bottom:1.5%;height:12%; z-index: 5 !important;'>
              <div class='container-fluid'>";
              if ($currentpage != 'Home'){
                $nav .= "<div>
                <a href='' onclick='window.history.back();return false;'>
                        <ul><li class='fa fa-angle-left fa-4x'></li></ul></a></div>
                        <div style='margin-left:15%;margin-bottom:1%;'>
                        <a href='chartmaker'>
                                <ul><li class='fa fa-bar-chart fa-4x'></br></li></ul></a></div>
                        <div style='margin-left:30%;margin-top:1%;'>
                        <a href='recorddatapageAddDelete'>
                                <ul><li class='fa  fa-pencil-square-o fa-4x'></br></li></ul></a></div>";
                $distance = '-1%';
              }
  $nav .= "<div style='margin-top:".$distance.";float:right;'>
  <a href='recorddatapageAddDelete'>
          <ul><li class='fa fa-gear fa-4x'></br></li></ul></a></div>
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
