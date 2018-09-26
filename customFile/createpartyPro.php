<?php

ob_start();
include '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/Controls.php';

if ($_POST['action'] == 'add') {

    if (!isset($_SESSION)) {
        session_start();
    }

    $dba = new DBAdapter();
    $cdba = new Controls();
    $create = $_POST['party_name'];

    $createdby = $dba->createdby();   // print_r($createdby);
    $_POST['party_created_by'] = $createdby;
    
    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);

    $_POST['branch_id'] = $last_id;

    unset($_POST['action']);
    unset($_POST['id']);
    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);

    $_POST['branch_id'] = $last_id;
    $result = $dba->setData("create_party", $_POST);

    $responce = array();

    if ($result) {

        $responce = array("status" => TRUE, "msg" => "Operation Successful!");

//        header('location:../AddParty.php');
    } else {

        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }

    echo json_encode($responce);

//    unset($_POST);
}
?>

