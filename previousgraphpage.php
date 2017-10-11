<?php
  include 'sql/mysql.inc';
  include 'inc/tools.inc';
  include 'inc/styles_and_scripts.inc';

  if (!is_log()){
    header('location: Index');
  }
  CheckRequestLogout();
  navBarCreate('rgb(252, 103, 25)', 'Chart Library');

?>


<!DOCTYPE html>
<html>
<head>

 <title>Chart Library</title>

 <style>
   .col-sm-12, col-md-4 {
      position: static !important;
   }
 </style>
</head>
<body>

  <!--
  <ul class="chartpages">
    <!-
    <li><a href="home">Home</a></li>
    <li><a href="chartmaker">Back</a></li>
    ->
    <li style="float:right"><a class="active" href="#about">Truii Chart Library</a></li>
    <li class="fa fa-angle-left fa-4x" onclick="goBack()"></li>
    <a href="chartmaker"><li class="fa fa-bar-chart fa-4x"></li></a>
    <a href="recorddatapageAddDelete"><li class="fa  fa-pencil-square-o fa-4x"></li></a>
  </ul>-->





  <div id ="Homebutton">
    <div class="container">

      <div class="row">

        <div class="col-sm-12 col-md-4">
          <div class="thumbnail">
            <img src="images/pies.png" alt="...">
            <div class="caption">
              <h3>Chart 1</h3>
              <p>Year 11's results</p>
              <p><a href="Graphs/year11_results(Pie Chart)" class="btn btn-primary" role="button">View</a> </p>
            </div>
          </div>
        </div>

        <div class="col-sm-12 col-md-4">
          <div class="thumbnail">
            <img src="images/bars.png" alt="...">
            <div class="caption">
              <h3>Chart 2</h3>
              <p>Exam results</p>
              <p><a href="Graphs/exam_results(Bar Chart)" class="btn btn-primary" role="button">View</a> </p>
            </div>
          </div>
        </div>

        <div class="col-sm-12 col-md-4">
          <div class="thumbnail">
            <img src="..." alt="...">
            <div class="caption">
              <h3>Chart 3</h3>
              <p>Year 9's results</p>
              <p><a href="Graphs/year9_results(Horizontal Bar Chart)" class="btn btn-primary" role="button">View</a> </p>
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
              <p><a href="Graphs/results_overtime(Scatter+Line Chart)" class="btn btn-primary" role="button">View</a> </p>
            </div>
          </div>
        </div>

        <div class="col-sm-12 col-md-4">
          <div class="thumbnail">
            <img src="..." alt="...">
            <div class="caption">
              <h3>Chart 5</h3>
              <p>Year 8s Results</p>
              <p><a href="Graphs/year8_results(Overlaid Area Chart)" class="btn btn-primary" role="button">View</a> </p>
            </div>
          </div>
        </div>

        <div class="col-sm-12 col-md-4">
          <div class="thumbnail">
            <img src="..." alt="...">
            <div class="caption">
              <h3>Chart 6</h3>
              <p>Exam Average Results</p>
              <p><a href="Graphs/exam_average_results(Bubble Chart)" class="btn btn-primary" role="button">View</a> </p>
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
              <p><a href="Graphs/cheatingstudents(Scatter Plot Chart)" class="btn btn-primary" role="button">View</a> </p>
            </div>
          </div>
        </div>

        <div class="col-sm-12 col-md-4">
          <div class="thumbnail">
            <img src="..." alt="...">
            <div class="caption">
              <h3>Chart 8</h3>
              <p>Number of Sick Students During a Year</p>
              <p><a href="Graphs/sickstudents(Line Chart)" class="btn btn-primary" role="button">View</a> </p>
            </div>
          </div>
        </div>

        <div class="col-sm-12 col-md-4">
          <div class="thumbnail">
            <img src="..." alt="...">
            <div class="caption">
              <h3>Chart 9</h3>
              <p>Classes Exam Average Results</p>
              <p><a href="Graphs/exam_average_class_results(Line Dash Chart)" class="btn btn-primary" role="button">View</a> </p>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>

</body>
</html>
