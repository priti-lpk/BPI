<?php

//include '../shreeLib/session_info.php';
include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
date_default_timezone_set('Asia/Kolkata');
if ($_POST['action'] == 'add') {
    $dba = new DBAdapter();

    $createdby = $dba->createdby();
    unset($_POST['action']);
    unset($_POST['id']);
    $_POST['user_createdby'] = $createdby;
    $password = md5($_POST['user_login_password']);
    $_POST['user_login_password'] = $password;
    if ($_POST['disable'] == 1) {
        $role = "0";

        $rolestring = json_encode($role, TRUE);
        //print_r($rolestring);
        $_POST['role_rights_id'] = $rolestring;
    } elseif ($_POST['disable'] == 0) {
        $role = $_POST['role_rights_id'];
       // print_r($role);

        $rolestring = json_encode($role, TRUE);
       // print_r($rolestring);
        $_POST['role_rights_id'] = $rolestring;
    }


    $userpass = md5($_POST['user_login_password']);
    unset($_POST['disable']);
    //print_r($_POST);
    $result = $dba->setData("create_user", $_POST);


    $last_id = $dba->getLastID("id", "create_user", "1");

    $rowcount = count($role);


    $mailToList = array();
    $email_subject = "Blue Parl International Import Export";
    $fromemail = "info@recommercexpo.com";
    $headers = "From: " . $fromemail . " \r\n";
    $headers .= "Reply-To: " . $fromemail . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $message = "Username: " . $_POST['user_login_username'] . "\r\n Password:" . $password . "\r\nBranch Name: " . $_POST['branch_id'] . "\r\nUrl: http://demo.bpiindia.in/";
//    header('location:../UserField.php'); 
    echo "<script>alert('Successfully Inserted User');top.location='../UserField.php';</script>";
   
} elseif ($_POST['action'] == 'edit') {

    $dba = new DBAdapter();
    unset($_POST['action']);

    $createdby = $dba->createdby();
    $_POST['user_createdby'] = $createdby;
    $id = $_POST['id'];
    if ($_POST['disable'] == 1) {
        $role = "0";

        $rolestring = json_encode($role, TRUE);
       // print_r($rolestring);
        $_POST['role_rights_id'] = $rolestring;
    } elseif ($_POST['disable'] == 0) {
        $role = $_POST['role_rights_id'];
        //print_r($role);

        $rolestring = json_encode($role, TRUE);
       // print_r($rolestring);
        $_POST['role_rights_id'] = $rolestring;
    }
    $userpass = md5($_POST['user_login_password']);
    $_POST['user_login_password'] = $userpass;
    unset($_POST['disable']);
    $result = $dba->updateRow("create_user", $_POST, "id=" . $id);
  //  print_r($result);
//    $last_id = $dba->getLastID("id", "create_user", "1");
//
//    $rowcount = count($role);
//    for ($i = 1; $i <= $rowcount; $i++) {
//
//        $modid = $role[$i - 1];
//
//        $role_create = 1;
//        $role_edit = 1;
//        $role_view = 1;
//        $role_delete = 1;
//        $result = $dba->updateRow("role_rights", $_POST, "id=" . $id);
//    }
    echo "<script>alert('Successfully Edited User');top.location='../UserField.php';</script>";
} elseif ($_POST['action'] == "changeStatus") {

    include_once '../shreeLib/DBAdapter.php';

    $dba = new DBAdapter();

    $field = array("user_status" => $_POST['ustatus'], "user_created_date" => date("Y-m-d H:i"));

    $result = $dba->updateRow("create_user", $field, "id=" . $_POST['uid']);

    $responce = array();

    if ($result) {

        $responce = array("status" => TRUE, "msg" => "Operation Successful!");
    } else {

        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }

    echo json_encode($responce);
}
?>



