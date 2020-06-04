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
    if ($user == '') {
        $user = '0';
    }
//    foreach ($user as $array) {
//        $tmpArr[] = implode(',', $array);
//    }
//    $username = $tmpArr;
    // print_r($username);

    for ($i = 0; $i < $totalrow; $i++) {
        unset($_POST['item_name'][$i]);
        unset($_POST['item_qnty'][$i]);
        $date = date('Y-m-d', strtotime($_POST['due_date'][$i]));
        $sql1 = "INSERT INTO inquiry_send_to (inq_id, inq_item_list_id, user_id, createdby_user, due_date,branch_id) VALUES ('" . $_POST['id'] . "','" . $_POST['inq_item_list_id'][$i] . "','" . $_POST['user_id'][$i] . "','" . $_POST['createdby_user'] . "','" . $date . "','" . $last_id . "')";
        mysqli_query($con, $sql1);
    }
    echo "<script>alert('Successfully Inserted Inquiry Details');top.location='../Dashboard.php';</script>";
    // header('location:../Dashboard.php');
} elseif ($_POST['action'] == 'edit') {

    $cdba = new Controls();
    $dba = new DBAdapter();
    $id = $_POST['id'];
    $createdby = $dba->createdby();
    $_POST['createdby_user'] = $createdby;
    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
    $rowcount = $_POST['inq_item_list_id'];
    $inq_item = implode(',', $rowcount);
//    $date = implode(',', $_POST['due_date']);
    $user = $_POST['user_id'];
//    print_r($user);
    if ($user == '') {
        $_POST['user_id'] = '0';
    } else {
        $_POST['user_id'] = $user;
    }
    $i = 0;
    //for ($i = 0; $i < $rowcount; $i++) {
    $date = date('Y-m-d', strtotime($_POST['due_date']));
    $query1 = "UPDATE inquiry_send_to set inq_id='" . $_POST['inq_id'] . "', inq_item_list_id='" . $inq_item . "', user_id='" . $_POST['user_id'] . "',createdby_user='" . $_POST['createdby_user'] . "',due_date='" . $date . "',branch_id='" . $last_id . "' WHERE id=" . $id;
    mysqli_query($con, $query1);
//    print_r($query1);
    //}
    echo "<script>alert('Successfully Edited Inquiry Details');top.location='../Dashboard.php';</script>";
}
?>




