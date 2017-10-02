<?php
include "sql/mysql.inc";
$sql = "TRUNCATE TABLE TableList;
        TRUNCATE TABLE FieldTable;
        TRUNCATE TABLE UserTable;
        TRUNCATE TABLE GraphTable;
        TRUNCATE TABLE CustomFieldTable;";
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
    $sql .= "DROP TABLE " . NumberToWordsFormat($data['TableID']) . ";";
  }
CallDatabase($sql);
echo "All Data has been erased";
 ?>
