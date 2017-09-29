<?php
  include 'sql/mysql.inc';
  include 'inc/NavBar.inc';

  if (!is_log()){
    header('location: Index.php');
  }
  CheckRequestLogout();
  navBarCreate('rgba(238, 86, 36, 0.8)', 'Chart Library');

?>


<!DOCTYPE html>
<html>
<head>

 <title>Chart Library</title>
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="css/bootstrap-theme.min.css">
 <link rel="stylesheet" href="css/style.css">
 <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
 <link href="https://font.googleapis.com/css?family-Source+San+Pro:300,400,600,700" rel="stylesheet">

</head>
<body>

  <!--
  <ul class="chartpages">
    <!-
    <li><a href="home.php">Home</a></li>
    <li><a href="chartmaker.php">Back</a></li>
    ->
    <li style="float:right"><a class="active" href="#about">Truii Chart Library</a></li>
    <li class="fa fa-angle-left fa-4x" onclick="goBack()"></li>
    <a href="chartmaker.php"><li class="fa fa-bar-chart fa-4x"></li></a>
    <a href="recorddatapageAddDelete.php"><li class="fa  fa-pencil-square-o fa-4x"></li></a>
  </ul>-->





  <div id ="Homebutton">
    <div class= "container">
       <center><img src="images/truii-full-colour-white.png" alt="Truii" width="200" height="128"></center>



      <div class="row">

        <div class="col-sm-12 col-md-4">
          <div class="thumbnail">
            <img src="images/pies.png" alt="...">
            <div class="caption">
              <h3>Chart 1</h3>
              <p>Year 11's results</p>
              <p><a href="Graphs/year11_results(Pie Chart).php" class="btn btn-primary" role="button">View</a> </p>
            </div>
          </div>
        </div>

        <div class="col-sm-12 col-md-4">
          <div class="thumbnail">
            <img src="images/bars.png" alt="...">
            <div class="caption">
              <h3>Chart 2</h3>
              <p>Exam results</p>
              <p><a href="Graphs/exam_results(Bar Chart).php" class="btn btn-primary" role="button">View</a> </p>
            </div>
          </div>
        </div>

        <div class="col-sm-12 col-md-4">
          <div class="thumbnail">
            <img src="..." alt="...">
            <div class="caption">
              <h3>Chart 3</h3>
              <p>Year 9's results</p>
              <p><a href="Graphs/year9_results(Horizontal Bar Chart).php" class="btn btn-primary" role="button">View</a> </p>
            </div>
          </div>
        </div>

      </div>
      <div class="row">

        <div class="col-sm-12 col-md-4">
          <div class="thumbnail">
            <img src="..." alt="...">
            <div class="caption">
              <h3>Chart 4</h3>
              <p>Student Overall Results During HighSchool</p>
              <p><a href="Graphs/results_overtime(Scatter+Line Chart).php" class="btn btn-primary" role="button">View</a> </p>
            </div>
          </div>
        </div>

        <div class="col-sm-12 col-md-4">
          <div class="thumbnail">
            <img src="..." alt="...">
            <div class="caption">
              <h3>Chart 5</h3>
              <p>Year 8s Results</p>
              <p><a href="Graphs/year8_results(Overlaid Area Chart).php" class="btn btn-primary" role="button">View</a> </p>
            </div>
          </div>
        </div>

        <div class="col-sm-12 col-md-4">
          <div class="thumbnail">
            <img src="..." alt="...">
            <div class="caption">
              <h3>Chart 6</h3>
              <p>Exam Average Results</p>
              <p><a href="Graphs/exam_average_results(Bubble Chart).php" class="btn btn-primary" role="button">View</a> </p>
            </div>
          </div>
        </div>

      </div>
      <div class="row">

        <div class="col-sm-12 col-md-4">
          <div class="thumbnail">
            <img src="..." alt="...">
            <div class="caption">
              <h3>Chart 7</h3>
              <p>Number of Cheating Students Caught During a Year</p>
              <p><a href="Graphs/cheatingstudents(Scatter Plot Chart).php" class="btn btn-primary" role="button">View</a> </p>
            </div>
          </div>
        </div>

        <div class="col-sm-12 col-md-4">
          <div class="thumbnail">
            <img src="..." alt="...">
            <div class="caption">
              <h3>Chart 8</h3>
              <p>Number of Sick Students During a Year</p>
              <p><a href="Graphs/sickstudents(Line Chart).php" class="btn btn-primary" role="button">View</a> </p>
            </div>
          </div>
        </div>

        <div class="col-sm-12 col-md-4">
          <div class="thumbnail">
            <img src="..." alt="...">
            <div class="caption">
              <h3>Chart 9</h3>
              <p>Classes Exam Average Results</p>
              <p><a href="Graphs/exam_average_class_results(Line Dash Chart).php" class="btn btn-primary" role="button">View</a> </p>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>

</body>
</html>
