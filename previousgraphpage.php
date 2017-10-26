<?php
  include 'sql/mysql.inc';
  include 'inc/tools.inc';
  include 'inc/styles_and_scripts.inc';
  include("sql/Bootgrid/connection.php");
  include("sql/Bootgrid/gettable.php");

  CheckMobile();

  if (!is_log()){
    gotoPage('Index');
  }
  CheckRequestLogout();
  navBarCreate('rgb(252, 103, 25)', 'Chart Library');



  $gsize = 0;
  $gotgraphlist = GetGraphTableList();
  if(!empty($gotgraphlist)){
      while($graph = $gotgraphlist->fetch(PDO::FETCH_ASSOC)){
          $graphlist_columns[] = $graph;
          $gsize += 1;
      }
  }

  $output = '';
  if ($tsize == 0 || $gsize == 0){
      $output .= '<div class="row" style="margin: 0;">';
      $output .= '<div class="col" style="padding: 0; width: 100%;">';
      $output .= '<label>Sorry There Are No ';
      if ($tsize == 0){
          $output .= 'Tables ';
      }
      if ($gsize == 0){
          if ($tsize == 0){
              $output .= 'Nor ';
          }
          $output .= 'Graphs ';
      }
      $output .= 'Avaliable';
      if ($tsize == 0){
          $output .= '. Please press the table icon located above to create a table first and then create a graph';
      }
      else {
          $output .= '. Please press the + button located at the bottom right of the page to create a graph';
      }
      $output .= '.</label></div></div>';

  }
  else {

      $graphlist_output = array( 'rows' => $graphlist_columns );
      $json = json_encode($graphlist_output);
      $graphlistarr = (json_decode($json, true));


      for($i = 0; $i < $gsize; $i+=1){
          $key = 0;
          $output .= '<form method="POST">';
          $output .= '<div class="row" style="margin: 0;">';
          $output .= '<div class="col-sm-12 col-md-4" style="padding: 0; width: 100%;">';
          $output .= '<div class="thumbnail">';
          $output .= '<canvas id="graph'.$i.'" width="300" height="300"></canvas>';
          $output .= '<div class="caption">';
          for ($j = 0; $j < $tsize; $j+=1){
              $gtID = $graphlistarr['rows'][$i]['TableID'];
              $tID = $tIDsarr['rows'][$j]['TableID'];
              if ($gtID == $tID){
                  $key = $j;
              }
          }
          $tName = $tIDsarr['rows'][$key]['TableName'];
          $tID = $tIDsarr['rows'][$key]['TableID'];
          $gID = $graphlistarr['rows'][$i]['GraphID'];
          $gType = $graphlistarr['rows'][$i]['GraphType'];
          $output .= '<h3>Chart ' . $gType . '</h3>';
          $output .= '<h4>Table: ' . $tName . '</h4>';
          $output .= '<input type="number" name="graphs_tableid" value='.$tID.' style="display: none"/>';
          $output .= '<button type="submit" style="width: 100%; font-size: 100%; border: solid; border-color: #A9A9A9; border-radius:5px; margin-bottom:10px; padding:10px" name="graphlist_selected" value='.$gID.'> View </button>';
          $output .= '</div></div></div></div></form>';
      }

      $graphimage = array();
      for ($j = 0; $j < $gsize; $j+=1){
          array_push($graphimage, $graphlistarr['rows'][$j]['Image']);
      }
  }


  if($_SERVER['REQUEST_METHOD'] == 'POST'){
      if (isset($_POST['graphs_tableid']) && isset($_POST['graphlist_selected'])){
          $selected_tableid = NumberToWordsFormat($_POST['graphs_tableid']);

          $table_exist = false;

          $db_table = get_dbDatabase();
          $db_tQuery = "SHOW TABLES FROM $db_table";
          $gotTable = mysqli_query($connection, $db_tQuery);
          while($db_t = mysqli_fetch_row($gotTable))
          {
              if ($selected_tableid == $db_t[0]){
                  $table_exist = true;
              }
          }

          if ($table_exist){
              $_SESSION['tableid'] = $_POST['graphs_tableid'];
              $_SESSION['graphid'] = $_POST['graphlist_selected'];
              gotoPage('GraphPage');
          }
          else {
              echo "<script language='javascript'>";
              echo "alert('Sorry, Table Associated With Selected Graph No Longer Exists, Please Select Another Graph')";
              echo "</script>";
          }

      }
  }

?>


<!DOCTYPE html>
<html>
<head>

 <title>Chart Library</title>
 <br/>

 <style>
   .col-sm-12, col-md-4 {
      position: static !important;
   }
 </style>
</head>
<body>
  <div id ="Homebutton">
    <div class="container" style="margin-top: 15%; padding: 0;">
      <?php echo $output; ?>
    </div>
  </div>
  <a href="choosedatapage.php"><div class="addGraph">+</div></a>

  <script>

  $(document).ready(function(){
      var ImagesAmount = "<?php echo $gsize ?>";
      var GraphImages = <?php echo json_encode($graphimage); ?>;
      var GraphCanvas;
      for(var i = 0; i < ImagesAmount; i+=1){
          eval("GraphCanvas = document.getElementById('graph"+i+"');");
          GraphCanvas.width = (window.innerWidth/1.2);
          GraphCanvas.height = (window.innerHeight/2);
          canvascopy(GraphCanvas, GraphImages[i]);
      }
  });


  function canvascopy(graphcanvas, graphimage){
      var ctx = graphcanvas.getContext('2d');
      var DOMURL = window.URL || window.webkitURL || window;

      pngCanvas = graphimage;
      //alert(pngCanvas);
      var img = new Image();
      var svg = dataURLtoBlob(pngCanvas);
      var url = DOMURL.createObjectURL(svg);

      img.onload = function() {
        ctx.drawImage(img, 0, 0);
        DOMURL.revokeObjectURL(url);
      }
      img.src = url;
  }

  function dataURLtoBlob(dataurl) {
      var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1],
          bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
      while(n--){
          u8arr[n] = bstr.charCodeAt(n);
      }
      return new Blob([u8arr], {type:mime});
  }

  </script>
</body>
</html>
