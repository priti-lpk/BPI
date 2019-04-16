<?php

include 'shreeLib/dbconn.php';
include_once 'shreeLib/DBAdapter.php';
$dba = new DBAdapter();
if (isset($_POST['action']) == 'mainstatus') {

    $field = array("status" => $_POST['status']);

    $result = $dba->updateRow("main_category", $field, "id=" . $_POST['sid']);

    $responce = array();

    if ($result) {

        $responce = array("status" => TRUE, "msg" => "Operation Successful!");
    } else {

        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }
    echo json_encode($responce);
} elseif (isset($_POST['action']) == 'substatus') {
    //echo $_POST['id'];
    $field = array("status" => $_POST['status']);

    $result = $dba->updateRow("sub_category", $field, "id=" . $_POST['sid']);

    $responce = array();

    if ($result) {

        $responce = array("status" => TRUE, "msg" => "Operation Successful!");
    } else {

        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }
    echo json_encode($responce);
}
?>