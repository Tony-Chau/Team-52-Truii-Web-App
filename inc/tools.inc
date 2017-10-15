<?php
function gotoPage($page){
  echo "<script>window.location.href = '". $page ."'; </script>";
}

function navBarCreate($ColorCode, $currentpage){
  $nav = " <nav class='navbar navbar-default' style='background-color:".$ColorCode.";padding-bottom:1%;'>
              <div class='container-fluid'>";
              if ($currentpage != 'Home'){
                $nav .= "<a href='' onclick='window.history.back();return false;'>
                        <ul><li class='fa fa-angle-left fa-4x'></li></ul></a>";
              }
  $nav .= "<div style='margin-left:12.5%;'>
  <a href='chartmaker'>
          <ul><li class='fa fa-bar-chart fa-4x'></br></li></ul></a></div>
  <div style='margin-left:30%;'>
  <a href='recorddatapageAddDelete'>
          <ul><li class='fa  fa-pencil-square-o fa-4x'></br></li></ul></a></div>
  <div style='float:right;text-decoration:none;padding-top:1%;font-size:15pt;'>
  <a href='' onClick='logout();' style='color:#FFFFFF;'>Account <span class='glyphicon glyphicon-wrench'></span></a></div>
          <form method=POST>
            <div align='center'>
              <input type='submit' id='logsub' name='logout' style='display:none;'>
            </div>
          </form></a>
  </div>
  </nav>
  <script>
  function logout(){
    $('#logsub').click();
  }
</script>
  ";
  echo $nav;
}
// <nav class="navbar navbar-default">
// <div class="container-fluid">
// <div class="navbar-header">
// <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#myNavbar">
// <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
// </button>
// <a href="/">
// <input class="navbar-brand" type="image" src="assets/logo.png"/></a></div>
// <div class="collapse navbar-collapse" id="myNavbar"><form class="navbar-form navbar-right" action="/Search" method="GET"><div class="form-group">
// <input class="form-control" type="text" placeholder="Search" name="qry"/>
// </div><button class="btn btn-default" type="submit">Submit</button></form></div></div></nav>
// }

function CallTestAlert($message){
  echo "<script>alert('".$message."');</script>";
}

function ConvertDatatoCSV($FieldName_Array, $Value_Array){
  $csv = '';
  $length =  count($FieldName_Array);
  for ($i = 0; $i < $length; $i += 1){
    if ($i == $length - 1){
      $csv .= $FieldName_Array[$i] . "\n";
    }else{
      $csv .= $FieldName_Array[$i] . ', ';
    }
  }
  for ($i = 0; $i < $length; $i += 1){
    for ($j = 0; $j < $length; $j += 1){
      if ($j == $length - 1){
        $csv .= $Value_Array[$i][$j];
      }else{
        $csv .= $Value_Array[$i][$j] . ', ';
      }
    }
  }
  return $csv;
}
 ?>
