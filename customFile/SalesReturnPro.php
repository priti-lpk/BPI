<?php
ob_start();
include_once '../shreeLib/Controls.php';
include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
if ($_POST['action'] == 'add') {

    $dba = new DBAdapter();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (!isset($_SESSION)) {
            session_start();
        }

        $cdba = new Controls();
        $user = $_POST['user_info'];
        print_r($user);
        $ip_id = $cdba->get_client_ip();

        date_default_timezone_set('Asia/Kolkata');
        $date = date('d-m-Y h:i:s');
        $user_array = array($user, $ip_id, $date);
        // print_r($user_array);
        $user_string = json_encode($user_array, TRUE);
        $_POST['user_action'] = "Create";

        $sql1 = "INSERT INTO sales_return (party_id,s_invoice_no,sale_date ,total_amount ,pay_type,note,user_info,user_action, user_id ) VALUES ('" . $_POST['party_id'] . "','" . $_POST['s_invoice_no'] . "','" . $_POST['sale_date'] . "','" . $_POST['total_amount'] . "','" . $_POST['pay_type'] . "','" . $_POST['note'] . "','" . $user_string . "','" . $_POST['user_action'] . "'," . $_SESSION['user_id'] . ")";
        mysqli_query($con, $sql1);
        $last_id = $dba->getLastID("id", "sales_return", "1");

        $c = count($_POST['item_name']);
        for ($i = 0; $i < $c; $i++) {
            $sql = "INSERT INTO  sales_return_item_list (sr_id , item_id , item_qnty, item_rate, sub_total , gst , total ) VALUES ('" . $last_id . "','" . $_POST['item_id'][$i] . "','" . $_POST['item_qnty'][$i] . "','" . $_POST['item_rate'][$i] . "','" . $_POST['sub_total'][$i] . "','" . $_POST['gst'][$i] . "','" . $_POST['total'][$i] . "')";
            mysqli_query($con, $sql);
            $itemid = $_POST['item_id'][$i];
            $itemqnty = $_POST['item_qnty'][$i];
            $dba->updateStock($itemid, $itemqnty * (-1));
        }
        if ($_POST['pay_type'] == 'Debit') {

            $pid = $_POST['party_id'];
            $pamount = $_POST['total_amount'];
            $dba->updatePartyAmount($pid, $pamount * (-1), 'Debit');
        }
        header('location:../AddSalesReturn.php');
    }
} elseif ($_POST['action'] == 'edit') {

    $totalrowcount = count($_POST['item_name']);

    $dba = new DBAdapter();
    $cdba = new Controls();
    $id = $_POST['id'];
    $user = $_POST['user_info'];

    $ip_id = $cdba->get_client_ip();

    $last_id = $dba->getLastID("user_info", "sales_return", "id=" . $id);

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

    $rowcount = $_POST['rowcount_no'];

    if ($totalrowcount >= 1) {
        $query = "UPDATE sales_return set party_id='" . $_POST['party_id'] . "', s_invoice_no='" . $_POST['s_invoice_no'] . "', sale_date='" . $_POST['sale_date'] . "',total_amount='" . $_POST['total_amount'] . "',pay_type='" . $_POST['pay_type'] . "', note='" . $_POST['note'] . "',user_info='" . $_POST['user_info'] . "' ,user_action='" . $_POST['user_action'] . "' WHERE id=" . $id;
        mysqli_query($con, $query);

        for ($i = 0; $i < $rowcount; $i++) {
            $id1 = $_POST['sr_id'][$i];
            $query1 = "UPDATE sales_return_item_list set item_id='" . $_POST['item_id'][$i] . "', item_qnty='" . $_POST['item_qnty'][$i] . "', item_rate='" . $_POST['item_rate'][$i] . "',sub_total='" . $_POST['sub_total'][$i] . "',gst='" . $_POST['gst'][$i] . "', total='" . $_POST['total'][$i] . "' WHERE id=" . $id1;
            mysqli_query($con, $query1);
            $itemid = $_POST['item_id'][$i];
            $qntynew = $_POST['item_qnty'][$i];
            $qntyold = $_POST['sr_qnty'][$i];
            $qnty = ($qntynew - $qntyold) * (-1);
            $dba->updateStock($itemid, $qnty);
        }
        if ($rowcount < $totalrowcount) {
            for ($i = $rowcount; $i < $totalrowcount; $i++) {
                $sql = "INSERT INTO  sales_return_item_list (sr_id , item_id , item_qnty, item_rate, sub_total , gst , total ) VALUES ('" . $id . "','" . $_POST['item_id'][$i] . "','" . $_POST['item_qnty'][$i] . "','" . $_POST['item_rate'][$i] . "','" . $_POST['sub_total'][$i] . "','" . $_POST['gst'][$i] . "','" . $_POST['total'][$i] . "')";
                mysqli_query($con, $sql);
                $itemid = $_POST['item_id'][$i];
                $itemqnty = $_POST['item_qnty'][$i];
                $qnty = ($itemqnty * (-1));
                $dba->updateStock($itemid, $qnty);
            }
        }
    }
    if ($_POST['pay_type'] == 'Debit' & $_POST['sr_type'] == 'Debit') {

        $pid = $_POST['party_id'];
        $pamount = $_POST['total_amount'];
        $oldamount = $_POST['sr_amount'];
        $dba->updatePartyAmount($pid, $pamount - $oldamount, 'Credit');
        
    } elseif ($_POST['pay_type'] == 'Debit' & $_POST['sr_type'] == 'Cash') {

        $pid = $_POST['party_id'];
        $pamount = $_POST['total_amount'];
        $oldamount = $_POST['sr_amount'];
        $dba->updatePartyAmount($pid, $pamount, 'Credit');
        
    } elseif ($_POST['pay_type'] == 'Cash' & $_POST['sr_type'] == 'Debit') {

        $pid = $_POST['party_id'];
        $pamount = $_POST['total_amount'];
        $oldamount = $_POST['sr_amount'];
        $dba->updatePartyAmount($pid, $oldamount, 'Debit');
    }
     header('location:../AddSalesReturn.php');
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


