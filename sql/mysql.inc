<?php
  session_start();
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

function GetCurrentTime(){
  $time = new DateTimeZone('Australia/Brisbane');
  $datetime = new DateTime();
  $datetime->setTimezone($time);
  return $datetime;
}

 ?>
