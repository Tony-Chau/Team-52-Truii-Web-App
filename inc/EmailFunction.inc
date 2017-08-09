<?php
function send_Validation_email($email, $name_of_user){
  $title = 'Registration';
  $email = $field_list[$field_name];
  $number = rand(100000,999999);
  $random_number = GetLink("Register.php") . $number;
  $message = "Hello " . $name_of_user;
  mail($email, $title, $message);
}

function GetLink($name_of_page, $GET_type_array, $GET_value_array){
  $link = "" . $name_of_page;
  if ($GET_type_array === null || $GET_value_array === null){
    return $link;
  }
  $length = count($GET_type_array);
  $link .= "?";
  if ($length > 1){
    for ($i = 0; $i < $length; $i += 1){
      $link .= str_replace(' ', '%20', $GET_type_array[$i]) . "=" . str_replace(' ', '_', $GET_value_array[$i]);
      if ($i != $length - 1){
        $link .= "&";
      }
    }
  }else if($length == 1){
    $link .= str_replace(' ', '%20', $GET_type_array) . "=" . str_replace(' ', '_', $GET_value_array);
  }
  return $link;
}

 ?>
