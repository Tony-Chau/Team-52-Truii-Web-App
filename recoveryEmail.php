<?php

include 'sql/mysql.inc';
include 'inc/tools.inc';
include 'inc/styles_and_scripts.inc';

  $email = '';

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
          <label class="label" id="label">Please enter your email.<br>
              A Recovery Link will be sent to your email.<br>
              Email</label><br>
          <?php echo "<input type=\"email\" name=\"email\" class=\"input\" id=\"input\" value=\"" . $email . "\" required>" ?>
        </div>

        <div class="row-button" id="row-button">
          <input type="submit" value="Recover" class="submit" id="submit" name='log'>
        </div>
      </form>

    </div>
  </div>

</body>
</html>
