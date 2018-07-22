<?php
  include 'sql/mysql.inc';
  include 'inc/tools.inc';
  include 'inc/styles_and_scripts.inc';
  //Leaving this part to allow people to automatically log-in, so u don't need to type down ur email and password again
  //log_in(1);
  //CheckMobile();
  if (is_log()){
    gotoPage('home');
  }
  if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    if (isset($_GET['confirmKey'])){
      //do something
      log_in($userid);
      gotoPage('home');
    }
  }else{
    //gotoPage('index');
    gotoPage('home');
  }
  ?>

  <!DOCTYPE html>
  <html>

  <head>
    <link rel="stylesheet" href="css/login.css">
    <title>Truii</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

  </head>
  <body style="background-image: url('BackGround/StartCropBackGround.jpg');
    background-repeat: no-repeat; background-attachment: fixed; background-size: 100% 100%;">

    <div class="centered" align="center" id="centered">
      <img src="Logo/truii-full-colour-white.png" class="logo" id="logo" alt="TruiiLogo" style="margin-top: 2%;">
    </div>

    <div class="centered" align="center" id="centered">
      <div class="container-fluid" id="login-container">

        <form method=POST>
          <div class="row-top" id="row-top" style>
            <label class="label" id="label">New Password</label><br>
            <input type="password" name="new_password" class="input" id="input" required><br>
          </div>

          <div class="row-mid" id="row-mid">
            <label class="label" id="label">Confirm Password</label><br>
            <input type="password" name="confirm_password" class="input" id="input" required><br>
          </div>

          <div class="row-bottom" id="row-bottom">
            <input type="submit" value="Set New Password" class="submit" id="submit" name='Confirm'>
          </div>
        </form>

      </div>
    </div>

  </body>
  </html>
