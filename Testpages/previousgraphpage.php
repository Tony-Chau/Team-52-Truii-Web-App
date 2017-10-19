<?php
  include '../sql/mysql.inc';
  include '../inc/tools.inc';
  if (!is_log()){
    header('location: ../Index.php');
  }
  CheckRequestLogout();
  //navBarCreate('rgb(252, 103, 25)', 'Chart Library');

  $graph_temp = GetGraphImage(1);
?>


<!DOCTYPE html>
<html>
<head>

 <title>Chart Library</title>
 <link rel="stylesheet" href="../css/bootstrap.min.css">
 <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
 <link rel="stylesheet" href="../css/style.css">
 <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
 <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
 <style>
   .col-sm-12, col-md-4 {
      position: static !important;
   }
 </style>

</head>
<body>


  <div id ="Homebutton">
    <div class="container">
<!--
      <div class="row">

        <div class="col-sm-12 col-md-4">
          <div class="thumbnail">
            <img src="../images/pies.png" alt="...">
            <div class="caption">
              <h3>Chart 1</h3>
              <p>Year 11's results</p>
              <p><a href="../Graphs/year11_results(Pie Chart).php" class="btn btn-primary" role="button">View</a> </p>
            </div>
          </div>
        </div>

        <div class="col-sm-12 col-md-4">
          <div class="thumbnail">
            <img src="../images/bars.png" alt="...">
            <div class="caption">
              <h3>Chart 2</h3>
              <p>Exam results</p>
              <p><a href="../Graphs/exam_results(Bar Chart).php" class="btn btn-primary" role="button">View</a> </p>
            </div>
          </div>
        </div>

        <div class="col-sm-12 col-md-4">
          <div class="thumbnail">
            <img alt="...">
            <div class="caption">
              <h3>Chart 3</h3>
              <p>Year 9's results</p>
              <p><a href="../Graphs/year9_results(Horizontal Bar Chart).php" class="btn btn-primary" role="button">View</a> </p>
            </div>
          </div>
        </div>

      </div>-->
      <div class="row">

        <div class="col-sm-12 col-md-4">
          <div class="thumbnail">
            <canvas id="graph" width="300" height="300" style="margin-top: -50px"></canvas>
            <div class="caption">
              <h3>Chart 4</h3>
              <p>Student Overall Results During HighSchool</p>
              <p><a href="results_overtime(ScatterLineChart)" class="btn btn-primary" role="button">View</a> </p>
            </div>
          </div>
        </div>
<!--
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
        </div>-->

      </div><!--
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

      </div>-->
      <!--<canvas id="canvas" width="100px" height="100px" ></canvas>
      <button type="button" onclick="canvasstart()">Start</button>-->
      <button type="button" onclick="canvascopy()">Copy</button>
      <!--<canvas id="copy" width="100px" height="100px" ></canvas>-->
      <script>

     var pngCanvas;


         function canvasstart() {
             var canvas = document.getElementById('canvas');
             var ctx = canvas.getContext("2d");
             ctx.font = "30px Arial";
             ctx.fillText("Hello World",10,50);

             pngCanvas = canvas.toDataURL(/*'image/jpeg', 0.5*/);
             // console.log(dataURL);
             // "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAYAAACNby
             // blAAAADElEQVQImWNgoBMAAABpAAFEI8ARAAAAAElFTkSuQmCC"
             alert(pngCanvas);

         }

         function dataURLtoBlob(dataurl) {
             var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1],
                 bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
             while(n--){
                 u8arr[n] = bstr.charCodeAt(n);
             }
             return new Blob([u8arr], {type:mime});
         }

         function canvascopy(){
             var canvas = document.getElementById('graph');
             var ctx = canvas.getContext('2d');

             var DOMURL = window.URL || window.webkitURL || window;

             pngCanvas = "<?php echo $graph_temp[0]; ?>";
             alert(pngCanvas);
             var img = new Image();
             var svg = dataURLtoBlob(pngCanvas);
             var url = DOMURL.createObjectURL(svg);

             img.onload = function() {
               ctx.drawImage(img, 0, 0);
               DOMURL.revokeObjectURL(url);
             }

             img.src = url;
         }

      </script>

    </div>
  </div>



</body>
</html>
