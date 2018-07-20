<?php
  include 'sql/mysql.inc';
  include 'inc/tools.inc';
  include 'inc/styles_and_scripts.inc';
  //Leaving this part to allow people to automatically log-in, so u don't need to type down ur email and password again
  //log_in(1);
  //CheckMobile();
  if (is_log()){
    gotoPage('home');
  }
  if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    if (isset($_GET['confirmKey'])){
      //do something
    }
  }else{
    gotoPage('index');
  }
  ?>
