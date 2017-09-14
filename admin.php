<?php
  include 'sql/mysql.inc';

  if($_SERVER['REQUEST_METHOD'] == 'POST'){
      if (isset($_POST['newtablename'])){
          $fields = array('Name', 'Email');
          $dtypes = array('VARCHAR(255)', 'VARCHAR(255)');
          $table_name = ($_POST['newtablename']);
          CreateTable($table_name, $fields, $dtypes);
      }
  }
?>
<!DOCTYPE html>
<html>
<head>

 <title>Truii Home</title>
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="css/bootstrap-theme.min.css">
 <link rel="stylesheet" href="css/style.css">

</head>
<body>


  <form method="POST" >
    <div align="center">
      <input type="text" name="newtablename" class="input" value="" required>
      <input type="submit" name="create_table" class="submit"><br>
    </div>
  </form>

</body>
</html>
