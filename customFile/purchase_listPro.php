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
    unset($_POST['action']);
    $totalrow = count($_POST['send_party_item_id']);
//    echo $totalrow;
    $godawn_id = $_POST['godawn_id'];
    $purchase_date = $_POST['purchase_date'];
    for ($i = 0; $i < $totalrow; $i++) {

        $sql1 = "INSERT INTO purchase_list (send_party_id,item_name, unit, qty, rate,total_amount,godawn_id,purchase_date,sup_id,user_id,send_party_item_id,inq_id,item_id) VALUES ('" . $_POST['send_party_id'][$i] . "','" . $_POST['item_name'][$i] . "','" . $_POST['unit'][$i] . "','" . $_POST['qty'][$i] . "','" . $_POST['rate'][$i] . "','" . $_POST['total_amount'][$i] . "','" . $godawn_id . "','" . $purchase_date . "','" . $_POST['sup_id'][$i] . "','" . $_POST['user_id'][$i] . "','" . $_POST['send_party_item_id'][$i] . "','".$_POST['inquiry_no'][$i]."','".$_POST['item_id'][$i]."')";
        mysqli_query($con, $sql1);
//        print_r($sql1);
    }
    echo "<script>alert('Successfully Inserted Purchase');top.location='../Dashboard.php';</script>";
//        header('location:../view/purchase.php');
} elseif ($_POST['action'] == 'edit') {
    if (!isset($_SESSION)) {
        session_start();
    }
    $cdba = new Controls();
    $dba = new DBAdapter();
    unset($_POST['action']);
    $id = $_POST['id'];
//    $user = $_POST['user_id'];
//    echo '<br>';
//    foreach ($user as $array) {
//        $tmpArr[] = implode(',', $array);
//    }
//    $username = $tmpArr;
////    print_r($username);
//    $i = 0;
    $date = date('Y-m-d', strtotime($_POST['due_date']));
    //echo $date;
    $sql2 = "update purchase_list set quotation_id='" . $_POST['quotation_id'] . "',item_name='" . $_POST['item_name'] . "', unit='" . $_POST['unit'] . "', qty='" . $_POST['qty'] . "', rate='" . $_POST['rate'] . "',godawn_id='" . $_POST['godawn_id'] . "',purchase_date='" . $date . "' where id=" . $_POST['id'];
    mysqli_query($con, $sql2);
    // print_r($sql2);
    echo "<script>alert('Successfully Edited Purchase');top.location='../view/purchase.php';</script>";
}
?>




