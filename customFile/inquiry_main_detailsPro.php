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
    $createdby = $dba->createdby();
    $_POST['createdby_user'] = $createdby;
    $last_id = $dba->getLastID("id", "inquiry_item_list", "1");
    unset($_POST['action']);

    $totalrow = count($_POST['inq_item_list_id']);
    for ($i = 0; $i < $totalrow; $i++) {
        unset($_POST['item_name'][$i]);
        unset($_POST['item_qnty'][$i]);
        $sql1 = "INSERT INTO inquiry_send_to (inq_id, inq_item_list_id, user_id, createdby_user, due_date) VALUES ('" . $_POST['id'] . "','" . $_POST['inq_item_list_id'][$i] . "'," . $_POST['user_id'][$i] . ",'" . $_POST['createdby_user'] . "','" . $_POST['due_date'][$i] . "')";
        mysqli_query($con, $sql1);
        //print_r($sql1);
    }
    header('location:../AddInquiry.php');
}
?>




