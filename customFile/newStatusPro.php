<?php

ob_start();
include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/Controls.php';
if ($_POST['action'] == "status") {
    $dba = new DBAdapter();
    $field = array("new_qty" => $_POST['qty'],"note" => $_POST['note'], "status" => $_POST['status']);
    $result = $dba->updateRow("send_party_item_list", $field, "id='" . $_POST['sid']."'");

    $responce = array();
    if ($result) {
        $responce = array("status" => TRUE, "msg" => "Operation Successful!");
    } else {
        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }
    echo json_encode($responce);
}
?>