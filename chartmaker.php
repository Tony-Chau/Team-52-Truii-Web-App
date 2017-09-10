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
    <div class="row">
      <div class="col-xs-6">
    <h1> Chart Maker </h1>
    </div>
      <div class="col-xs-3">

      <div class="icon">
      <img class="" src="images//homeicon-01.png" alt=""> </div>

      </div>

  <div class="col-xs-3">
  <div class="icon">
      <img class="" src="images//back-01.png" alt=""> </div>
</div>
</div>
</div>

</header>
  
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
