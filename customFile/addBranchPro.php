<?php

include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/Controls.php';
date_default_timezone_set('Asia/Kolkata');
if ($_POST['action'] == 'add') {

    $dba = new DBAdapter();
    if (isset($_POST['branch_status'])) {

        if ($_POST['branch_status'] == "on") {

            $_POST['branch_status'] = "true";
        } else {

            $_POST['branch_status'] = "false";
        }

        if ($_POST['branch_status'] == "true") {

            $_POST['branch_created_date'] = date("Y-m-d H:i");
        } else {

            $_POST['branch_created_date'] = "";
        }
    } else
        $_POST['branch_status'] = "false";
    unset($_POST['action']);
    unset($_POST['id']);
    $result = $dba->setData("create_branch", $_POST);

    $responce = array();

    if ($result) {

        $responce = array("status" => TRUE, "msg" => "Operation Successful!");
        header('location:../AddBranch.php');
    } else {

        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }

    echo json_encode($responce);

    unset($_POST);
} elseif ($_POST['action'] == 'edit') {
    include_once '../shreeLib/DBAdapter.php';

    $dba = new DBAdapter();

    if ($_POST['branch_status'] == "on") {

        $_POST['branch_status'] = "true";
    } else {

        $_POST['branch_status'] = "false";
    }    

    $id = $_POST['id'];


    unset($_POST['action']);


    if ($dba->updateRow("create_branch", $_POST, "id=" . $id)) {
        $msg = "Edit Successfully";
        header("location:../AddBranch.php");
    } else {
        $msg = "Edit Fail Try Again";
    }
} elseif ($_POST['action'] == "changeStatus") {

    include_once '../shreeLib/DBAdapter.php';

    $dba = new DBAdapter();

    $field = array("branch_status" => $_POST['bstatus']);

    $result = $dba->updateRow("create_branch", $field, "id=" . $_POST['bid']);

    $responce = array();

    if ($result) {

        $responce = array("status" => TRUE, "msg" => "Operation Successful!");
    } else {

        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }

    echo json_encode($responce);
}
?>


