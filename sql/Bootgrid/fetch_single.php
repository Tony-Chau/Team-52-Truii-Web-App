<?php
  //fetch_single.php
  include("../mysql.inc");
  include("connection.php");
  include("getcolumns.php");
  $id = $arr["rows"][0]["COLUMN_NAME"];
  if(isset($_POST[$id]))
  {
      $query = "SELECT * FROM " . $table . " WHERE " . $id . " = '".$_POST[$id]."'";
      $result = mysqli_query($connection, $query);
      while($row = mysqli_fetch_array($result))
      {
          for($i = 1; $i < $size; $i+=1){
              $col = $arr["rows"][$i]["COLUMN_NAME"];
              $output[$col] = $row[$col];
          }
      }
      echo json_encode($output);
  }
?>
