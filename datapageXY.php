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
      $colNum = $i;
      $output .= '<option value='.$colNum.'>'.$cName.'</option>';
      //$output .= '<option value="{\'id\':'.$colNum. '\', \'name\':'.$cName.'}">'.$cName.'</option>';
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
        height: 10%;
    }

    .table>tbody>tr>td{
        font-size: 150%;
        height: 10%;
    }

  </style>

  <script>
    var x;
    var y;

    function x_column() {
        if (x != null){
            $("table>thead>tr>th:nth-child(" + x + ")").css("background-color", "white");
        }

        var old_x = x;
        x = document.getElementById("x_column_selected").value;
        if (x == 0){
            $("table>thead>tr>th:nth-child(" + old_x + ")").css("background-color", "white");
        }
        else if (x > 0){
            if (x == y){
                y = 0;
                document.getElementById("y_column_selected").value = y;
            }
            $("table>thead>tr>th:nth-child(" + x + ")").css("background-color", "rgb(252, 103, 25)");
        }
    }

    function y_column() {
        if (y != null){
            $("table>thead>tr>th:nth-child(" + y + ")").css("background-color", "white");
        }

        old_y = y;
        y = document.getElementById("y_column_selected").value;
        if (y == 0){
            $("table>thead>tr>th:nth-child(" + old_y + ")").css("background-color", "white");
        }
        else if (y > 0){
            if (y == x){
                x = 0;
                document.getElementById("x_column_selected").value = x;
            }
            $("table>thead>tr>th:nth-child(" + y + ")").css("background-color", "rgb(31,194,222)");
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
            $col = '';
            $col .= "<th data-column-id='" . $arr['rows'][0]['COLUMN_NAME'] . "' data-type='numeric'>";
            $col .= $arr['rows'][0]['COLUMN_NAME'] . "</th>";
            echo $col;
            */
            for($i = 1; $i < $size; $i+=1){
                $col = '';
                $col .= "<th data-column-id='" . $arr['rows'][$i]['FieldName'] . "'>";
                $col .= $arr['rows'][$i]['FieldName'] . "</th>";
                echo $col;
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
            <br />

            <select name="x_column_selected" id="x_column_selected" onchange="x_column()" class="form-control">
              <option value=0>Select X Value</option>
              <?php echo $output ?>
            </select>

            <br />

            <select name="y_column_selected" id="y_column_selected" onchange="y_column()" class="form-control">
              <option value=0>Select Y Value</option>
              <?php echo $output ?>
            </select>
            <br />
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

  $(document).on('submit', '#table_form', function(event){
    event.preventDefault();
    var form_correct = true;
    for (var i = 0; i < colSize; i+=1){
      var col = $('#'+aColumns[i]).val();
      if (col != ''){
        form_correct = true;
      }
      else {
        form_correct = false;
      }
    }
    var form_data = $(this).serialize();
    if(form_correct)
    {
      $.ajax({
        url:"sql/Bootgrid/insert.php",
        method:"POST",
        data:form_data,
        success:function(data)
        {
          alert(data);
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
    productTable.find(".delete").on("click", function(event)
    {
      if(confirm("Are you sure you want to delete this?"))
      {
        var col = "<?php echo $arr['rows'][0]['COLUMN_NAME']; ?>";
        eval("var " + col + " = $(this).data('row-id');");
        var rowDelete = "$.ajax({"+
          "url:'sql/Bootgrid/delete.php'," +
          "method:'POST'," +
          "data:{"+col+":"+col+"}, "+
          "success:function(data){" +
            "alert(data);" +
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
              $col = $arr['rows'][$i]['FieldName'];
              echo "<label>Enter " . $col . "</label>";
              echo "<input type='text' name='$col' id='$col' class='form-control' />";
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
