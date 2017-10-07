<?php
include 'sql/mysql.inc';
include 'inc/tools.inc';
include 'inc/ChartValidator.inc';
include 'sql/Bootgrid/connection.php';
include 'sql/Bootgrid/getcolumns.php';

  if (!is_log()){
    header('location: Index.php');
  }
  CheckRequestLogout();
  navBarCreate('rgb(31,194,222)','Data XY');

  $outputx = '';
  $outputy = '';
  for($i = 1; $i < $size; $i+=1){
      $cName = $arr['rows'][$i]['FieldName'];
      $outputx .= '<input type="button" value="'.$cName.'" id="'.'x-'.$cName.'">'.$cName.'</option>';
  }
  for($i = 1; $i < $size; $i+=1){
      $cName = $arr['rows'][$i]['FieldName'];
      $outputy .= '<input type="button" value="'.$cName.'" id="'.'y-'.$cName.'">'.$cName.'</option>';
  }
?>


<!DOCTYPE html>
<html>
<head>
  <title>Data Page</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-bootgrid/1.3.1/jquery.bootgrid.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bootgrid/1.3.1/jquery.bootgrid.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <script src='js/Functions/Link.js'></script>
  <link rel="stylesheet" href="css/datapage.css"/>
  <script src='js/Functions/datapagexy.js'></script>
  <script src='js/Functions/ChartValidator.js'></script>
</head>
<body>
<form method=POST id="table_form">
  <div class="box" style=" min-height: 100% !important; height: auto; width: 100vw; margin-top: 50px; ">
  </div>
</form>
</body>
</html>
