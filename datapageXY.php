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
<div>
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
  <!-- <script src='js/Functions/datapagexy.js'></script> -->
</div>
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
            <th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
          </tr>
        </thead>
      </table>
    </div>
    <table class="table table-bordered table-striped">
      <tbody>
        <tr align="center">
          <td>
            <div class="container" id="XYSelector">

              <br />
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
              <div class="input-group">
                <select name="x_column_selected" id="X_column_selected1" onChange="Xdataselected('1');" disabled class="form-control">
                  <option value=0>Select X Value</option>
                  <?php echo $outputx ?>
                </select>
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button" id='buttonx' disabled> X </button>
                </span>
                <select name="Y_column_selected" id="Y_column_selected1" onChange="Ydataselected();" disabled class="form-control">
                  <option value=0>Select Y Value</option>
                  <?php echo $outputy ?>
                </select>
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button" id='buttony' disabled> Y </button>
                </span>
              </div>
              <br />
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
</body>
</html>
<script>
var size = Number("<?php echo $size;?>");
var chart = '';
var x_select = [size];
var options = [size];
for (var i = 0; i < size; i += 1){
  x_select[i] = '';
}
"<?php for ($i = 1; $i < $size; $i += 1){?>";
  options[Number("<?php echo $i;?>")] = "<?php echo $arr['rows'][$i]['FieldName']?>";
"<?php } ?>";
function ChartSelected(){
  var select = document.getElementById('ChartOption');
  if (select.selectedIndex != 0){
    chart = select.options[select.selectedIndex].text;
    document.getElementById('X_column_selected1').disabled = false;
    document.getElementById('Y_column_selected1').disabled = false;
    document.getElementById('buttonx').disabled = false;
    document.getElementById('buttony').disabled = false;
    EnabledOrDisableOption('x', false);
    EnabledOrDisableOption('y', false);
  }else{
    chart = '';
    document.getElementById('X_column_selected1').disabled = true;
    document.getElementById('Y_column_selected1').disabled = true;
    document.getElementById('buttonx').disabled = true;
    document.getElementById('buttony').disabled = true;
    EnabledOrDisableOption('x', true);
    EnabledOrDisableOption('y', true);
  }
  document.getElementById('X_column_selected1').selectedIndex = 0;
  document.getElementById('Y_column_selected1').selectedIndex = 0;
}

function Xdataselected(num){
  var select = document.getElementById('X_column_selected'+num);
  var index = select.selectedIndex;
  var selectedOption = select.options;
  var Value = selectedOption[index].text;

  if (index == 0){
    document.getElementById(x_select[num]).disabled = false;
  }else{
    x_select[num] = '';
    for (var i = 1; i < size; i += 1){
      var option = selectedOption;
      document.getElementById('y-' + option[i].text).disabled = false;
    }
    for (var i = 1; i < size; i += 1){
      if (x_select[i] != ''){
        document.getElementById(x_select[i]).disabled = true;
      }
    }
    document.getElementById('y-' + Value).disabled = true;
    x_select[num] = 'y-' + Value;
  }
}

function Ydataselected(){
  var select = document.getElementById('Y_column_selected1');
  var index = select.selectedIndex;
  var selectedOption = select.options;
  var Value = selectedOption[index].text;
  for (var i = 1; i < size; i += 1){
    EnabledOrDisableOption('x', false);
  }
  if (index != 0){
    document.getElementById('x-' + selectedOption[index].text).disabled = true;
  }
}

function EnabledOrDisableOption(axis, bool){
  for (var i = 1; i < size; i += 1){
    document.getElementById(axis+ '-' + options[i]).disabled = bool;
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
    formatters: {
      'commands': function(column, row)
      {
        var id = "row."+"<?php echo $arr['rows'][0]['COLUMN_NAME']; ?>";
        var buttonID = eval(id);
        var buttons = "<button type='button' class='btn btn-warning btn-xs update' data-row-id='"+buttonID+"' style=\"font-size: 75%;\">Edit</button>"+
              "&nbsp; <button type='button' class='btn btn-danger btn-xs delete' data-row-id='"+buttonID+"' style=\"font-size: 75%;\">Delete</button>";
        return buttons;
      }
    }
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
