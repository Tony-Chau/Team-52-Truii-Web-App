<?php
  include './sql/mysql.inc';
    include 'inc/tools.inc';
  if (is_log()){
    header('location: home');
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

        <form action="action">
          <div class="row-top">
            <label class="label">Email</label><br>
            <input type="email" name="email" class="input" required>
          </div>

          <div class="row-mid">
            <label class="label">Password</label><br>
            <input type="password" name="password" class="input">
          </div>

          <div class="row-mid">
            <label class="label">Confirm Password</label><br>
            <input type="password" name="confirmpassword" class="input" required>
          </div>

          <div class="row-bottom">
            <input type="submit" value="Register" class="submit">
          </div>
        </form>
    </div>
  </div>

  <!-- JavaScript files should be linked at the bottom of the page  -->
  <script src="js/jquery.min.js"></script>

  <!-- Latest compiled and minified JavaScript  -->
  <script src="js/bootstrap.min.js"></script>

</body>
</html>
