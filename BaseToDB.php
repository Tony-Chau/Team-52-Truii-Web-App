<?php
include("sql/mysql.inc");
include("sql/Bootgrid/connection.php");

if(isset($_POST['temp'])){
  $temp = $_POST['temp'];
  $query = UpdateImageGraphTable($_SESSION['graphid'], $temp);
  if (mysqli_query($connection, $query)){
    echo 'Point';
  }
}

 ?>
