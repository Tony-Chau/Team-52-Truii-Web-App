<?php
  include 'sql/mysql.inc';
  include("sql/Bootgrid/connection.php");
  include("sql/Bootgrid/gettable.php");

  $output = '';
  for($i = 0; $i < $tsize; $i+=1){
      $tName = $tIDsarr['rows'][$i]['TableID'];
      $output .= '<option value='.$tName.'>'.$tName.'</option>';
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
              header('location: datapage.php');
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

</head>
<body>
  <header id="titlelogo1">
    <div class="container1">
      <span class="logo1"></span>
    </div>
  </header>


  <div id ="Homebutton">
    <div class= "container1">

      <form method="POST" >
        <div align="center">
          <select name="table_selected" id="table_selected" class="form-control">
            <option value="">Select Table</option>
            <?php echo $output ?>
          </select>
          <input type="submit" name="create_table" class="submit"><br>
        </div>
      </form>

    </div>
  </div>
</body>
</html>
