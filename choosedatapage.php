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
      $output .= '<fieldset clase="form-box" style="position: relative; margin-bottom:10% ">';
      $output .= '<button style="position: absolute; right:-15px; top:-15px; text-align: right;" type="button" class="btn btn-primary" onClick="DeleteTable('.$tID.')">X</button>';
      $output .= '<button type="submit" style="width: 100%; font-size: 100%; border: solid; border-color: #A9A9A9; border-radius:5px; padding:10px" name="table_selected" value='.$tID.'>'. $tName .'</button>';
      $output .= '</fieldset>';
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
      else if (isset($_POST['delete_table'])){
          DeleteTable($_POST['delete_table']);
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
      <form method="POST" style="display: none;">
        <button type="submit" name="delete_table" id="delete_table" value="">
      </form>


    </div>
  </div>
  <script>
    function DeleteTable(TID){
        if(confirm("The Table will be permanantly deleted. \nAre you Sure?")){
            if(confirm("All data within the table will not be Reclaimable. \nLast Chance")){
                var d_t = document.getElementById('delete_table');
                d_t.value = TID;
                d_t.click();
            }
        }
    }
  </script>
</body>
</html>
