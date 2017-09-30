<?php
//fetch.php
include("../mysql.inc");
include("connection.php");
$query = '';
$data = array();
$records_per_page = 10;
$start_from = 0;
$current_page_number = 0;
if(isset($_POST["rowCount"]))
{
    $records_per_page = $_POST["rowCount"];
}
else
{
    $records_per_page = 10;
}

if(isset($_POST["current"]))
{
    $current_page_number = $_POST["current"];
}
else
{
    $current_page_number = 1;
}

$start_from = ($current_page_number - 1) * $records_per_page;

//started using getcolumns.php
include("getcolumns.php");
$query .= "SELECT ";
$query .= $table . '.' . $arr["rows"][0]["COLUMN_NAME"];
for($i = 1; $i < $size; $i+=1){
    if ($i < $size){
        $query .= ", ";
    }
    $query .= $table . "." . $arr["rows"][$i]["FieldName"];
}
$query .= " FROM " . $table . " ";

if(!empty($_POST["searchPhrase"]))
{
    $query .= 'WHERE (';
    $query .= $table . '.' . $arr["rows"][0]["COLUMN_NAME"];
    for($i = 1; $i < $size; $i+=1){
        if ($i > 0){
            $query .= 'OR ';
        }
        $query .= $table . '.' . $arr["rows"][$i]["FieldName"];
        $query .= 'LIKE "%'.$_POST["searchPhrase"].'%" ';
    }
    $query .= ') ';
}

$order_by = '';
if(isset($_POST["sort"]) && is_array($_POST["sort"]))
{
    foreach($_POST["sort"] as $key => $value)
    {
        $order_by .= " $key $value, ";
    }
}
else
{
    $query .= 'ORDER BY ' . $table . '.' . $arr["rows"][0]["COLUMN_NAME"] . ' DESC ';
}

if($order_by != '')
{
    $query .= ' ORDER BY ' . substr($order_by, 0, -2);
}

if($records_per_page != -1)
{
    $query .= " LIMIT " . $start_from . ", " . $records_per_page;
}

//echo $query;
$result = mysqli_query($connection, $query);

if(!empty($result)){

    while($row = mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }

    //$query1 = "SELECT * FROM " . $table;
    //$result1 = mysqli_query($connection, $query1);
    $total_records = mysqli_num_rows($result);

}else{
    $total_records = 0;
}

$output = array(
    'current'     => intval($_POST["current"]),
    'rowCount'    => 10,
    'total'       => intval($total_records),
    'rows'        => $data
);

echo json_encode($output);

?>
