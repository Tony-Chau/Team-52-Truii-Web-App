<?php
  include 'sql/mysql.inc';
  include 'inc/NavBar.inc';
  if (!is_log()){
    header('location: Index.php');
  }
  CheckRequestLogout();
  navBarCreate('rgb(252, 103, 25)', 'Chart List');
?>
<!DOCTYPE html>
<html>
<head>

 <title>Chart Type</title>
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="css/bootstrap-theme.min.css">
 <link rel="stylesheet" href="css/style.css">
 <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
 <link href="https://font.googleapis.com/css?family-Source+San+Pro:300,400,600,700" rel="stylesheet">


</head>
<body>

  <!--
  <ul class="chartpages">
    <!-
    <li><a href="#home">Home</a></li>
    <li><a href="#news">Back</a></li>
    ->
    <li style="float:right"><a class="active" href="#about">Chart Type</a></li>
    <li class="fa fa-angle-left fa-4x" onclick="goBack()"></li>
    <a href="chartmaker.php"><li class="fa fa-bar-chart fa-4x"></li></a>
    <a href="recorddatapageAddDelete.php"><li class="fa  fa-pencil-square-o fa-4x"></li></a>
  </ul>-->

  <div id ="Homebutton">

  <body style="background-image: url('images/backgroundss.png');background-position:right top;background-size:auto 100%;background-repeat: no-repeat; ">

  <div class= "container1">

        <a href="graph.php" style="text-decoration:none">
      <div align="center">
        <br><input type="image" src="images//piechart.png" name="image" width="180" height="180"><br>
        <h1 style="color:#EF6724;"> Pie Chart </h1>
      </div></a>


          <a href="recorddatapage.php" style="text-decoration:none">
      <div align="center">

        <br><input type="image" src="images//bargraph.png" name="image" width="180" height="180"><br>
        <h1 style="color:#EF6724;">Bar Chart</h1>
      </div></a>

        <a href="recorddatapage.php" style="text-decoration:none">
      <div align="center">
        <br><input type="image" src="images//linegraph.png" name="image" width="180" height="180"><br>
        <h1 style="color:#EF6724;">Line Chart</h1>
      </div></a>

  </div>
</body>
</html>
