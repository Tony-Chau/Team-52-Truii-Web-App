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

 <title>Data Library</title>
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="css/bootstrap-theme.min.css">
 <link rel="stylesheet" href="css/style.css">

</head>

<body>

<ul>
  <li><a href="#home">Home</a></li>
  <li><a href="#news">Back</a></li>
  <li style="float:right"><a class="active" href="#about">Truii Data Library</a></li>

</ul>

</body>

<div id ="Homebutton">
  <div class= "container">

    <center><img src="images/truii-full-colour-white.png" alt="Truii" width="200" height="128"></center>


    <div class="list-group">
      <a href="#" class="list-group-item active">
        Data 1
      </a>
      <a href="#" class="list-group-item list-group-item-action">Data 2</a>
      <a href="#" class="list-group-item list-group-item-action">Data 3</a>
      <a href="#" class="list-group-item list-group-item-action">Data 4</a>
      <a href="#" class="list-group-item list-group-item-action">Data 5</a>
    </div>
