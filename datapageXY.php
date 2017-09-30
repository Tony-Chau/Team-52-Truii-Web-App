<?php
  include("sql/mysql.inc");
  include("inc/NavBar.inc");
  include("sql/Bootgrid/connection.php");
  include("sql/Bootgrid/getcolumns.php");

  if (!is_log()){
    header('location: Index.php');
  }
  CheckRequestLogout();
  navBarCreate('rgb(31,194,222)','Data XY');

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
  <link href="https://font.googleapis.com/css?family-Source+San+Pro:300,400,600,700" rel="stylesheet">
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
  </style>
</head>
<body>

  <div class="box" style="margin-top: 50px">
    <br />

    <div class="table-responsive" style="overflow-x: scroll">
      <table id="test_data" class="table table-bordered table-striped">
        <thead>
          <tr>
            <?php
            $col = '';
            $col .= "<th data-column-id='" . $arr['rows'][0]['COLUMN_NAME'] . "' data-type='numeric'>";
            $col .= $arr['rows'][0]['COLUMN_NAME'] . "</th>";
            echo $col;

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
  </div>
</body>
</html>
<script type="text/javascript" language='javascript'>
$(document).ready(function(){

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
    url: 'sql/Bootgrid/fetch.php',
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


});
</script>
