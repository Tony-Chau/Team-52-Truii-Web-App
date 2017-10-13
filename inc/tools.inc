<?php
function gotoPage($page){
  echo "<script>window.location.href = '". $page ."'; </script>";
}

function navBarCreate($ColorCode, $currentpage){
  $nav =  '<ul class="navbar" style="background-color:'.$ColorCode.'; z-index: 5">';
  if ($currentpage != 'Home'){
    $nav .= '<a href="" onclick="window.history.back();return false;"><li class="fa fa-angle-left fa-4x"></li></a>';
  }
  echo $nav . '<li><a href="home">'.$currentpage.'</a></li>
        <a href="chartmaker"><li class="fa fa-bar-chart fa-4x"></li></a>
        <a href="recorddatapageAddDelete"><li class="fa  fa-pencil-square-o fa-4x"></li></a>
        <li style="float:right;">
          <a href="" onClick=logout();>Logout <span class="glyphicon glyphicon-log-out"></span></a>
          <form method="POST">
            <div align="center">
              <input type="submit" id="logsub" name="logout" style="display:none;">
            </div>
          </form>
        </li>
      </ul>
<script>
  function logout(){
    $("#logsub").click();
  }
</script>
';
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
