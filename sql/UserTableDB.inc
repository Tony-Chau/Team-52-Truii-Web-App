<?php
function LogUser($username, $password){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT * FROM UserTableDB");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  foreach($result as $data){
    if (($result['Username'] == $username) && $result['Password'] == $password){
      $_SESSION['UserId'] = $result['UserId'];
    }
  }
  $pdo = nuill;
}
function CreateUser($Username, $password){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("INSERT INTO UserTable(Username, Password) VALUES(\"" . $username . "\", \"" . $password . "\");");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  $pdo=null;
}
function CheckUser($username, $password){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT * FROM UserTableDB");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  foreach($result as $data){
    if ($data['Username'] == $username){
      $pdo= null;
      return false;
    }
  }
  $pdo=null;
  return true;
}
 ?>
