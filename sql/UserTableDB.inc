<?php
function LogUser($username, $password){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT * FROM usertable");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  foreach($result as $data){
    if (($result['UserName'] == $username) && $result['Password'] == $password){
      $_SESSION['UserID'] = $result['UserID'];
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
    $result = $pdo->query("INSERT INTO usertable(UserName, Password) VALUES(\"" . $username . "\", \"" . $password . "\");");
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
    $result = $pdo->query("SELECT * FROM usertable");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  foreach($result as $data){
    if ($data['UserName'] == $username){
      $pdo= null;
      return false;
    }
  }
  $pdo=null;
  return true;
}
function RequestUserDetail($userID, $request){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT * FROM usertable WHERE UserID = \"" . $userID . "\");" );
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  foreach($result as $data){
    $pdo = null;
    return $data["\" . $request . "\""];
}
 ?>
