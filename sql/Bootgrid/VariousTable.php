<?php
include("../mysql.inc");
include("connection.php");
include("getcolumns.php");

$output = '';

for($i = 1; $i < $size; $i+=1){
    $cName = $arr['rows'][$i]['COLUMN_NAME'];
    $output .= '<option value="'.$cName.'">'.$cName.'</option>';
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Bootgrid Tutorial - Server Side Processing using Ajax PHP</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-bootgrid/1.3.1/jquery.bootgrid.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bootgrid/1.3.1/jquery.bootgrid.js"></script>
    <style>
      body
      {
        margin:0;
        pAdd_Dataing:0;
        background-color:#f1f1f1;
      }
      .box
      {
        width:1270px;
        padding:20px;
        background-color:#fff;
        border:1px solid #ccc;
        border-radius:5px;
        margin-top:25px;
      }
    </style>
  </head>
  <body>
    <div class="container box">
      <h1 align="center">Jquery Bootgrid Tutorial - Server Side Processing using Ajax PHP</h1>
      <br />
      <div align="right">
        <button type="button" id="add_data_button" data-toggle="modal" data-target="#testModal" class="btn btn-info btn-lg">Add Data</button>
        <button type="button" id="add_column_button" data-toggle="modal" data-target="#columnAddModal" class="btn btn-info btn-lg">Add Column</button>
        <button type="button" id="delete_column_button" data-toggle="modal" data-target="#columnDeleteModal" class="btn btn-info btn-lg">Delete Column</button>
      </div>
      <div class="table-responsive">
        <table id="test_data" class="table table-bordered table-striped">
          <thead>
            <tr>
              <?php
              for($i = 0; $i < $size; $i+=1){
                  $col = '';
                  $col .= "<th data-column-id='" . $arr["rows"][$i]["COLUMN_NAME"] . "'";
                  if ($i == 0){
                      $col .= "data-type='numeric'>";
                  }
                  else{
                      $col .= ">";
                  }
                  $col .= $arr["rows"][$i]["COLUMN_NAME"] . "</th>";
                  echo $col;
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
<script type="text/javascript" language='javascript' >
$(document).ready(function(){
  $('#add_data_button').click(function(){
    $('#test_form')[0].reset();
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

  $('#delete_column_button').click(function(){
    $('#column_deleteform')[0].reset();
    $('.modal-title').text('Delete Column');
    $('#action').val('Delete Column');
    $('#operation').val('Delete');
  });

  var productTable = $('#test_data').bootgrid({
    ajax: true,
    rowSelect: true,
    multiSelect: true,
    post: function()
    {
      return{
        id: 'b0df282a-0d67-40e5-8558-c9e93b7befed'
      };
    },
    url: 'fetch.php',
    formatters: {
      'commands': function(column, row)
      {
        var id = "row."+"<?php echo $arr['rows'][0]['COLUMN_NAME']; ?>";
        var buttonID = eval(id);
        var buttons = "<button type='button' class='btn btn-warning btn-xs update' data-row-id='"+buttonID+"'>Edit</button>"+
              "&nbsp; <button type='button' class='btn btn-danger btn-xs delete' data-row-id='"+buttonID+"'>Delete</button>";
        return buttons;
      }
    }
  });

  var colSize = "<?php echo $size-1 ?>";
  <?php
  //$aColumns = array();
  $aColumn = "var aColumns = ['";
  for($i = 1; $i < $size; $i+=1){
    $aColumn .= $arr['rows'][$i]['COLUMN_NAME'];
    if ($i < $size-1){
      $aColumn .= "', '";
    }
  }
  $aColumn .= "'];";
  ?>;
  var aCol = "<?php echo $aColumn?>"
  eval(aCol);

  $(document).on('submit', '#test_form', function(event){
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
        url:"insert.php",
        method:"POST",
        data:form_data,
        success:function(data)
        {
          alert(data);
          $('#test_form')[0].reset();
          $('#testModal').modal('hide');
          $('#test_data').bootgrid('reload');
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
        "url:'fetch_single.php'," +
        "method:'POST'," +
        "data:{"+col+":"+col+"}," +
        "dataType:'json'," +
        "success:function(data)" +
        "{" +
          "$('#testModal').modal('show');";
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
          "url:'delete.php'," +
          "method:'POST'," +
          "data:{"+col+":"+col+"}, "+
          "success:function(data){" +
            "alert(data);" +
            "$('#test_data').bootgrid('reload');" +
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
    var column_name = $('#column_name').val();
    var form_data = $(this).serialize();
    if(column_name != '')
    {
      $.ajax({
        url:"Columninsert.php",
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

  $(document).on('submit', '#column_deleteform', function(event){
    event.preventDefault();
    var column_selected = $('#column_selected').val();
    var form_data = $(this).serialize();
    if(column_selected != '')
    {
      $.ajax({
        url:"Columndelete.php",
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

<div id="testModal" class="modal fade">
  <div class="modal-dialog">
    <form method="post" id="test_form">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Test</h4>
        </div>
        <div class="modal-body">
          <?php
          for($i = 1; $i < $size; $i+=1){
              $col = $arr["rows"][$i]["COLUMN_NAME"];
              echo "<label>Enter " . $col . "</label>";
              echo "<input type='text' name='$col' id='$col' class='form-control' />";
              echo "<br />";
          }
           ?>
          <br />
        </div>
        <div class="modal-footer">
          <?php
          $id = $arr["rows"][0]["COLUMN_NAME"];
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
          <h4 class="modal-title">Add Test</h4>
        </div>
        <div class="modal-body">
          <label>Enter Column Name</label>
          <input type='text' name='column_name' id='column_name' class='form-control' />
          <br />
        </div>
        <div class="modal-footer">
          <input type="hidden" name="operation" id="operation" />
          <input type="submit" name="action" id="action" class="btn btn-success" value="Add Column" />
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
          <h4 class="modal-title">Delete Test</h4>
        </div>
        <div class="modal-body">
          <label>Select Column</label>
          <select name="column_selected" id="column_selected" class="form-control">
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