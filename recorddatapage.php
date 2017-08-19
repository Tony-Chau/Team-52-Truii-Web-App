<!DOCTYPE html>
<html>
<head>

 <title>Truii Record Page</title>
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="css/bootstrap-theme.min.css">
 <link rel="stylesheet" href="css/style.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <script>
 var columnNumber;
function Create(){
  var div = "";
  var i = 1;
  var title = document.getElementById("xampletextinput").value;
  //There was a glitch in the form function, so these parts will be invisible, but data is still transferred
  div += "<input type=\"text\" value=\"" + title + "\"class=\"form-control\" id=\"xampletextinput\" aria-describedby=\"tablename\" name=\"Title\" style=\"display: none !important;\">";
  div += "<input type=\"text\" value=\"" + columnNumber + "\"class=\"form-control\" id=\"xampletextinput\" aria-describedby=\"tablename\" name=\"ColumnNumber\" style=\"display: none !important;\">";
  for (i = 1; i <= columnNumber; i+= 1){
    div += "<div class=\"form-group\" id=\"ColumnList\">";
    div += "<h2> Column" +  i + "</h2><label for=\"exampletextinput\">Column " +  i + " Title </label>";
    div += "<input type=\"text\" class=\"form-control\" id=\"xampletextinput\" aria-describedby=\"tablename\" placeholder=\"Enter Title\" name=\"ColumnTitle" + i + "\">";
    div += "<div class=\"form-group\"><label for=\"exampleSelect1\">Unit of Measurement</label>";
    div += "<select class=\"form-control\" id=\"exampleSelect1\" name=\"ColumnType" + i + "\">";
    div += "<option>% Percentage</option><option># Numbers</option><option> Text</option></select></div></div>";
  }

  return div;
}

 $(document).ready(function(){
   $("#fadeToItemColumn").click(function(){
       $("#Create").fadeOut();
    //  This gets the value from the select box
      var exampleSelect1 = document.getElementById("exampleSelect1");
       columnNumber = exampleSelect1.options[exampleSelect1.selectedIndex].value;
       $("#Column").html(Create());
       $("#Column").fadeIn();
       $("#Buttons").fadeIn();
   }),
   $("#FadeBack").click(function(){
     $("#Create").fadeIn();
       $("#Column").fadeOut();
       $("#Buttons").fadeOut();

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
  <div class= "container1" id="Create">

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
      <button type="button" class="btn btn-primary" id="fadeToItemColumn">Submit</button>

</div>
  <div class="form-group" id="Column">

</div>
<div class="form-group" id="Buttons" style="display: none;">
<button type="button" class="btn btn-primary" id="FadeBack">Back</button>
<button type="submit" class="btn btn-primary">Submit</button>
</div>
</div>
</form>
