<?php
  include 'sql/mysql.inc';
  include 'inc/tools.inc';
  include 'inc/styles_and_scripts.inc';
  //Leaving this part to allow people to automatically log-in, so u don't need to type down ur email and password again
  log_in(1);

  CheckMobile();

  if (is_log()){
    gotoPage('home');
  }
  $log_username = '';
  $reg_username = '';
  if ($_SERVER['REQUEST_METHOD'] == "POST"){
    $UserTable = GetAllUser();
    if (isset($_POST['log'])){
      //log
      $log_username = $_POST['log_username'];
      $password = $_POST['log_password'];
      $userid = -1;
      foreach($UserTable as $data){
        if($data['Username'] == $log_username && $data['Password'] == $password){
          $userid = $data['UserID'];
        }
      }
      if($userid != -1){
        log_in($userid);
        gotoPage('home');
      }else{
        CallTestAlert('Sorry it seems either your email or your password was incorrect or do not exist. Please try again or create an account');
      }
    }else if(isset($_POST['btnRegister'])){
      //register
      $reg_username = $_POST['reg_username'];
      $reg_name = $_POST['reg_name'];
      $password = $_POST['reg_confirmpassword'];
      $valid = true;
      //Checking if the username already exist or not
      foreach($UserTable as $data){
        if ($reg_username == $data['Username']){
          $valid = false;
        }
      }
      if ($valid){
        CreateUser($reg_name, $reg_username, $password);
        LogUser($reg_username, $password);
      }else{
        CallTestAlert('This email has already been registered. Please register with a different email address');
      }
    }
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
          <div id="log" style="display:block; opacity:1;">
          <div class="row-top" id="row-top">
            <label class="label" id="label">Username</label><br>
            <?php echo "<input type=\"email\" name=\"log_username\" class=\"input\" id=\"input\" value=\"" . $log_username . "\" required>" ?>
          </div>

          <div class="row-mid" id="row-mid">
            <label class="label" id="label">Password</label><br>
            <input type="password" name="log_password" class="input" id="input" required>
          </div>

          <div class="row-button" id="row-button">
            <input type="submit" value="Login" class="submit" id="submit" name='log'>
          </div>
        </form>

          <div class="row-bottom" id="row-bottom">
              <input type="button" value="Register" class="submit" id="btnRegister" onclick="toRegiter();">
          </div>
        </div>
          <form method=POST >
            <div id ="Register" style="opacity:0;display:none;" id="Register">
              <div class="row-top" id="row-top">
                <label class="label" id="label">Full Name</label><br>
                <input type="text" name="reg_name" class="input" id="input" required>
              </div>

            <div class="row-top" id="row-top">
              <label class="label" id="label">Email</label><br>
              <?php echo "<input type=\"email\" name=\"reg_username\" class=\"input\" id=\"input\" value=\"" . $reg_username . "\" required>"; ?>
            </div>

            <div class="row-mid" id="row-mid">
              <label class="label" id="label">Password</label><br>
              <input type="password" name="reg_password" class="input" id="reg_password" style='width: 100%;border-radius: 5px;padding-left: 2%;font-size: 125%;'>
            </div>

            <div class="row-mid" id="row-mid">
              <label class="label" id="label">Confirm Password</label><br>
              <input type="password" name="reg_confirmpassword" class="input" id="reg_confirmpassword" required style='width: 100%;border-radius: 5px;padding-left: 2%;font-size: 125%;'>
            </div>

            <div class="row-bottom" id="row-bottom">
              <input type="button" value="Register" class="submit" id="submit" onclick='Register();'>
              <input type="submit" style='display:none;' class="submit" id="register" name='btnRegister'>
            </div>
            <div class="row-bottom" id="row-bottom">
              <input type="button" value="Back" id="btnLog" class="submit" onclick="toLog();">
            </div>
          </div>
          </form>
    </div>
  </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
function toRegiter(){
  $("#log").animate({height: 'toggle', opacity: "0", display:'none'}, "slow");
  $("#Register").animate({height: 'toggle'}, "slow");
  $('#Register').animate({opacity: "1", display:'block'}, "slow");
}

function toLog(){
  $("#Register").animate({height: 'toggle', opacity: "0", display:'none'}, "slow");
  $("#log").animate({height: 'toggle'}, "slow");
  $('#log').animate({opacity: "1", display:'block'}, "slow");
}

function Register(){
  var password = $('#reg_password').val();
  var con_password = $('#reg_confirmpassword').val();
  if (password == con_password){
    $('#register').click();
  }else{
    alert('Your passwords do not match');
  }
}
</script>
  <!-- JavaScript files should be linked at the bottom of the page  -->
  <script src="js/jquery.min.js"></script>

  <!-- Latest compiled and minified JavaScript  -->
  <script src="js/bootstrap.min.js"></script>

</body>
</html>
