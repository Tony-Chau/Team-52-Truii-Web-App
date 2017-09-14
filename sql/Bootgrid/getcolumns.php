<?php
//include after <include("connection.php");>

$size = 0;
$tableid = 1;
$table = NumberToWordsFormat($tableid);
$ColumnsQuery = "
    SELECT COLUMN_NAME
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = '" . get_dbDatabase() . "'
    AND TABLE_NAME = '" . $table . "'";

$gotcolumns = mysqli_query($connection, $ColumnsQuery);
while($column = mysqli_fetch_assoc($gotcolumns))
{
    $columns[] = $column;
    $size+=1;
}

$columnsoutput = array( 'rows' => $columns );

$json = json_encode($columnsoutput);
$arr = (json_decode($json, true));


 ?>
