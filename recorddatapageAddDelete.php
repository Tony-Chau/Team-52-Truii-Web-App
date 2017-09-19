<?php
  include 'sql/mysql.inc';
  if (!is_log()){
    header('location: Index.php');
  }
  CheckRequestLogout();

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
      if (isset($_POST['title'])){
          $columnNumber = $_POST["columnNumber"];
          $table_name = ($_POST["title"]);
          $aFields = array();
          $dTypes = array();
          for ($i = 1; $i < ($columnNumber + 1); $i+=1){
              array_push($aFields, $_POST["ColumnTitle{$i}"]);
              array_push($dTypes, $_POST["ColumnType{$i}"]);
          }
          CreateTable($table_name, $aFields, $dTypes);
      }
  }
?>
<!DOCTYPE html>
<html>
<head>

  <header id ="titlelogo">
    <div class="container">

      <div class="row">
        <div class="col-xs-6">
      <h1> Record Data </h1>
      </div>
        <div class="col-xs-3">

        <div class="icon">
        <img class="" alt=""> </div>

        </div>

    <div class="col-xs-3">
    <div class="icon">
        <img class="" alt="" > </div>
  </div>

    </div>
  </div>


  </header>
 <title>Truii Record Page</title>
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="css/bootstrap-theme.min.css">
 <link rel="stylesheet" href="css/style.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <script src='js/Functions/Link.js'></script>
 <script>
    var columnNumber = 1;
   function addField(){
     columnNumber += 1;
     var i = columnNumber;
     var number = '#Column' + i;
     var div = "<div class=\"container\" id=\"Column" + i + "\" style=\"margin-right: 10%;margin-left: -10px;margin-top:10px;display:none;padding-top: 10px; padding-bottom: 10px;\">";
     div += "<fieldset clase=\"form-box\" id=\"Box" + i + "\" style=\"position: relative; border-radius: 25px;background-color:rgb(10,191,211);opacity:0.8\">";
     div += "<button style=\"position: absolute;right: 10px; top:-15px;text-align: right;\" type=\"button\" onClick=\"deleteField("+ i +");\" class=\"btn btn-primary\" id=\"DeleteColumn"+ i +"\">X</button>";
     div += "<label for=\"exampletextinput\" style=\"color: #FFFFFF;margin-left: 4%; margin-right: 4%;padding-top: 10px;\">Column Title </label>";
     div += "<input type=\"text\" name=\"ColumnTitle" + i + "\" class=\"form-control\" id=\"textinput" + i + "\" style=\"width: 92%; margin-left: 4%; margin-right: 4%;\" aria-describedby=\"tablename\" placeholder=\"Enter Title\" required></br>";
     div += "<div class=\"form-group\" style=\"margin-bottom: 2%;\"><label for=\"exampleSelect1\" style=\"margin-left: 4%; margin-right: 4%;color: #FFFFFF;\">Unit of Measurement</label>";
     div += "<select name=\"ColumnType" + i + "\" class=\"form-control\" id=\"selectinput" + i + "\" style=\"width: 92%; margin-left: 4%; margin-right: 4%;\">";
     div += "<option value=\"VARCHAR(255)\">Text</option><option value=\"numbers\"># Numbers</option><option value=\"percentage\">% Percentage</option></select></div></fieldset>";
     div += "</div>";
     $('#divColumn').append(div);
     $(number).animate({height: 'toggle', display:'block'}, 500);
   }
   function deleteField(column){
     $('#Column' + column).animate({display:'none', height: 'toggle'}, 500);
     document.getElementById("textinput" + column).required = false;
     document.getElementById("textinput" + column).value = '';
   }
   function ResetValue(){
     document.getElementById('xampletextinput').value = '';
     for (var i = 1; i < (columnNumber + 1); i += 1){
        document.getElementById('textinput' + i).value = '';
     }
   }

   function Submission(){
      var str = "<input name='columnNumber' style='display:none;' value=" + columnNumber + " type='number'>";
      $('#divButtons').append(str);
      document.getElementById('create_table').click();
   }
 </script>
</head>
<form method=POST>
  <div id ="recordform">
    <div class= "container1" id="divCreate">
      <div class="form-group" style="margin-right: 10%">
        <label for="exampletextinput">Title </label>
        <input type="text" name="title" class="form-control" id="xampletextinput" aria-describedby="tablename" placeholder="Enter Title" required>
      </div>
    </div>

    <div class="form-group" id="divColumn" style='margin-top:10px;'>
      <div class="container" id="Column1" style="margin-right: 10%;margin-left: -10px;margin-top:10px;padding-top: 10px; padding-bottom: 20px;">
        <fieldset clase="form-box" id="Box1" style="position: relative; border-radius: 25px;background-color:rgb(10,191,211);opacity:0.8">
          <label for="exampletextinput" style="color: #FFFFFF;margin-left: 4%; margin-right: 4%;padding-top: 10px;">Column Title </label>
          <input type="text" name="ColumnTitle1" class="form-control" id="textinput1" style="width: 92%; margin-left: 4%; margin-right: 4%;" aria-describedby="tablename" placeholder="Enter Title" required></br>
          <div class="form-group" style="margin-bottom: 2%;"><label for="exampleSelect1" style="color: #FFFFFF;margin-left: 4%; margin-right: 4%;">Unit of Measurement</label>
            <select name="ColumnType1" class="form-control" id="selectinput1" style="width: 92%; margin-left: 4%; margin-right: 4%;">
              <option value="VARCHAR(255)">Text</option>
              <option value="numbers"># Numbers</option>
              <option value="percentage">% Percentage</option>
                </select></div></fieldset>
            </div>
          </div>
          <button type="button" class="btn btn-primary" onClick="addField();" style="margin-top: 1%; margin-left: 6%;">Add Column</button>
          <div class="form-group" id="divButtons" style = "margin-top: 10px;">
      <button type="button" class="btn btn-primary" id="btn_ResetColumn" onclick="ResetValue();">Reset Column</button>
      <button type="button" class="btn btn-primary" onClick='Submission();' >Submit</button>
      <button type="submit" class="btn btn-primary" id='create_table' style="display:none;">Submit</button>
    </div>
  </div>
</form>
