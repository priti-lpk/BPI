<?php

include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
$dba = new DBAdapter();

$sql = "SELECT user_type FROM create_user INNER JOIN create_branch ON create_user.branch_id=create_branch.id WHERE user_type = '" . $_GET['user-type'] . "' and create_branch.id='" . $_GET['createbranch'] . "'";
//print_r($sql);
$select = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($select)) {
    $data = $row['user_type'];
}
$get_rows = mysqli_affected_rows($con);

if ($get_rows >= 1) {
    echo "1";
} else {
    echo "0";
}
?>

