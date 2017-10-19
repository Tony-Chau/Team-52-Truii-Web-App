<?php
  include 'sql/mysql.inc';
  include 'inc/tools.inc';
  include 'inc/styles_and_scripts.inc';
  include("sql/Bootgrid/connection.php");
  include("sql/Bootgrid/gettable.php");

  if (!is_log()){
    gotoPage('Index');
  }
  CheckRequestLogout();
  navBarCreate('rgb(252, 103, 25)', 'Chart Library');

  $gsize = 0;
  $graphlist_Query = "SELECT * FROM GraphTable WHERE UserID = " . $_SESSION['UserID'] . " ORDER BY GraphID ASC;";
  $gotgraphlist = mysqli_query($connection, $graphlist_Query);
  if(!empty($gotgraphlist)){
      while($graph = mysqli_fetch_assoc($gotgraphlist)){
          $graphlist_columns[] = $graph;
          $gsize += 1;
      }
  }

  $graphlist_output = array( 'rows' => $graphlist_columns );

  $json = json_encode($graphlist_output);
  $graphlistarr = (json_decode($json, true));

  $output = '';

  for($i = 1; $i < $gsize; $i+=1){
      $key = 0;
      $output .= '<form method="POST">';
      $output .= '<div class="row">';
      $output .= '<div class="col-sm-12 col-md-4">';
      $output .= '<div class="thumbnail">';
      $output .= '<canvas id="graph" width="300" height="300"></canvas>';
      $output .= '<div class="caption">';
      for ($j = 0; $j < $tsize; $j+=1){
          $gtID = $graphlistarr['rows'][$i]['TableID'];
          $tID = $tIDsarr['rows'][$j]['TableID'];
          if ($gtID == $tID){
              $key = $j;
          }
      }
      $tName = $tIDsarr['rows'][$key]['TableName'];
      $tID = $tIDsarr['rows'][$key]['TableID'];
      $gID = $graphlistarr['rows'][$i]['GraphID'];
      $gType = $graphlistarr['rows'][$i]['GraphType'];
      $output .= '<h3>Chart ' . $gType . '</h3>';
      $output .= '<h4>Table: ' . $tName . '</h4>';
      $output .= '<input type="number" name="graphs_tableid" value='.$tID.' style="display: none"/>';
      $output .= '<button type="submit" style="width: 100%; font-size: 100%; border: solid; border-color: #A9A9A9; border-radius:5px; margin-bottom:10px; padding:10px" name="graphlist_selected" value='.$gID.'> View </button>';
      $output .= '</div></div></div></div></form>';
  }

  if($_SERVER['REQUEST_METHOD'] == 'POST'){
      if (isset($_POST['graphs_tableid']) && isset($_POST['graphlist_selected'])){
          $selected_tableid = NumberToWordsFormat($_POST['graphs_tableid']);

          $table_exist = false;

          $db_table = get_dbDatabase();
          $db_tQuery = "SHOW TABLES FROM $db_table";
          $gotTable = mysqli_query($connection, $db_tQuery);
          while($db_t = mysqli_fetch_row($gotTable))
          {
              if ($selected_tableid == $db_t[0]){
                  $table_exist = true;
              }
          }

          if ($table_exist){
              $_SESSION['tableid'] = $_POST['graphs_tableid'];
              $_SESSION['graphid'] = $_POST['graphlist_selected'];
              gotoPage('GraphPage');
          }
          else {
              echo "<script language='javascript'>";
              echo "alert('Sorry, Table Associated With Selected Graph No Longer Exists, Please Select Another Graph')";
              echo "</script>";
          }

      }
  }

?>


<!DOCTYPE html>
<html>
<head>

 <title>Chart Library</title>

 <style>
   .col-sm-12, col-md-4 {
      position: static !important;
   }
 </style>
</head>
<body>
  <div id ="Homebutton">
    <div class="container">
      <?php echo $output; ?>
    </div>
  </div>
  <a href="choosedatapage"><div class="addGraph">+</div></a>
</body>
</html>
