<?php

ob_start();
include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/Controls.php';
if ($_GET['action'] == 'add') {
    $dba = new DBAdapter();
    $sql1 = "INSERT INTO create_godawn (godawn_name,godawn_address,contact) VALUES ('" . $_GET['godawn_name'] . "','" . $_GET['godawn_address'] . "','" . $_GET['contact'] . "')";
    mysqli_query($con, $sql1);
} elseif ($_GET['action'] == 'edit') {
    include_once '../shreeLib/DBAdapter.php';
    $dba = new DBAdapter();
    $id = $_GET['id'];
    $sql2 = "update create_godawn set godawn_name='" . $_GET['godawn_name'] . "',godawn_address='" . $_GET['godawn_address'] . "', contact='" . $_GET['contact'] . "' where id=" . $id;
    mysqli_query($con, $sql2);
}
?>

