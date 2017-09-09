<?php
function GetCurrentTime(){
  $time = new DateTimeZone('Australia/Brisbane');
  $datetime = new DateTime();
  $datetime->setTimezone($time);
  return $datetime;
}

function NumberToWordsFormat($Number){
  $format = new NumberFormatter("en", NumberFormatter::SPELLOUT);
  $FormNumber = $format->format($Number);
  $NewFormNumber = str_replace(" ", "_", $FormNumber);
  return str_replace("-", "_", $NewFormNumber);
}
 ?>
