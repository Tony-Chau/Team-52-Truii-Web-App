<?php
function navBarCreate($ColorCode, $currentpage){
echo '<ul class="navbar" style="background-color:'.$ColorCode.'; z-index: 5">
        <li class="fa fa-angle-left fa-4x" onclick="goBack()"></li>
        <li><a href="#about">'.$currentpage.'</a></li>
        <li><a href="home.php">Home</a></li>
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

  function goBack() {
     window.history.back();
  }
</script>
';
}
 ?>
