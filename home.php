<?php
  include 'sql/mysql.inc';
  include 'inc/NavBar.inc';

  if (!is_log()){
    header('location: Index.php');
  }
  CheckRequestLogout();
  navBarCreate('rgba(238, 86, 36, 0.6)', 'home.php');
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


</head>
<body>
  <!-- <header id="titlelogo1">
    <div class="container1">
    <span class="logo1"></span>
    </div>

    <form method="POST">
      <div align="center">
        <input type="submit" value="Logout" id="logout" name="logout" class="submit"><br>
      </div>
    </form>
  </header> -->



  <div id ="Homebutton">
    <div class= "container1">

          <a href='chartmaker.php' style="text-decoration:none">
        <div align="center">

            <div class="big1">
          <br><input type="image" src="images//graphmarker.png" name="image" href='chartmaker.php'><br> </div>
          <h1 style="color:#EF6724;"> Chart Marker </h1>
        </div></a>

          <a href='recorddatapage.php' style="text-decoration:none">
        <div align="center">
           <div class="big2">
          <br><input type="image" src="images//recorddata.png" name="image" href='recorddatapage.php'><br> </div>
          <h1 style="color:#0ABFDD;"> Record Data</h1>
        </div></a>

    </div>
  </div>
</body>
</html>
