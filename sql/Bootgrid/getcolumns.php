<?php
//include after <include("connection.php");>

$size = 0;
//$tableid = 47;
if (!empty($_SESSION['tableid'])){
    $tableid = $_SESSION['tableid'];
}
else {
    header('location: choosedatapage.php');
}


$table = NumberToWordsFormat($tableid);
$ColumnsQuery = "
    SELECT COLUMN_NAME
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = '" . get_dbDatabase() . "'
    AND TABLE_NAME = '" . $table . "'";

$gotcolumns = mysqli_query($connection, $ColumnsQuery);
$column = mysqli_fetch_assoc($gotcolumns);
$columns[] = $column;
$size+=1;

$fieldName = GetFieldTableList($tableid);
while($column = $fieldName->fetch(PDO::FETCH_ASSOC))
{
    $columns[] = $column;
    $size+=1;
}

$columnsoutput = array( 'rows' => $columns );

$json = json_encode($columnsoutput);
$arr = (json_decode($json, true));


 ?>
