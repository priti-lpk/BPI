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
//    $user = $_POST['user_id'];
//    echo '<br>';
//    $tmpArr = implode(",", $user);
//    $username = $tmpArr;
//    $i = 0;
    $sql1 = "INSERT INTO purchase_list (quotation_id,item_name, unit, qty, rate,godawn_id,purchase_date) VALUES ('" . $_POST['quotation_id'] . "','" . $_POST['item_name'] . "','" . $_POST['unit'] . "','" . $_POST['qty'] . "','" . $_POST['rate'] . "','" . $_POST['godawn_id'] . "','" . $_POST['purchase_date'] . "')";
    mysqli_query($con, $sql1);
//    print_r($sql1);    
    echo "<script>alert('Successfully Inserted Purchase');top.location='../view/purchase.php';</script>";
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
    $sql2 = "update purchase_list set quotation_id='" . $_POST['quotation_id'] . "',item_name='" . $_POST['item_name'] . "', unit='" . $_POST['unit'] . "', qty='" . $_POST['qty'] . "', rate='" . $_POST['rate'] . "',godawn_id='" . $_POST['godawn_id'] . "',purchase_date='" . $_POST['purchase_date'] . "' where id=" . $_POST['id'];
    mysqli_query($con, $sql2);
    print_r($sql2);
    echo "<script>alert('Successfully Edited Purchase');top.location='../view/purchase.php';</script>";
}
?>




