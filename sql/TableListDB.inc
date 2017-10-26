<?php
//Creates Table
function EnterTable($TableName){
  $userid = $_SESSION['UserID'];
  $dateTime = GetCurrentTime();
  $dateTimeFormat = $dateTime->format('Y-m-d H:i:s');
  return "INSERT INTO TableList(TableName, UserID, DateCreated) VALUES (\"$TableName\", $userid, \"$dateTimeFormat\");";
}

function DeleteTableInTableList($TableID){
  return "DELETE FROM TableList WHERE TableID = $TableID;";
}


//Presents the list of tables
function GetTableList(){
  $userid = $_SESSION['UserID'];
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT * FROM TableList WHERE UserID = $userid;");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  $pdo=null;
  return $result;
}

//Ask an request to obtain any details
function RequestTableDetail($TableID, $request){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT * FROM TableList WHERE TableID = $TableID;" );
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  foreach($result as $data){
    $pdo = null;
    return $data[$request];
  }
}

function GetTableIDLastNumber(){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT TableID FROM TableList ORDER BY TableID DESC LIMIT 1;");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  $pdo = null;
  foreach($result as $data){
    return $data['TableID'];
  }
  return 1;
}

?>
