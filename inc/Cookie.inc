<?php
function CreateCookie($name, $value, $hour){
  setcookie($name, $value, time() + (60*60*$hour));
}

function ReadCookie($name){
  return $_COOKIE[$name];
}

function DeleteCookie($name){
  unset($_COOKIE[$name]);
}
 ?>
