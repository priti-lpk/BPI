<?php

ob_start();
include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/Controls.php';
if ($_POST['action'] == 'add') {
    $dba = new DBAdapter();
    unset($_POST['action']);
    unset($_POST['id']);
    $result = $dba->setData("create_godawn", $_POST);
    $responce = array();
    if ($result) {
        $responce = array("status" => TRUE, "msg" => "Operation Successful!");
//        header('location:../Godawn.php');
        echo "<script>alert('Successfully Inserted Godawn');top.location='../Godawn.php';</script>";
    } else {
        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }
    echo json_encode($responce);
    unset($_POST);
} elseif ($_POST['action'] == 'edit') {
    include_once '../shreeLib/DBAdapter.php';
    $dba = new DBAdapter();
    $id = $_POST['id'];
    unset($_POST['action']);
    if ($dba->updateRow("create_godawn", $_POST, "id=" . $id)) {
        $msg = "Edit Successfully";
        echo "<script>alert('Successfully Edited Godawn');top.location='../Godawn.php';</script>";
    } else {
        $msg = "Edit Fail Try Again";
    }
}
?>

