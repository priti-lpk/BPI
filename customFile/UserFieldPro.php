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
//    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = md5($_POST['user_login_password']);
    $_POST['user_login_password'] = $password;
    //print_r($password);
    if ($_POST['disable'] == 1) {
        $_POST['role_rights_id'] = '0';
    } elseif ($_POST['disable'] == 0) {
        $role = $_POST['role_rights_id'];
        $roles = implode(',', $role);

        $_POST['role_rights_id'] = $roles;
    }
    $userpass = md5($_POST['user_login_password']);
    unset($_POST['disable']);
    $result = $dba->setData("create_user", $_POST);
    //$sql1 = "INSERT INTO create_user (branch_id,roles_id,role_rights_id,user_fullname,user_contact,user_email,user_login_username,user_login_password,user_createdby) VALUES ('" . $_POST['branch_id'] . "','".$_POST['roles_id']."','".$roles."','" . $_POST['user_fullname'] . "','" . $_POST['user_contact'] . "','" . $_POST['user_email'] . "','" . $_POST['user_login_username'] . "','" . $userpass . "','" . $_POST['user_createdby'] . "')";
//        $sql1 = "INSERT INTO create_user (branch_id,user_fullname,user_contact,user_email,user_login_username,user_login_password,user_type,user_createdby,user_status) VALUES ('" . $_POST['branch_id'] . "','" . $_POST['user_fullname'] . "','" . $_POST['user_contact'] . "','" . $_POST['user_email'] . "','" . $_POST['user_login_username'] . "','" . $userpass . "','" . $_POST['user_type'] . "','" . $_POST['user_createdby'] . "','" . $_POST['user_status'] . "')";
    //mysqli_query($con, $sql1);
    //print_r($sql1);

    $mailToList = array();
    $email_subject = "Blue Parl International Import Export";
    $fromemail = "info@recommercexpo.com";
    $headers = "From: " . $fromemail . " \r\n";
    $headers .= "Reply-To: " . $fromemail . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $message = "Username: " . $_POST['user_login_username'] . "\r\n Password:" . $password . "\r\nBranch Name: " . $_POST['branch_id'] . "\r\nUrl: http://demo.bpiindia.in/";
    //echo $message;
    header('location:../UserField.php');
    //}
    //  }
} elseif ($_POST['action'] == 'edit') {

    $dba = new DBAdapter();


    $createdby = $dba->createdby();
    // print_r($createdby);
    $_POST['user_createdby'] = $createdby;
    $id = $_POST['id'];

//    $rowcount = $_POST['r_count'];
    $userpass = md5($_POST['user_login_password']);
//    if ($rowcount >= 1) {
    $query = "UPDATE create_user set branch_id='" . $_POST['branch_id'] . "',roles_id='" . $_POST['roles_id'] . "', user_fullname='" . $_POST['user_fullname'] . "',user_contact ='" . $_POST['user_contact'] . "', user_email='" . $_POST['user_email'] . "',user_login_password='" . $userpass . "',user_createdby='" . $_POST['user_createdby'] . "' WHERE id=" . $id;

//        $query = "UPDATE create_user set branch_id='" . $_POST['branch_id'] . "', user_contact ='" . $_POST['user_contact'] . "', user_email='" . $_POST['user_email'] . "',user_login_password='" . $userpass . "',user_type='" . $_POST['user_type'] . "',user_createdby='" . $_POST['user_createdby'] . "',user_status='" . $_POST['user_status'] . "' WHERE id=" . $id;
    //print_r($query);
    mysqli_query($con, $query);


    header('location:../UserField.php');
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



