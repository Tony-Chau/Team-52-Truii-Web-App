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


    /* xy buttons part  start */

    #x-button, #y-button {
        margin:4px;
        background-color:#EFEFEF;
        border-radius:4px;
        border:1px solid #D0D0D0;
        overflow:auto;
        float:left;
    }

    #x-button:hover,  #y-button:hover {
        background:blue;
    }

    #x-button, #y-button label {
        float:left;
        width:4.0em;
    }

    #x-button, #y-button label span {
        text-align:center;
        padding:3px 0px;
        display:block;
    }

    #x-button, #y-button label input {
        position:absolute;
        top:-20px;
    }

    #x-button, #y-button input:checked + span {
        background-color:#911;
        color:#fff;
    }

    /* xy buttons part  end */

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
                $col .= "<th data-column-id='" . $arr['rows'][$i]['FieldName'] . "'><span class=\"text\">";
                $col .= $arr['rows'][$i]['FieldName'] . "</span>\n";
                $col .= "<div id=\"x-button\"><label><input type=\"checkbox\" value=\"#\"><span>Choose As X</span></input></label></div> \n";
                $col .= "<div id=\"y-button\"><label><input type=\"checkbox\" value=\"#\"><span>Choose As Y</span></input></label></div>";
                $col .= "</th>\n";
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

    <?php
      $chooseXY = '';
      $chooseXY .= '<div id="x-button"><label><input type="checkbox" value="#"><span>Choose As X</span></input></label></div>';
      $chooseXY .= '<div id="y-button"><label><input type="checkbox" value="#"><span>Choose As Y</span></input></label></div>';

      for($i = 1; $i < $size; $i+=1){
          $addtofield .= "$('" . $chooseXY . "').appendTo('#" . $arr['rows'][$i]['FieldName'] . "');";
      };
    ?>
    var ChooseXY = "<?php echo $addtofield;?>";
    eval(ChooseXY);

  });


});
</script>
