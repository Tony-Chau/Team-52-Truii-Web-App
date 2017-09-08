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
    <h1> Number of Cheating Students Caught During a Year </h1>
  </div>
</header>


  <div id ="Homebutton">
    <div class= "container">

      <div id="Results"></div>
      <script>

        var trace1 = {
          x: [1, 2, 3, 4],
          y: [10, 15, 13, 17],
          mode: 'markers',
          type: 'scatter',
          name: 'Year 2000',
          text: ['Number of Students Caught During Term 1', 'Number of Students Caught During Term 2', 'Number of Students Caught During Term 3', 'Number of Students Caught During Term 4']
        };

        var trace2 = {
          x: [1, 2, 3, 4],
          y: [20, 30, 26, 34],
          mode: 'markers',
          type: 'scatter',
          name: 'Year 2001',
          text: ['Number of Students Caught During Term 1', 'Number of Students Caught During Term 2', 'Number of Students Caught During Term 3', 'Number of Students Caught During Term 4']
        };

        var layout = {
          title: 'Cheating Student Caught during Exams',
          xaxis: {
            title: 'Term',
            showgrid: false,
            zeroline: false
          },
          yaxis: {
            title: 'Number of Students',
            showline: false
          },
          width: (window.innerWidth / 1.2),
          height: 500
        };

        var data = [trace1, trace2];
        Plotly.newPlot('Results', data, layout);
      </script>
    </div>
  </div>

</body>
</html>
