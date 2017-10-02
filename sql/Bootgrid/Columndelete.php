<?php
  //columninsert.php
  include("../mysql.inc");
  include("connection.php");

  //started using getcolumns.php
  include("getcolumns.php");
  if(isset($_POST["operation"]))
  {
      $cName = $_POST['delete_column_selected'];
      DeleteColumn($tableid, $cName);
      echo 'Column Deleted';
  }
?>
