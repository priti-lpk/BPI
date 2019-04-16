<?php

include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/Controls.php';

if ($_POST['action'] == 'add') {

    if (!isset($_SESSION)) {
        session_start();
    }

    $dba = new DBAdapter();
    $cdba = new Controls();
    $create = $_POST['party_name'];

    $createdby = $dba->createdby($_SESSION['user_login_username']);   // print_r($createdby);
    $_POST['party_created_by'] = $createdby;

//    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
//
//    $_POST['branch_id'] = $last_id;
    // $id = $_POST['id'];
    unset($_POST['action']);
    unset($_POST['id']);
    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);

    $_POST['branch_id'] = $last_id;
    $result = $dba->setData("create_party", $_POST);

    $responce = array();

    if ($result) {

        $responce = array("status" => TRUE, "msg" => "Operation Successful!");
        echo "<script>alert('Successfully Inserted Party');top.location='../Party.php';</script>";

//        header('location:../Party.php');
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
    $create = $_POST['party_name'];

    $createdby = $dba->createdby($_SESSION['user_login_username']);   // print_r($createdby);

    $_POST['party_created_by'] = $createdby;
    unset($_POST['action']);
    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);

    $_POST['branch_id'] = $last_id;
    if ($dba->updateRow("create_party", $_POST, "id=" . $id)) {
        $msg = "Edit Successfully";
        echo "<script>alert('Successfully Edited Party');top.location='../Party.php';</script>";
    } else {
        $msg = "Edit Fail Try Again";
    }
} elseif ($_POST['action'] == 'delete') {

    include_once '../shreeLib/DBAdapter.php';

    $dba = new DBAdapter();

    $id = $_POST['party_id'];


    unset($_POST['action']);

    unset($_POST['party_id']);

    $result = $dba->deleteRow("party_list", $_POST, "id=" . $id);

    $responce = array();

    if ($result) {

        $responce = array("status" => TRUE, "msg" => "Operation Successful!");

        header('location:../AddParty.php');
    } else {

        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }

    echo json_encode($responce);
}
?>



