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
    <h1> Year 11's Results </h1>
  </div>
</header>


  <div id ="Homebutton">
    <div class= "container">

      <div id="Results"></div>
      <script>
        var trace1 = {
          x: [1, 2, 3, 4],
          y: [60, 55, 61, 59],
          fill: 'tozeroy',
          type: 'scatter',
          name: 'Year 2000',
          text: ['Overall Grade of Term 1 is 60/100', 'Overall Grade of Term 2 is 55/100', 'Overall Grade of Term 3 is 61/100', 'Overall Grade of Term 4 is 59/100']
          };

          var trace2 = {
          x: [1, 2, 3, 4],
          y: [100, 50, 80, 20],
          fill: 'tonexty',
          type: 'scatter',
          name: 'Year 2001',
          text: ['Overall Grade of Term 1 is 100/100', 'Overall Grade of Term 2 is 50/100', 'Overall Grade of Term 3 is 80/100', 'Overall Grade of Term 4 is 20/100']
        };

        var data = [trace1, trace2];


        var layout = {
          title: 'Grade 8 Overall Grade Overtime',
          xaxis: {
            title: 'Terms',
            showgrid: false,
            zeroline: false
          },
          yaxis: {
            title: 'Overall Grade',
            showline: false
          },
          width:  (window.innerWidth / 1.5),
          height: 500
        };

        Plotly.newPlot('Results', data, layout);


      </script>
    </div>
  </div>

</body>
</html>
