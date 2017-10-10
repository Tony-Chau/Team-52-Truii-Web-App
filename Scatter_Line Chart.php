<?php
  include 'sql/mysql.inc';
    include 'inc/tools.inc';
  include("sql/Bootgrid/connection");
  include("sql/Bootgrid/getcolumns");

 ?>

<!DOCTYPE html>
<html>
<head>

 <title>Chart Library</title>
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="css/bootstrap-theme.min.css">
 <link rel="stylesheet" href="css/style.css">
 <script src="js/plotly_latest.min.js"></script>
 <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
 <link href="https://font.googleapis.com/css?family-Source+San+Pro:300,400,600,700" rel="stylesheet">

</head>
<body>
<header id ="titlelogo2">
  <div class="container">
    <h1> Student Overall Results During HighSchool </h1>
  </div>
</header>


  <div id ="Homebutton">
    <div class= "container">

      <div id="Results"></div>
      <script>
        /*

        0 F

        1-8 E-
        9-14 E
        15-20 E+

        21-28 D-
        29-34 D
        35-40 D+

        41-48 C-
        49-54 C
        55-60 C+

        61-68 B-
        69-74 B
        75-80 B+

        81-88 A-
        89-94 A
        95-100 A+

        */


        var trace = {
        x: [8, 9, 10, 11, 12],
        y: [81, 95, 87, 93, 90],
        mode: 'scatter',
        name: 'Satou Pendragon',
        text: ['Overall Grade 81/100 A-',
               'Overall Grade 95/100 A+',
               'Overall Grade 87/100 A-',
               'Overall Grade 93/100 A',
               'Overall Grade 90/100 A']
        };

        <?php
          $trace = "";

         ?>



        var layout = {
          title: 'Record of Student Results',
          xaxis: {
            title: 'Year',
            showgrid: false,
            zeroline: false
          },
          yaxis: {
            title: 'Overall Grade',
            showline: false
          },
          width: (window.innerWidth / 1.2),
          height: 500
        };

        var data = [trace1, trace2, trace3, trace4, trace5, trace6, trace7];
        Plotly.newPlot('Results', data, layout);
      </script>
    </div>
  </div>

</body>
</html>
