<?php
  include 'sql/mysql.inc';
  include 'inc/tools.inc';
  include 'inc/styles_and_scripts.inc';
  //CheckMobile();
  if (!is_log()){
    gotoPage('Index');
  }
  CheckRequestLogout();
  navBarCreate('rgb(252, 103, 25)', 'settings');
?>
<!DOCTYPE html>
<html>
<head>

 <title>My Settings</title>
 <br/>

</head>
<body>

  <div id ="Homebutton">
    <div class="container" style="padding: 0; margin: 0;">
      <label style="font-size: 125%; margin-top: 6%; margin-bottom: 5%">My Account</label>
      <div class="row" style="padding: 0; padding-left:10px; margin-bottom: 3%">
        <label>Name</label>
        <div class="col-sm-10" style="margin-top:-3%;">
          <h5>Jane Doe</h5>
        </div>
      </div>

      <div class="row" style="padding: 0; padding-left:10px; margin-bottom: 3%">
        <label>Email</label>
        <div class="col-sm-10" style="margin-top:-3%; ">
          <h5>email@example.com</h5>
        </div>
      </div>

      <div class="row" style="padding: 0; padding-left:10px; padding-right:50px; margin-bottom: 3%">
        <label for="inputPassword">Current Password</label>
        <div class="col">
          <input type="password" class="form-control" id="inputPassword" placeholder="Password">
        </div>
      </div>

      <div class="row" style="padding: 0; padding-left:10px; padding-right:50px; margin-bottom: 5%">
        <label for="inputPassword">New Password</label>
        <div class="col">
          <input type="password" class="form-control" id="inputPassword" placeholder="Password">
          <span style="color: red">Password does not match</span>
        </div>
        <button type="button" class="btn btn-primary1" id="btnfadeToItemColumn" style="margin-top: 5%" >Change Password</button>
      </div>

      <div class="row" style="padding: 0; padding-left:10px; margin-bottom: 10%">
        <label>Get Help</label>
        <div class="col-sm-10">
          <a href='#' onclick='mail();'><label style="font-size: 90%"> Contact Truii</label></a><br/>
        </div>
      </div>

      <div class="row" style="padding: 0; padding-left:10px; margin-bottom: 3%">
        <form method="POST">
          <button type="button" class="btn btn-primary" id="btnfadeToItemColumn">Logout</button>
        </form>
      </div>
    </div>
