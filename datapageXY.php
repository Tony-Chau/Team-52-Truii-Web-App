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

  $BreakPoints = 3;

  $outputx = '<tr>';
  $bps = 3;
  for($i = 1; $i < $size; $i+=1){
      $cName = $arr['rows'][$i]['FieldName'];
      $outputx .= '<td><div data-toggle="buttons"><label class="btn btn-default original-btn" style="width: 100%" disable><input type="checkbox" value="'.$cName.'" name="'.'x-'.$cName.'" id="'.'x-'.$cName.'" disable><span style="font-size: 125%;">'.$cName.'</span></input></label></div></td>';
      if ($i == $size-1){
        $outputx .= '</tr>';
      }
      else if ($i == $bps){
        $outputx .= '</tr><tr>';
        $bps += $BreakPoints;
      }
  }
  $outputy = '<tr>';
  $bps = 3;
  for($i = 1; $i < $size; $i+=1){
      $cName = $arr['rows'][$i]['FieldName'];
      $outputy .= '<td><div data-toggle="buttons"><label class="btn btn-default original-btn" style="width: 100%" disable><input type="checkbox" value="'.$cName.'" name="'.'y-'.$cName.'" id="'.'y-'.$cName.'" disable><span style="font-size: 125%;">'.$cName.'</span></input></label></div></td>';
      if ($i == $size-1){
        $outputy .= '</tr>';
      }
      else if ($i == $bps){
        $outputy .= '</tr><tr>';
        $bps += $BreakPoints;
      }
  }
?>


<!DOCTYPE html>
<html>
<head>
  <title>DataPage XY</title>
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

  <div class="box" style=" min-height: 100% !important; height: auto; width: 100vw; margin-top: 50px; ">
    <div class="table-responsive" >


      <table class="table" style="overflow-x:auto; table-layout: fixed;">
        <thead>
          <tr><th><span style="margin-left:5px"> Please select a chart </span></th></tr>
        </thead>
        <tbody id="ChartsList">
        </tbody>

        <thead >
          <tr>
            <th style="width: 100px"><span style="margin-left:5px"> X-Axis </span></th>
          </tr>
        </thead>
        <tbody id="X">
          <?php echo $outputx ?>
        </tbody>

        <thead >
          <tr>
            <th style="width: 100px"><span style="margin-left:5px"> Y-Axis </span></th>
          </tr>
        </thead>
        <tbody id="Y">
          <?php echo $outputy ?>
        </tbody>

      </table>
    </div>

    <div class="input-group" align="center">
      <button class="btn btn-default" type="button" id="buttonadd" onclick="XY_Buttons();"> Create Chart </button>
    </div>
  </div>

</body>
</html>

<script>

//Initialise some values
var size = Number("<?php echo $size;?>");
var chart = '';
var x_select = [size];
var options = {
    FieldName: [size],
    DataType:[size]
};
var colourY;
//set all x_select values as an empty string
for (var i = 0; i < size; i += 1){
  x_select[i] = '';
}
//Transfer all php values to options as an javascript value
"<?php for ($i = 1; $i < $size; $i += 1){?>";
  options.FieldName[Number("<?php echo $i;?>")] = "<?php echo $arr['rows'][$i]['FieldName']?>";
  options.DataType[Number("<?php echo $i;?>")] = "<?php echo $arr['rows'][$i]['DataType']?>";
