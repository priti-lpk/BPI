<?php

ob_start();
include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/Controls.php';
if ($_POST['action'] == 'add') {
    if (!isset($_SESSION)) {
        session_start();
    }
    $dba = new DBAdapter();
    $cdba = new Controls();

    unset($_POST['action']);
//    $user = $_POST['supplier_id'];
    $_POST['supplier_id'] = implode(",", $_POST['supplier_id']);


    $sql1 = "INSERT INTO item_supplier (item_id, supplier_id,inq_id) VALUES ('" . $_POST['item_id'] . "','" . $_POST['supplier_id'] . "','" . $_POST['inquiry_id'] . "')";
    mysqli_query($con, $sql1);
    // print_r($sql1);
    //echo "<script>alert('Successfully Inserted Inquiry Details');top.location='../Dashboard.php';</script>";
    echo "<script>alert('Successfully Inserted Inquiry Details');top.location='../view/InquiryMainDetails.php';</script>";
} elseif ($_POST['action'] == 'edit') {

    $cdba = new Controls();
    $dba = new DBAdapter();
    $id = $_POST['id'];
    $_POST['supplier_id'] = implode(",", $_POST['supplier_id']);

    $query1 = "UPDATE item_supplier set item_id='" . $_POST['item_id'] . "', supplier_id='" . $_POST['supplier_id'] . "',inq_id='" . $_POST['inquiry_id'] . "' WHERE id=" . $id;
    mysqli_query($con, $query1);

    echo "<script>alert('Successfully Edited Inquiry Details');top.location='../view/InquiryMainDetails.php';</script>";
}
?>




