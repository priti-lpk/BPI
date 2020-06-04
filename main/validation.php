<?php

include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
$dba = new DBAdapter();
if (isset($_GET['user-name'])) {
    $sql = "SELECT user_login_username FROM create_user WHERE user_login_username = '" . $_GET['user-name'] . "'";
    $select = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_array($select)) {
        $data = $row['user_login_username'];
    }
    $get_rows = mysqli_affected_rows($con);

    if ($get_rows >= 1) {
        echo "1";
    } else {
        echo "0";
    }
}
?>

