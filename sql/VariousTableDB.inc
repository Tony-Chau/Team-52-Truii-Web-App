<?php
//Generates tables
function CreateTable($TableName, $ArrayOfFields, $DataType){
  $TableID = GetTableIDLastNumber();
  $sql = "CREATE TABLE " . NumberToWordsFormat($TableID) . "( " . $TableName . "ID INT AUTO_INCREMENT, ";
  for ($i = 0; $i < count($ArrayOfFields); $i+= 1){
    if ($i == count($ArrayOfFields) - 1){
      $sql .= CheckDateTime($ArrayOfFields[$i]) . " " . $DataType[$i] . ", PRIMARY KEY(" . $TableName . "ID));";
    }else{
      $sql .= CheckDateTime($ArrayOfFields[$i]) . " " . $DataType[$i] . ", ";
    }
  }
  $sql .= EnterTable($TableName);
  $sql .= EnterArrayFieldTable($TableID, $ArrayOfFields, $DataType);
  CallDatabase($sql);
}

function CheckDateTime($field){
  if ($field == 'DATE' || $field == 'TIME'){
    return "DATETIME";
  }
  return $field;
}


//returns the whole table as an array format
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

//Deletes the table and updates FieldTable and TableList database to match the changes
function DeleteTable($TableID){
  $sql = DeleteFieldTable($TableID);
  $sql .= DeleteTableInTableList($TableID);
  $sql .= "DROP TABLE " . NumberToWordsFormat($TableID) . ";";
  CallDatabase($sql);
}

//Add columns to the customise table
function AddColumn($TableID, $FieldName, $DataType){
  $sql = EnterFieldTable($TableID, $FieldName, $DataType);
  $sql .= "ALTER TABLE " . NumberToWordsFormat($TableID) . " ADD " .  $FieldName . " " . $DataType . ";";
  CallDatabase($sql);
}

//Removes the columns from the customise table
function DeleteColumn($TableID, $FieldName){
  $sql = DeleteField($TableID, $FieldName);
  $sql .= "ALTER TABLE " . NumberToWordsFormat($TableID) . " DROP " .  $FieldName . ";";
  CallDatabase($sql);
}

//Rename the columns for the customise table
function RenameColumn($TableID, $FieldID, $NewFieldName, $NewFieldType){
  $OldFieldName = RequestFieldTableDetail($FieldID, "FieldName");
  $sql = ChangeField($FieldID, $NewFieldName, $NewFieldType);
  $sql .= "ALTER TABLE " . NumberToWordsFormat($TableID) . " CHANGE " . $OldFieldName . " " . $NewFieldName . " " . $NewFieldType . ";";
  CallDatabase($sql);
}

//Enter data of the customise table
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

//Edit the value of the customise table
function EditValueVariousTable($TableID, $VariousID, $Field_Array, $Value_Array, $type_array){
  $TableName = RequestTableDetail($TableID, "TableName");
  $sql = '';
  for ($i = 0; $i < count($Field_Array); $i += 1){
    $sql .= "UPDATE " . NumberToWordsFormat($TableID) . " SET " . $Field_Array[$i] . " =" . sqlInsertionString($Value_Array[$i], $type_array[$i]);
    $sql .= " WHERE " . $TableName . "ID = " . $VariousID . ";";
  }
  CallDatabase($sql);
}

//Remove specific data row from the customise table
function RemoveValueVariousTable($TableID, $FieldName, $Value, $FieldType){
  $sql = "DELETE FROM " . NumberToWordsFormat($TableID) . " WHERE " . $FieldName . "=" . sqlInsertionString($Value, $FieldType) . ";";
  CallDatabase($sql);
}

//Resets all the data within the customise table
function ResetValueVariousTable($TableID){
  $sql = "TRUNCATE TABLE " . NumberToWordsFormat($TableID) . ";";
  CallDatabase($sql);
}

//A small function that returns the correct type out query depending on the data type
function sqlInsertionString($data, $type){
  if ($type == 'VARCHAR(255)'){
    return "\" " . $data . "\"";
  }else if ($type == 'DATETIME'){
    $format = new DateTime($data);
    return "\" " . $format->format('Y-m-d H:i:s') . "\"";
  }else{
    return $data;
  }
}
 ?>
