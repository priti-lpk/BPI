<?php

ob_start();
include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/Controls.php';

if ($_POST['action'] == "msg") {
    include_once '../shreeLib/DBAdapter.php';
    $dba = new DBAdapter();
    $field = array("message" => $_POST['message']);
    $result = $dba->updateRow("inquiry", $field, "id=" . $_POST['id']);

    $responce = array();
    if ($result) {
        $responce = array("status" => TRUE, "msg" => "Operation Successful!");
    } else {
        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }
    echo json_encode($responce);
}
?>