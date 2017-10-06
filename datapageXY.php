<?php
  include("sql/mysql.inc");
  include 'inc/tools.inc';
  include ("inc/ChartValidator.inc");
  include("sql/Bootgrid/connection.php");
  include("sql/Bootgrid/getcolumns.php");

  if (!is_log()){
    header('location: Index.php');
  }
  CheckRequestLogout();
  navBarCreate('rgb(31,194,222)','Data XY');

  $output = '';
  for($i = 1; $i < $size; $i+=1){
      $cName = $arr['rows'][$i]['FieldName'];
      $output .= '<option value="'.$cName.'">'.$cName.'</option>';
  }

  $datatypes = '';
  $datatypes .= '<option value="VARCHAR(255)">Text</option>';
  $datatypes .= '<option value="INT"># Numbers</option>';
  $datatypes .= '<option value="FLOAT">% Percentage</option>';
  $datatypes .= '<option value="DATETIME">&#128467 DateTime</option>';

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
  <style>
    body
    {
      margin:0;
      pAdd_Dataing:0;
      background-color:#f1f1f1;
    }

    .box
    {
      min-width: 600px;
      padding:20px;
      background-color:#fff;
      border:1px solid #ccc;
      border-radius:5px;
    }

    .btn-info {
      color: #fff;
      background-color: rgb(31,194,222);
      border-color: #46b8da;
    }

    .table-responsive .bootgrid-table td
    {
      white-space: nowrap !important;
    }

    .pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
      z-index: 3;
      color: #fff;
      cursor: default;
      background-color: rgb(31,194,222);
      border-color: rgb(31,194,222);
    }

    .pagination{
      font-size: 200%;
    }

    .infos{
      font-size: 150%;
    }

    .table>thead>tr>th{
        font-size: 150%;
    }

    .table>tbody>tr>td{
        font-size: 150%;
    }

  </style>

  <script>
    var size = "<?php echo $size; ?>";
    //var XY_values = array();
    var x;
    var y;
    function X_column(num) {
        if (x != null){
            $("table>thead:first-child>tr:first-child>th:nth-child(" + x + ")").css("background-color", "white");
        }

        var old_x = x;
        x = document.getElementById("X_column_selected"+num).value;
        if (x == 0){
            $("table>thead:first-child>tr:first-child>th:nth-child(" + old_x + ")").css("background-color", "white");
        }
        else if (x > 0){
            if (x == y){
                y = 0;

                document.getElementById("Y_column_selected"+num).value = y;
            }
            $("table>thead:first-child>tr:first-child>th:nth-child(" + x + ")").css("background-color", "rgb(252, 103, 25)");
        }
    }


    function Y_column() {
        if (y != null){
            $("table>thead:first-child>tr:first-child>th:nth-child(" + y + ")").css("background-color", "white");
        }

        old_y = y;
        y = document.getElementById("Y_column_selected"+num).value;
        if (y == 0){
            $("table>thead:first-child>tr:first-child>th:nth-child(" + old_y + ")").css("background-color", "white");
        }
        else if (y > 0){
            if (y == x){
                x = 0;
                document.getElementById("X_column_selected"+num).value = x;
            }
            $("table>thead:first-child>tr:first-child>th:nth-child(" + y + ")").css("background-color", "rgb(31,194,222)");
        }
    }

    function chooseFields(Primary, Secondary){

      var xy = '';
      var i = 1;
      xy += '<div class="input-group">';
      xy += '<select name="'+Primary+'_column_selected'+i+'" id="xy_selected_'+i+'" onchange="'+Primary+'_column('+i+')" class="form-control">';
      xy += '<option value=0>Select '+Primary+' Value</option>';
      xy += '<?php echo $output; ?>';
      xy += '</select></div><br/>';

      var number = '#Column' + i;
      for (i = 2; i < size; i+=1){
          xy += '<div class="input-group">';
          xy += '<select name="'+Secondary+'_column_selected'+i+'" id="xy_selected_'+i+'" onchange=\"'+Secondary+'_column('+i+')" class="form-control">';
          xy += '<option value=0>Select '+Secondary+' Value</option>';
          xy += '<?php echo $output; ?>';
          xy += '</select><span class="input-group-btn">';
          xy += '<button class="btn btn-default" type="button"> X </button>';
          xy += '</span></div><br/>';
      }
      $('#XYSelector').append(xy);

    }
    function deleteField(column){
      document.getElementById("textinput" + column).required = false;
      document.getElementById("textinput" + column).value = '';
    }


    function updateXY(num, val){
      for (var i = 1; i < size; i += 1){
        if ( i != num ){
          var select=document.getElementById('xy_selected'+i);
          for (var j = 1; i < select.length; i+=1) {
            if (select.options[i].value == val) {
              select.option[i].disabled = true;
            }
          }
        }
      }

      function renewXY(){
        //for (var i = 1; i < size){}
      }
    }

  </script>

</head>
<body>

  <div class="box" style=" min-height: 100% !important; height: auto; width: 100vw; margin-top: 50px; ">

    <div class="table-responsive" style="overflow-x: scroll">
      <table id="table_data" class="table table-bordered table-striped">
        <thead>
          <tr>
            <?php
            /*
            $coltitle = '';
            $coltitle .= "<th data-column-id='" . $arr['rows'][0]['COLUMN_NAME'] . "' data-type='numeric'>";
            $coltitle .= $arr['rows'][0]['COLUMN_NAME'] . "</th>";
            echo $coltitle;
            */
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
                <select name="x_column_selected" id="X_column_selected1" onchange="X_column(1)" class="form-control">
                  <option value=0>Select X Value</option>
                  <?php echo $output ?>
                </select>
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"> X </button>
                </span>
              </div>
              <br />
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</body>
</html>
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
