<?php
  include './sql/mysql.inc';
  if (!is_log()){
    header('location: Index.php');
  }
  if($_SERVER['REQUEST_METHOD'] == "POST") {
    if (is_log()){
      log_out();
      header('location: Index.php');
    }
  }
?>
<!DOCTYPE html>
<html>
<head>

 <title>Truii Home</title>
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="css/bootstrap-theme.min.css">
 <link rel="stylesheet" href="css/style.css">

</head>
<body>
  <header id="titlelogo1">
    <div class="container1">
    <span class="logo1"></span>
    </div>

    <form method="POST">
      <div align="center">
        <input type="submit" value="Logout" id="logout" class="submit"><br>
      </div>
    </form>
  </header>


  <div id ="Homebutton">
    <div class= "container1">


        <div align="center">
          <a href='chartmaker.php' style="text-decoration:none">
          <br><input type="image" src="images//graphmarker.png" name="image" width="120" height="80" href='chartmaker.php'><br>
          <h1 style="color:#EF6724;"> Graph Marker </h1> </a>
        </div>


        <div align="center">
          <a href='recorddatapage.php' style="text-decoration:none">
          <br><input type="image" src="images//recorddata.png" name="image" width="120" height="80"><br>
          <h1 style="color:#0ABFDD;"> Record Data</h1> </a>
        </div>

    </div>
  </div>
</body>
</html>
