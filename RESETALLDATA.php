<?php
include "sql/mysql.inc";
$sql = "TRUNCATE TABLE TableList;
        TRUNCATE TABLE FieldTable;
        TRUNCATE TABLE UserTable;
        TRUNCATE TABLE GraphTable;
        TRUNCATE TABLE CustomFieldTable;";
$TableID_Array = array();
$dbUser = get_dbUsername();
$dbPassword = get_dbPassword();
$link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
$pdo = new PDO($link, $dbUser, $dbPassword);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try{
    $result = $pdo->query("SELECT TableID FROM TableList;");
  }catch (PDOException $e){
  echo $e->getMessage();
  }
  foreach($result as $data){
    array_push($TableID_Array, $data['TableID']);
  }
  for ($i = 0; $i < count($TableID_Array); $i += 1){
    $sql .= "DROP TABLE " . NumberToWordsFormat($TableID_Array[$i]) . ";";
  }
CallDatabase($sql);
echo "All Data has been erased";
 ?>
