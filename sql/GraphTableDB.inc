<?php
//Creates Table
function EnterGraphTable($tableId, $Image){
  $dateTime = GetCurrentTime();
  $sql = "INSERT INTO GraphTable(TableID, UserID, DateCreated, Image) VALUES(" . $tableId . ", " . $_SESSION['UserID'] . ", \"" . $dateTime->format('Y-m-d H:i:s') . "\", \"" . $Image ."\");";
  CallDatabase($sql);
}

//Presents the list of tables
function GetGraphTableList(){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT * FROM GraphTable WHERE UserID = " . $_SESSION['UserID'] . ";");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  $pdo=null;
  return $result;
}

//Ask an request to obtain any details
function RequestGraphTableDetail($GraphID, $request){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT * FROM GraphTable WHERE GraphID = " . $GraphID . ";" );
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
    $result = $pdo->query("SELECT " . $requestfield . " FROM GraphTable;");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  foreach($result as $data){
    $pdo = null;
    return $data[$request];
  }
}

function UpdateColourCodeGraphTable($GraphID, $ColourCode){
  return "UPDATE GraphTable SET ColourCode = " . $ColourCode . " WHERE GraphID = " . $GraphID . ";";
}

function UpdateImageGraphTable($GraphID, $Image){
  return "UPDATE GraphTable SET Image = \"" . $Image . "\" WHERE GraphID = " . $GraphID . ";";
}

function GetGraphImage($TableID){
  $image = array();
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT Image FROM GraphTable WHERE TableID=" . $TableID .";");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  foreach($result as $data){
    array_push($image, ("data:image;base64," . $data['Image']));
  }
  return $image;
}

 ?>
