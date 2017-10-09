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
$IDcolumnQuery = "
    SELECT COLUMN_NAME
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = '" . get_dbDatabase() . "'
    AND TABLE_NAME = '" . $table . "'";

$gotcolumnsID = mysqli_query($connection, $IDcolumnQuery);
$columnID = mysqli_fetch_assoc($gotcolumnsID);
$columns[] = $columnID;
$size+=1;

$fieldQuery = "SELECT * FROM FieldTable WHERE TableID = " . $tableid . " ORDER BY FieldID ASC;";
$gotfields = mysqli_query($connection, $fieldQuery);
if(!empty($gotfields)){

    while($fields = mysqli_fetch_assoc($gotfields))
    {
        $columns[] = $fields;
        $size+=1;
    }

}

$columnsoutput = array( 'rows' => $columns );

$json = json_encode($columnsoutput);
$arr = (json_decode($json, true));


 ?>
