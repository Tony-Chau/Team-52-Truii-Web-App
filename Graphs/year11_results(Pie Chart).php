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
        var data = [{
        values: [81, 19],
        labels: ['Year 11\'s That Passed', 'Year 11\'s That Failed'],
        type: 'pie'
        }];

        var layout = {
          height: 500,
          width: (window.innerWidth / 1.2)
        };

        Plotly.newPlot('Results', data, layout);


      </script>
    </div>
  </div>

</body>
</html>
