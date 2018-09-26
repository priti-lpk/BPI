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
        header('location:../AddItems.php');
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

    $createdby = $dba->createdby($_SESSION['user_login_username']);
    $_POST['item_created_by'] = $createdby;

    unset($_POST['action']);
    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);

    $_POST['branch_id'] = $last_id;
    if ($dba->updateRow("create_item", $_POST, "id=" . $id)) {
        $msg = "Edit Successfully";
        header("location:../AddItems.php");
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

