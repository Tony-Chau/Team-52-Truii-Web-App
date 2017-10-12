<?php
function EnterGraphColumnTable($GraphID, $FieldID, $Axis){
  $sql = "INSERT INTO GraphColumnTable(GraphID, FieldID, Axis) VALUES(".$GraphID.", ".$FieldID.", \"".$Axis."\");";
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

//Removes Graph column that links with the graphID
function DeleteGraphColumn($GraphID){
  return "DELETE FROM GraphColumnTable WHERE GraphID =" . $GraphID . ";";
}

//Changes the values within the ChangeGraphColumn table
function ChangeGraphColumn($GraphID, $FieldID, $axis){
  return "UPDATE GraphColumnTable SET FieldID = " . $FieldID .", Axis=\"".$axis."\" WHERE GraphID=" . $GraphID . ";";
}

 ?>
