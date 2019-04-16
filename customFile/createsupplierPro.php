<?php

include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/Controls.php';
//print_r("sadds");
if ($_POST['action'] == 'add') {

    if (!isset($_SESSION)) {
        session_start();
    }

    $dba = new DBAdapter();
    $cdba = new Controls();
    $create = $_POST['sup_name'];

    $createdby = $dba->createdby($_SESSION['user_login_username']);   // print_r($createdby);
    $_POST['created_user'] = $createdby;

    unset($_POST['action']);
    unset($_POST['id']);
    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);

    $_POST['branch_id'] = $last_id;
    $result = $dba->setData("supplier", $_POST);

    $responce = array();

    if ($result) {

        $responce = array("status" => TRUE, "msg" => "Operation Successful!");

        //header('location:../Supplier.php');
    } else {

        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }

    echo json_encode($responce);

    unset($_POST);
}
?>

