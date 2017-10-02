<?php
  include 'sql/mysql.inc';
  include 'inc/NavBar.inc';
  include("sql/Bootgrid/connection.php");
  include("sql/Bootgrid/gettable.php");

  if (!is_log()){
    header('location: Index.php');
  }
  CheckRequestLogout();
  navBarCreate('rgb(31,194,222)', 'Choose Data Page');

  $output = '';
  for($i = 0; $i < $tsize; $i+=1){
      $tID = $tIDsarr['rows'][$i]['TableID'];
      $tName = $tIDsarr['rows'][$i]['TableName'];
      $output .= '<option value='.$tID.'>'.$tID.' '. $tName .'</option>';
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
 <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
 <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">

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
