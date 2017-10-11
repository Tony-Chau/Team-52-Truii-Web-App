<?php
  include '../sql/mysql.inc';
  include '../inc/tools.inc';
  include("../sql/Bootgrid/connection.php");
  if (!is_log()){
    header('location: ../Index.php');
  }
  CheckRequestLogout();
  //navBarCreate('rgb(252, 103, 25)', 'Chart Library');

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
      if(isset($_POST['temp'])){
        $temp = $_POST['temp'];
        $query = UpdateImageGraphTable(1, $temp);

        if(mysqli_query($connection, $query))
        {
            echo "<script language='javascript'>";
            echo "alert('success');";
            echo "</script>";
            gotoPage('previousgraphpage');
        }

        echo "<script language='javascript'>";
        echo "alert('$temp');";
        echo "</script>";
      }
  }

?>
<!DOCTYPE html>
<html>
<head>

 <title>Chart Library</title>
 <link rel="stylesheet" href="../css/bootstrap.min.css">
 <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
 <link rel="stylesheet" href="../css/style.css">
 <script src="../js/plotly_latest.min.js"></script>
 <script src="../js/html2canvas.min.js"></script>


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



      <button type="button" onclick="canvasstart()">Start</button>

      <form method=POST>
        <input type="hidden" name="temp" id="temp" value="" />
        <input type="submit" name="action" id="action" class="btn btn-success" value=" Send " />
      </form>
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
        var trace1 = {
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

        var trace2 = {
        x: [8, 9, 10, 11, 12],
        y: [9, 31, 53, 75, 97],
        mode: 'scatter',
        name: 'Shiraori',
        text: ['Overall Grade 9/100 E',
               'Overall Grade 31/100 D',
               'Overall Grade 53/100 C',
               'Overall Grade 75/100 B+',
               'Overall Grade 97/100 A+']
        };

        var trace3 = {
        x: [8, 9, 10, 11, 12],
        y: [52, 60, 63, 69, 75],
        mode: 'scatter',
        name: 'Mary',
        text: ['Overall Grade 52/100 C',
               'Overall Grade 60/100 C+',
               'Overall Grade 63/100 B-',
               'Overall Grade 69/100 B',
               'Overall Grade 75/100 B+']
        };

        var trace4 = {
        x: [8, 9, 10, 11, 12],
        y: [100, 100, 100, 100, 100],
        mode: 'scatter',
        name: 'Leylin Farlier',
        text: ['Overall Grade 100/100 A+',
               'Overall Grade 100/100 A+',
               'Overall Grade 100/100 A+',
               'Overall Grade 100/100 A+',
               'Overall Grade 100/100 A+']
        };

        var trace5 = {
        x: [8, 9, 10, 11, 12],
        y: [81, 76, 84, 79, 89],
        mode: 'scatter',
        name: 'An Jun Cheng',
        text: ['Overall Grade 81/100 A-',
               'Overall Grade 76/100 B+',
               'Overall Grade 84/100 A-',
               'Overall Grade 79/100 B+',
               'Overall Grade 89/100 A']
        };

        var trace6 = {
        x: [8, 9, 10, 11, 12],
        y: [85, 81, 89, 90, 91],
        mode: 'scatter',
        name: 'Han Yujin',
        text: ['Overall Grade 85/100 A-',
               'Overall Grade 81/100 A-',
               'Overall Grade 89/100 A',
               'Overall Grade 90/100 A',
               'Overall Grade 91/100 A']
        };

        var trace7 = {
        x: [8, 9, 10, 11, 12],
        y: [95, 45, 21, 8, 0],
        mode: 'scatter',
        name: 'Prince Charming',
        text: ['Overall Grade 95/100 A+',
               'Overall Grade 45/100 C-',
               'Overall Grade 21/100 D-',
               'Overall Grade 8/100 E-',
               'Overall Grade 0/100 F']
        };

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
          height: 300
        };

        var data = [trace1, trace2, trace3, trace4, trace5, trace6, trace7];
        Plotly.newPlot('Results', data, layout);

        html2canvas(document.getElementById('Results'), {
          onrendered: function(canvas) {
            canvas.id = 'graph';
            document.body.appendChild(canvas);
          },
          width: 300,
          height: 300
        });

        /*
        function cleandataURL(dataURI) {
            var byteString = atob(dataURI.split(',')[1]);
            var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0]
            var ab = new ArrayBuffer(byteString.length);
            var ia = new Uint8Array(ab);
            for (var i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }
            var blob = new Blob([ab], {type: mimeString});
            return byteString;
        }*/

        function cleandataURL(dataurl) {
            var arr = dataurl.split(','), url = arr[1];
            return url;
        }

        function canvasstart() {
            var canvas = document.getElementById('graph');
            var pngCanvas = canvas.toDataURL();
            // console.log(pngCanvas);
            //alert(pngCanvas);
            document.getElementById('temp').value = cleandataURL(pngCanvas);
            alert(document.getElementById('temp').value);
        }

      </script>
    </div>
  </div>

</body>
</html>
