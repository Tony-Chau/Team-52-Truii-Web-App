<?php

//Creates Table
function EnterGraphTable($tableId, $GraphType){
  $userid = $_SESSION['UserID'];
  $dateTime = GetCurrentTime();
  $dateTimeFormat = $dateTime->format('Y-m-d H:i:s');
  $sql = "INSERT INTO GraphTable(TableID, UserID, DateCreated, GraphType) VALUES($tableId, $userid, \"$dateTimeFormat\", \"$GraphType\");";
  CallDatabase($sql);
}

function RemoveTableInGraph($TableID){
  return "DELETE FROM GraphTable WHERE TableID = $TableID;";
}

function InsertImage($GraphID, $Image){
  $sql = "UPDATE GraphTable SET Image=\"$Image\" WHERE GraphID=$GraphID;";
  CallDatabase($sql);
}

//Presents the list of tables
function GetGraphTableList(){
  $userid = $_SESSION['UserID'];
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT * FROM GraphTable WHERE UserID =$userid ORDER BY GraphID ASC;");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  $row_count =  $result->rowCount();
  $pdo = null;
  if ($row_count >= 1){
    return $result;
  }
  return null;
}

//Ask an request to obtain any details
function RequestGraphTableDetail($GraphID, $request){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT * FROM GraphTable WHERE GraphID = $GraphID;" );
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  foreach($result as $data){
    $pdo = null;
    return $data[$request];
  }
}

//Ask an request to obtain any details as a list
function RequestGraphTableDetailAsList($GraphID, $requestfield){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT $requestfield FROM GraphTable;");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  foreach($result as $data){
    $pdo = null;
    return $data[$request];
  }
}

function UpdateColourCodeGraphTable($GraphID, $ColourCode){
  return "UPDATE GraphTable SET ColourCode = $ColourCode WHERE GraphID = $GraphID;";
}

function UpdateImageGraphTable($GraphID, $Image){
  return "UPDATE GraphTable SET Image = \"$Image\" WHERE GraphID = $GraphID;";
}

function GetGraphImage($GraphID){
  $image = array();
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT Image FROM GraphTable WHERE GraphID=$GraphID;");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  foreach($result as $data){
    array_push($image, ("data:image;base64," . $data['Image']));
  }
  return $image;
}

function GetLastGraphTableID(){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT GraphID FROM GraphTable ORDER BY GraphID DESC LIMIT 1;");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  foreach ($result as $data){
    return $data['GraphID'] + 1;
  }
  return 1;
}

function GetGraphID($TableID){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT GraphID FROM GraphTable WHERE TableID=$TableID;");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  $GraphIDArray = array();
  foreach ($result as $data){
    array_push($GraphIDArray, $data['GraphID']);
  }
  return $GraphIDArray;
}

 ?>
