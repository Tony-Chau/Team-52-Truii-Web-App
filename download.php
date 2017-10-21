<?php
include 'sql/mysql.inc';
include 'inc/tools.inc';

if (!is_log() && !isset($_SESSION['tableid'])){
  gotoPage('Index');
}
CheckRequestLogout();
 $TableID = $_SESSION['tableid'];
 $TableName = NumberToWordsFormat($TableID);
  $FieldNameResult = GetFieldTableList($TableID);
  $FieldResult = array();
  foreach($FieldNameResult as $data){
    array_push($FieldResult, $data['FieldName']);
  }
  $VariousTable = GetVariousTable($TableID);
  $ValueResult = array(array());
  $count = 0;
  foreach ($VariousTable as $data){
    foreach ($VariousTable as $result) {
      array_push($ValueResult[$count], $result[$count]);
    }
    $count += 1;
  }
  print_r($ValueResult);
  // $csv = ConvertDatatoCSV($FieldResult, $ValueResult);
  //
  // $TableNames = RequestTableDetail($TableID, 'TableName');
  // $file = fopen("$TableNames" . ".csv","w");
  //
  // foreach ($list as $line)
  //   {
  //   fputcsv($file,$csv);
  //   }
  //
  // fclose($file);
?>
