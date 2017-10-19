<?php
  include 'sql/mysql.inc';
  include 'inc/tools.inc';
  include 'inc/styles_and_scripts.inc';
  if (!is_log()){
    gotoPage('Index');
  }
  CheckRequestLogout();
  navBarCreate('rgb(252, 103, 25)', 'Home');
?>
<!DOCTYPE html>
<html>
<head>

 <title>Truii Home</title>

</head>
<body>




  <div id ="Homebutton">
    <div class= "container">
      <div class="row">
        <div class="col">

          <div align="center" style="margin-top: 20%">
            <a href='previousgraphpage.php' style="text-decoration:none;">
              <input type="image" src="images//graphmarker.png" name="image" style="width: 75%; height: 30%"><br>
              <h1 style="color:#EF6724;" style='margin-left:5%;'> <b style="font-size: 150%;">Chart Marker</b> </h1>
            </a>
          </div>

        </div>
      </div>
      <div class="row">
        <div class="col">

          <div align="center" style="font-size: 200%;">
            <a href='recorddatapageAddDelete.php' style="text-decoration:none;">
              <br><input type="image" src="images//recorddata.png" name="image" style="width: 75%; height: 30%"><br>
              <h1 style="color:#0ABFDD;" style='margin-left:5%;'> <b style="font-size: 150%;">Record Data</b> </h1>
            </a>
          </div>

        </div>
      </div>
    </div>
  </div>
</body>
</html>
