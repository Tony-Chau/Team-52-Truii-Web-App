<!DOCTYPE html>
<html>
<head>

 <title>Chart Library</title>
 <link rel="stylesheet" href="../css/bootstrap.min.css">
 <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
 <link rel="stylesheet" href="../css/style.css">
 <script src="../js/plotly_latest.min.js"></script>

</head>
<body>
<header id ="titlelogo2">
  <div class="container">
    <h1> Exam Average Results </h1>
  </div>
</header>


  <div id ="Homebutton">
    <div class= "container">

      <div id="Results"></div>
      <script>
        var trace1 = {
          x: [1, 2, 3, 4],
          y: [60, 55, 70, 40],
          mode: 'markers',
          marker: {
            size: [60, 55, 70, 40]
          }
          };

          var data = [trace1];

          var layout = {
          title: 'Exam Average Results Overtime',
          xaxis: {
            title: 'Year',
            showgrid: false,
            zeroline: false
          },
          yaxis: {
            title: 'Overall Grade',
            showline: false
          },
          showlegend: false,
          height: 500,
          width: (window.innerWidth / 1.2)
        };


        Plotly.newPlot('Results', data, layout);
      </script>
    </div>
  </div>

</body>
</html>
