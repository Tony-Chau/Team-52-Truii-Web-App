<?php
  include 'sql/mysql.inc';
  include 'inc/tools.inc';
  if (!is_log()){
    header('location: Index.php');
  }
  CheckRequestLogout();
  navBarCreate('rgb(252, 103, 25)', 'Home');
?>
<!DOCTYPE html>
<html>
<head>

 <title>Truii Home</title>
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="css/bootstrap-theme.min.css">
 <link rel="stylesheet" href="css/style.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
 <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">


</head>
<body>




  <div id ="Homebutton">
    <div class= "container1">


        <div align="center">

            <div class="big1">
          <br><a href='chartmaker.php' style="text-decoration:none"><div><input type="image" src="images//graphmarker.png" name="image" href='chartmaker.php'><br> </div>
          <h1 style="color:#EF6724;"> Chart Marker </h1></div></a>
        </div>
<br unselectable="on">

        <div align="center">
           <div class="big2">
           <a href='recorddatapageAddDelete.php' style="text-decoration:none"><div>
          <br><input type="image" src="images//recorddata.png" name="image"><br> </div>
          <h1 style="color:#0ABFDD;" style="width:50%;"> Record Data</h1></div></a>
        </div>

    </div>
  </div>
</body>
</html>
