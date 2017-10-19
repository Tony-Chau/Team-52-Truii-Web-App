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
  //navBarCreate('rgb(31,194,222)','Graph Page');
  $tablegraphIDs = GetGraphID($_SESSION['tableid']);
  if (in_array($_SESSION['graphid'], $tablegraphIDs)){
      $graphid = $_SESSION['graphid'];
  }
  else {
    gotoPage('previousgraphpage');
  }
  $graphtype = 'Scatter Line'; //$_SESSION['graphtype'] = 'ScatterLine';

  $graphsize = 0;
  $graph_query = getGraphColumn($graphid);
  while($graphfields = $graph_query->fetch(PDO::FETCH_ASSOC))
  {
      $graphcolumns[] = $graphfields;
      $graphsize+=1;
  }

$graphoutput = array( 'rows' => $graphcolumns );
$json = json_encode($graphoutput);
$grapharr = (json_decode($json, true));
//echo $grapharr['rows'][0]['FieldID'];

$query_row = "SELECT * FROM " . $table;
$result_row = mysqli_query($connection, $query_row);
$total_records = mysqli_num_rows($result_row);


$x_axis = array();
$x_size = 0;
$y_axis = array();
$y_size = 0;

for ($i = 0; $i < $graphsize; $i+=1){
    if ($grapharr['rows'][$i]['Axis'] == 'x'){
        for ($j=1; $j < $size; $j+=1) {
            if ($grapharr['rows'][$i]['FieldID'] == $arr['rows'][$j]['FieldID']){
                $fname = $arr['rows'][$j]['FieldName'];
            }
        }
        array_push($x_axis, $fname);
        $x_size += 1;
    }
    else if ($grapharr['rows'][$i]['Axis'] == 'y'){
        for ($j=1; $j < $size; $j+=1) {
            if ($grapharr['rows'][$i]['FieldID'] == $arr['rows'][$j]['FieldID']){
                $fname = $arr['rows'][$j]['FieldName'];
            }
        }
        array_push($y_axis, $fname);
        $y_size += 1;
    }
}

$xy_size = 0;
if ($x_size < $y_size){
    $xy_size = $y_size;
    $base = 'x';
}
else {
    $xy_size = $x_size;
    $base = 'y';
}

$listquery = "SELECT ";
for($i = 1; $i < $size; $i+=1){
    $listquery .= $table . "." . $arr["rows"][$i]["FieldName"];
    if ($i < $size-1){
        $listquery .= ", ";
    }
}

$listquery .= " FROM " . $table . " ORDER BY " . $arr["rows"][0]["COLUMN_NAME"];
$listresult = mysqli_query($connection, $listquery);
if(!empty($listresult)){
    while($listrow = mysqli_fetch_assoc($listresult))
    {
        $listdata[] = $listrow;
    }
}
else{
    echo "<script language='javascript'>";
    echo "alert('Table possesses no variables, please include atleast 1 row')";
    echo "</script>";
    gotoPage('datapage');
}

$listoutput = array('rows' => $listdata);
$json = json_encode($listoutput);
$dataarr = (json_decode($json, true));

?>


<!DOCTYPE html>
<html>
<head>

  <title>Graph Page</title>
  <script src="js/plotly_latest.min.js"></script>
  <script src="js/html2canvas.min.js"></script>

