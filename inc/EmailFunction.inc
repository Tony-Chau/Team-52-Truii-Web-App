<?php
function send_Validation_email($email, $name_of_user){
  $title = 'Registeration';
  $email = $field_list[$field_name];
  $number = rand(100000,999999);
  $random_number = SendMainWebLink("Register.php") . $number;
  $message = "Hello " . $name_of_user;
  mail($email, $title, $message);
}

function SendMainWebLink($name_of_page, $type_of_information){
  return "" . $name_of_page . "?" . $type_of_information;
}

 ?>
