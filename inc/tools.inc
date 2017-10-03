<?php
function GetCurrentTime(){
  $time = new DateTimeZone('Australia/Brisbane');
  $datetime = new DateTime();
  $datetime->setTimezone($time);
  return $datetime;
}

function NumberToWordsFormat($Number){
  $format = new NumberFormatter("en", NumberFormatter::SPELLOUT);
  $FormNumber = $format->format($Number);
  $NewFormNumber = str_replace(" ", "_", $FormNumber);
  return str_replace("-", "_", $NewFormNumber);
}

function SpaceCancel($string){
  $NewFormNumber = str_replace(" ", "_", $FormNumber);
  return str_replace("-", "_", $NewFormNumber);
}

function gotoPage($page){
  echo "<script>window.location.href = '". $page ."'; </script>";
}

function navBarCreate($ColorCode, $currentpage){
echo '<ul class="navbar" style="background-color:'.$ColorCode.'; z-index: 5">
        <a href="" onclick="window.history.back();return false;"><li class="fa fa-angle-left fa-4x"></li></a>
        <li><a href="home.php">'.$currentpage.'</a></li>
        <a href="chartmaker.php"><li class="fa fa-bar-chart fa-4x"></li></a>
        <a href="recorddatapageAddDelete.php"><li class="fa  fa-pencil-square-o fa-4x"></li></a>
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
 ?>
