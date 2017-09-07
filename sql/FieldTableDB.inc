<?php
//Creates Table
function EnterFieldTable($TableID, $fieldname, $DataType){
  $username = RequestUserDetail($_SESSION['UserID'], 'Username');
  $dateTime = GetCurrentTime();
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("INSERT INTO FieldTable(FieldName, TableID, DataType) VALUES(\"" . $fieldname . "\", " . $TableID . ", \"" . $DataType . "\");");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  $pdo=null;
}

//Presents the list of tables
function GetFieldTableList($TableID){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT * FROM FieldTable WHERE TableID = " . $TableID . ";");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  $pdo=null;
  return $result;
}

//Ask an request to obtain any details
function RequestFieldTableDetail($FieldID, $request){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT * FROM FieldTable WHERE FieldID = " . $FieldID . ";" );
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  foreach($result as $data){
    $pdo = null;
    return $data[$request];
  }
}

//Ask an request to obtain any details as a list
function RequestFieldTableDetailAsList($FieldID, $requestfield){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT " . $requestfield . " FROM FieldTable;");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  $pdo = null;
  return $result;
}

function DeleteField($TableID, $FieldName){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("DELETE FROM FieldTable WHERE TableID = " . $TableID . "& FieldName = " . $FieldName . ";" );
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  $pdo = null;
}

function DeleteFieldTable($TableID){
  $dateTime = GetCurrentTime();
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("DELETE FROM FieldTable WHERE TableID = " . $TableID . ";");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  $pdo=null;
}

function GetFieldID($TableID, $FieldName){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT FieldID FROM FieldTable WHERE TableID=" . $TableID . "&FieldName=" . $FieldName . ";");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  foreach($result as $data){
    $pdo=null;
    return $result['FieldID'];
  }

}

function ChangeField($FieldID, $NewFieldName, $NewFieldType){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query();
  }catch (PDOException $e){
    echo $e->getMessage("UPDATE FieldTable SET FieldName= \"" . $NewFieldName . "\" & DataType=\"" . $NewFieldType . "\" WHERE FieldID=" . $FieldID . ";");
  }
  $pdo=null;
}

?>
