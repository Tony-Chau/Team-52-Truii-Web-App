<?php
  include 'sql/mysql.inc';
  include 'inc/tools.inc';
  include 'inc/styles_and_scripts.inc';

  if (!is_log()){
    header('location: Index');
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
    <div class= "container1">


        <div align="center">

            <div class="big1">
          <br><a href='chartmaker' style="text-decoration:none"><div><input type="image" src="images//graphmarker.png" name="image" href='chartmaker'><br> </div>
          <h1 style="color:#EF6724;"> Chart Marker </h1></div></a>
        </div>
        <br unselectable="on">

        <div align="center">
           <div class="big2">
           <a href='recorddatapageAddDelete' style="text-decoration:none"><div>
          <br><input type="image" src="images//recorddata.png" name="image" href='recorddatapageAddDelete'><br> </div>
          <h1 style="color:#0ABFDD;" style="width:50%;"> Record Data</h1></div></a>
        </div>

    </div>
  </div>
</body>
</html>
