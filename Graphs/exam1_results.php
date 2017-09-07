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
    <h1> Exam Results </h1>
  </div>
</header>


  <div id ="Homebutton">
    <div class= "container">

      <div id="Results"></div>
      <script>
        var trace1 = {
        x: ['Satou', 'Sophia', 'Yama', 'Mia', 'Jun Cheng', 'Sitri', 'Olivia', 'Prince Charming'],
        y: [80.0, 60.0, 52.0, 100.0, 75.0, 30.0, 49.0, 14.0],
        type: 'bar',
        text: ['80/100 B+', '60/100 C+', '52/100 C', '100/100 A+', '75/100 B+', '30/100 D', '49/100 C', '14/100 E+'],
        marker: {
          color: 'rgb(253, 103, 26)'
        }
        };

        var data = [trace1];

        var layout = {
        title: 'Exam Results',
        font:{
          family: 'Raleway, snas-serif'
        },
        showlegend: false,
        xaxis: {
          tickangle: -45
        },
        yaxis: {
          zeroline: false,
          gridwidth: 2
        },
        bargap :0.05
        };

        Plotly.newPlot('Results', data, layout);
      </script>
    </div>
  </div>

</body>
</html>
