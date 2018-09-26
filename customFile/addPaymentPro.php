<?php
ob_start();
include_once '../shreeLib/Controls.php';
include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
if ($_POST['action'] == 'add') {

    $dba = new DBAdapter();

    $cdba = new Controls();

    $user = $_POST['user_info'];

    $ip_id = $cdba->get_client_ip();

    date_default_timezone_set('Asia/Kolkata');
    $date = date('d-m-Y h:i:s');

    $user_array = array($user, $ip_id, $date);

    $user_string = json_encode($user_array, TRUE);

    $_POST['user_info'] = $user_string;
    $_POST['user_action'] = "Create";

    unset($_POST['action']);

    unset($_POST['payment_id']);

    unset($_POST['tag_pay_amount']);

    unset($_POST['tag_pay_type']);

    $result = $dba->setData("payment_list", $_POST);
    $responce = array();

    if ($_POST['pay_crdb'] == 'Debit') {

        $pid = $_POST['party_id'];
        $pamount = $_POST['pay_amount'];
        $pdisc = $_POST['pay_discount'];
        $total = $pamount * ($pdisc / 100);
        $dba->updatePartyAmount($pid, $pamount + $total, 'Debit');
    } else if ($_POST['pay_crdb'] == 'Credit') {
        $pid = $_POST['party_id'];
        $pamount = $_POST['pay_amount'];
        $pdisc = $_POST['pay_discount'];
        $total = $pamount * ($pdisc / 100);
        $dba->updatePartyAmount($pid, $pamount + $total, 'Credit');
    }

    if ($result) {

        $responce = array("status" => TRUE, "msg" => "Operation Successful!");

        $mobno = $dba->getLastID("party_contact", "party_list", "id=" . $_POST['party_id']);
        $partyname = $dba->getLastID("party_name", "party_list", "id=" . $_POST['party_id']);
       
        $msg = $partyname . " Your Payment Rs. " . $_POST['pay_amount'] . " is Successfully.!!";
        
        $cdba->sendsms($mobno, "DEMOOS", "1", $msg, "sms.shreesoftech.com", "27a97f896f4d26c7ec084ffa4b4a69");
        
        header('location:../AddPayment.php');
    } else {

        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }

    echo json_encode($responce);

    unset($_POST);
} elseif ($_POST['action'] == 'edit') {

    include_once '../shreeLib/DBAdapter.php';
    $cdba = new Controls();

    $dba = new DBAdapter();

    $id = $_POST['payment_id'];
    $user = $_POST['user_info'];

    $ip_id = $cdba->get_client_ip();

    $last_id = $dba->getLastID("user_info", "payment_list", "id=" . $id);

    $json = json_decode($last_id, true);

    echo '</br>';
    $crate_user = array_slice($json, 0, 3);


    date_default_timezone_set('Asia/Kolkata');
    $date = date('d-m-Y h:i:s');

    $user_array = array($user, $ip_id, $date);

    $merge = array_merge($crate_user, $user_array);
    print_r($merge);
    $user_edit = json_encode($merge, TRUE);
    print_r($user_edit);
    echo '</br>';
    $_POST['user_info'] = $user_edit;
    $_POST['user_action'] = "Edit";

    unset($_POST['action']);

    unset($_POST['payment_id']);

    $pid = $_POST['party_id'];
    $newamount = $_POST['pay_amount'];
    $oldamout = $_POST['tag_pay_amount'];
    $dis = $_POST['pay_discount'];
    if ($_POST['tag_pay_type'] == $_POST['pay_crdb']) {

        $amount = ($newamount + $dis) - $oldamout;

        $dba->updatePartyAmount($pid, $amount, $_POST['pay_crdb']);
    } elseif ($_POST['tag_pay_type'] != $_POST['pay_crdb']) {

        $dba->updatePartyAmount($pid, $newamount + $oldamout, $_POST['pay_crdb']);
    }

    unset($_POST['tag_pay_amount']);

    unset($_POST['tag_pay_type']);

    $result = $dba->updateRow("payment_list", $_POST, "id=" . $id);

    $responce = array();

    if ($result) {

        $responce = array("status" => TRUE, "msg" => "Operation Successful!");

        header('location:../payment_list.php');
    } else {

        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }
    echo json_encode($responce);
    header('location:../AddPayment.php');
} elseif ($_POST['action'] == 'delete') {

    include_once '../shreeLib/DBAdapter.php';

    $dba = new DBAdapter();

    $id = $_POST['payment_id'];

    unset($_POST['action']);

    unset($_POST['payment_id']);

    $result = $dba->deleteRow("payment_list", $_POST, "id=" . $id);


    $responce = array();

    if ($result) {

        $responce = array("status" => TRUE, "msg" => "Operation Successful!");

        header('location:../payment_list.php');
    } else {

        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }

    echo json_encode($responce);
}
?>



