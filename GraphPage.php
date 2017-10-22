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
  navBarCreate('rgb(252, 103, 25)','Graph Page');
  $tablegraphIDs = GetGraphID($_SESSION['tableid']);
  if (in_array($_SESSION['graphid'], $tablegraphIDs)){
      $graphid = $_SESSION['graphid'];
  }
  else {
    gotoPage('previousgraphpage');
  }

  $graphtype = RequestGraphTableDetail($graphid, 'GraphType');

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



$x_axis = array();
$x_size = 0;
$y_axis = array();
$y_size = 0;
// if ($graphsize == 1){
//     for ($i=1; $i < $size; $i+=1) {
//         if ($grapharr['rows'][0]['FieldID'] == $arr['rows'][$i]['FieldID']){
//             $fname = $arr['rows'][$i]['FieldName'];
//         }
//     }
//     array_push($y_axis, $fname);
//     $y_size += 1;
// }
// else {
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
// }


$query_row = "SELECT $y_axis[0] FROM " . $table;
$result_row = mysqli_query($connection, $query_row);
$total_records = mysqli_num_rows($result_row);


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
  <br/>

</head>
<body onresize="Redo_Graph()">

  <div id ="Homebutton">
    <div class= "container" align="center">
      <div class="row">
        <div class="col">

          <div id="Results" style="margin-top: 10%"></div>
          <button type="button" id="ColorChange" data-toggle="modal" data-target="#tableModal" class="btn btn-info btn-lg" style="font-size: 125%; margin-right: 1%;">Change Color</button>

        </div>
      </div>
    </div>
  </div>
  <?php

  $graph = "";
  $layout = "";
  $x_num = 0;
  $y_num = 0;
  $chart_list = ["Scatter plot", "Line Dash", "Bubble", "Bar", "Scatter Line", "Line", "Overlaid Area", "Horizontal Bar", "Pie"];
  if ($graphtype == $chart_list[8]){
      $graph .= "var data = [{";
      $graph .= "type: 'pie', ";
      $graph .= "values:[";
      for ($i=0; $i < $total_records; $i+=1) {
          $graph .= $dataarr["rows"][$i][$x_axis[$x_num]];
          if ($i < $total_records-1){
              $graph .= ", ";
          }
      }
      $graph .= "], ";
      $graph .= "labels:['";
      for ($i=0; $i < $total_records; $i+=1) {
          $graph .= $dataarr["rows"][$i][$y_axis[$y_num]];
          if ($i < $total_records-1){
              $graph .= "', '";
          }
      }
      $graph .= "'] }]; ";

      $layout .= "var layout = {";
      $layout .= "title: 'Record of Student Results', ";
      $layout .= "width: (window.innerWidth / 1.25), ";
      $layout .= "height: (window.innerHeight / 1.5) ";
      $layout .= "};";


  }
  else if ($graphtype == $chart_list[3] || $graphtype == $chart_list[7]){
      $graph .= "var data = [{";
      $graph .= "type: 'bar', ";
      if ($graphtype == 'Bar'){
          $graph .= "y:[";
      }
      else {
          $graph .= "x:[";
      }
      for ($i=0; $i < $total_records; $i+=1) {
          $graph .= $dataarr["rows"][$i][$x_axis[$x_num]];
          if ($i < $total_records-1){
              $graph .= ", ";
          }
      }
      $graph .= "], ";
      if ($graphtype == 'Bar'){
          $graph .= "x:['";
      }
      else {
          $graph .= "y:['";
      }
      for ($i=0; $i < $total_records; $i+=1) {
          $graph .= $dataarr["rows"][$i][$y_axis[$y_num]];
          if ($i < $total_records-1){
              $graph .= "', '";
          }
      }
      $graph .= "'], ";

      $graph .= "marker: { color: 'rgb(31,194,222)' }, ";
      if ($graphtype == 'Horizontal Bar'){
          $graph .= "orientation: 'h', ";
      }

      $graph .= " }]; ";

      $layout .= "var layout = {";
      $layout .= "title: 'Record of Student Results', ";
      $layout .= "width: (window.innerWidth / 1.25), ";
      $layout .= "height: (window.innerHeight / 1.5) ";
      $layout .= "};";
  }

  else {
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

          if ($graphtype == $chart_list[0]){
              $graph .= "mode: 'markers', ";
              $graph .= "type: 'scatter', ";
          }
          else if ($graphtype == $chart_list[1]){
              $graph .= "mode: 'lines', ";
              $graph .= "line: { dash: 'solid', width: 4}, ";
          }
          else if ($graphtype == $chart_list[2]){
              $graph .= "mode: 'markers', ";
              $graph .= "marker: { size: [";
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
              $graph .= "]}, ";
          }
          else if ($graphtype == $chart_list[4]){
              $graph .= "mode: 'scatter', ";
          }
          else if ($graphtype == $chart_list[5]){
              $graph .= "mode: 'lines', ";
              $graph .= "type: 'scatter', ";
          }
          else if ($graphtype == $chart_list[6]){
              $graph .= "fill: 'tozeroy', ";
              $graph .= "type: 'scatter', ";
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

      $layout .= "var layout = {";
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
  }






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

    $(document).ready(function(){
      $('#ColorChange').click(function(){
        $('#table_form')[0].reset();
        $('.modal-title').text('Change Color');
      });
    });
  </script>

</body>
</html>

<div id="tableModal" class="modal fade" style="margin: 5%; overflow: hidden;">
  <div class="modal-dialog">
    <form method="post" id="table_form">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Colors</h4>
        </div>
        <div class="modal-body" style="overflow-y: scroll !important;">
          <?php
          echo "<div class='container' style='margin: auto;'><form method='POST'>";
          for($i = 0; $i < $graphsize - 1; $i+=1){
              if ($base == 'x'){
                  $colname = $y_axis[$i];
              }
              else {
                  $colname = $x_axis[$i];
              }
              echo "<div class='row' style='margin: auto'>";
              echo "<div class='col' style='margin: auto; float:left;'><label>" . $colname . "</label></div>";
              echo "<div class='col' style='margin: auto; float: right;'>";
              echo "<input type='color' name='color' id='$colname' value='#000000' style='border-radius: 5px;'/>";
              echo "</div></div><br/>";
          }
          echo "</form></div>";
           ?>
          <br />
        </div>
        <div class="modal-footer">
          <?php
          $id = $arr['rows'][0]['COLUMN_NAME'];
          echo "<input type='hidden' name='$id' id='$id' />";
           ?>
          <input type="hidden" name="operation" id="operation" />
          <input type="submit" name="action" id="action" class="btn btn-success" value="Add Data" />
        </div>
      </div>
    </form>
  </div>
</div>
