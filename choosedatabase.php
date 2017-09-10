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

<header id ="titlelogo2">
  <div class="container">
    <div class="row">
      <div class="col-xs-6">
    <h1> Data Library </h1>
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

  </div>

</header>

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
