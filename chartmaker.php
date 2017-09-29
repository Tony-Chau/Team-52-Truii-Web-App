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
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://font.googleapis.com/css?family-Source+San+Pro:300,400,600,700" rel="stylesheet">
</head>

<body>
<ul>


<li class ="fa fa-angle-left fa-4x"></li>
<li class ="fa  fa-pencil-square-o fa-4x"></li>
<li class ="fa fa-bar-chart fa-4x"></li>
<li style="float:left"><a class="active" href="#about">Chart Maker</a></li>
</ul>
</body>



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
