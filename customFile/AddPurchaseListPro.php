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
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $cdba = new Controls();
        $user = $_POST['user_info'];

        $ip_id = $cdba->get_client_ip();

        date_default_timezone_set('Asia/Kolkata');
        $date = date('d-m-Y h:i:s');
        $user_array = array($user, $ip_id, $date);

        $user_string = json_encode($user_array, TRUE);

        $_POST['user_action'] = "Create";

        $sql1 = "INSERT INTO purchase_list (order_id, party_id, p_invoice_no, pl_date, total_amount, pay_type, pay_tax, note, user_info, user_action, user_id ) VALUES ('" . $_POST['order_id'] . "','" . $_POST['party_id'] . "','" . $_POST['p_invoice_no'] . "','" . $_POST['pl_date'] . "','" . $_POST['total_amount'] . "','" . $_POST['pay_type'] . "','" . $_POST['pay_tax'] . "','" . $_POST['note'] . "','" . $user_string . "','" . $_POST['user_action'] . "'," . $_SESSION['user_id'] . ")";
        mysqli_query($con, $sql1);
        print_r($sql1);

        $sql_update = "UPDATE purchase_order_list SET order_status='Complate' WHERE id=" . $_POST['order_id'];
        mysqli_query($con, $sql_update);

        $last_id = $dba->getLastID("id", "purchase_list", "1");

        $totalrow = count($_POST['item_name']);

        $rowcount = $_POST['rowcount_no'];

        for ($i = 0; $i < $totalrow; $i++) {

            $sql = "INSERT INTO  purchase_item_list (pl_id , item_id , item_qnty, item_rate, sub_total , gst , total ) VALUES ('" . $last_id . "','" . $_POST['item_id'][$i] . "','" . $_POST['item_qnty'][$i] . "','" . $_POST['item_rate'][$i] . "','" . $_POST['sub_total'][$i] . "','" . $_POST['gst'][$i] . "','" . $_POST['total'][$i] . "')";
            mysqli_query($con, $sql);

            $itemid = $_POST['item_id'][$i];

            $itemqnty = $_POST['item_qnty'][$i];

            $qnty = ($itemqnty * (-1));

            $dba->updateStock($itemid, $qnty);
        }
        if ($_POST['pay_type'] == 'Debit') {

            $pid = $_POST['party_id'];
            $pamount = $_POST['total_amount'];
            $dba->updatePartyAmount($pid, $pamount, 'Credit');
        }

        header('location:../AddPurchaseList.php');
    }
} elseif ($_POST['action'] == 'edit') {

    $totalrowcount = count($_POST['item_name']);
    $cdba = new Controls();

    $dba = new DBAdapter();

    $id = $_POST['id'];

    $user = $_POST['user_info'];

    $ip_id = $cdba->get_client_ip();

    $last_id = $dba->getLastID("user_info", "purchase_list", "id=" . $id);

    $json = json_decode($last_id, true);

    echo '</br>';
    $crate_user = array_slice($json, 0, 3);


    date_default_timezone_set('Asia/Kolkata');
    $date = date('d-m-Y h:i:s');

    $user_array = array($user, $ip_id, $date);

    $merge = array_merge($crate_user, $user_array);
    // print_r($merge);
    $user_edit = json_encode($merge, TRUE);
    // print_r($user_edit);
    //  echo '</br>';
    $_POST['user_info'] = $user_edit;
    $_POST['user_action'] = "Edit";

    $rowcount = $_POST['rowcount_no'];

    if ($totalrowcount >= 1) {
        $query = "UPDATE purchase_list set party_id='" . $_POST['party_id'] . "', p_invoice_no='" . $_POST['p_invoice_no'] . "', pl_date='" . $_POST['pl_date'] . "',total_amount='" . $_POST['total_amount'] . "',pay_type='" . $_POST['pay_type'] . "', note='" . $_POST['note'] . "',user_info='" . $_POST['user_info'] . "' ,user_action='" . $_POST['user_action'] . "', pay_tax='".$_POST['pay_tax']."' WHERE id=" . $id;
        mysqli_query($con, $query);
        // print_r($query);

        for ($i = 0; $i < $rowcount; $i++) {
            $id1 = $_POST['p_id'][$i];
            $query1 = "UPDATE purchase_item_list set item_id='" . $_POST['item_id'][$i] . "', item_qnty='" . $_POST['item_qnty'][$i] . "', item_rate='" . $_POST['item_rate'][$i] . "',sub_total='" . $_POST['sub_total'][$i] . "',gst='" . $_POST['gst'][$i] . "', total='" . $_POST['total'][$i] . "' WHERE id=" . $id1;
            mysqli_query($con, $query1);
            //  print_r($query1);
            $itemid = $_POST['item_id'][$i];
            $qntynew = $_POST['item_qnty'][$i];

            $qntyold = $_POST['p_qnty'][$i];

            $qnty = ($qntynew - $qntyold) * (-1);
            $dba->updateStock($itemid, $qnty);
        }
        if ($rowcount < $totalrowcount) {
            for ($i = $rowcount; $i < $totalrowcount; $i++) {
                $sql = "INSERT INTO  purchase_item_list (pl_id , item_id , item_qnty, item_rate, sub_total , gst , total ) VALUES ('" . $id . "','" . $_POST['item_id'][$i] . "','" . $_POST['item_qnty'][$i] . "','" . $_POST['item_rate'][$i] . "','" . $_POST['sub_total'][$i] . "','" . $_POST['gst'][$i] . "','" . $_POST['total'][$i] . "')";
                mysqli_query($con, $sql);
                $itemid = $_POST['item_id'][$i];
                $itemqnty = $_POST['item_qnty'][$i];
                $qnty = ($itemqnty * (-1));
                $dba->updateStock($itemid, $qnty);
            }
        }
    }
    if ($_POST['pay_type'] == 'Debit' & $_POST['p_type'] == 'Debit') {

        $pid = $_POST['party_id'];
        $pamount = $_POST['total_amount'];

        $oldamount = $_POST['pl_amount'];
 
        $dba->updatePartyAmount($pid, $pamount - $oldamount, 'Credit');
        
    } elseif ($_POST['pay_type'] == 'Debit' & $_POST['p_type'] == 'Cash') {

        $pid = $_POST['party_id'];
        $pamount = $_POST['total_amount'];
        $oldamount = $_POST['pl_amount'];
        $dba->updatePartyAmount($pid, $pamount, 'Credit');
        
    } elseif ($_POST['pay_type'] == 'Cash' & $_POST['p_type'] == 'Debit') {

        $pid = $_POST['party_id'];
        $pamount = $_POST['total_amount'];
        $oldamount = $_POST['pl_amount'];
        $dba->updatePartyAmount($pid, $oldamount, 'Debit');
    }
    header('location:../AddPurchaseList.php');
} elseif ($_POST['action'] == 'delete') {

    $dba = new DBAdapter();

    $id = $_POST['purchase_id'];


    unset($_POST['action']);

    unset($_POST['purchase_id']);

    $result = $dba->deleteRow("purchase_list", $_POST, "id=" . $id);

    $responce = array();

    if ($result) {

        $responce = array("status" => TRUE, "msg" => "Operation Successful!");

        header('location:../AddPurchaseList');
    } else {

        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }

    echo json_encode($responce);
}
?>


