<?php
  include "sql/mysql.inc";
  include 'inc/styles_and_scripts.inc';
  include 'inc/tools.inc';
  include("sql/Bootgrid/connection.php");

  CheckMobile();

  if (!is_log()){
    gotoPage('Index');
  }
  CheckRequestLogout();
  navBarCreate('rgb(31,194,222)','Record Data');

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
      if (isset($_POST['title'])){
          $columnNumber = $_POST["columnNumber"];
          $table_name = SpaceCancel($_POST["title"]);
          $aFields = array();
          $dTypes = array();
          for ($i = 1; $i < ($columnNumber + 1); $i+=1){
              if (!empty($_POST["ColumnTitle{$i}"])){
                  array_push($aFields, SpaceCancel($_POST["ColumnTitle{$i}"]));
                  array_push($dTypes, $_POST["ColumnType{$i}"]);
              }
          }
          $valid = true;
          for ($i = 0; $i < count($aFields); $i += 1){
            for ($j = 0; $j < count($aFields); $j += 1){
              if ($i != $j){
                if ($aFields[$i] == $aFields[$j]){
                  $valid = false;
                }
              }
            }
          }
          if ($valid){
            CreateTable($table_name, $aFields, $dTypes);
            $LastTID_sql = "SELECT TableID FROM TableList ORDER BY TableID DESC LIMIT 1;";
            $gotlastTID = mysqli_query($connection, $LastTID_sql);
            $lastTID = mysqli_fetch_assoc($gotlastTID);
            $_SESSION['tableid'] = $lastTID['TableID'];
            gotoPage('datapage');
          }else{
            CallTestAlert('Around 2 or more tables have the same name. Please try again');
            //gotoPage('recorddatapageAddDelete');
          }
      }
  }
?>

<!DOCTYPE html>
<html>
<head>

 <title>Truii Record Page</title>
 <br/>
 <style>
   .container{
     margin: 0 !important;
     padding: 0 !important;
   }
 </style>

<script>
    var columnNumber = 1;
   function addField(){
     columnNumber += 1;
     var i = columnNumber;
     var number = '#Column' + i;
     var div = "<div class=\"container\" id=\"Column" + i + "\" style=\"display:none;opacity:0;\">";
     div += "<fieldset clase=\"form-box\" id=\"Box" + i + "\" style=\"position: relative; border-radius: 25px;background-color:rgb(10,191,211);opacity:0.8;padding-bottom: 5%; margin-top:10%; margin-bottom:10% \">";
     div += "<button style=\"position: absolute;right: 10px; top:-15px;text-align: right;\" type=\"button\" onClick=\"deleteField("+ i +");\" class=\"btn btn-primary\" id=\"DeleteColumn"+ i +"\">X</button>";
     div += "<label for=\"exampletextinput\" style=\"color: #FFFFFF;margin-left: 4%; margin-right: 4%;padding-top: 10px;\">Column Title </label>";
     div += "<input type=\"text\" name=\"ColumnTitle" + i + "\" class=\"form-control\" id=\"textinput" + i + "\" style=\"width: 92%; margin-left: 4%; margin-right: 4%;\" aria-describedby=\"tablename\" placeholder=\"Enter Title\" required></br>";
     div += "<div class=\"form-group\" style=\"margin-bottom: 2%;\"><label for=\"exampleSelect1\" style=\"margin-left: 4%; margin-right: 4%;color: #FFFFFF;\">Unit of Measurement</label>";
     div += "<select name=\"ColumnType" + i + "\" class=\"form-control\" id=\"selectinput" + i + "\" style=\"width: 92%; margin-left: 4%; margin-right: 4%;\">";
     div += "<option value=\"VARCHAR(255)\">Text</option><option value=\"INT\"># Numbers</option><option value=\"DATETIME\">&#x1F5D3 DateTime</option>";
     div += "<option value=\"DATE\">&#x1F4C5 Date</option><option value=\"TIME\">&#x231A Time</option></select></div></fieldset>";
     div += "</div>";
     $('#divColumn').append(div);
    $(number).animate({height: 'toggle', display: 'block'}, 250);
    $(number).animate({opacity: 1}, 250);
   }
   function deleteField(column){
     $('#Column' + column).animate({opacity: 0}, 250);
     $('#Column' + column).animate({display:'none', height: 'toggle'}, 250);
     document.getElementById("textinput" + column).required = false;
     document.getElementById("textinput" + column).value = '';
   }

   function Submission(){
      var str = "<input name='columnNumber' style='display:none;' value=" + columnNumber + " type='number'>";
      $('#divButtons').append(str);
      document.getElementById('create_table').click();
   }


 </script>

</head>
<body>
  <div id ="Homebutton" style="width: 100%">
    <form method='POST' style="margin-top: 20%;">
      <div class="container" style="width: 100%;">
        <div class="row" id="divCreate" style="margin-top: 2%; margin-left:2%; margin-right: 2%;">
          <div class="col">
            <div class="form-group">
              <label for="exampletextinput">Title </label>
              <input type="text" name="title" class="form-control" id="xampletextinput" aria-describedby="tablename" placeholder="Enter Title" required>
            </div>
          </div>
        </div>

        <div class="form-group" id="divColumn" style='width: 100%;'>
          <div class="container" id="Column1" style="width: 100%;">
            <fieldset clase="form-box" id="Box1" style="width: 100%; position: relative; border-radius: 25px;background-color:rgb(10,191,211);opacity:0.8; padding-bottom: 5%; margin-top:10%; margin-bottom:10%;">
              <label for="exampletextinput" style="color: #FFFFFF;margin-left: 4%; margin-right: 4%;padding-top: 10px;">Column Title </label>
              <input type="text" name="ColumnTitle1" class="form-control" id="textinput1" style="width: 92%; margin-left: 4%; margin-right: 4%;" aria-describedby="tablename" placeholder="Enter Title" required></br>
              <div class="form-group" style="margin-bottom: 2%;"><label for="exampleSelect1" style="color: #FFFFFF;margin-left: 4%; margin-right: 4%;">Unit of Measurement</label>
                <select name="ColumnType1" class="form-control" id="selectinput1" style="width: 92%; margin-left: 4%; margin-right: 4%;">
                  <option value="VARCHAR(255)">Text</option>
                  <option value="INT"># Numbers</option>
                  <option value="DATETIME">&#x1F5D3 DateTime</option>
                  <option value="DATE">&#x1F4C5 Date</option>
                  <option value="TIME">&#x231A Time</option>
                </select>
              </div>
            </fieldset>
          </div>
        </div>
        <div class="form-group" id="divButtons" style = "margin-top: 1%;margin-right: 21%;display: inline-block;float:left;">
          <button type="button" class="btn btn-primary1" onClick="addField();" style="margin-top: 1%; margin-left: 5%;display: inline-block;">Add Column</button>
          <button type="button" class="btn btn-primary1" onClick='Submission();' style="margin-top: 1%; margin-left: 5%;display: inline-block;">Submit</button>
          <input type="submit" class="btn btn-primary1" id='create_table' style="display:none;">
        </div>
      </div>
    </form>
  </div>

</body>
</html>
