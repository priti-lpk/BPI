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

        $createdby = $dba->createdby();

        $_POST['created_by_user'] = $createdby;
        $remark = $_POST['inq_remark'];
        
        $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);

        $_POST['branch_id'] = $last_id;
        print_r($_POST['branch_id']);
        $sql1 = "INSERT INTO inquiry (party_id,branch_id,inq_date,inq_remark,user_id,created_by_user) VALUES ('" . $_POST['party_id'] . "','".$_POST['branch_id']."','" . $_POST['inq_date'] . "','" . $_POST['inq_remark'] . "'," . $_SESSION['user_id'] . ",'" . $_POST['created_by_user'] . "')";
        mysqli_query($con, $sql1);
        //print_r($sql1);

        $last_id = $dba->getLastID("id", "inquiry", "1");

        $totalrow = count($_POST['item_name']);

        $rowcount = $_POST['rowcount_no'];

        for ($i = 0; $i < $totalrow; $i++) {

            $sql = "INSERT INTO  inquiry_item_list (inq_id , item_id , item_unit,item_quantity,remark) VALUES ('" . $last_id . "','" . $_POST['item_id'][$i] . "','" . $_POST['item_unit'][$i] . "','" . $_POST['item_quantity'][$i] . "','" . $_POST['remark'][$i] . "')";
            mysqli_query($con, $sql);
            //print_r($sql);
        }

        header('location:../AddInquiry.php');
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
        $query = "UPDATE purchase_list set party_id='" . $_POST['party_id'] . "', p_invoice_no='" . $_POST['p_invoice_no'] . "', pl_date='" . $_POST['pl_date'] . "',total_amount='" . $_POST['total_amount'] . "',pay_type='" . $_POST['pay_type'] . "', note='" . $_POST['note'] . "',user_info='" . $_POST['user_info'] . "' ,user_action='" . $_POST['user_action'] . "', pay_tax='" . $_POST['pay_tax'] . "' WHERE id=" . $id;
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


