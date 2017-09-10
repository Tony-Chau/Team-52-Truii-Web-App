<?php
  include './sql/mysql.inc';
  if (!is_log()){
    header('location: Index.php');
  }
  CheckRequestLogout();
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
 var columnNumber = 1; //The number of columns the user has inputted on the first table
//Creates the Html code for the divColumn and also uses the information it had obtained from the first table to create the second one
 var text;
 var selectoption;
function ColumnHTML(){
  var div = "";
  columnNumber += 1;
  //var title = document.getElementById("xampletextinput").value;
  //There was a glitch in the form function, so these parts will be invisible, but data is still transferred
  //div += "<input type=\"text\" value=\"" + title + "\"class=\"form-control\" id=\"xampletextinput\" aria-describedby=\"tablename\" name=\"Title\" style=\"display: none !important;\">";
  //div += "<input type=\"text\" value=\"" + columnNumber + "\"class=\"form-control\" id=\"xampletextinput\" aria-describedby=\"tablename\" name=\"ColumnNumber\" style=\"display: none !important;\">";
  for (var i = firstColumn; i < columnNumber; i+=1){
    div += "<div class=\"form-group\" id=\"Column" + i + "\">";
    div += "</br>";
    div += "<h2> Column " + i + "</h2><label for=\"exampletextinput\">Column " +  i + " Title </label>";
    div += "<input type=\"text\" class=\"form-control\" id=\"textinput" + i + "\" aria-describedby=\"tablename\" placeholder=\"Enter Title\" name=\"ColumnTitle" + i + "\">";
    div += "<div class=\"form-group\"><label for=\"exampleSelect1\">Unit of Measurement</label>";
    div += "<select class=\"form-control\" id=\"selectinput" + i + "\" name=\"ColumnType" + i + "\">";
    div += "<option value=\"percentage\">% Percentage</option><option value=\"umbers\"># Numbers</option><option value=\"text\">Text</option></select></div></div>";
    //div += "<button type=\"button\" class=\"btn btn-primary\" id=\"AddColumn"+ i +"\">Add Column</button>";
    //div += "<button type=\"button\" class=\"btn btn-primary\" id=\"DeleteColumn"+ i +"\">Delete Column</button></br>";
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
    });

    $("#btn_DeleteColumn").click(function(){
      Delete();
      if (columnNumber == 1){
        $("#divColumn").hide();
      }
    });
  });

</script>
</head>

<header id ="titlelogo">
  <div class="container">
  <span class="logo"></span>
    <h1>
      Record Data
    </h1>
  </div>


</header>
<form>
<div id ="recordform">
  <div class= "container1" id="divCreate">

    <div class="form-group">
      <label for="exampletextinput">Title </label>
      <input type="text" class="form-control" id="xampletextinput" aria-describedby="tablename" placeholder="Enter Title"></input>
      <!--<label for="exampleSelect1">Number of columns</label>
      <select class="form-control" id="exampleSelect1" id="NumberOfColumn">
        <?php
        //for ($i = 1; $i < 100; $i += 1){
        //  echo "<option>" . $i . "</option>";
        //}
         ?>
      </select>-->
    </div>
  </div>
  <div class="form-group" id="divColumn">

  </div>
  <div class="form-group" id="divButtons">
    <button type="button" class="btn btn-primary" id="btn_AddColumn">Add Column</button>
    <button type="button" class="btn btn-primary" id="btn_DeleteColumn">Delete Column</button>

    <button type="submit" class="btn btn-primary">Submit</button>
  </div>
</div>
</form>
