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
      $outputx .= '<option value="'.$cName.'" id="'.'x-'.$cName.'">'.$cName.'</option>';
  }
  for($i = 1; $i < $size; $i+=1){
      $cName = $arr['rows'][$i]['FieldName'];
      $outputy .= '<option value="'.$cName.'" id="'.'y-'.$cName.'">'.$cName.'</option>';
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

  <div class="box" style=" min-height: 100% !important; height: auto; width: 100vw; margin-top: 50px; ">
    <div class="table-responsive" style="overflow-x: scroll">
      <table id="table_data" class="table table-bordered table-striped">
        <thead>
          <tr>
            <?php
            for($i = 1; $i < $size; $i+=1){
                $coltitle = '';
                $coltitle .= "<th data-column-id='" . $arr['rows'][$i]['FieldName'] . "'>";
                $coltitle .= $arr['rows'][$i]['FieldName'] . "</th>";
                echo $coltitle;
            }
             ?>
          </tr>
        </thead>
      </table>
    </div>
    <table class="table table-bordered table-striped">
      <tbody>
        <tr align="center">
          <td>
            <div class="container" id="XYSelector">

              <div class="input-group">
              <select name="Chart" id="ChartOption" onChange="ChartSelected();" class="form-control">
                  <option>Please select a chart</option>
                  <option>Scatter plot</option>
                  <option>Line Dash</option>
                  <option>Bubble</option>
                  <option>Bar</option>
                  <option>Scatter Line</option>
                  <option>Line</option>
                  <option>Overlaid Area</option>
                  <option>Horizontal Bar</option>
                  <option>Pie</option>
                </select>
              </div>
              <br/>

                <select name="Y_column_selected" id="Y_column_selected1" onChange="Ydataselected();" disabled class="form-control">
                  <option value=0>Select Y Value</option>
                  <?php echo $outputy ?>
                </select>

              <br />
              <div class="form-group" id="Extra_X">

                  <select name="X_column_selected" id="X_column_selected1" onChange="Xdataselected('1');" disabled class="form-control">
                    <option value=0>Select X Value</option>
                    <?php echo $outputx ?>
                  </select>

                <br/>
              </div>
              <div class="input-group">
                <button class="btn btn-default" type="button" id="buttonadd" onclick="ExtraX()"> Add Another Selection </button>
              </div>

            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>


<div id="tableModal" class="modal fade">
  <div class="modal-dialog">
    <form method="post" id="table_form">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Data</h4>
        </div>
        <div class="modal-body">
          <?php
            for($i = 1; $i < $size; $i+=1){
              $colname = $arr['rows'][$i]['FieldName'];
              echo "<label>Enter " . $colname . "</label>";

              if ('INT' == $arr['rows'][$i]['DataType']){
                  $coltype = 'number';
              }
              else {
                  $coltype = 'text';
              }

              echo "<input type='$coltype' name='$colname' id='$colname' class='form-control' />";
              echo "<br />";
            }
           ?>
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
var num_x = 1;
var sizes = size - 2;
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
  }
  for (var i = 0; i < num_x; i += 1){
    $('select#X_column_selected' + i).prop('selectedIndex', 0);
  }
  $('select#Y_column_selected1').prop('selectedIndex', 0);
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
  for (var i = 1; i <= num_x; i += 1){
    var mess = '#X_column_selected' + i;
    $(mess).prop('disabled', bool);
  }
  $('#Y_column_selected1').prop('disabled', bool);
  $('#buttonadd').prop('disabled', bool);
  EnabledOrDisableOption('x', bool);
  EnabledOrDisableOption('y', bool);
}
var divSaver = [sizes];
function ExtraX(){
  if (num_x < sizes){
    num_x += 1;
    var div = '';
    div += '<div class="input-group" id="Axis-X-'+num_x+'" style="margin-top:50px;">';
    div += '<select name="X_column_selected" id="X_column_selected'+num_x+'" onChange="Xdataselected(\''+num_x+'\');" class="form-control">';
    div += '<option>Select X Value</option>'
    div += '<?php echo $outputx ?>';
    div += '</select><span class="input-group-btn">';
    div += '<button onClick="RemoveX('+num_x+');" class="btn btn-default" type="button" id="buttonx"> X </button>';// this is the cancel button
    div += '</span></div>';
    $('#Extra_X').append(div);
    divSaver[num_x] = div;
    if (num_x == size){
      document.getElementById('buttonadd').disabled = true;
    }
  }
  else {
    document.getElementById('buttonadd').disabled = true;
  }
  refreshAxisDiable();
}

