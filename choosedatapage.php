<?php
  include 'sql/mysql.inc';
  include 'inc/tools.inc';
  include 'inc/styles_and_scripts.inc';
  include("sql/Bootgrid/connection.php");
  include("sql/Bootgrid/gettable.php");

  if (!is_log()){
    gotoPage('Index');
  }

  if ($tsize == 0){
    gotoPage('previousgraphpage');
  }
  CheckRequestLogout();
  navBarCreate('rgb(31,194,222)', 'Choose Data Page');

  $output = '';
  for($i = 0; $i < $tsize; $i+=1){
      $tID = $tIDsarr['rows'][$i]['TableID'];
      $tName = $tIDsarr['rows'][$i]['TableName'];
      $output .= '<button type="submit" style="width: 100%; font-size: 100%; border: solid; border-color: #A9A9A9; border-radius:5px; margin-bottom:10px; padding:10px" name="table_selected" value='.$tID.'> Table '.$tID.': '. $tName .'</button>';
  }

  if($_SERVER['REQUEST_METHOD'] == 'POST'){
      if (isset($_POST['table_selected'])){
          $selected_table =  NumberToWordsFormat($_POST['table_selected']);
          $table_exist = false;

          $db_table = get_dbDatabase();
          $db_tQuery = "SHOW TABLES FROM $db_table";
          $gotTable = mysqli_query($connection, $db_tQuery);
          while($db_t = mysqli_fetch_row($gotTable))
          {
              if ($selected_table == $db_t[0]){
                  $table_exist = true;
              }
          }

          if ($table_exist){
              $_SESSION['tableid'] = $_POST['table_selected'];
              gotoPage('datapage');
          }
          else {
            CallTestAlert('Sorry. The selected table no longer exist. Please select another table');
          }
      }
  }

?>
<!DOCTYPE html>
<html>
<head>

 <title>Truii Home</title>
 <br/>

</head>

<body>

  <div id ="Homebutton">

    <div class= "container" style="padding: 0;">
      <div align="center" style="width: 100%; padding: 0;">
        <span class="logo1"></span>
      </div>


      <div class="row" style="padding: 15px; padding-top: 0;border-radius: 15px; margin: 0;">
        <form method="POST">
          <?php echo $output ?>
        </form>

      </div>


    </div>
  </div>
</body>
</html>
