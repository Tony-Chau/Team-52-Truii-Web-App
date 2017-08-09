<?php
function send_Validation_email($email, $name_of_user){
  $title = 'Registration';
  $email = $field_list[$field_name];
  $number = rand(100000,999999);
  $random_number = GetLink("Register.php", "cookieNumber", $number) . $number;
  $message = "Hello " . $name_of_user;
  mail($email, $title, $message);
}

function GetLink($PageDirectory, $Type, $Value){
  $link = "" . $name_of_page;
  if ($Type === null || $Value === null){
    return $link;
  }
  $length = count($Type);
  $link .= "?";
  if ($length > 1){
    for ($i = 0; $i < $length; $i += 1){
      $link .= str_replace(' ', '%20', $Type[$i]) . "=" . str_replace(' ', '_', $Value[$i]);
      if ($i != $length - 1){
        $link .= "&";
      }
    }
  }else if($length == 1){
    $link .= str_replace(' ', '%20', $Type) . "=" . str_replace(' ', '_', $Value);
  }
  return $link;
}

 ?>
