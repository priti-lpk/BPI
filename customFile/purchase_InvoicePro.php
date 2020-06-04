<?php

ob_start();
include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/Controls.php';
if ($_POST['action'] == 'add') {
    $dba = new DBAdapter();
    $id = $_POST['id'];
    unset($_POST['action']);
//    $last_id = $dba->getLastID("id", "send_party_item_list", "id=" . $_POST['id']);
    $totalrow = count($_POST['item_id']);
//    echo $totalrow;
    for ($i = 0; $i < $totalrow; $i++) {
        $sql = "insert into invoice_list(purchase_id,reference_no,item_id,item_name,unit,qty,rate,total_amount)value('" . $_POST['purchase_id'][$i] . "','" . $_POST['reference_no'][$i] . "','" . $_POST['item_id'][$i] . "','" . $_POST['item_name'][$i] . "','" . $_POST['unit'][$i] . "','" . $_POST['qty'][$i] . "','" . $_POST['rate'][$i] . "','" . $_POST['total_amount'][$i] . "')";
        mysqli_query($con, $sql);
//        echo $sql;
    }

    unset($_POST);
    header('location:../purchaseinvoice.php');
} elseif ($_POST['action'] == 'edit') {
    $dba = new DBAdapter();

    unset($_POST['action']);
//    $last_id = $dba->getLastID("id", "send_party_item_list", "id=" . $_POST['id']);
    $totalrow = count($_POST['item_id']);
//    echo $totalrow;
    for ($i = 0; $i < $totalrow; $i++) {
        $id = $_POST['pid'][$i];
//        echo $id;
        $sql = "update invoice_list set purchase_id='" . $_POST['purchase_id'][$i] . "',reference_no='" . $_POST['reference_no'][$i] . "',item_id='" . $_POST['item_id'][$i] . "',item_name='" . $_POST['item_name'][$i] . "',unit='" . $_POST['unit'][$i] . "',qty='" . $_POST['qty'][$i] . "',rate='" . $_POST['rate'][$i] . "',total_amount='" . $_POST['total_amount'][$i] . "' where id=" . $id;
        mysqli_query($con, $sql);
//        echo $sql;
    }

    unset($_POST);
    header('location:../purchaseinvoice.php');
}
?>

