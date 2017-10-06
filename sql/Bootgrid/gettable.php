<?php
//include after <include("connection.php");>

$tsize = 0;
$TablesIDQuery = "SELECT TableID, TableName FROM TableList WHERE UserID = '" . $_SESSION['UserID'] . "'";

$gotTableID = mysqli_query($connection, $TablesIDQuery);
while($tID = mysqli_fetch_assoc($gotTableID))
{
    $tIDs[] = $tID;
    $tsize += 1;
}

if(!empty($tIDs)){

    $tIDsoutput = array( 'rows' => $tIDs );
    $json = json_encode($tIDsoutput);
    $tIDsarr = (json_decode($json, true));

}else{
    header('location: recorddatapageAddDelete.php');
}


 ?>
