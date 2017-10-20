<?php
//Logs the user in
function LogUser($username, $password){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT * FROM UserTable WHERE Username = \"$username\";");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  foreach($result as $data){
    if ($data['Password'] == $password){
      log_in($data['UserID']);
      $pdo = null;
    }
  }
}
//Creates an account for the user
function CreateUser($Username, $password){
  $sql = "INSERT INTO UserTable(Username, Password) VALUES(\"$Username\", \"$password\");";
  CallDatabase($sql);
}
//Check if the account exist
function CheckUser($username){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT * FROM UserTable");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  foreach($result as $data){
    if ($data['Username'] == $username){
      $pdo= null;
      return true;
    }
  }
  $pdo=null;
  return false;
}
//Checks if Username and password matches
function CheckUserAndPassword($username, $password){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT * FROM UserTable");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  foreach($result as $data){
    if ($data['Username'] == $username && $data['Password'] == $password){
      $pdo= null;
      return true;
    }
  }
  $pdo=null;
  return false;
}


//Ask an request to obtain any details
function RequestUserDetail($userID, $request){
  $dbUser = get_dbUsername();
  $dbPassword = get_dbPassword();
  $link = 'mysql:host=' . get_dbServer() . ';dbname=' . get_dbDatabase();
  $pdo = new PDO($link, $dbUser, $dbPassword);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try{
    $result = $pdo->query("SELECT * FROM UserTable WHERE UserID = $userID);");
  }catch (PDOException $e){
    echo $e->getMessage();
  }
  foreach($result as $data){
    $pdo = null;
    return $data[$request];
  }
}

function ChangeUserPassword($password){
  $id = $_SESSION['UserID'];
  $sql = "UPDATE UserTable SET Password=\"$password\" WHERE UserID=\"$id\";";
  CallDatabase($sql);
}
 ?>
