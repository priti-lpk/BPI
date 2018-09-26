<?php
ob_start();
//include '../shreeLib/session_info.php';
include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/Controls.php';
if ($_POST['action'] == 'add') {

    if (!isset($_SESSION)) {
        session_start();
    }
    $dba = new DBAdapter();

    $createdby = $dba->createdby();

    $_POST['created_by'] = $createdby;
    
     $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);

    $_POST['branch_id'] = $last_id;

    unset($_POST['action']);
    
    $result = $dba->setData("sub_category", $_POST);
    
    unset($_POST);
    
    $responce = array();

    if ($result) {

        $responce = array("status" => TRUE, "msg" => "Operation Successful!");
    } else {

        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }

    echo json_encode($responce);
}
?>



