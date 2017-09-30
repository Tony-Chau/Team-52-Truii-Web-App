<?php
//Generates tables
function CreateTable($TableName, $ArrayOfFields, $DataType){
  EnterTable($TableName);
  $TableID = GetTableIDLastNumber();
  $sql = "CREATE TABLE " . NumberToWordsFormat($TableID) . "( " . $TableName . "ID INT AUTO_INCREMENT, ";
  for ($i = 0; $i < count($ArrayOfFields); $i+= 1){
    if ($i == count($ArrayOfFields) - 1){
      $sql .= $ArrayOfFields[$i] . " " . $DataType[$i] . ", PRIMARY KEY(" . $TableName . "ID));";
    }else{
      $sql .= $ArrayOfFields[$i] . " " . $DataType[$i] . ", ";
    }
  }
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
  for ($i = 0; $i < count($ArrayOfFields); $i += 1){
    EnterFieldTable($TableID, $ArrayOfFields[$i], $DataType[$i]);
  }
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

function GetVariousTable($TableID){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT * FROM " . NumberToWordsFormat($TableID) . ";");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  $pdo=null;
  return $result;
}

function RequestVariousTableAsList($TableID, $requestfield){
  $dateTime = GetCurrentTime();
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT " . $requestfield . " FROM " . NumberToWordsFormat($TableID) . ";");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  $pdo=null;
  return $result;
}

function DeleteTable($TableID){
  $dateTime = GetCurrentTime();
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("DROP TABLE " . NumberToWordsFormat($TableID) . ";");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  $pdo=null;
  DeleteFieldTable($TableID);
}


function AddColumn($TableID, $FieldName, $DataType){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("ALTER TABLE " . NumberToWordsFormat($TableID) . " ADD " .  $FieldName . " " . $DataType . ";");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  $pdo=null;
  EnterFieldTable($TableID, $FieldName, $DataType);
}

function DeleteColumn($TableID, $FieldName){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("ALTER TABLE " . /*NumberToWordsFormat($TableID)*/$TableID . " DROP " .  $FieldName . ";");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  $pdo=null;
  DeleteField($TableID, $FieldName);
}

function RenameColumn($TableID, $FieldID, $NewFieldName, $NewFieldType){
  $OldFieldName = RequestFieldTableDetail($FieldID, "FieldName");
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("ALTER TABLE " . NumberToWordsFormat($TableID) . " CHANGE " . $OldFieldName . " " . $NewFieldName . " " . $NewFieldType . ";");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  $pdo=null;
  ChangeField($FieldID, $NewFieldName, $NewFieldType);
}


function EnterVariousTable($TableID, $array_of_data, $array_of_type){
  $sql = "INSERT INTO " . NumberToWordsFormat($TableID) . "(";
  for ($i = 0; $i < count($array_of_data); $i += 1){
    if ($i == count($array_of_data) - 1){
      $sql .= sqlInsertionString($array_of_data[$i], $array_of_type[$i]) . ");";
    }else{
      $sql .= sqlInsertionString($array_of_data[$i], $array_of_type[$i]) . ",";
    }
  }
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
}

function UpdateVariousTable($TableID, $VariousID, $Field, $Value){
  $TableName = RequestTableDetail($TableID, "TableName");
  $sql = "UPDATE " . NumberToWordsFormat($TableID) . " SET " . $Field . " = " . $Value . " WHERE " . $TableName . "ID = " . $VariousID . ";";
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
}

function sqlInsertionString($data, $type){
  if ($type == 'VARCHAR(255)'){
    return "\" " . $data . "\"";
  }else if ($type == 'DATETIME'){
    return "\" " . $data->format('Y-m-d H:i:s') . "\"";
  }else{
    return $data;
  }
}
 ?>
