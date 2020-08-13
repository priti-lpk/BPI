<?php

ob_start();
include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/Controls.php';
//print_r($_POST);
if ($_POST['action'] == 'add') {

    if (!isset($_SESSION)) {
        session_start();
    }
    $dba = new DBAdapter();
    $cdba = new Controls();
//    $reference_no = $_POST['reference_no'];
    unset($_POST['action']);
    unset($_POST['id']);
    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);

    $_POST['branch_id'] = $last_id;
    $_POST['quotation_date'] = date('Y-m-d', strtotime($_POST['quotation_date']));
//    $result = $dba->setData("add_quotation", $_POST);
    $sql1 = "INSERT INTO add_quotation (inquiry_item_id,inquiry_id,supplier_id,item_name,unit,qty,rate,quotation_date,remark,branch_id,reference_no,party_id,user_id) VALUES ('" . $_POST['inquiry_item_id'] . "','" . $_POST['inquiry_id'] . "','" . $_POST['supplier_id'] . "','" . $_POST['item_name'] . "','" . $_POST['unit'] . "','" . $_POST['qty'] . "','" . $_POST['rate'] . "','" . $_POST['quotation_date'] . "','" . $_POST['remark'] . "','" . $_POST['branch_id'] . "','" . $_POST['reference_no'] . "','" . $_POST['party_id'] . "','" . $_SESSION['user_id'] . "')";
    $result = mysqli_query($con, $sql1);
//    print_r($sql1);
//    $responce = array();
//    if ($result) {
//
//        $responce = array("status" => TRUE, "msg" => "Operation Successful!");
//        echo "<script>alert('Successfully Inserted Quotation');top.location='../view/Quotation.php?id='.;</script>";
    $last_id1 = mysqli_insert_id($con);
    $sql = "SELECT inquiry_item_id FROM add_quotation where id=" . $last_id1;
//    print_r($sql);
    $resultset = mysqli_query($con, $sql);
    $dat = mysqli_fetch_array($resultset);
//        $last_id1 = $dba->getLastID("inquiry_id", "add_quotation", "user_id=" . $_SESSION['user_id']);
    header('location:../Quotation.php?inquiry_id=' . $dat['inquiry_item_id']);
//    } else {
//
//        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
//    }
//
//    echo json_encode($responce);
//
//    unset($_POST);
} elseif ($_POST['action'] == 'edit') {

    include_once '../shreeLib/DBAdapter.php';

    $dba = new DBAdapter();

    $id = $_POST['id'];

    if (!isset($_SESSION)) {
        session_start();
    }
    $cdba = new Controls();

    unset($_POST['action']);
    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);

    $_POST['branch_id'] = $last_id;
    $_POST['quotation_date'] = date('Y-m-d', strtotime($_POST['quotation_date']));
    if ($dba->updateRow("add_quotation", $_POST, "id=" . $id)) {
        $msg = "Edit Successfully";
        echo "<script>alert('Successfully Edited Quotation');top.location='../view/Quotation.php';</script>";
    } else {
        $msg = "Edit Fail Try Again";
    }
}
?>



