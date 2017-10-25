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


$custom_query = "SELECT * FROM CustomFieldTable WHERE GraphID = $graphid";
$gotcustoms = mysqli_query($connection, $custom_query);
while($customfields = mysqli_fetch_assoc($gotcustoms))
{
    $customcolumns[] = $customfields;
}
$customoutput = array( 'rows' => $customcolumns );
$json = json_encode($customoutput);
$customarr = (json_decode($json, true));


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

  <style>
    .modebar-group{
      margin-left: 4px !important;
    }
    .modebar-group:first-child{
      margin-left: 15px !important;
      float: right !important;
    }
    .modebar-group:first-child>.modebar-btn:nth-child(2) {
      display: none !important;
    }
    .modebar-group:nth-child(5){
      display: none !important;
    }

  </style>
</head>
<body onresize="Redo_Graph()">

  <div id ="Homebutton">
    <div class= "container" align="center" style="padding:0; margin:0;">
      <div class="row" style="padding:0; margin:0;">
        <div class="col">

          <div id="Results" style="margin-top: 10%"></div>
          <button type="button" id="ColorChange" data-toggle="modal" data-target="#tableModal" class="btn btn-info btn-lg" style="font-size: 125%; margin-right: 1%;">Change Color</button>
          <div id="H2Canvas" style="display: none;"></div>

          <form method=POST style="display: none;" id="snapshot">
            <input type="hidden" name="temp" id="temp" value="" />
            <input type="submit" name="action" id="action"/>
          </form>

        </div>
      </div>
    </div>
  </div>
  <?php

  $graph = "";
  $layout = "";
  $canvas = "";
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
      $layout .= "title: 'Record of Student Results' ";
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

      $graph .= "marker: { color: '";
      $graph .= $customarr["rows"][$x_num]["ColourCode"] . "' }, ";
      if ($graphtype == 'Horizontal Bar'){
          $graph .= "orientation: 'h', ";
      }

      $graph .= " }]; ";

      $layout .= "var layout = {";
      $layout .= "title: 'Record of Student Results' ";
      $layout .= "};";
  }

  else {
      for ($i = 0; $i < $xy_size; $i+=1) {
          $graph .= " var trace" . $i . " = { ";
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
          $graph .= "], ";

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
          $graph .= "], ";

          /****************************************************/

          if ($graphtype == $chart_list[0]){
              $graph .= "mode: 'markers', ";
              $graph .= "type: 'scatter', ";
              $graph .= "marker: { color: '";
              if ($base == 'x'){
                $graph .= $customarr["rows"][$y_num]["ColourCode"] . "'} ";
              }
              else {
                $graph .= $customarr["rows"][$x_num]["ColourCode"] . "'} ";
              }
          }
          else if ($graphtype == $chart_list[1]){
              $graph .= "mode: 'lines', ";
              $graph .= "line: { dash: 'solid', width: 4, color: '";
              if ($base == 'x'){
                $graph .= $customarr["rows"][$y_num]["ColourCode"] . "'} ";
              }
              else {
                $graph .= $customarr["rows"][$x_num]["ColourCode"] . "'} ";
              }
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
              $graph .= "], color: '";
              if ($base == 'x'){
                $graph .= $customarr["rows"][$y_num]["ColourCode"] . "'} ";
              }
              else {
                $graph .= $customarr["rows"][$x_num]["ColourCode"] . "'} ";
              }
          }
          else if ($graphtype == $chart_list[4]){
              $graph .= "mode: 'scatter', ";
              $graph .= "marker: { color: '";
              if ($base == 'x'){
                $graph .= $customarr["rows"][$y_num]["ColourCode"] . "'} ";
              }
              else {
                $graph .= $customarr["rows"][$x_num]["ColourCode"] . "'} ";
              }
              $graph .= "line: { color: '";
              if ($base == 'x'){
                $graph .= $customarr["rows"][$y_num]["ColourCode"] . "'} ";
              }
              else {
                $graph .= $customarr["rows"][$x_num]["ColourCode"] . "'} ";
              }
          }
          else if ($graphtype == $chart_list[5]){
              $graph .= "mode: 'lines', ";
              $graph .= "type: 'scatter', ";
              $graph .= "line: { color: '";
              if ($base == 'x'){
                $graph .= $customarr["rows"][$y_num]["ColourCode"] . "'} ";
              }
              else {
                $graph .= $customarr["rows"][$x_num]["ColourCode"] . "'} ";
              }
          }
          else if ($graphtype == $chart_list[6]){
              $graph .= "fill: '";
              $graph .= $customarr["rows"][$y_num]["ColourCode"];
              $graph .= "', ";
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
      $layout .= "autosize: true,";
      $layout .= "margin: {";
      $layout .= "l	:	60, ";
      $layout .= "r	:	20, ";
      $layout .= "t	:	120, ";
      $layout .= "b	:	75, ";
      $layout .= "pad	:	0, ";
      $layout .= "autoexpand : true,";
      $layout .= "}, ";

      $layout .= "xaxis: {";
      $layout .= "title: 'Overall Grade', ";
      $layout .= "showgrid: false, ";
      $layout .= "zeroline: false, ";
      //$layout .= "fixedrange: true";
      $layout .= "}, ";
      $layout .= "yaxis: {";
      $layout .= "title: 'Year', ";
      $layout .= "showline: false, ";
      $layout .= "zeroline: false, ";
      //$layout .= "fixedrange: true";
      $layout .= "} };";


      $canvas .= "var clayout = {";
      $canvas .= "autosize: true,";
      $canvas .= "margin: {";
      $canvas .= "l	:	0, ";
      $canvas .= "r	:	0, ";
      $canvas .= "t	:	0, ";
      $canvas .= "b	: 0, ";
      $canvas .= "pad	:	0, ";
      $canvas .= "autoexpand : true,";
      $canvas .= "} };";
  }






   ?>
  <script>
    var Graph = "<?php echo $graph; ?>";
    eval(Graph);
    var graphlayout = "<?php echo $layout; ?>";
    eval(graphlayout);
    var canvaslayout = "<?php echo $canvas; ?>";
    eval(canvaslayout);

    function Redo_Graph(){
      Plotly.newPlot('Results', data, layout);
    }

    Plotly.newPlot('Results', data, clayout);
    html2canvas(document.getElementById('Results'), {
      onrendered: function(canvas) {
        canvas.id = 'graph';
        document.getElementById('H2Canvas').appendChild(canvas);
      },
      width: clayout.width,
      height: clayout.height
    });
    Plotly.newPlot('Results', data, layout);

    setTimeout(function() {
        canvasstart();
    }, 1000);

    $(document).ready(function(){
        $('#ColorChange').click(function(){
          $('#table_form')[0].reset();
          $('.modal-title').text('Change Color');
        });

        $(document).on('submit', '#snapshot', function(event){
            event.preventDefault();
            var form_data = $(this).serialize();
            $.ajax({
                url:"BaseToDB.php",
                method:"POST",
                data:form_data,
                success:function(data)
                {
                    alert(data);
                }
            });
        });
    });

    function cleandataURL(dataurl) {
        var arr = dataurl.split(','), url = arr[1];
        return url;
    }

    function canvasstart() {
        var canvas = document.getElementById('graph');
        var pngCanvas = canvas.toDataURL();
        document.getElementById('temp').value = cleandataURL(pngCanvas);
        //alert(document.getElementById('temp').value);
        document.getElementById('action').click();
    }

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
              if (checkPhone() == 'ios'){
                echo "<input type=\"text\" id=\"custom\"/>";
                echo '<script>
                        $("#custom").spectrum({
                            color: "#f00"
                        });
                        </script>';
                //echo "<div class='sp-replacer sp-light sp-active'></div>";//echo "<input class='jscolor' name='color' id='$colname' value='#000000' style='border-radius: 5px; max-width: 60px' onclick='jscolor.init();'/>";
              }
              else{
                echo "<input type='color' name='color' id='$colname' value='#000000' style='border-radius: 5px;'/>";
              }

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
