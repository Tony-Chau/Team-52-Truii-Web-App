<?php
  //columninsert.php
  include("../mysql.inc");
  include("connection.php");
  include("getcolumns.php");
  if(isset($_POST["operation"]))
  {
      $cName = $_POST['column_name'];
      $dType = 'VARCHAR(255)';
      AddColumn($table, $cName, $dType);

      echo 'Column Inserted';
  }
?>
