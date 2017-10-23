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
  <h1>
    My Account
    <h1/>
    <form>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Name</label>
        <div class="col-sm-10">
          <p class="form-control-static">Jane Doe</p>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
          <p class="form-control-static">email@example.com</p>
        </div>
        <button type="button" class="btn btn-primary1" id="btnfadeToItemColumn">Change Password</button>
      </div>
      <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Current Password</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" id="inputPassword" placeholder="Password">
        </div>

        <div class="form-group row">
          <label for="inputPassword" class="col-sm-2 col-form-label">New Password</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="inputPassword" placeholder="Password">
          </div>
        </div>

        <h1>
          Get Help
          <h1>
            <a href='#' onclick='mail();'><p> contact Truii</p></a>

          </div>
        <h1>
          Logout
        </h1>
        <button type="button" class="btn btn-primary" id="btnfadeToItemColumn">Logout</button>


    </form>
