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

<ul>
  <li><a href="#home">Home</a></li>
  <li><a href="#news">Back</a></li>
  <li style="float:right"><a class="active" href="#about">Chart Maker</a></li>

</ul>

</body>
  
  <div id ="Homebutton">
    <div class= "container">

          <a href="charttype.php" style="text-decoration:none">
        <div align="center">
            <div class="big1">
              <br><input type="image" src="images//addnew.png" name="image" ><br></div>
          <h1 style="color:#EF6724;"> New Chart </h1>
        </div></a>

          <a href="charttype.php" style="text-decoration:none">
        <div align="center">
          <div class="big2">
            <br><input type="image" src="images//viewold.png" name="image"><br></div>
          <h1 style="color:#EF6724;"> View Previous Charts</h1>
        </div></a>

    </div>
  </div>
</body>
</html>
