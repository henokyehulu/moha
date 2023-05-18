<?php

function validate_phone_number($phoneNumber) {
  // Check if the phone number starts with +251 or 09.
  if (!preg_match("/^(^\+251|^251|^0)?(9|7)\d{8}$/", $phoneNumber)) {
    return null;
  }

  if(str_starts_with($phoneNumber, '09') || str_starts_with($phoneNumber, '9')){
    if(str_starts_with($phoneNumber, '09')) $phoneNumber = ltrim($phoneNumber,$phoneNumber[0]);
    $phoneNumber = "+251".$phoneNumber;
  }

  return $phoneNumber;

}

?>
