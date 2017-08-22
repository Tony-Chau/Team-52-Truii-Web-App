<?php
  include './sql/mysql.inc';
  //unset($_SESSION['UserID']);
  if (is_log()){
    header('location: home.php');
  }
  $log_username = "";
  $reg_username = "";
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //Log
      if (isset($_POST['log_username'])){
          if(CheckUser($_POST['log_username'])){
            if (CheckUserAndPassword($_POST['log_username'], $_POST['log_password'])){
              LogUser($_POST['log_username'], $_POST['log_password']);
              header('location: Index.php');
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
              header('location: Index.php');
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
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/bootstrap-theme.css">
  <link rel="stylesheet" href="css/main.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body style="background-image: url('BackGround/StartCropBackGround.jpg');
background-size:100% 100%; background-repeat: no-repeat; background-attachment: fixed;">

  <div class="centered" align="center">
    <img src="Logo/truii-full-colour-white.png" class="logo" alt="TruiiLogo">
  </div>

  <div class="centered" align="center">
    <div class="container-fluid">

        <form method=POST>
          <div id = "log">
          <div class="row-top">
            <label class="label">Username</label><br>
            <?php echo "<input type=\"email\" name=\"log_username\" class=\"input\" value=\"" . $log_username . "\" required>" ?>
          </div>

          <div class="row-mid">
            <label class="label">Password</label><br>
            <input type="password" name="log_password" class="input" required>
          </div>

          <div class="row-button">
            <input type="submit" value="Login" class="submit">
          </div>
        </form>

          <div class="row-bottom">
              <input type="button" value="Register" class="submit"  id= "btnRegister">
          </div>
        </div>
          <form method=POST style="display: none;" id="Register">
            <div id ="Register">
            <div class="row-top" >
              <label class="label">Email</label><br>
              <?php echo "<input type=\"email\" name=\"reg_username\" class=\"input\" value=\"" . $reg_username . "\" required>"; ?>
            </div>

            <div class="row-mid">
              <label class="label">Password</label><br>
              <input type="password" name="reg_password" class="input">
            </div>

            <div class="row-mid">
              <label class="label">Confirm Password</label><br>
              <input type="password" name="reg_confirmpassword" class="input" required>
            </div>

            <div class="row-bottom">
              <input type="submit" value="Register" class="submit">
            </div>
            <div class="row-bottom">
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
        }),
        $('[name=log_username]').value = 'pa';
    });
</script>
  <!-- JavaScript files should be linked at the bottom of the page  -->
  <script src="js/jquery.min.js"></script>

  <!-- Latest compiled and minified JavaScript  -->
  <script src="js/bootstrap.min.js"></script>

</body>
</html>
