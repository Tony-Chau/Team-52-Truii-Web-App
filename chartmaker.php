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

 <title>Chart Maker</title>
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="css/bootstrap-theme.min.css">
 <link rel="stylesheet" href="css/style.css">

</head>
<body>
<header id ="titlelogo2">
  <div class="container">
    <h1> Chart Maker </h1>
  </div>
</header>

  <div id ="Homebutton">
    <div class= "container">

        <div align="center">
          <a href="charttype.php" style="text-decoration:none">
          <br><input type="image" src="images//addnew.png" name="image" width="180" height="120"><br>
          <h1 style="color:#EF6724;"> New Chart </h1></a>
        </div>


        <div align="center">
          <a href="charttype.php" style="text-decoration:none">
          <br><input type="image" src="images//viewold.png" name="image" width="180" height="120"><br>
          <h1 style="color:#EF6724;"> View Previous Charts</h1> </a>
        </div>

    </div>
  </div>
</body>
</html>
