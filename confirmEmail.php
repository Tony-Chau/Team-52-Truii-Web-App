<?php
  include 'sql/mysql.inc';
  include 'inc/tools.inc';
  include 'inc/styles_and_scripts.inc';
  //Leaving this part to allow people to automatically log-in, so u don't need to type down ur email and password again
  //log_in(1);
  CheckMobile();
  if (is_log()){
    gotoPage('home');
  }
  if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    if (isset($_GET['confirmKey'])){
      //do something
      $key = $_GET['confirmKey'];
      $email = $_GET['Email'];
      $check = checkCookie($email, $key);
      if (!$check){
        CallTestAlert('Sorry, but it seems the key do not match, or it has expired. Page will direct you back to login page');
        gotoPage('index');
      }
    }
  }else if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['Confirm'])){
      ChangeUserPasswordByEmail($_POST['email'], $_POST['password']);
      CallTestAlert('Your password has been successfully been updated. We will redirect you back to the login page.');
      gotoPage('index');
    }
  }else{
    CallTestAlert('Sorry, but the website does not recongnise any keys. Page will redirect you back to the login page');
    gotoPage('index');
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
            <input type="password" name="new_password" class="input" id="password" required><br>
          </div>
          <div class="row-mid" id="row-mid">
            <label class="label" id="label">Confirm Password</label><br>
            <input type="password" name="confirm_password" class="input" id="confirm_password" required><br>
          </div>
          <!-- FIX THIS-->
          <div class="row-bottom" id="row-bottom">
            <input type="button" value="Set New Password" class="submit" id="submit" onclick="comparePassword();">
            <input type="submit" value="Set New Password" class="submit" style="display:none;opacity:0;" id="register" name='Confirm'>
          </div>
          <input type="text" name="email" style="display:none;opacity:0;" value=<?php echo $email;?>>
        </form>

      </div>
    </div>
<script>
function comparePassword(){
    var pass = document.getElementById('password').value;
    var pass2 = document.getElementById('confrim_password').value;
    if (pass == pass2){
      $('#register').click();
    }else{
      alert('It seems your passwords do not match, please try again');
    }
}
</script>
  </body>
  </html>
