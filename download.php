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
  $ValueResult = array();
  $count = 0;
  array_push($ValueResult, $FieldResult);
  foreach ($VariousTable as $data){
    $Values = array();
    for ($i = 0; $i < count($FieldResult); $i += 1){
      if (isset($FieldResult[$i]) && isset($data[$FieldResult[$i]])){
        $Field = $FieldResult[$i];
        if (!is_null($data[$Field])){
          $info =  $data[$Field];
          array_push($Values, $info);
        }else{
          array_push($Values, '');
        }
      }
      if ($FieldResult[$i] == $data[$FieldResult[$i]]){
        array_push($Values, '');
      }
    }
    array_push($ValueResult, $Values);
    $count += 1;
  }
  print_r($ValueResult);
  // $TableNames = 'file';
  // $json = '' . json_encode($ValueResult);
  // $json_dec = json_decode ($json);
  $filename =  rand(100000,999999) . '.csv';
  // $handle = fopen($filename, 'w');
  // foreach($json_dec as $row){
  //   fputcsv($handle, $row);
  // }
  // fclose($handle);
  file_put_contents($filename, ConvertDatatoCSV($FieldResult, $ValueResult));
  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename='.basename($filename));
  header('Expires: 0');
  header('Cache-Control: must-revalidate');
  header('Pragma: public');
  header('Content-Length: ' . filesize($filename));
  readfile($filename);
?>
