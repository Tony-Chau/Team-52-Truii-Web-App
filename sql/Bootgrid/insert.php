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
              array_push($Fields, $col);
              array_push($Datas, $_POST[$col]);
              array_push($Types, $arr['rows'][$i]['DataType']);
          }

          EnterVariousTable($tableid, $Fields, $Datas, $Types);
          echo 'Value Inserted';

      }

      if($_POST["operation"] == "Edit")
      {

          $variousID = array();
          $Fields = array();
          $Datas = array();
          for($i = 1; $i < $size; $i+=1){

              array_push($variousID, $_POST[$arr["rows"][0]["COLUMN_NAME"]]);

              $col = $arr['rows'][$i]['FieldName'];
              array_push($Fields, $col);
              array_push($Datas, $_POST[$col]);
          }

          EditValueVariousTable($tableid, $variousID, $Fields, $Datas);
          echo 'Value Updated';

      }
  }
?>
