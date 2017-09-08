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
    <h1> Year 9's Results </h1>
  </div>
</header>


  <div id ="Homebutton">
    <div class= "container">

      <div id="Results"></div>
      <script>
      var data = [{
      type: 'bar',
      x: [50, 30, 80],
      y: ['StudentA', 'StudentB', 'StudentC'],
      text: ['50/100 Average Behaviour', '30/100 Bad Behaviour', '80/100 Good Behaviour'],
      marker: {
        color: 'rgb(253, 103, 26)'
      },
      orientation: 'h'
      }];

        Plotly.newPlot('Results', data);


      </script>
    </div>
  </div>

</body>
</html>