"<?php } ?>";
//response to Chart Combobox
function ChartSelected(){
  var select = document.getElementById('ChartOption');
  if (select.selectedIndex != 0){
    chart = select.options[select.selectedIndex].text;
    EnableOrDiableEverything(false);
    AxisChecker('x');
    AxisChecker('y');
  }else{
    chart = '';
    EnableOrDiableEverything(true);
    XYButtons('XY');
  }
  document.getElementById('X_column_selected1').selectedIndex = 0;
  document.getElementById('Y_column_selected1').selectedIndex = 0;
  Clear_column_colour();
}
//Response to the x-axis combo box
function Xdataselected(num){
  var select = document.getElementById('X_column_selected'+num);
    var index = select.selectedIndex;
    var selectedOption = select.options;
    var Value = selectedOption[index].text;
    if (index == 0){
      document.getElementById(x_select[num]).disabled = false;
    }else{
      x_select[num] = '';
      AxisChecker('y');
      for (var i = 1; i < size; i += 1){
        if (x_select[i] != ''){
          document.getElementById(x_select[i]).disabled = true;
        }
      }
      document.getElementById('y-' + Value).disabled = true;
      x_select[num] = 'y-' + Value;
    }
    X_column(index);
}

//Response to the y-axis combo box
function Ydataselected(){
  var select = document.getElementById('Y_column_selected1');
  var index = select.selectedIndex;
  var selectedOption = select.options;
  var Value = selectedOption[index].text;
  AxisChecker('x');
  if (index != 0){
    document.getElementById('x-' + selectedOption[index].text).disabled = true;
  }
  Y_column(index);
  colourY = index;
}

//Either enable or disable every options in the x and y combo box
function EnabledOrDisableOption(axis, bool){
  for (var i = 1; i < size; i += 1){
    document.getElementById(axis+ '-' + options.FieldName[i]).disabled = bool;
  }
}

function AxisChecker(axis){
  for (var i = 1; i < size; i += 1){
    document.getElementById(axis+ '-' + options.FieldName[i]).disabled = !ChartValidate(chart, axis, options.DataType[i]);
  }
}
//Either enable or disable everything in the x-axis, y-axis and their buttons
function EnableOrDiableEverything(bool){
  document.getElementById('X_column_selected1').disabled = bool;
  document.getElementById('Y_column_selected1').disabled = bool;
  //document.getElementById('buttonx').disabled = bool;
  //document.getElementById('buttony').disabled = bool;
  //document.getElementById('buttonadd').disabled = bool;
  EnabledOrDisableOption('x', bool);
  EnabledOrDisableOption('y', bool);
}

var chart_list = ["Scatter plot", "Line Dash", "Bubble", "Bar", "Scatter Line", "Line", "Overlaid Area", "Horizontal Bar", "Pie"];
var BreakPoints = 3;
var bps = 2;
var charts = '<tr>';
for (var i = 0; i < chart_list.length; i+=1) {
  charts += '<td><div data-toggle="buttons"><label class="btn btn-default original-btn-chart" id="chart'+i+'" style="width: 100%"><input type="radio" value="#" name="chartType" onclick="charts_reset('+i+')"><span style="font-size: 125%;">'+chart_list[i]+'</span></input></label></div></td>';
  if (i == chart_list.length-1){
    charts += '</tr>';
  }
  else if (i == bps){
    charts += '</tr><tr>';
    bps += BreakPoints;
  }
}
$('#ChartsList').append(charts);

function charts_reset(num){
  for (var i = 0; i < chart_list.length; i+=1){
    if (i != num){
      $('.original-btn-chart').removeClass('active');
    }
  }
}

/*
$('div label').click(function(e) {
   e.preventDefault();
   $('label').removeClass('active');
   $(this).addClass('active');
});*/

function XY_Buttons(){
  var num_of_columns;
  var XYsize = <?php echo $size; ?>;
  var div = '';
  for (num_of_columns = 1; num_of_columns < XYsize; num_of_columns+=1){
    div += '<th><span class="input-group-btn">';
    div += '';
    div += '<div data-toggle="buttons"><label class="btn btn-default"><input type="checkbox" value="#"><span>Choose As Y</span></input></label></div>';

    //div += '<button class="btn btn-default" type="button" id="X_button_'+num_of_columns+'" disabled> Choose as X </button></br>';
    //div += '<button class="btn btn-default" type="button" id="Y_button_'+num_of_columns+'" disabled> Choose as Y </button>';
    div += '</span></th>';
  }
  $('#XY').append(div);
}

</script>
