<?php
  include 'sql/mysql.inc';
  include 'inc/tools.inc';
  include 'inc/styles_and_scripts.inc';

  if (!is_log()){
    header('location: Index');
  }
  CheckRequestLogout();
  navBarCreate('rgb(252, 103, 25)', 'Chart Maker');

?>
<!DOCTYPE html>
<html>
<head>

 <title>Chart Maker</title>

</head>

<body>

</body>




  <div id ="Homebutton">
    <div class= "container">

      <a href="choosedatapage" style="text-decoration:none">
        <div align="center">
            <div class="big1">
              <br><input type="image" src="images//addnew.png" name="image" ><br></div>
          <h1 style="color:#EF6724;"> New Chart </h1>
        </div>
      </a>

      <a href="previousgraphpage" style="text-decoration:none">
        <div align="center">
          <div class="big2">
            <br><input type="image" src="images//viewold.png" name="image"><br></div>
          <h1 style="color:#EF6724;"> View Previous Charts</h1>
        </div>
      </a>

    </div>
  </div>
</body>
</html>
