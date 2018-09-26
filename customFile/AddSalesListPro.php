<?php
ob_start();
include_once '../shreeLib/Controls.php';
include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
if ($_POST['action'] == 'add') {

    if (!isset($_SESSION)) {
        session_start();
    }

    $cdba = new Controls();
    $user = $_POST['user_info'];

    $ip_id = $cdba->get_client_ip();

    date_default_timezone_set('Asia/Kolkata');
    $date = date('d-m-Y h:i:s');
    $user_array = array($user, $ip_id, $date);

    $user_string = json_encode($user_array, TRUE);
    $_POST['user_action'] = "Create";

    $dba = new DBAdapter();

    $sql1 = "INSERT INTO sales_list (order_id, party_id, s_invoice_no, sale_date, total_amount, pay_type, pay_tax, note, vehicle_no, lr_no , user_info, user_action, user_id ) VALUES ('" . $_POST['order_id'] . "','" . $_POST['party_id'] . "','" . $_POST['s_invoice_no'] . "','" . $_POST['sale_date'] . "','" . $_POST['total_amount'] . "','" . $_POST['pay_type'] . "','" . $_POST['pay_tax'] . "','" . $_POST['note'] . "','" . $_POST['vehicle_no'] . "','" . $_POST['lr_no'] . "','" . $user_string . "','" . $_POST['user_action'] . "'," . $_SESSION['user_id'] . ")";
    mysqli_query($con, $sql1);

    $sql_update = "UPDATE sales_order_list SET order_status='Complate' WHERE id=" . $_POST['order_id'];

    mysqli_query($con, $sql_update);

    $last_id = $dba->getLastID("id", "sales_list", "1");

    $totalrow = count($_POST['item_name']);

    $rowcount = $_POST['rowcount_no'];

    for ($i = 0; $i < $totalrow; $i++) {

        $sql = "INSERT INTO  sales_item_list (sl_id , item_id , item_qnty, item_rate, sub_total , gst , total ) VALUES ('" . $last_id . "','" . $_POST['item_id'][$i] . "','" . $_POST['item_qnty'][$i] . "','" . $_POST['item_rate'][$i] . "','" . $_POST['sub_total'][$i] . "','" . $_POST['gst'][$i] . "','" . $_POST['total'][$i] . "')";

        mysqli_query($con, $sql);

        $itemid = $_POST['item_id'][$i];

        $itemqnty = $_POST['item_qnty'][$i];

        $qnty = ($itemqnty);

        $dba->updateStock($itemid, $qnty);
    }

    if ($_POST['pay_type'] == 'Credit') {
        $pid = $_POST['party_id'];
        $pamount = $_POST['total_amount'];
        $dba->updatePartyAmount($pid, $pamount, 'Debit');
    }

    $mobno = $dba->getLastID("party_contact", "party_list", "id=" . $_POST['party_id']);
    $partyname = $dba->getLastID("party_name", "party_list", "id=" . $_POST['party_id']);

    $msg = "Thanks For Sales Product with Our Company. " . $partyname . " Your Sales  Amount is Rs. " . $_POST['total_amount'];
  //  echo $msg;
    $cdba->sendsms($mobno, "DEMOOS", "1", $msg, "sms.shreesoftech.com", "27a97f896f4d26c7ec084ffa4b4a69");

    header('location:../AddSalesList.php');
} elseif ($_POST['action'] == 'edit') {

    $c = count($_POST['item_name']);
    $cdba = new Controls();
    $dba = new DBAdapter();

    $id = $_POST['id'];
    $user = $_POST['user_info'];

    $ip_id = $cdba->get_client_ip();

    $last_id = $dba->getLastID("user_info", "sales_list", "id=" . $id);

    $json = json_decode($last_id, true);

    echo '</br>';
    $crate_user = array_slice($json, 0, 3);


    date_default_timezone_set('Asia/Kolkata');
    $date = date('d-m-Y h:i:s');

    $user_array = array($user, $ip_id, $date);

    $merge = array_merge($crate_user, $user_array);
    // print_r($merge);
    $user_edit = json_encode($merge, TRUE);
    //  print_r($user_edit);
    echo '</br>';
    $_POST['user_info'] = $user_edit;
    $_POST['user_action'] = "Edit";

    $rowcount = $_POST['rowcount_no'];

    if ($c >= 1) {
        $query = "UPDATE sales_list set party_id='" . $_POST['party_id'] . "', s_invoice_no='" . $_POST['s_invoice_no'] . "', sale_date='" . $_POST['sale_date'] . "',total_amount='" . $_POST['total_amount'] . "',pay_type='" . $_POST['pay_type'] . "',pay_tax='" . $_POST['pay_tax'] . "', note='" . $_POST['note'] . "', vehicle_no='" . $_POST['vehicle_no'] . "', lr_no='" . $_POST['lr_no'] . "', user_info='" . $_POST['user_info'] . "' ,user_action='" . $_POST['user_action'] . "' WHERE id=" . $id;
        print_r($query);
        mysqli_query($con, $query);

        for ($i = 0; $i < $rowcount; $i++) {
            $id1 = $_POST['s_id'][$i];
            $query1 = "UPDATE sales_item_list set item_id='" . $_POST['item_id'][$i] . "', item_qnty='" . $_POST['item_qnty'][$i] . "', item_rate='" . $_POST['item_rate'][$i] . "',sub_total='" . $_POST['sub_total'][$i] . "',gst='" . $_POST['gst'][$i] . "', total='" . $_POST['total'][$i] . "' WHERE id=" . $id1;
            mysqli_query($con, $query1);

            $itemid = $_POST['item_id'][$i];
            $qntynew = $_POST['item_qnty'][$i];
            $qntyold = $_POST['s_qnty'][$i];

            $qnty = ($qntynew - $qntyold);
            $dba->updateStock($itemid, $qnty);
        }
        if ($rowcount < $c) {
            for ($i = $rowcount; $i < $c; $i++) {
                $sql1 = "INSERT INTO  sales_item_list (sl_id , item_id , item_qnty, item_rate, sub_total , gst , total ) VALUES ('" . $id . "','" . $_POST['item_id'][$i] . "','" . $_POST['item_qnty'][$i] . "','" . $_POST['item_rate'][$i] . "','" . $_POST['sub_total'][$i] . "','" . $_POST['gst'][$i] . "','" . $_POST['total'][$i] . "')";
                mysqli_query($con, $sql1);
                $itemid = $_POST['item_id'][$i];
                $itemqnty = $_POST['item_qnty'][$i];
                $qnty = ($itemqnty);
                $dba->updateStock($itemid, $qnty);
            }
        }
    }
    if ($_POST['pay_type'] == 'Credit' & $_POST['s_type'] == 'Credit') {

        $pid = $_POST['party_id'];
        $pamount = $_POST['total_amount'];
        $oldamount = $_POST['sl_amount'];
        $dba->updatePartyAmount($pid, $pamount - $oldamount, 'Debit');
    } elseif ($_POST['pay_type'] == 'Credit' & $_POST['s_type'] == 'Cash') {

        $pid = $_POST['party_id'];
        $pamount = $_POST['total_amount'];
        $oldamount = $_POST['sl_amount'];
        $dba->updatePartyAmount($pid, $pamount, 'Debit');
    } elseif ($_POST['pay_type'] == 'Cash' & $_POST['s_type'] == 'Credit') {

        $pid = $_POST['party_id'];
        $pamount = $_POST['total_amount'];
        $oldamount = $_POST['sl_amount'];
        $dba->updatePartyAmount($pid, $oldamount, 'Credit');
    }
    header('location:../AddSalesList.php');
} elseif ($_POST['action'] == 'delete') {

    include_once '../shreeLib/DBAdapter.php';

    $dba = new DBAdapter();

    $id = $_POST['sales_id'];


    unset($_POST['action']);

    unset($_POST['sales_id']);

    $result = $dba->deleteRow("sales_list", $_POST, "id=" . $id);

    $responce = array();

    if ($result) {

        $responce = array("status" => TRUE, "msg" => "Operation Successful!");

        //header('location:../AddSalesList');
    } else {

        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }

    echo json_encode($responce);
}
?>




