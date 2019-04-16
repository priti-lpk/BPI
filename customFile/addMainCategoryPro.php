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

    unset($_POST['action']);
    unset($_POST['id']);

    $createdby = $dba->createdby();

    $_POST['created_by'] = $createdby;

    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);

    $_POST['branch_id'] = $last_id;

    $result = $dba->setData("main_category", $_POST);
    //print_r($result);

    $responce = array();

    if ($result) {

        $responce = array("status" => TRUE, "msg" => "Operation Successful!");
        echo "<script>alert('Successfully Inserted Main Category');top.location='../MainCategory.php';</script>";

//        header('location:../MainCategory.php');
    } else {

        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }

    echo json_encode($responce);

    unset($_POST);
} elseif ($_POST['action'] == 'edit') {

    include_once '../shreeLib/DBAdapter.php';

    $dba = new DBAdapter();

    $id = $_POST['id'];

    if (!isset($_SESSION)) {
        session_start();
    }
    $cdba = new Controls();
    $create = $_POST['name'];

    $createdby = $dba->createdby($_SESSION['user_login_username']);   // print_r($createdby);

    $_POST['created_by'] = $createdby;


    unset($_POST['action']);

    if ($dba->updateRow("main_category", $_POST, "id=" . $id)) {
        $msg = "Edit Successfully";
        echo "<script>alert('Successfully Edited Main Category');top.location='../MainCategory.php';</script>";
    } else {
        $msg = "Edit Fail Try Again";
    }
} elseif ($_POST['action'] == 'delete') {

    include_once '../shreeLib/DBAdapter.php';

    $dba = new DBAdapter();

    $id = $_POST['id'];


    unset($_POST['action']);

    unset($_POST['item_id']);

    $result = $dba->deleteRow("item_list", $id);

    $responce = array();

    if ($result) {

        $responce = array("status" => TRUE, "msg" => "Operation Successful!");

        header('location:../AddItems');
    } else {

        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }

    echo json_encode($responce);
}
?>






