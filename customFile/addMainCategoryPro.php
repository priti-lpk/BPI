<?php

ob_start();
include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/Controls.php';

if ($_POST['action'] == 'add') {
    
     if (!isset($_SESSION)) {
        session_start();
    }

    $dba = new DBAdapter();

    unset($_POST['action']);
    unset($_POST['id']);
   
    $createdby = $dba->createdby();   

    $_POST['created_by'] = $createdby;
    
    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);

    $_POST['branch_id'] = $last_id;

    $result = $dba->setData("main_category", $_POST);
    print_r($result);

    $responce = array();

    if ($result) {

        $responce = array("status" => TRUE, "msg" => "Operation Successful!");
        header('location:../AddMainCategory.php');
    } else {

        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }

    echo json_encode($responce);

    unset($_POST);
} elseif ($_POST['action'] == 'edit') {

    include_once '../shreeLib/DBAdapter.php';

    $dba = new DBAdapter();

    $id = $_POST['id'];

    if (!isset($_SESSION)) {
        session_start();
    }
    $cdba = new Controls();
    $create = $_POST['name'];

    $createdby = $dba->createdby($_SESSION['user_login_username']);   // print_r($createdby);

    $_POST['created_by'] = $createdby;
//    $user = $_SESSION['user_name'];
//
//    $ip_id = $cdba->get_client_ip();
//
//    $last_id = $dba->getLastID("user_info", "category_list", "id=" . $id);
//
//    $json = json_decode($last_id, true);
//
//    echo '</br>';
//    $crate_user = array_slice($json, 0, 3);
//
//
//    date_default_timezone_set('Asia/Kolkata');
//    $date = date('d-m-Y h:i:s');
//
//    $user_array = array($user, $ip_id, $date);
//
//    $merge = array_merge($crate_user, $user_array);
//    //print_r($merge);
//    $user_edit = json_encode($merge, TRUE);
////    print_r($user_edit);
////    echo '</br>';
    ////$_POST['user_info'] = $user_edit;



    unset($_POST['action']);

    if ($dba->updateRow("main_category", $_POST, "id=" . $id)) {
        $msg = "Edit Successfully";
        header("location:../AddMainCategory.php");
    } else {
        $msg = "Edit Fail Try Again";
    }
} elseif ($_POST['action'] == 'delete') {

    include_once '../shreeLib/DBAdapter.php';

    $dba = new DBAdapter();

    $id = $_POST['id'];


    unset($_POST['action']);

    unset($_POST['item_id']);

    $result = $dba->deleteRow("item_list", $id);

    $responce = array();

    if ($result) {

        $responce = array("status" => TRUE, "msg" => "Operation Successful!");

        header('location:../AddItems');
    } else {

        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }

    echo json_encode($responce);
}
?>






