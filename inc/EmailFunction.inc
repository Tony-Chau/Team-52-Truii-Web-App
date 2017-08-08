<?php
function send_Validation_email($email, $name_of_user){
  $title = 'Registeration';
  $email = $field_list[$field_name];
  $number = rand(100000,999999);
  $random_number = SendMainLink("Register.php") . $number;
  $message = "Hello " . $name_of_user;
  mail($email, $title, $message);
}

function SendMainLink($name_of_page, $GET_type_array, $GET_value_array){
  $link = "" . $name_of_page;
  if ($GET_type_array === null || $GET_value_array === null){
    return $link;
  }
  $length = count($GET_type_array);
  if ($length >= 1){
    $link .= "?";
    for ($i = 0; $i < $length; $i += 1){
      $value = str_replace(' ', '_', $GET_value_array[$i]);
      $link .= $type . "=" . $value;
      if ($i != $length - 1){
        $link .= "&";
      }
    }
  }
  return $link;
}

 ?>
