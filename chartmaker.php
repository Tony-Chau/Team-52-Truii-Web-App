<?php
  include './sql/mysql.inc';
  if (!is_log()){
    header('location: Index.php');
  }
  CheckRequestLogout();
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

          <a href="charttype.php" style="text-decoration:none">
        <div align="center">
          <br><input type="image" src="images//addnew.png" name="image" width="180" height="120"><br>
          <h1 style="color:#EF6724;"> New Chart </h1>
        </div></a>

          <a href="charttype.php" style="text-decoration:none">
        <div align="center">
          <br><input type="image" src="images//viewold.png" name="image" width="180" height="120"><br>
          <h1 style="color:#EF6724;"> View Previous Charts</h1>
        </div></a>

    </div>
  </div>
</body>
</html>
