<?php
function EnterGraphColumnTable($GraphID, $FieldID, $Axis){
  return "INSERT INTO GraphColumnTable(GraphID, FieldID, Axis) VALUES($GraphID, $FieldID, \"$Axis\");";
}

function GraphColumnSwitchAxis($result){
  $sql = '';
  foreach ($result as $data){
    if ($data['Axis'] == 'x'){
      $id = $data['GraphColumnID'];
      $sql .= "UPDATE GraphColumnTable SET Axis=\"y\" WHERE GraphColumnID=$id;";
    }else{
      $sql .= "UPDATE GraphColumnTable SET Axis=\"x\" WHERE GraphColumnID=$id;";
    }
  }
  CallTestAlert($sql);
  CallDatabase($sql);
}

function getGraphColumn($GraphID){
  $sql = "SELECT * FROM GraphColumnTable WHERE GraphID = $GraphID;";
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
  foreach($result as $data){
    CallTestAlert($data['Axis']);
  }
  return $result;
}

//Removes Graph column that links with the graphID
function DeleteGraphColumn($GraphID){
  return "DELETE FROM GraphColumnTable WHERE GraphID =$GraphID;";
}

//Changes the values within the ChangeGraphColumn table
function ChangeGraphColumn($GraphID, $FieldID, $axis){
  return "UPDATE GraphColumnTable SET FieldID = $FieldID, Axis=\"$axis\" WHERE GraphID=$GraphID;";
}


 ?>
