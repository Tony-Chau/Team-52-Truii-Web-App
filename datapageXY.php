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
  navBarCreate('#EE6724','Data XY');

  if($_SERVER['REQUEST_METHOD'] == 'POST'){
      if (isset($_POST['chart'])){
          $charttype = $_POST['chart'];
          $ID_Graph = GetLastGraphTableID();
          $sql = EnterGraphTable($_SESSION['tableid'], $charttype);
          for ($i = 1; $i < $size; $i+=1){
              if (isset($_POST["x_axis{$i}"])){
                  $sql .= EnterGraphColumnTable($ID_Graph, $arr['rows'][$i]['FieldID'], "x");
              }
              if (isset($_POST["y_axis{$i}"])){
                  $sql .= EnterGraphColumnTable($ID_Graph, $arr['rows'][$i]['FieldID'], "y");
              }
          }
          CallDatabase($sql);
          $_SESSION['graphid'] = $ID_Graph;
          gotoPage('GraphPage');
      }
  }
?>


<!DOCTYPE html>
<html>
<head>

  <title>DataPage XY</title>
  <br/>

</head>
<body>

  <div class="container" style="margin-top: 20%; padding:0; ">
    <div class="table-responsive">


      <table class="table"  style="overflow-x:auto; table-layout: fixed;">
        <thead id="title-chart">
          <tr><th><span style="margin-left:5px" id='title'> Please select a chart </span></th></tr>
        </thead>
        <tbody id="table-button">
        </tbody>
      </table>
    </div>
    <div class="input-group" style="width: 100%;" align="center">
      <button class="btn btn-default" type="button" id="buttonback" style="float: left;background-color:#EE6724;color:#FFFFFF;" onclick="back();" disabled> Back </button>
      <button class="btn btn-default" type="button" id="buttonadd" style="float: right;background-color:#EE6724;color:#FFFFFF;" onclick="next();" disabled> Next </button>
    </div>
  </div>
  <div>
    <form method="POST" id="XY">
      <input type="submit" id="xy_submit" style="display: none;">
    </form>
  </div>
</body>
</html>

<script>

//Initialise some values
var size = Number("<?php echo $size;?>");
var chart;
var page = 1;
var options = {
    FieldName: [size],
    DataType:[size]
};
var x_disabled = [size];

//Transfer all php values to options as an javascript value
"<?php for ($i = 1; $i < $size; $i += 1){?>";
  options.FieldName[Number("<?php echo $i;?>")] = "<?php echo $arr['rows'][$i]['FieldName']?>";
  options.DataType[Number("<?php echo $i;?>")] = "<?php echo $arr['rows'][$i]['DataType']?>";
"<?php } ?>";

var chart_list = ["Scatter plot", "Line Dash", "Bubble", "Bar", "Scatter Line", "Line", "Overlaid Area", "Horizontal Bar", "Pie"];
function Create_Chart(){
  var BreakPoints = 2;
  var bps = 1;
  var charts = '<tr>';
  for (var i = 0; i < chart_list.length; i+=1) {
    charts += '<td><button onClick="charts_reset('+i+');" class="btn btn-default original-btn-chart" id="chart'+i+'" style="width: 100%"><span style="font-size: 100%;">'+chart_list[i]+'</span></button></td>';
    if (i == chart_list.length-1){
      charts += '</tr>';
    }
    else if (i == bps){
      charts += '</tr><tr>';
      bps += BreakPoints;
    }
  }
  for (var i = 0; i < size; i += 1){
    x_disabled[i] = true;
  }
  $('#title-chart').html('<tr><th><span style="margin-left:5px" id="title"> Please select a chart </span></th></tr>');
  $('#table-button').html(charts);
}

function charts_reset(num){
  chart = chart_list[num];
  $('.original-btn-chart').removeAttr('disabled');
  $('.original-btn-chart').css('background-color', '#FFFFFF');
  $('#chart' + num).css('background-color', '#EE6724');
  $('#chart' + num).attr('disabled', 'disabled');
  $('#buttonadd').removeAttr('disabled');
}

function Create_Axis(axis){
  var breakpoints = 2;
  var bps = 2;
  var point = 0;
  var outputx = '<tr>';
  for (var i = 1; i < size; i += 1){
    var cName = options.FieldName[i];
    if (ChartValidate(chart, axis, options.DataType[i])){
      if (x_disabled[i]){
        point += 1;
        outputx  += '<td><button onclick="'+axis+'_selection(' + i + ');" class="btn btn-default original-btn-'+axis+'" value="'+ cName +'" name="'+axis+'-'+ cName +'" id="'+axis+'-axis-button' + i +'" style="width: 100%"><span style="font-size: 100%;" disabled>'+ cName + '</span></button></td>';
      }
    }
    if(point == size - 1){
      $outputx += '</tr>';
    }else if (point == bps){
      outputx += '</tr><tr>';
      breakpoints += bps;
      point = 0;
    }
  }
  $('#title-chart').html('<tr><th><span style="margin-left:5px" id="title"> '+axis.toUpperCase()+'-Axis </span></th></tr>');
  $('#table-button').html(outputx);
}

