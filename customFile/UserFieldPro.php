<?php
ob_start();
include '../shreeLib/session_info.php';
include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
if ($_POST['action'] == 'add') {

    $dba = new DBAdapter();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $sql1 = "INSERT INTO system_user (user_name,user_pass,user_mobile,user_address) VALUES ('" . $_POST['user_name'] . "','" . $_POST['user_pass'] . "','" . $_POST['user_mobile'] . "','" . $_POST['user_address'] . "')";
        //mysqli_query($con, $sql1);
        //print_r($sql1);
        $last_id = $dba->getLastID("id", "system_user", "1");

        $totalrow = count($_POST['user_name']);

        $rowcount = count($_POST['mod_id']);
        //print_r($rowcount);
        // for ($i = 0; $i < $rowcount; $i++) {
       
        //  print_r($_POST['check_list']);
        // if (!empty($_POST['check_list'])) {
        for ($i = 1; $i <= $rowcount; $i++) {
            
            $role_create = isset($_POST['role_create'][$i]) ? 1 : 0;
            //print_r($role_create);
            $role_edit = isset($_POST['role_edit'][$i]) ? 1 : 0;
            $role_view = isset($_POST['role_view'][$i]) ? 1 : 0;
            $role_delete = isset($_POST['role_delete'][$i]) ? 1 : 0;
            //print_r($_POST['role_delete']);

            $sql = "INSERT INTO  role_rights (user_id,mod_id,role_create,role_edit,role_view,role_delete) VALUES ('" . $last_id . "','" . $_POST['mod_id'][$i-1] . "','" . $role_create . "','" . $role_edit . "','" . $role_view . "','" . $role_delete . "')";
            // mysqli_query($con, $sql);
            print_r($sql);
            echo "</br>";
        }

        // }
        //header('location:../AddPurchaseList.php');
    }
} elseif ($_POST['action'] == 'edit') {

    $totalrowcount = count($_POST['item_name']);

    $dba = new DBAdapter();

    $id = $_POST['id'];
    $rowcount = $_POST['rowcount_no'];

    if ($totalrowcount >= 1) {
        $query = "UPDATE purchase_list set party_id='" . $_POST['party_id'] . "', p_invoice_no='" . $_POST['p_invoice_no'] . "', pl_date='" . $_POST['pl_date'] . "',total_amount='" . $_POST['total_amount'] . "',pay_type='" . $_POST['pay_type'] . "', note='" . $_POST['note'] . "' WHERE id=" . $id;
        mysqli_query($con, $query);

        for ($i = 0; $i < $rowcount; $i++) {
            $id1 = $_POST['p_id'][$i];
            $query1 = "UPDATE purchase_item_list set item_id='" . $_POST['item_id'][$i] . "', item_qnty='" . $_POST['item_qnty'][$i] . "', item_rate='" . $_POST['item_rate'][$i] . "',sub_total='" . $_POST['sub_total'][$i] . "',gst='" . $_POST['gst'][$i] . "', total='" . $_POST['total'][$i] . "' WHERE id=" . $id1;
            mysqli_query($con, $query1);
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
        $dba->updatePartyAmount($pid, $pamount, 'Debit');
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



