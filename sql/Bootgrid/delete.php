<?php
  //Delete.php
  include("../mysql.inc");
  include("connection.php");

  //started using getcolumns.php
  include("getcolumns.php");
  $id = $arr['rows'][0]['COLUMN_NAME'];
  //$fname = $arr['rows'][1]['FieldName'];
  if(isset($_POST[$id]))
  {
      $query = "DELETE FROM " . $table . " WHERE " . $id . " = '".$_POST[$id]."'";
      if(mysqli_query($connection, $query))
      {
          //echo 'Value Deleted';
      }
      //RemoveValueVariousTable($tableid, $Field, $Data, $Type);
  }
?>
