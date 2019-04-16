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
    $cdba = new Controls();
    $createdby = $dba->createdby();
    $_POST['createdby_user'] = $createdby;
    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
    unset($_POST['action']);
    $totalrow = count($_POST['inq_item_list_id']);
    $user = $_POST['user_id'];
    foreach ($user as $array) {
        $tmpArr[] = implode(',', $array);
    }
    $username = $tmpArr;
    // print_r($username);
    for ($i = 0; $i < $totalrow; $i++) {
        unset($_POST['item_name'][$i]);
        unset($_POST['item_qnty'][$i]);
        $sql1 = "INSERT INTO inquiry_send_to (inq_id, inq_item_list_id, user_id, createdby_user, due_date,branch_id) VALUES ('" . $_POST['id'] . "','" . $_POST['inq_item_list_id'][$i] . "','" . $username[$i] . "','" . $_POST['createdby_user'] . "','" . $_POST['due_date'][$i] . "','" . $last_id . "')";
        mysqli_query($con, $sql1);
       // print_r($sql1);
    }
    //echo "<script>alert('Successfully Inserted Inquiry Details');top.location='../Dashboard.php';</script>";
    header('location:../Dashboard.php');
} elseif ($_POST['action'] == 'edit') {

    $cdba = new Controls();
    $dba = new DBAdapter();
    $id = $_POST['id'];
    //echo $id;
    $createdby = $dba->createdby();
    $_POST['createdby_user'] = $createdby;
    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
    $rowcount = $_POST['inq_item_list_id'];
    $inq_item = implode(',', $rowcount);
    //print_r($rowcount);
    $date = implode(',', $_POST['due_date']);
    $user = $_POST['user_id'];
    echo '<br>';
    foreach ($user as $array) {
        $tmpArr[] = implode(',', $array);
    }
    $username = $tmpArr;
    $i = 0;
    //print_r($username);
    //for ($i = 0; $i < $rowcount; $i++) {
    $query1 = "UPDATE inquiry_send_to set inq_id='" . $_POST['inq_id'] . "', inq_item_list_id='" . $inq_item . "', user_id='" . $username[$i] . "',createdby_user='" . $_POST['createdby_user'] . "',due_date='" . $date . "',branch_id='" . $last_id . "' WHERE id=" . $id;
    mysqli_query($con, $query1);
    //print_r($query1);
    //}
    echo "<script>alert('Successfully Edited Inquiry Details');top.location='../Dashboard.php';</script>";
}
?>




