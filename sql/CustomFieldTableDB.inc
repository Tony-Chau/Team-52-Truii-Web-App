<?php
//Creates Table
function EnterCustomFieldTable($FieldID, $GraphID, $ColourCode){
  $username = RequestUserDetail($_SESSION['UserID'], 'Username');
  $dateTime = GetCurrentTime();
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("INSERT INTO CustomFieldTable(FieldID, GraphID, ColourCode) VALUES(" . $FieldID . ", " . $GraphID . ", \"" . $ColourCode . "\");");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  $pdo=null;
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
    $result = $pdo->query("SELECT " . $requestfield . " FROM CustomFieldTable;");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  $pdo = null;
  return $result;
}
 ?>
