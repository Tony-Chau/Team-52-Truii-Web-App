<?php
//Generates tables
function CreateTable($TableName, $ArrayOfFields, $DataType){
  $TableID = GetTableIDLastNumber();
  $sql = "CREATE TABLE " . NumberToWordsFormat($TableID) . "( " . $TableName . "ID INT AUTO_INCREMENT, ";
  for ($i = 0; $i < count($ArrayOfFields); $i+= 1){
    if ($i == count($ArrayOfFields) - 1){
      $sql .= $ArrayOfFields[$i] . " " . $DataType[$i] . ", PRIMARY KEY(" . $TableName . "ID));";
    }else{
      $sql .= $ArrayOfFields[$i] . " " . $DataType[$i] . ", ";
    }
  }
  $sql .= EnterTable($TableName);
  $sql .= EnterArrayFieldTable($TableID, $ArrayOfFields, $DataType);
  CallDatabase($sql);
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
  $sql = DeleteFieldTable($TableID);
  $sql .= "DROP TABLE " . NumberToWordsFormat($TableID) . ";";
  CallDatabase($sql);
}

function AddColumn($TableID, $FieldName, $DataType){
  $sql = EnterFieldTable($TableID, $FieldName, $DataType);
  $sql .= "ALTER TABLE " . NumberToWordsFormat($TableID) . " ADD " .  $FieldName . " " . $DataType . ";";
  CallDatabase($sql);
}

function DeleteColumn($TableID, $FieldName){
  $sql = DeleteField($TableID, $FieldName);
  $sql .= "ALTER TABLE " . NumberToWordsFormat($TableID) . " DROP " .  $FieldName . ";";
  CallDatabase($sql);
}

function RenameColumn($TableID, $FieldID, $NewFieldName, $NewFieldType){
  $OldFieldName = RequestFieldTableDetail($FieldID, "FieldName");
  $sql = ChangeField($FieldID, $NewFieldName, $NewFieldType);
  $sql .= "ALTER TABLE " . NumberToWordsFormat($TableID) . " CHANGE " . $OldFieldName . " " . $NewFieldName . " " . $NewFieldType . ";";
  CallDatabase($sql);
}


function EnterVariousTable($TableID, $Array_of_FieldName, $array_of_data, $array_of_type){
  $sql = "INSERT INTO " . NumberToWordsFormat($TableID) . "(";
  for ($i = 0; $i < count($Array_of_FieldName); $i += 1){
    if ($i == count($Array_of_FieldName) - 1){
      $sql .= $Array_of_FieldName[$i] . ") ";
    }else{
      $sql .= $Array_of_FieldName[$i] . ", ";
    }
  }
  $sql .= "VALUES (";
  for ($i = 0; $i < count($array_of_data); $i += 1){
    if ($i == count($array_of_data) - 1){
      $sql .= sqlInsertionString($array_of_data[$i], $array_of_type[$i]) . ");";
    }else{
      $sql .= sqlInsertionString($array_of_data[$i], $array_of_type[$i]) . ",";
    }
  }
  CallDatabase($sql);
}

function EditValueVariousTable($TableID, $VariousID_Array, $Field_Array, $Value_Array){
  $TableName = RequestTableDetail($TableID, "TableName");
  $sql = "UPDATE " . NumberToWordsFormat($TableID) . " SET ";
  for ($i = 0; $i < count($VariousID_Array); $i += 1){
    $sql .= $Field_Array[$i] . " = " . $Value_Array[$i] . " WHERE " . $TableName . "ID = " . $VariousID_Array[$i] . ";";
  }
  CallDatabase($sql);
}

function RemoveValueVariousTable($TableID, $FieldName, $Value, $FieldType){
  $sql = "DELETE FROM " . NumberToWordsFormat($TableID) . " WHERE " . $FieldName . "=" . sqlInsertionString($Value, $FieldType) . ";";
  CallDatabase($sql);
}

function ResetValueVariousTable($TableID){
  $sql = "TRUNCATE TABLE " . NumberToWordsFormat($TableID) . ";";
  CallDatabase($sql);
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
