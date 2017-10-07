<?php
function EnterGraphColumnTable($GraphID, $TableID, $Axis){
  $sql = "INSERT INTO GraphColumnTable(GraphID, TableID, Axis) VALUES(".$GraphID.", ".$TableID.", \"".$Axis."\");";
  CallDatabase($sql);
}

function getGraphColumn($tableID){
  $sql = "SELECT * FROM getGraphColumn WHERE TableID =".$tableID.";";
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query($sql);
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  $pdo=null;
  return $result;
}

 ?>
