<?php
include 'sql/mysql.inc';
include 'inc/tools.inc';
include 'inc/styles_and_scripts.inc';
include 'inc/ChartValidator.inc';
include 'sql/Bootgrid/connection.php';
include 'sql/Bootgrid/getcolumns.php';

  if (!is_log()){
    header('location: Index');
  }
  CheckRequestLogout();
  navBarCreate('rgb(31,194,222)','Graph Page');

?>


<!DOCTYPE html>
<html>
<head>

  <title>Graph Page</title>

</head>
<body>

  <div class="box" style=" min-height: 100% !important; height: auto; width: 100vw; margin-top: 50px; ">
    
  </div>
</body>
</html>

<script>

</script>
