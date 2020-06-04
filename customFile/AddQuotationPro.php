<?php

ob_start();
include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/Controls.php';
//print_r($_POST);
if ($_POST['action'] == 'add') {

    if (!isset($_SESSION)) {
        session_start();
    }
    $dba = new DBAdapter();
    $cdba = new Controls();
//    $reference_no = $_POST['reference_no'];
    unset($_POST['action']);
    unset($_POST['id']);
    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);

    $_POST['branch_id'] = $last_id;
    $_POST['quotation_date'] = date('Y-m-d', strtotime($_POST['quotation_date']));
   // echo $_POST['quotation_date'];
    $result = $dba->setData("add_quotation", $_POST);

    $responce = array();

    if ($result) {

        $responce = array("status" => TRUE, "msg" => "Operation Successful!");
        echo "<script>alert('Successfully Inserted Quotation');top.location='../view/Quotation.php';</script>";

//        header('location:../view/Quotation.php');
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

    unset($_POST['action']);
    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);

    $_POST['branch_id'] = $last_id;
    $_POST['quotation_date'] = date('Y-m-d', strtotime($_POST['quotation_date']));
    if ($dba->updateRow("add_quotation", $_POST, "id=" . $id)) {
        $msg = "Edit Successfully";
        echo "<script>alert('Successfully Edited Quotation');top.location='../view/Quotation.php';</script>";
    } else {
        $msg = "Edit Fail Try Again";
    }
}
?>



