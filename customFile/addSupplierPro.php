<?php

include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/Controls.php';

if ($_GET['action'] == 'add') {
//
//    if (!isset($_SESSION)) {
//        session_start();
//    }

    $dba = new DBAdapter();
    $cdba = new Controls();
//    $createdby = $dba->createdby($_SESSION['user_login_username']);   // print_r($createdby);

    unset($_GET['action']);
    unset($_GET['id']);
//    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);

    $sql1 = "INSERT INTO supplier (branch_id,sup_name,sup_add,sup_contact,sup_email,sup_gstno,created_user,country_id,city_id) VALUES ('" . $_GET['branch_id'] . "','" . $_GET['sup_name'] . "','" . $_GET['sup_add'] . "','" . $_GET['sup_contact'] . "','" . $_GET['sup_email'] . "','" . $_GET['sup_gstno'] . "','" . $_GET['created_user'] . "','" . $_GET['countries'] . "','" . $_GET['cities'] . "')";
    mysqli_query($con, $sql1);
} elseif ($_GET['action'] == 'edit') {
    include_once '../shreeLib/DBAdapter.php';
    $dba = new DBAdapter();
    $id = $_GET['id'];
    if (!isset($_SESSION)) {
        session_start();
    }
    $cdba = new Controls();
    $createdby = $dba->createdby($_SESSION['user_login_username']);   // print_r($createdby);
    unset($_GET['action']);
    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
    $sql2 = "update supplier set branch_id='" . $last_id . "',sup_name='" . $_GET['sup_name'] . "', sup_add='" . $_GET['sup_add'] . "',sup_contact='".$_GET['sup_contact']."',sup_email='".$_GET['sup_email']."',sup_gstno='".$_GET['sup_gstno']."',country_id='".$_GET['countries']."',city_id='".$_GET['cities']."' where id=" . $id;
    mysqli_query($con, $sql2);
//    echo $sql2;
}
?>





