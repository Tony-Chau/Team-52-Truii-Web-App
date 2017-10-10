<?php
  include 'sql/mysql.inc';
  include 'inc/tools.inc';
  include("sql/Bootgrid/connection.php");
  include("sql/Bootgrid/gettable.php");

  if (!is_log()){
    header('location: Index');
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
              echo "<script language='javascript'>";
              echo "alert('Sorry, Selected Table No Longer Exists, Please Select Another Table')";
              echo "</script>";
          }

      }
  }

?>
<!DOCTYPE html>
<html>
<head>

 <title>Truii Home</title>
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="css/bootstrap-theme.min.css">
 <link rel="stylesheet" href="css/style.css">
 <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
 <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">

</head>

<body>





  <div id ="Homebutton">

    <div class= "container">
      <div align="center" style="width: 100% margin-bottom: 50%">
        <span class="logo1"></span>
      </div>


      <div class="row" style="background-color: white; padding: 15px; border-radius: 15px">
        <form method="POST">
          <?php echo $output ?>
        </form>

      </div>


    </div>
  </div>
</body>
</html>
