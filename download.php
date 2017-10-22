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
  $length = $VariousTable->rowCount();
  $ValueResult = array();
  $count = 0;
  foreach ($VariousTable as $data){
    $Values = array();
    for ($i = 0; $i < count($FieldResult); $i += 1){
      $Field = $FieldResult[$i];
      array_push($Values, $data[$Field]);
    }
    array_push($ValueResult, $Values);
    $count += 1;
  }
  $ValueResult = array_reverse($ValueResult);
  $TableNames = 'file';//RequestTableDetail($TableID, 'TableName');
  $list = ConvertDatatoCSV($FieldResult, $ValueResult);
  $filename = $TableNames . '.csv';
  $handle = fopen($filename, 'w');
  fwrite ($handle, $list);
  fclose($handle);
  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename='.basename($filename));
  header('Expires: 0');
  header('Cache-Control: must-revalidate');
  header('Pragma: public');
  header('Content-Length: ' . filesize($filename));
  readfile($filename);
?>
