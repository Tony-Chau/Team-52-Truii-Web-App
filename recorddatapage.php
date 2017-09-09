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
 var columnNumber; //The number of columns the user has inputted on the first table
//Creates the Html code for the divColumn and also uses the information it had obtained from the first table to create the second one
function ColumnHTML(){
  var div = "";
  var i = 1;
  var title = document.getElementById("xampletextinput").value;
  //There was a glitch in the form function, so these parts will be invisible, but data is still transferred
  div += "<input type=\"text\" value=\"" + title + "\"class=\"form-control\" id=\"xampletextinput\" aria-describedby=\"tablename\" name=\"Title\" style=\"display: none !important;\">";
  div += "<input type=\"text\" value=\"" + columnNumber + "\"class=\"form-control\" id=\"xampletextinput\" aria-describedby=\"tablename\" name=\"ColumnNumber\" style=\"display: none !important;\">";
  for (i = 1; i <= columnNumber; i+= 1){
    div += "<div class=\"form-group\" id=\"ColumnList\">";
    div += "<h2> Column " +  i + "</h2><label for=\"exampletextinput\">Column " +  i + " Title </label>";
    div += "<input type=\"text\" class=\"form-control\" id=\"xampletextinput\" aria-describedby=\"tablename\" placeholder=\"Enter Title\" name=\"ColumnTitle" + i + "\">";
    div += "<div class=\"form-group\"><label for=\"exampleSelect1\">Unit of Measurement</label>";
    div += "<select class=\"form-control\" id=\"exampleSelect1\" name=\"ColumnType" + i + "\">";
    div += "<option>% Percentage</option><option># Numbers</option><option> Text</option></select></div></div>";
  }

  return div;
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
   })
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
      <label for="exampleSelect1">Number of columns</label>
      <select class="form-control" id="exampleSelect1" id="NumberOfColumn">
        <?php
        for ($i = 1; $i < 100; $i += 1){
          echo "<option>" . $i . "</option>";
        }
         ?>
      </select>
    </div>
      <button type="button" class="btn btn-primary" id="btnfadeToItemColumn">Submit</button>

</div>
  <div class="form-group" id="divColumn" style="display: none;">

</div>
<div class="form-group" id="divButtons" style="display: none;">
<button type="button" class="btn btn-primary" id="btnFadeBack">Back</button>
<button type="submit" class="btn btn-primary">Submit</button>
</div>
</div>
</form>
