<?php
  //columninsert.php
  include("../mysql.inc");
  include("connection.php");

  //started using getcolumns.php
  include("getcolumns.php");
  if(isset($_POST["operation"]))
  {
      $cName = $_POST['column_name'];
      $dType = 'VARCHAR(255)';
      AddColumn($tableid, $cName, $dType);

      echo 'Column Inserted';
  }
?>
