<?php
  include 'sql/mysql.inc';
  include 'inc/tools.inc';
  include 'inc/styles_and_scripts.inc';
  //CheckMobile();
  if (!is_log()){
    gotoPage('Index');
  }
  CheckRequestLogout();
  $UserDetail = GetAllUserDetail($_SESSION['UserID']);
  $name = '';
  $email = '';
  $password = '';
  foreach ($UserDetail as $data){
    $name = $data['Name'];
    $email = $data['Username'];
    $password = $data['Password'];
  }
  if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['ChangePassword'])){
    if ($_POST['password'] == $password){
      ChangeUserPassword($_POST['con_password']);
      CallTestAlert('Password has been changed');
    }else{
      CallTestAlert('Your current password do not match');
    }
    gotoPage('settings');
  }

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
          <h5><?php echo $name; ?></h5>
        </div>
      </div>

      <div class="row" style="padding: 0; padding-left:10px; margin-bottom: 3%">
        <label>Email</label>
        <div class="col-sm-10" style="margin-top:-3%; ">
          <h5><?php echo $email; ?></h5>
        </div>
      </div>

      <div class="row" style="padding: 0; padding-left:10px; padding-right:50px; margin-bottom: 3%">
        <label for="inputPassword">Current Password</label>
        <form method='POST'>
        <div class="col">
          <input type="password" class="form-control" id="password" placeholder="Password" name='password'>
        </div>
      </div>

      <div class="row" style="padding: 0; padding-left:10px; padding-right:50px; margin-bottom: 5%">
        <label for="inputPassword">New Password</label>
        <div class="col">
          <input type="password" class="form-control" id="con_password" name='con_password' placeholder="Password">
        </div>
        <input type="submit" class="btn btn-primary1" id="btnChange" style="margin-top: 5%" name='ChangePassword'>
      </div>
    </form>
      <div class="row" style="padding: 0; padding-left:10px; margin-bottom: 10%">
        <label>Get Help</label>
        <div class="col-sm-10">
          <a href='#' onclick='mail();'><label style="font-size: 90%"> Contact Truii</label></a><br/>
        </div>
      </div>
      <div class="row" style="padding: 0; padding-left:10px; margin-bottom: 3%">
        <form method="POST">
          <input type="submit" name='logout' class="btn btn-primary" value='Logout'>
        </form>
      </div>
    </div>
