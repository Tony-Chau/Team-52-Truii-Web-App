<!DOCTYPE html>
<html>
<head>

 <title>Chart Maker</title>
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="css/bootstrap-theme.min.css">
 <link rel="stylesheet" href="css/style.css">

</head>

<header id ="titlelogo2">
  <div class="container">
  <h1> Chart Maker </h1>

  </div>

</header>

<div id ="Homebutton">
  <div class= "container">

<form name="myform" action="chartmaker.php" method="POST">
<div align="center">
<br><input type="image" src="images//addnew.png" name="image" width="180" height="120"><br>
<h1 style="color:#EF6724;"> New Chart </h1>
</div>

<div>
  <form name="myform" action="recorddatapage.php" method="POST">
  <div align="center">
  <br><input type="image" src="images//viewold.png" name="image" width="180" height="120"><br>
  <h1 style="color:#EF6724;"> View Previous Charts</h1>
</div>
</form>

</html>