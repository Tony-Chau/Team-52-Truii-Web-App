<?php
  include 'sql/mysql.inc';
  include 'inc/NavBar.inc';
  if (!is_log()){
    header('location: Index.php');
  }
  CheckRequestLogout();
  navBarCreate('rgb(252, 103, 25)', 'Chart Maker');

?>
<!DOCTYPE html>
<html>
<head>

 <title>Chart Maker</title>
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="css/bootstrap-theme.min.css">
 <link rel="stylesheet" href="css/style.css">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://font.googleapis.com/css?family-Source+San+Pro:300,400,600,700" rel="stylesheet">

</head>

<body>

</body>
<!-- =======
  <ul class="chartpages">
    <!-
    <li><a href="#home">Home</a></li>
    <li><a href="#news">fa-angle-left</a></li>
    ->
    <li style="float:right"><a class="active" href="#about">Chart Maker</a></li>
    <li class="fa fa-angle-left fa-4x" onclick="goBack()"></li>
    <a href="chartmaker.php"><li class="fa fa-bar-chart fa-4x"></li></a>
    <a href="recorddatapageAddDelete.php"><li class="fa  fa-pencil-square-o fa-4x"></li></a>
  </ul>
>>>>>>> 96c96403f8c25fab08d61e1c12a05909dc8a7aca
-->



  <div id ="Homebutton">
    <div class= "container">

      <a href="charttype.php" style="text-decoration:none">
        <div align="center">
            <div class="big1">
              <br><input type="image" src="images//addnew.png" name="image" ><br></div>
          <h1 style="color:#EF6724;"> New Chart </h1>
        </div>
      </a>

      <a href="previousgraphpage.php" style="text-decoration:none">
        <div align="center">
          <div class="big2">
            <br><input type="image" src="images//viewold.png" name="image"><br></div>
          <h1 style="color:#EF6724;"> View Previous Charts</h1>
        </div>
      </a>

    </div>
  </div>
</body>
</html>
