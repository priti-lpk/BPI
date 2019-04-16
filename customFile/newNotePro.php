<?php

ob_start();
include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/Controls.php';
if ($_POST['action'] == "note") {
    $dba = new DBAdapter();
    $field = array("note" => $_POST['note'], "status" => $_POST['status']);
    $result = $dba->updateRow("link_master", $field, "s_id='" . $_POST['sid']."'");

    $responce = array();
    if ($result) {
        $responce = array("status" => TRUE, "msg" => "Operation Successful!");
    } else {
        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }
    echo json_encode($responce);
}
?>