function RemoveX(num){
  num_x -= 1;
  $('#Axis-X-' + num).remove();
  var button = document.getElementById('buttonadd');
  if (button.disabled){
    button.disabled = false;
  }
}

function refreshAxisDiable(){
  for (var i = 1; i < size; i += 1){
    var mess = 'x-' + options.FieldName[i];
    var diabled = document.getElementById(mess).disabled
    document.getElementById(mess).disabled = diabled;
  }
}

</script>

<script type="text/javascript" language='javascript'>
$(document).ready(function(){
  $('#add_data_button').click(function(){
    $('#table_form')[0].reset();
    $('.modal-title').text('Add Information');
    $('#action').val('Add Data');
    $('#operation').val('Add');
  });

  var productTable = $('#table_data').bootgrid({
    ajax: true,
    rowSelect: true,
    multiSelect: true,
    post: function()
    {
      return{
        id: 'b0df282a-0d67-40e5-8558-c9e93b7befed'
      };
    },
    url: 'sql/Bootgrid/fetch.php',

  });

  var colSize = "<?php echo $size-1 ?>";

  <?php
  //$aColumns = array();
  $aColumn = "var aColumns = ['";
  for($i = 1; $i < $size; $i+=1){
    $aColumn .= $arr['rows'][$i]['FieldName'];
    if ($i < $size-1){
      $aColumn .= "', '";
    }
  }
  $aColumn .= "'];";
  ?>;
  var aCol = "<?php echo $aColumn?>"
  eval(aCol);

  $(document).on('submit', '#table_form', function(event){
    event.preventDefault();
    var form_correct = true;
    for (var i = 0; i < colSize; i+=1){
      var col = $('#'+aColumns[i]).val();
      if (col == ''){
        form_correct = false;
      }
    }
    var form_data = $(this).serialize();
    if(form_correct)
    {
      $(':input[type="submit"]').prop('disabled', true);
      $.ajax({
        url:"sql/Bootgrid/insert.php",
        method:"POST",
        data:form_data,
        success:function(data)
        {
          alert(data);
          $(':input[type="submit"]').prop('disabled', false);
          $('#table_form')[0].reset();
          $('#tableModal').modal('hide');
          $('#table_data').bootgrid('reload');
        }
      });
    }
    else
    {
      alert("All Fields are Required");
    }
  });

  $(document).on("loaded.rs.jquery.bootgrid", function()
  {
    productTable.find(".update").on("click", function(event)
    {
      var col = "<?php echo $arr['rows'][0]['COLUMN_NAME']; ?>";
      eval("var " + col + " = $(this).data('row-id');");
      var rowUpdate = "$.ajax({" +
        "url:'sql/Bootgrid/fetch_single.php'," +
        "method:'POST'," +
        "data:{"+col+":"+col+"}," +
        "dataType:'json'," +
        "success:function(data)" +
        "{" +
          "$('#tableModal').modal('show');";
          for (var i = 0; i < colSize; i+=1){
            rowUpdate += "$('#"+aColumns[i]+"').val(data."+aColumns[i]+");";
          }
          rowUpdate += "$('.modal-title').text('Edit Product');"+
          "$('#"+col+"').val("+col+");" +
          "$('#action').val('Edit');" +
          "$('#operation').val('Edit');" +
        "}" +
      "});";
      eval(rowUpdate);
    });
  });

  $(document).on("loaded.rs.jquery.bootgrid", function()
  {
    productTable.find(".delete").on("click", function(event)
    {
      if(confirm("Are you sure you want to delete this?"))
      {
        $(':input[type="submit"]').prop('disabled', true);
        var col = "<?php echo $arr['rows'][0]['COLUMN_NAME']; ?>";
        //var col = "<?php //echo $arr['rows'][1]['FieldName']; ?>";
        eval("var " + col + " = $(this).data('row-id');");
        var rowDelete = "$.ajax({" +
          "url:'sql/Bootgrid/delete.php'," +
          "method:'POST'," +
          "data:{"+col+":"+col+"}, "+
          "success:function(data){" +
            "alert(data);" +
            "$(':input[type=\"submit\"]').prop('disabled', false);" +
            "$('#table_data').bootgrid('reload');" +
          "}" +
        "});";
        eval(rowDelete);
      }
      else{
        return false;
      }
    });
  });


});
</script>
