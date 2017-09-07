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
          y: [60, 72, 84, 96],
          mode: 'lines',
          name: 'Class 1 Average Results',
          line: {
            dash: 'solid',
            width: 4
          }
        };

        var trace2 = {
          x: [1, 2, 3, 4],
          y: [90, 60, 30, 0],
          mode: 'lines',
          name: 'Class 2 Average Results',
          line: {
            dash: 'dashdot',
            width: 4
          }
        };

        var trace3 = {
          x: [1, 2, 3, 4],
          y: [100, 10, 41, 60],
          mode: 'lines',
          name: 'Class 3 Average Results',
          line: {
            dash: 'dot',
            width: 4
          }
        };

        var data = [trace1, trace2, trace3];

        var layout = {
          title: 'Comparing Classes',
          xaxis: {
            title: 'Terms',
            showgrid: false,
            zeroline: false
            //range: [0.75, 5.25],
            //autorange: false
          },
          yaxis: {
            title: 'Overall Grade',
            showline: false
            //range: [0, 18.5],
            //autorange: false
          },
          legend: {
            y: 0.5,
            traceorder: 'reversed',
            font: {
              size: 16
            }
          },
          height: 500,
          width: (window.innerWidth / 1.5)
        };

        Plotly.newPlot('Results', data, layout);
      </script>
    </div>
  </div>

</body>
</html>
