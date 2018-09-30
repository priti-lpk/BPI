<?php

include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
$dba = new DBAdapter();
if (isset($_GET['user-name'])) {
    $sql = "SELECT user_login_username FROM create_user WHERE user_login_username = '" . $_GET['user-name'] . "'";
    $select = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_array($select)) {
        $data = $row['user_login_username'];
        //print_r($data);
    }
    $get_rows = mysqli_affected_rows($con);

    if ($get_rows >= 1) {
        echo "1";
    } else {
        echo "0";
    }
} elseif (isset($_GET['create-rights'])) {
    $sql = "SELECT role_rights.role_create FROM role_rights INNER JOIN module ON role_rights.mod_id=module.id WHERE role_rights.role_id = '" . $_GET['create-rights'] . "' AND role_rights.mod_id=9";
    //print_r($sql);
    $select = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_array($select)) {
        $data = $row['role_create'];
        //print_r($data);
    }
    $get_rows = mysqli_affected_rows($con);

    if ($data == 1) {
        echo "1";
    } else {
        echo "0";
    }
}
?>

