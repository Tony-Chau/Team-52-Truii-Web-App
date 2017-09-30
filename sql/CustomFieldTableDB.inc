<?php
//Creates Table
function EnterCustomFieldTable($FieldID, $GraphID, $ColourCode){
  $sql = "INSERT INTO CustomFieldTable(FieldID, GraphID, ColourCode) VALUES(" . $FieldID . ", " . $GraphID . ", \"" . $ColourCode . "\");"
  CallDatabase($sql);
}

//Presents the list of tables
function GetCustomFieldTableList($GraphID){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT * FROM CustomFieldTable WHERE GraphID = " . $GraphID . ";");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  $pdo=null;
  return $result;
}

//Ask an request to obtain any details
function RequestCustomFieldTableDetail($CustomFieldID, $request){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT * FROM CustomFieldTable WHERE CustomFieldID = " . $CustomFieldID . ";" );
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  foreach($result as $data){
    $pdo = null;
    return $data[$request];
  }
}
//Ask an request to obtain any details as a list
function RequestCustomFieldTableDetailAsList($CustomFieldID, $requestfield){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT " . $requestfield . " FROM CustomFieldTable WHERE CustomerFieldID = " . $CustomFieldID . ";");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  $pdo = null;
  return $result;
}
 ?>
