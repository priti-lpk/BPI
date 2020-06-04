<?php

ob_start();
include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/Controls.php';
if ($_POST['action'] == 'add') {
    $dba = new DBAdapter();
    $id = $_POST['id'];
    unset($_POST['action']);
    $last_id = $dba->getLastID("id", "send_party_item_list", "id=" . $_POST['id']);
    $totalrow = count($_POST['item_id']);
    for ($i = 0; $i < $totalrow; $i++) {
        $sql = "insert into send_party_item_status(send_party_item_id,new_qty,status,note)value('".$_POST['iid'][$i]."','" . $_POST['new_qty'][$i] . "','" . $_POST['status'][$i] . "','" . $_POST['note'][$i] . "')";
        mysqli_query($con, $sql);
//        echo $sql;
    }

    unset($_POST);
    header('location:../view/Send_Party.php');
}

?>

