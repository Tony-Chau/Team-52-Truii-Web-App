<?php
  session_start();
include 'inc/tools.inc';
include 'UserTableDB.inc';
include 'TableListDB.inc';
include 'FieldTableDB.inc';
include 'CustomFieldTableDB.inc';
include 'GraphTableDB.inc';
include 'VariousTableDB.inc';

function get_dbServer(){
  return 'team52.heliohost.org';
}
function get_dbUsername(){
  return 'team52_manager';
}
function get_dbPassword(){
  return 'Midori.1';
}
function get_dbDatabase(){
  return 'team52_TruiiDB';
}
function is_log(){
  if (isset($_SESSION['UserID'])){
    return true;
  };
  return false;
}
function log_in($value){
  $_SESSION['UserID'] = $value;
}
function log_out(){
  unset($_SESSION['UserID']);
}

function CheckRequestLogout(){
  if($_SERVER['REQUEST_METHOD'] == "POST") {
    if(isset($_POST['logout']) && is_log()){
        log_out();
        header('location: Index.php');
    }
  }
}

function CallDatabase($sql){
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
?>
