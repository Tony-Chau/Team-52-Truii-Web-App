<?php
  include 'sql/mysql.inc';
  if (!is_log()){
    header('location: Index.php');
  }
  CheckRequestLogout();

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
      if (isset($_POST['title'])){
          $firstColumn = 1;
          $columnNumber = $_POST["numofColumn"];

          $table_name = ($_POST["title"]);
          $aFields = array();
          $dTypes = array();
          for ($i = $firstColumn; $i <= $columnNumber; $i+=1){
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

 <title>Truii Record Page</title>
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="css/bootstrap-theme.min.css">
 <link rel="stylesheet" href="css/style.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <script>

 var firstColumn = 1;
 var columnNumber = 0; //The number of columns the user has inputted on the first table
//Creates the Html code for the divColumn and also uses the information it had obtained from the first table to create the second one
 var text;
 var selectoption;
function ColumnHTML(){
  var div = "";
  columnNumber += 1;
  //var title = document.getElementById("xampletextinput").value;
  //There was a glitch in the form function, so these parts will be invisible, but data is still transferred
  // div += "<input type=\"text\" value=\"" + title + "\"class=\"form-control\" id=\"xampletextinput\" aria-describedby=\"tablename\" name=\"Title\" style=\"display: none !important;\">";
  // div += "<input type=\"text\" value=\"" + columnNumber + "\"class=\"form-control\" id=\"xampletextinput\" aria-describedby=\"tablename\" name=\"ColumnNumber\" style=\"display: none !important;\">";
  for (var i = firstColumn; i <= columnNumber; i+=1){
    div += "<div class=\"form-group\" id=\"Column" + i + "\" style=\"margin-right: 10%\">";
    div += "<fieldset clase=\"form-box\" id=\"Box" + i + "\" style=\"border: 2px black dashed; border-radius: 25px;\">";
    div += "<legend style=\"width: auto; height: auto; margin-bottom: 5px; margin-left: 6%;\"><b>Column " + i + "</b></legend>";
    div += "<button type=\"button\" class=\"btn btn-primary\" id=\"DeleteColumn"+ i +"\" style=\"float: right; margin-top: -22px; margin-right: -2px;\">X</button>";
    div += "<label for=\"exampletextinput\" style=\"margin-left: 4%; margin-right: 4%; margin-top -5%\">Column Title </label>";
    div += "<input type=\"text\" name=\"ColumnTitle" + i + "\" class=\"form-control\" id=\"textinput" + i + "\" style=\"width: 92%; margin-left: 4%; margin-right: 4%;\" aria-describedby=\"tablename\" placeholder=\"Enter Title\" value=\"\" required></br>";
    div += "<div class=\"form-group\" style=\"margin-bottom: 2%;\"><label for=\"exampleSelect1\" style=\"margin-left: 4%; margin-right: 4%;\">Unit of Measurement</label>";
    div += "<select name=\"ColumnType" + i + "\" class=\"form-control\" id=\"selectinput" + i + "\" style=\"width: 92%; margin-left: 4%; margin-right: 4%;\">";
    div += "<option value=\"VARCHAR(255)\">Text</option><option value=\"numbers\"># Numbers</option><option value=\"percentage\">% Percentage</option></select></div></fieldset>";
    div += "<button type=\"button\" class=\"btn btn-primary\" id=\"AddColumn"+ i +"\" style=\"margin-top: 1%; margin-left: 6%;\">Add Column</button>";
    div += "</div>";
  }
  return div;
}


function Collect(){
  text = [columnNumber];
  selectoption = [columnNumber];
  for (var i = 1; i < columnNumber; i+=1){
    eval("text[" + i + "] = document.getElementById(\"textinput" + i + "\").value;");
    eval("selectoption[" + i + "] = document.getElementById(\"selectinput" + i + "\").value;");
  }
}

function Insert(){
  for (var i = 1; i < (columnNumber-1); i+=1){
    eval("document.getElementById(\"textinput" + i + "\").value = text[" + i + "];");
    eval("document.getElementById(\"selectinput" + i + "\").value = selectoption[" + i + "];");
  }
}

function Delete(){
  if (columnNumber > 1){
    columnNumber -= 1;
    var val = "Column" + columnNumber;
    var a = document.getElementById(val);
    a.parentNode.removeChild(a);
  }
}



  $(document).ready(function(){
    document.getElementById("firstofColumn").value = firstColumn;
    $("#btnfadeToItemColumn").click(function(){
      $("#divCreate").fadeOut("slow"); //Fade out animation to make the first table disseapear
    //  This gets the value from the select box
      var exampleSelect1 = document.getElementById("exampleSelect1");
      columnNumber = exampleSelect1.options[exampleSelect1.selectedIndex].value;
      //The sleep funciton to give the web more time
      window.setTimeout(function(){
		    $("#divColumn").fadeIn("slow");
			  $("#divButtons").fadeIn("slow");
      }, 500);
    //Uses ColumnHtml function to to return a string to include it to the html code of divColumn
      $("#divColumn").html(ColumnHTML());
    }),
    //This button does the opposite task where it fades the second table out and fades the first table back in
    $("#btnFadeBack").click(function(){
      $("#divColumn").fadeOut("slow");
      $("#divButtons").fadeOut("slow");
	    window.setTimeout(function(){
		    $("#divCreate").fadeIn("slow");
	    }, 500);
    });

    $("#btn_AddColumn").click(function(){
      //$("#divColumn").fadeOut("slow");
      Collect();
      $("#divColumn").html(ColumnHTML());
      Insert();
      $("#divColumn").show();
      document.getElementById("numofColumn").value = columnNumber;
    });

    $("#btn_DeleteColumn").click(function(){
      Delete();
      if (columnNumber == 0){
        $("#divColumn").hide();
      }
      document.getElementById("numofColumn").value = columnNumber;
    });
  });

</script>
</head>
<!--
<header id ="titlelogo">
  <div class="container">
    <div class="row">
      <div class="col-xs-6">
        <h1> Record Data </h1>
      </div>
      <div class="col-xs-3">
        <div class="icon">
          <img class="" src="images//homeicon-01.png" alt="">
        </div>
      </div>
      <div class="col-xs-3">
        <div class="icon">
          <img class="" src="images//back-01.png" alt="">
        </div>
      </div>
    </div>
  </div>
</header>-->

<form method=POST>
  <div id ="recordform">
    <div class= "container1" id="divCreate">
      <div class="form-group" style="margin-right: 10%">
        <label for="exampletextinput">Title </label>
        <input type="text" name="title" class="form-control" id="xampletextinput" aria-describedby="tablename" placeholder="Enter Title" value="" required>
      </div>
    </div>

    <div class="form-group" id="divColumn"></div>

    <div class="form-group" id="divButtons">
      <input type="hidden" name="firstofColumn" id="firstofColumn" value=1>
      <input type="hidden" name="numofColumn" id="numofColumn" value=0>

      <button type="button" class="btn btn-primary" id="btn_AddColumn">Add Column</button>
      <button type="button" class="btn btn-primary" id="btn_DeleteColumn">Delete Column</button>
      <button type="submit" class="btn btn-primary" name="create_table">Submit</button>
    </div>
  </div>
</form>
