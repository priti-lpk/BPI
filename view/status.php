<?php

ob_start();
include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/Controls.php';

if (isset($_POST['action']) == 'mainstatus') {
    if (isset($_POST['status'])) {
        if ($_POST['status'] == "on") {

            $_POST['status'] = "on";
        } else {

            $_POST['status'] = "off";
        }
    } else
        $_POST['status'] = "off";

    $field = array("status" => $_POST['status']);
    $result = $dba->updateRow("inquiry", $field, "id=" . $_POST['sid']);
    if ($result) {
        $responce = "Success";
    } else {

        $responce = "Fail";
    }
    echo $responce;
}
?>


