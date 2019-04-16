<?php

ob_start();
include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
if ($_POST['action'] == 'add') {
    $dba = new DBAdapter();

    $createdby = $dba->createdby();
    unset($_POST['action']);
    unset($_POST['id']);
    $role = $_POST['role_rights_id'];
    $rolestring = json_encode($role, TRUE);
    $_POST['role_rights_id'] = $rolestring;
    $result = $dba->setData("create_user", $_POST);
    echo "<script>alert('Successfully Inserted Data');top.location='getdata.php';</script>";
} elseif ($_POST['action'] == 'edit') {
    $dba = new DBAdapter();
    unset($_POST['action']);
    $id = $_POST['id'];
    $role = $_POST['role_rights_id'];
    $rolestring = json_encode($role, TRUE);
    $_POST['role_rights_id'] = $rolestring;
    $result = $dba->updateRow("create_user", $_POST, "id=" . $id);
    echo "<script>alert('Successfully Edited Data');top.location='getdata.php';</script>";
}
?>



