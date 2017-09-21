<?php
  //columninsert.php
  include("../mysql.inc");
  include("connection.php");

  //started using getcolumns.php
  include("getcolumns.php");
  if(isset($_POST["operation"]))
  {

      $oldcName = $_POST['column_selected'];
      $cName = $_POST['column_name'];
      $dType = 'VARCHAR(255)';
      RenameColumn($tableid, $oldcName, $cName, $dType);
      echo 'Column Renamed';
  }
?>
