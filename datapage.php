<?php
  include "sql/mysql.inc";
  include 'inc/tools.inc';
  include("sql/Bootgrid/connection.php");
  include("sql/Bootgrid/getcolumns.php");

  if (!is_log()){
    header('location: Index.php');
  }
  CheckRequestLogout();
  navBarCreate('rgb(31,194,222)','Data');

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
        height: 10%;
    }

    .table>tbody>tr>td{
        font-size: 150%;
        height: 10%;
    }

  </style>
</head>
<body>

  <div class="box" style=" min-height: 100% !important; height: auto; width: 100vw; margin-top: 50px; ">
    <br />
    <div align="right" style="margin-top: 10%; margin-bottom: 5%;">
      <?php

        $addData = "<button type=\"button\" id=\"add_data_button\" data-toggle=\"modal\" data-target=\"#tableModal\" class=\"btn btn-info btn-lg\" style=\"font-size: 125%;\"";
        if ($size <= 1){
          $addData .= " disabled";
        }
        $addData .= ">Add Data</button>";
        echo $addData;

        echo "<button type=\"button\" id=\"add_column_button\" data-toggle=\"modal\" data-target=\"#columnAddModal\" class=\"btn btn-info btn-lg\" style=\"font-size: 125%;\">Add Column</button>";

        $editColumn = "<button type=\"button\" id=\"edit_column_button\" data-toggle=\"modal\" data-target=\"#columnEditModal\" class=\"btn btn-info btn-lg\" style=\"font-size: 125%;\"";
        if ($size <= 1){
          $editColumn .= " disabled";
        }
        $editColumn .= ">Edit Column</button>";
        echo $editColumn;

        $delColumn = "<button type=\"button\" id=\"delete_column_button\" data-toggle=\"modal\" data-target=\"#columnDeleteModal\" class=\"btn btn-info btn-lg\" style=\"font-size: 125%;\"";
        if ($size <= 1){
          $delColumn .= " disabled";
        }
        $delColumn .= ">Delete Column</button>";
        echo $delColumn;
       ?>
    </div>
    <div class="table-responsive" style="overflow-x: scroll">
      <table id="table_data" class="table table-bordered table-striped">
        <thead>
          <tr>
            <?php
            $coltitle = '';
            $coltitle .= "<th data-column-id='" . $arr['rows'][0]['COLUMN_NAME'] . "' data-type='numeric'>";
            $coltitle .= $arr['rows'][0]['COLUMN_NAME'] . "</th>";
            echo $coltitle;

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

  $('#add_column_button').click(function(){
    $('#column_addform')[0].reset();
    $('.modal-title').text('Add Column');
    $('#action').val('Add Column');
    $('#operation').val('Add');
  });

  $('#edit_column_button').click(function(){
    $('#column_editform')[0].reset();
    $('.modal-title').text('Edit Column');
    $('#action').val('Edit Column');
    $('#operation').val('Edit');
  });

  $('#delete_column_button').click(function(){
    $('#column_deleteform')[0].reset();
    $('.modal-title').text('Delete Column');
    $('#action').val('Delete Column');
    $('#operation').val('Delete');
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

  $(document).on('submit', '#column_addform', function(event){
    event.preventDefault();
    var column_name = $('#add_column_name').val();
    var datatype_selected = $('#datatype_selected').val();
    var form_data = $(this).serialize();
    if(column_name != '' && datatype_selected != '')
    {
      $.ajax({
        url:"sql/Bootgrid/Columninsert.php",
        method:"POST",
        data:form_data,
        success:function(data)
        {
          alert(data);
          $('#column_addform')[0].reset();
          $('#columnAddModal').modal('hide');
          location.reload();
        }
      });
    }
    else
    {
      alert("All Fields are Required");
    }
  });


  $(document).on('submit', '#column_editform', function(event){
    event.preventDefault();
    var column_name = $('#edit_column_name').val();
    var column_selected = $('#edit_column_selected').val();
    var form_data = $(this).serialize();
    if(column_name != '' && column_selected != '')
    {
      $.ajax({
        url:"sql/Bootgrid/Columnedit.php",
        method:"POST",
        data:form_data,
        success:function(data)
        {
          alert(data);
          $('#column_deleteform')[0].reset();
          $('#columnDeleteModal').modal('hide');
          location.reload();
        }
      });
    }
    else
    {
      alert("All Fields are Required");
    }
  });

  $(document).on('submit', '#column_deleteform', function(event){
    event.preventDefault();
    var column_selected = $('#delete_column_selected').val();
    var form_data = $(this).serialize();
    if(column_selected != '')
    {
      $.ajax({
        url:"sql/Bootgrid/Columndelete.php",
        method:"POST",
        data:form_data,
        success:function(data)
        {
          alert(data);
          $('#column_deleteform')[0].reset();
          $('#columnDeleteModal').modal('hide');
          location.reload();
        }
      });
    }
    else
    {
      alert("All Fields are Required");
    }
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


<div id="columnAddModal" class="modal fade">
  <div class="modal-dialog">
    <form method="post" id="column_addform">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Column</h4>
        </div>
        <div class="modal-body">
          <label>Enter Column Name</label>
          <input type='text' name='add_column_name' id='add_column_name' class='form-control' />
          <br />
          <label>Select DataType</label>
          <select name="datatype_selected" id="datatype_selected" class="form-control">
            <option value="">Select DataType</option>
            <?php echo $datatypes; ?>
          </select>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="operation" id="operation" />
          <input type="submit" name="action" id="action" class="btn btn-success" value="Add Column" />
        </div>
      </div>
    </form>
  </div>
</div>


<div id="columnEditModal" class="modal fade">
  <div class="modal-dialog">
    <form method="post" id="column_editform">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Column</h4>
        </div>
        <div class="modal-body">
          <label>Select Column</label>
          <select name="edit_column_selected" id="edit_column_selected" class="form-control">
            <option value="">Select Column</option>
            <?php echo $output; ?>
          </select>
          <br />
          <label>Enter Column Name</label>
          <input type='text' name='edit_column_name' id='edit_column_name' class='form-control' />
          <br />
        </div>
        <div class="modal-footer">
          <input type="hidden" name="operation" id="operation" />
          <input type="submit" name="action" id="action" class="btn btn-success" value="Edit Column" />
        </div>
      </div>
    </form>
  </div>
</div>


<div id="columnDeleteModal" class="modal fade">
  <div class="modal-dialog">
    <form method="post" id="column_deleteform">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete Column</h4>
        </div>
        <div class="modal-body">
          <label>Select Column</label>
          <select name="delete_column_selected" id="delete_column_selected" class="form-control">
            <option value="">Select Column</option>
            <?php echo $output ?>
          </select>
          <br />
        </div>
        <div class="modal-footer">
          <input type="hidden" name="operation" id="operation" />
          <input type="submit" name="action" id="action" class="btn btn-success" value="Delete Column" />
        </div>
      </div>
    </form>
  </div>
</div>
