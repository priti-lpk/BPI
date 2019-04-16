<?php

include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/Controls.php';
date_default_timezone_set('Asia/Kolkata');
if ($_POST['action'] == 'add') {

    $dba = new DBAdapter();
    //echo $_POST['branch_status'];
    if ($_POST['branch_status'] == "true") {

        $_POST['branch_status'] = "true";
    } else {

        $_POST['branch_status'] = "false";
    }

    if ($_POST['branch_status'] == "true") {

        $_POST['branch_created_date'] = date("Y-m-d H:i");
    } else {

        $_POST['branch_created_date'] = date("Y-m-d H:i");
    }


    unset($_POST['action']);

    $result = $dba->setData("create_branch", $_POST);

    $responce = array();

    if ($result) {

        $responce = array("status" => TRUE, "msg" => "Operation Successful!");
    } else {

        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }

    echo json_encode($responce);

    unset($_POST);
}
?>