function checkbutton(){
  if (page == 1){
    $('#buttonback').attr('disabled', 'disabled');
    $('#buttonadd').attr('disabled', 'disabled');
    $('#title-chart').fadeOut('slow');
    $('#table-button').fadeOut('slow');
    setTimeout(function(){
      Create_Chart();
      $('#title-chart').fadeIn('slow');
      $('#table-button').fadeIn('slow');
    }, 500);
  }else if (page == 2){
    $('#buttonback').removeAttr('disabled');
    $('#buttonadd').html('Next');
    $('#title-chart').fadeOut('slow');
    $('#table-button').fadeOut('slow');
    $('#buttonadd').attr('disabled', 'disabled');
    setTimeout(function(){
      Create_Axis('x');
      $('#title-chart').fadeIn('slow');
      $('#table-button').fadeIn('slow');
    }, 500);
  }else{
    $('#buttonadd').attr('disabled', 'disabled');
    $('#buttonadd').html('Create Chart');
    $('#title-chart').fadeOut('slow');
    $('#table-button').fadeOut('slow');
    setTimeout(function(){
      Create_Axis('y');
      $('#title-chart').fadeIn('slow');
      $('#table-button').fadeIn('slow');
    }, 500);
  }
}

var x_selected = 0;
var x_highlight = [size];
for (var i = 0; i < size; i += 1){
  x_highlight[i] = false;
}
var previous_x = -1;
function x_selection(num){
  if (!(chart == 'Pie' || chart == 'Bar' || chart == "Horizontal Bar")){
    if (x_disabled[num]){
      $('#x-axis-button' + num).css('background-color', 'rgb(31,194,222)');
      x_disabled[num] = false;
      x_highlight[num] = true;
      x_selected += 1;
    }else{
      $('#x-axis-button' + num).css('background-color', '#FFFFFF');
      x_disabled[num] = true;
      x_highlight[num] = false;
      x_selected -= 1;
    }
    if (x_selected >= 1){
      $('#buttonadd').removeAttr('disabled');
    }
  }else{
    $('.original-btn-x').css('background-color', '#FFFFFF');
    if (previous_x == -1){
      $('#x-axis-button' + num).attr('disabled', 'disabled');
      $('#x-axis-button' + num).css('background-color', 'rgb(31,194,222)');
      previous_x = num;
      x_disabled[num] = true;
      x_selected = 1;
    }else{
      $('#x-axis-button' + num).attr('disabled', 'disabled');
      $('#x-axis-button' + previous_x).removeAttr('disabled');
      $('#x-axis-button' + num).css('background-color', 'rgb(31,194,222)');
      x_disabled[num] = true;
      x_disabled[previous_x] = false;
      previous_x = num;
      x_selected = 1;
    }
  }
  if (x_selected >= 1){
    $('#buttonadd').removeAttr('disabled');
  }
}
var y_selected = false;
var previous_y = -1;
function y_selection(num){
  $('.original-btn-y').css('background-color', '#FFFFFF');
  if (previous_y == -1){
    $('#y-axis-button' + num).attr('disabled', 'disabled');
    $('#y-axis-button' + num).css('background-color', 'rgb(31,194,222)');
    previous_y = num;
    x_disabled[num] = true;
    y_selected = true;
  }else{
    $('#y-axis-button' + num).attr('disabled', 'disabled');
    $('#y-axis-button' + previous_y).removeAttr('disabled');
    $('#y-axis-button' + num).css('background-color', 'rgb(31,194,222)');
    x_disabled[num] = true;
    x_disabled[previous_y] = false;
    previous_y = num;
  }
  if (y_selected){
    $('#buttonadd').removeAttr('disabled');
  }else{
    $('#buttonadd').attr('disabled', 'disabled');
  }
}

function back(){
  if (page == 3){
    x_disabled[previous_y] = false;
    previous_y = -1;
    for (var i = 0; i < size; i += 1){
      x_highlight[i] = false;
      if (ChartValidate(chart, 'x', options.DataType[i])){
        x_disabled[i] = true;
      }
    }
  }
  page -= 1;
  checkbutton();
}

function next(){
  if (page == 3){
    var div = "<input type='text' name='size' value='"+size+"' style='display:none !important;'/>";
    div += "<input type='text' name='chart' value='"+chart+"' style='display:none !important;'/>";
    for (var i = 1; i < size; i += 1){
      if (!(chart == 'Pie' || chart == 'Bar' || chart == "Horizontal Bar")){
        if (x_highlight[i]){
          div += "<input type='text' name='x_axis" + i + "' value='"+options.FieldName[i]+"' style='display:none !important;'/>";
        }
      }else{
        if (i == previous_x){
          div += "<input type='text' name='x_axis" + i + "' value='"+options.FieldName[i]+"' style='display:none !important;'/>";
        }
      }
        if (i == previous_y){
          div += "<input type='text' name='y_axis" + i + "' value='"+options.FieldName[i]+"' style='display:none !important;'/>";
        }
    }
    $('#XY').append(div);
    $('#xy_submit').click();
  }else{
    page += 1;
    checkbutton();
  }
}
Create_Chart();
</script>
