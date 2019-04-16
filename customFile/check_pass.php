<?php

ob_start();
if (!isset($_SESSION)) {
    session_start();
}
include '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/Controls.php';
$dba = new DBAdapter();
if ($_POST['action'] == 'check') {

    unset($_POST['action']);
    $_POST['pass'] = md5($_POST['pass']);
    $pass = $_POST['pass'];

    $field = array("*");
    $data = $dba->getRow("system_user", $field, "id=2");

    $responce = array();
    if ($pass == $data[0][2]) {

        $responce = array("status" => TRUE, "msg" => "Operation Successful!");
        $_SESSION['user_checkpass'] = $pass;
    } else {

        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }

    echo json_encode($responce);
//
    unset($_POST);
}
?>

