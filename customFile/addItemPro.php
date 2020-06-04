<?php

ob_start();

include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/Controls.php';

if ($_GET['action'] == 'add') {

    $dba = new DBAdapter();
    $cdba = new Controls();
    $createdby = $dba->createdby();
    $_GET['item_created_by'] = $createdby;
    unset($_GET['action']);
    unset($_GET['id']);
    $sql1 = "INSERT INTO create_item (item_name,cat_id,item_unit_id,item_created_by,remark,hsn_code) VALUES ('" . $_GET['item_name'] . "','" . $_GET['cat_id'] . "','" . $_GET['item_unit_id'] . "','" . $_GET['item_created_by'] . "','" . $_GET['remark'] . "','" . $_GET['hsn_code'] . "')";
    mysqli_query($con, $sql1);
} elseif ($_GET['action'] == 'edit') {

    include_once '../shreeLib/DBAdapter.php';
    $dba = new DBAdapter();
    $cdba = new Controls();
    $id = $_GET['id'];
    unset($_GET['action']);
    $sql2 = "update create_item set item_name='" . $_GET['item_name'] . "',cat_id='" . $_GET['cat_id'] . "',item_unit_id='" . $_GET['item_unit_id'] . "', remark='" . $_GET['remark'] . "', hsn_code='" . $_GET['hsn_code'] . "' where id=" . $id;
    mysqli_query($con, $sql2);
//    echo $sql2;
}
?>

