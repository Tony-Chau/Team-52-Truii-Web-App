<?php
  //columninsert.php
  include("../mysql.inc");
  include("connection.php");

  //started using getcolumns.php
  include("getcolumns.php");
  if(isset($_POST["operation"]))
  {
      $cName = $_POST['add_column_name'];
      $dType = $_POST['datatype_selected'];
      AddColumn($tableid, $cName, $dType);

      //echo 'Column Inserted';
  }
?>
