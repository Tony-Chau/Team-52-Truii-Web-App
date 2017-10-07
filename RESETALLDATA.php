<?php
include "sql/mysql.inc";
  include 'inc/tools.inc';
  if (isset($_GET['method'])){
    $sql = "";
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
      $sql .="TRUNCATE TABLE TableList;
              TRUNCATE TABLE GraphColumnTable;
              TRUNCATE TABLE FieldTable;
              TRUNCATE TABLE UserTable;
              TRUNCATE TABLE GraphTable;
              TRUNCATE TABLE CustomFieldTable;";
    CallTestAlert($sql);
    CallDatabase($sql);
    echo "<script> alert('All Data has been erased'); </script>";
}
 ?>
 <body style='background-color: black;'>
 <form method=GET>
 <div class="buttonHolder">
   <h1 style="color: white;">By Clicking this button will delete all of the data within the database and removed all the custom table.
     If you do not wish to reset all the data, please do not click it. </br> Choose Wisely :) </h1>
   <input value="Reset now" type="submit" name='method'>
 </div>
 </form>
 <style>
 .buttonHolder{ margin-top: 20%; text-align: center; }
 </style>
</body>
