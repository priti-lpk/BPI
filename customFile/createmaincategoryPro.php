<?php
  
ob_start();
include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/Controls.php';
if ($_POST['action'] == 'add') {

    $dba = new DBAdapter();
    unset($_POST['action']);

    if (!isset($_SESSION)) {
        session_start();
    }

    $createdby = $dba->createdby();

    $_POST['created_by'] = $createdby;

    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);

    $_POST['branch_id'] = $last_id;

    $result = $dba->setData("main_category", $_POST);

    $responce = array();

    if ($result) {

        $responce = array("status" => TRUE, "msg" => "Operation Successful!");
    } else {

        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }

    echo json_encode($responce);
    unset($_POST);
}
?>

