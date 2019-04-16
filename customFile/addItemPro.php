<?php

ob_start();

include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/Controls.php';

if ($_POST['action'] == 'add') {

    $dba = new DBAdapter();
    $cdba = new Controls();

    $createdby = $dba->createdby();

    $_POST['item_created_by'] = $createdby;

    unset($_POST['action']);
    unset($_POST['id']);
//    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
//
//    $_POST['branch_id'] = $last_id;
    $result = $dba->setData("create_item", $_POST);

    $responce = array();

    if ($result) {

        $responce = array("status" => TRUE, "msg" => "Operation Successful!");
//        header('location:../Items.php');
        echo "<script>alert('Successfully Inserted Item');top.location='../Items.php';</script>";
    } else {

        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }

    echo json_encode($responce);

    unset($_POST);
} elseif ($_POST['action'] == 'edit') {

    include_once '../shreeLib/DBAdapter.php';

    $dba = new DBAdapter();

    $cdba = new Controls();

    $id = $_POST['id'];

    $create = $_POST['item_name'];



    unset($_POST['action']);
    $last_id = $dba->getLastID("branch_id", "create_user", "1");

    //$_POST['branch_id'] = $last_id;
    if ($dba->updateRow("create_item", $_POST, "id=" . $id)) {
        $msg = "Edit Successfully";
        echo "<script>alert('Successfully Edited Item');top.location='../Items.php';</script>";
    } else {
        $msg = "Edit Fail Try Again";
    }
}
?>

