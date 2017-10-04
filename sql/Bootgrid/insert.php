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
          /*
          $query = "INSERT INTO " . $table . "(";
          for($i = 1; $i < $size; $i+=1){
              $query .= $arr['rows'][$i]['FieldName'];
              if ($i < ($size-1)){
                  $query .= ', ';
              }
          }
          $query .= ") VALUES ('";
          for($i = 1; $i < $size; $i+=1){
              $col = $arr['rows'][$i]['FieldName'];
              $query .= mysqli_real_escape_string($connection, $_POST[$col]);
              if ($i < ($size-1)){
                  $query .= "', '";
              }
          }
          $query .= "');";

          if(mysqli_query($connection, $query))
          {
              echo 'Value Inserted';
          }*/

          $Fields = array();
          $Datas = array();
          $Types = array();
          for($i = 1; $i < $size; $i+=1){
              $col = $arr['rows'][$i]['FieldName'];
              array_push($Fields, $col);
              array_push($Datas, $_POST[$col]);
              array_push($Types, $arr['rows'][$i]['DataType']);
          }

          EnterVariousTable($tableid, $Fields, $Datas, $Types);
          echo 'Value Inserted';

      }


      if($_POST["operation"] == "Edit")
      {
          $query = "UPDATE " . $table . " SET ";
          for ($i = 1; $i < $size; $i+=1){
              $col = $arr['rows'][$i]['FieldName'];
              $query .= $col . " = '";
              $query .= mysqli_real_escape_string($connection, $_POST[$col]);
              if ($i < ($size-1)){
                  $query .= "', ";
              }
          }
          $query .= "'";

          $id = $arr["rows"][0]["COLUMN_NAME"];
          $query .= "WHERE " . $id . " = '".$_POST[$id]."'";

          if(mysqli_query($connection, $query))
          {
              echo 'Value Updated';
          }
      }
  }
?>