</head>
<body onresize="Redo_Graph()">

  <div id ="Homebutton">
    <div class= "container" align="center">
      <div class="row">
        <div class="col">

          <div id="Results" style="margin-top: 10%"></div>

        </div>
      </div>
    </div>
  </div>
  <?php

  $graph = "";
  $x_num = 0;
  $y_num = 0;
  for ($i = 0; $i < $xy_size; $i+=1) {
      $graph .= " var trace" . $i . " = {";
      if ($base == 'x'){
          $graph .= "x:[";
      }
      else {
          $graph .= "y:[";
      }
      for ($j=0; $j < $total_records; $j+=1) {
          if ($base == 'x'){
              $graph .= $dataarr["rows"][$j][$x_axis[$x_num]];
          }
          else{
              $graph .= $dataarr["rows"][$j][$y_axis[$y_num]];
          }
          if ($j < $total_records-1){
              $graph .= ", ";
          }
      }
      $graph .= "],";

      if ($base == 'x'){
          $graph .= "y:[";
      }
      else {
          $graph .= "x:[";
      }
      for ($j=0; $j < $total_records; $j+=1) {
          if ($base == 'x'){
              $graph .= $dataarr["rows"][$j][$y_axis[$y_num]];
          }
          else{
              $graph .= $dataarr["rows"][$j][$x_axis[$x_num]];
          }
          if ($j < $total_records-1){
              $graph .= ", ";
          }
      }
      $graph .= "],";

      /****************************************************/
      $chart_list = ["Scatter plot", "Line Dash", "Bubble", "Bar", "Scatter Line", "Line", "Overlaid Area", "Horizontal Bar", "Pie"];
      if ($graphtype == $chart_list[0]){
          $graph .= "mode: 'markers', ";
          $graph .= "type: 'scatter', ";
      }
      else if ($graphtype == $chart_list[1]){
          "mode: 'lines', ";
          "line: { dash: 'solid', width: 4}, ";
      }
      else if ($graphtype == $chart_list[2]){
          "mode: 'markers', ";
          "marker: { size: [";
              for ($j=0; $j < $total_records; $j+=1) {
                  if ($base == 'x'){
                      $graph .= $dataarr["rows"][$j][$y_axis[$y_num]];
                  }
                  else{
                      $graph .= $dataarr["rows"][$j][$x_axis[$x_num]];
                  }
                  if ($j < $total_records-1){
                      $graph .= ", ";
                  }
              }
          "]}, ";
      }
      else if ($graphtype == $chart_list[3]){
          "type: 'bar', ";
          "marker: { color: 'rgb(31,194,222)' }, ";
      }
      else if ($graphtype == $chart_list[4]){
          "mode: 'scatter', ";
      }
      else if ($graphtype == $chart_list[5]){
          "mode: 'lines', ";
          "type: 'scatter', ";
      }
      else if ($graphtype == $chart_list[6]){
          //"fill: 'tozeroy', ";
          "type: 'scatter', ";
      }
      else if ($graphtype == $chart_list[7]){
          "type: 'bar', ";
          "marker: { color: 'rgb(31,194,222)' }, ";
          "orientation: 'h', ";
      }
      else if ($graphtype == $chart_list[8]){
          "type: 'pie', ";
      }

      $graph .= "};";

      if ($base == 'x'){
          $y_num+=1;
      }
      else {
          $x_num+=1;
      }
  }

  $graph .= "var data = [";
  for ($i=0; $i < $xy_size; $i+=1) {
      $graph .= "trace" . $i;
      if ($i < $xy_size-1){
          $graph .= ", ";
      }
  }
  $graph .= "]; ";


  $layout = "var layout = {";
  $layout .= "title: 'Record of Student Results', ";
  $layout .= "xaxis: {";
  $layout .= "title: 'Overall Grade', ";
  $layout .= "showgrid: false, ";
  $layout .= "zeroline: false,";
  $layout .= "fixedrange: true";
  $layout .= "}, ";
  $layout .= "yaxis: {";
  $layout .= "title: 'Year', ";
  $layout .= "showline: false,";
  $layout .= "zeroline: false,";
  $layout .= "fixedrange: true";
  $layout .= "}, ";
  $layout .= "width: (window.innerWidth / 1.25), ";
  $layout .= "height: (window.innerHeight / 1.5) ";
  $layout .= "};";

   ?>
  <script>
    var Graph = "<?php echo $graph; ?>";
    eval(Graph);
    var graphlayout = "<?php echo $layout; ?>";
    eval(graphlayout);
    Plotly.newPlot('Results', data, layout);

    function Redo_Graph(){
      layout.width = (window.innerWidth / 1.25);
      layout.height = (window.innerHeight / 1.5);
      Plotly.newPlot('Results', data, layout);
    }
  </script>

</body>
</html>
