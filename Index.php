<!DOCTYPE html>
<html>
<head>

  <title>Truii</title>
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/bootstrap-theme.css">

  <link rel="stylesheet" href="css/main.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body style="background-image: url('BackGround/StartBackGround.png');background-position:right top;background-size:auto 100%;background-repeat: no-repeat;">

  <div class="centered" align="center">
    <img src="Logo/truii-full-colour-white.png" class="logo" alt="TruiiLogo">
  </div>

  <div class="centered" align="center">
    <div class="container-fluid">

        <form action="action.php">
          <div class="row-top">
            <label class="label">Username</label><br>
            <input type="text" name="username" class="input">
          </div>

          <div class="row-mid">
            <label class="label">Password</label><br>
            <input type="password" name="password" class="input">
          </div>

          <div class="row-button">
            <input type="submit" value="Login" class="submit">
          </div>
        </form>

          <div class="row-bottom">
            <form action="Registration.php">
              <input type="submit" value="Register" class="submit">
            </form>
          </div>
    </div>
  </div>

  <!-- JavaScript files should be linked at the bottom of the page  -->
  <script src="js/jquery.min.js"></script>

  <!-- Latest compiled and minified JavaScript  -->
  <script src="js/bootstrap.min.js"></script>

</body>
</html>
