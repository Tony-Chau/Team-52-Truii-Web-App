<?php
include 'sql/mysql.inc';
include 'inc/tools.inc';
include 'inc/styles_and_scripts.inc';
include 'inc/ChartValidator.inc';
include 'sql/Bootgrid/connection.php';
include 'sql/Bootgrid/getcolumns.php';

  if (!is_log()){
    gotoPage('Index');
  }
  CheckRequestLogout();
  navBarCreate('rgb(31,194,222)','Graph Page');
  $_SESSION['graphid'] = 2;
  $graphsize = 0;
  $graph_query = getGraphColumn($_SESSION['graphid']);
  while($graphfields = $graph_query->fetch(PDO::FETCH_ASSOC);)
  {
      $graphcolumns[] = $graphfields;
      $graphsize+=1;
  }

}

$columnsoutput = array( 'rows' => $columns );

$json = json_encode($columnsoutput);
$arr = (json_decode($json, true));
?>


<!DOCTYPE html>
<html>
<head>

  <title>Graph Page</title>

</head>
<body>

  <!--
  <div class="box" style=" min-height: 100% !important; height: auto; width: 100vw; margin-top: 50px; ">
  </div>-->
  <div id="Results"></div>

</body>
</html>

<script>

</script>
