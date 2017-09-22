<?php
function navBarCreate($ColorCode, $previous){
echo '<nav style="background-color:'.$ColorCode.'">
  <ul>
    <li class="active"><a href="#about">Chart Maker</a></li>
    <li><a href="home.php">Home</a></li>
    <li><a href="'.$previous.'">Back</a></li>
  <li style="float:right;">
  <a href="" onClick=logout();>Logout <span class="glyphicon glyphicon-log-out"></span></a>
    <form method="POST">
      <div align="center">
        <input type="submit" id="logsub" name="logout" style="display:none;">
      </div>
    </form>
</li>
</nav>
<script>
  function logout(){
    $("#logsub").click();
  }
</script>
';
}
 ?>
