<?php
  //columninsert.php
  include("../mysql.inc");
  include("connection.php");

  //started using getcolumns.php
  include("getcolumns.php");
  if(isset($_POST["operation"]))
  {

      $oldcName = $_POST['edit_column_selected'];
      for($i = 1; $i < $size; $i+=1){
          if ($oldcName == $arr['rows'][$i]['FieldName']){
              $oldID = $arr['rows'][$i]['FieldID'];
          }
      }

      $cName = $_POST['edit_column_name'];
      $dType = 'VARCHAR(255)';
      RenameColumn($tableid, $oldID, $cName, $dType);
      echo 'Column Renamed';
  }
?>
