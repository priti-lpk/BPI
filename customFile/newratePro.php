<?php

ob_start();
include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/Controls.php';

if ($_POST['action'] == "new_rate") {
    include_once '../shreeLib/DBAdapter.php';
    $dba = new DBAdapter();
    $field = array("new_rate" => $_POST['new_rate']);
    $result = $dba->updateRow("add_quotation", $field, "id=" . $_POST['qid']);

    $responce = array();
    if ($result) {
        $responce = array("status" => TRUE, "msg" => "Operation Successful!");
    } else {
        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }
    echo json_encode($responce);
}
?>