<?php
//Generates tables
function CreateTable($TableName, $ArrayOfFields, $DataType){
  $dateTime = GetCurrentTime();
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $sql = "CREATE TABLE " . $TableName . "( " . $TableName . "ID INT AUTO_INCREMENT NOT NULL, ";
  for ($i = 0; $i < count($ArrayOfFields); $i+= 1){
    if ($i == count($ArrayOfFields) - 1){
      $sql .= $ArrayOfFields[$i] . " " . $DataType[$i] . ', PRIMARY KEY(' . $TableName . 'ID));';
    }
    $sql .= $ArrayOfFields[$i] . " " . $DataType[$i] . ', ';
  }
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query($sql);
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  $pdo=null;
  EnterTable($TableName);
}
//Sorry I need to know the name of this, which is why i left it empty
function SortDataType($DataStringList){
  $NewDataString = array();
  for ($i = 0; $i < count($DataStringList); $i += 1){
    if($DataStringList[$i] == ''){
      array_push($NewDataString, 'INT');
    }
    else if ($DataStringList[$i] == ''){
      array_push($NewDataString, 'DATETIME');
    }else{
      array_push($NewDataString, 'VARCHAR(255)');
    }
  }
  return $NewDataString;
}

function GetVariousTable($TableName){
  $dateTime = GetCurrentTime();
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT * FROM " . $TableName . ";");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  $pdo=null;
  return $result;
}

function RequestVariousTableAsList($TableName, $requestfield){
  $dateTime = GetCurrentTime();
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT " . $requestfield . " FROM " . $TableName . ";");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  $pdo=null;
  return $result;
}

function AddColumn($TableName, $FieldName, $DataType){

}

function DeleteColumn($TableName, $FieldName){

}

 ?>
