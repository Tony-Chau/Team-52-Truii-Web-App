<?php
  //insert.php
  include("../mysql.inc");
  include("connection.php");

  //started using getcolumns.php
  include("getcolumns.php");
  if(isset($_POST["operation"]))
  {
      if($_POST["operation"] == "Add")
      {

          $Fields = array();
          $Datas = array();
          $Types = array();
          for($i = 1; $i < $size; $i+=1){
              $col = $arr['rows'][$i]['FieldName'];
              if (isset($_POST[$col])){
                  $colPost = $_POST[$col];
              }
              else {
                  $colPost = NULL;
              }
              array_push($Fields, $col);
              array_push($Datas, $colPost);
              array_push($Types, $arr['rows'][$i]['DataType']);
          }

          EnterVariousTable($tableid, $Fields, $Datas, $Types);
          echo 'Value Inserted';

      }

      if($_POST["operation"] == "Edit")
      {

          $variousid = $_POST[$arr["rows"][0]["COLUMN_NAME"]];
          $Fields = array();
          $Datas = array();
          $Types = array();
          for($i = 1; $i < $size; $i+=1){
              $col = $arr['rows'][$i]['FieldName'];
              if (isempty($_POST[$col])){
                  $colPost = $_POST[$col];
              }
              else {
                  $colPost = NULL;
              }
              array_push($Fields, $col);
              array_push($Datas, $colPost);
              array_push($Types, $arr['rows'][$i]['DataType']);
          }

          EditValueVariousTable($tableid, $variousid, $Fields, $Datas, $Types);
          echo 'Value Updated';

      }
  }
?>
