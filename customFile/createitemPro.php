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
//        header('location:../AddItems.php');
    } else {

        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }

    echo json_encode($responce);

    unset($_POST);
}
?>

