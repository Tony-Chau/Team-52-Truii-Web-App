<?php
  include 'sql/mysql.inc';
  include 'inc/tools.inc';
  include 'inc/styles_and_scripts.inc';
  //Leaving this part to allow people to automatically log-in, so u don't need to type down ur email and password again
  log_in(1);
  if (is_log()){
    header('location: home');
  }
  $log_username = "";
  $reg_username = "";
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //Log
      if (isset($_POST['log_username'])){
          if(CheckUser($_POST['log_username'])){
            if (CheckUserAndPassword($_POST['log_username'], $_POST['log_password'])){
              LogUser($_POST['log_username'], $_POST['log_password']);
              header('location: Index');
            }
          }
          echo "<script>alert('Sorry but the login details you have entered do not match within our database, please retype your password');</script>";
          $log_username = $_POST['log_username'];
      }
      //Register
      else{
        if (isset($_POST['reg_username'])){
          if ($_POST['reg_password'] == $_POST['reg_confirmpassword']){
            if (!CheckUser($_POST['reg_username'])){
              CreateUser($_POST['reg_username'], $_POST['reg_confirmpassword']);
              LogUser($_POST['reg_username'], $_POST['reg_password']);
              header('location: Index');
            }
              echo "<script>alert('Sorry, but this email has already been registered. Please use a different email account');</script>";
          }
          else{
              echo "<script>alert('Sorry, but your passwords do not match. Please try again');</script>";
          }
          $reg_username = $_POST['reg_username'];
        }
      }
  }
 ?>
<!DOCTYPE html>
<html>
<head>
  <title>Truii</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body style="background-image: url('BackGround/StartCropBackGround.jpg');
background-size:100% 100%; background-repeat: no-repeat; background-attachment: fixed;">

  <div class="centered" align="center" id="centered">
    <img src="Logo/truii-full-colour-white.png" class="logo" id="logo" alt="TruiiLogo">
  </div>

  <div class="centered" align="center" id="centered">
    <div class="container-fluid" id="login-container">

        <form method=POST>
          <div id="log">
          <div class="row-top" id="row-top">
            <label class="label" id="label">Username</label><br>
            <?php echo "<input type=\"email\" name=\"log_username\" class=\"input\" id=\"input\" value=\"" . $log_username . "\" required>" ?>
          </div>

          <div class="row-mid" id="row-mid">
            <label class="label" id="label">Password</label><br>
            <input type="password" name="log_password" class="input" id="input" required>
          </div>

          <div class="row-button" id="row-button">
            <input type="submit" value="Login" class="submit" id="submit">
          </div>
        </form>

          <div class="row-bottom" id="row-bottom">
              <input type="button" value="Register" class="submit" id="btnRegister">
          </div>
        </div>
          <form method=POST style="display: none;" id="Register">
            <div id ="Register">
            <div class="row-top" id="row-top">
              <label class="label" id="label">Email</label><br>
              <?php echo "<input type=\"email\" name=\"reg_username\" class=\"input\" id=\"input\" value=\"" . $reg_username . "\" required>"; ?>
            </div>

            <div class="row-mid" id="row-mid">
              <label class="label" id="label">Password</label><br>
              <input type="password" name="reg_password" class="input" id="input">
            </div>

            <div class="row-mid" id="row-mid">
              <label class="label" id="label">Confirm Password</label><br>
              <input type="password" name="reg_confirmpassword" class="input" id="input" required>
            </div>

            <div class="row-bottom" id="row-bottom">
              <input type="submit" value="Register" class="submit" id="submit">
            </div>
            <div class="row-bottom" id="row-bottom">
              <input type="button" value="Back" id="btnLog" class="submit">
            </div>
          </div>
          </form>
    </div>
  </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#btnRegister").click(function(){
            $("#log").animate({height: 'toggle', opacity: "0"}, "slow");
            $("#Register").animate({height: 'toggle', opacity: "100"}, "slow");
        }),
        $("#btnLog").click(function(){
        $("#Register").animate({ height: 'toggle' ,opacity: '0'}, "slow");
          $("#log").animate({height: 'toggle' , opacity: '100' }, "slow");
        })
    });
</script>
  <!-- JavaScript files should be linked at the bottom of the page  -->
  <script src="js/jquery.min.js"></script>

  <!-- Latest compiled and minified JavaScript  -->
  <script src="js/bootstrap.min.js"></script>

</body>
</html>
