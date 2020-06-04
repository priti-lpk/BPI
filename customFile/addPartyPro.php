<?php

include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/Controls.php';

if ($_GET['action'] == 'add') {

//    if (!isset($_SESSION)) {
//        session_start();
//    }
    $dba = new DBAdapter();
    $cdba = new Controls();
//    $createdby = $dba->createdby($_SESSION['user_login_username']);   // print_r($createdby);
    unset($_GET['action']);
    unset($_GET['id']);
//    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
    $sql1 = "INSERT INTO create_party (branch_id,party_name,party_contact,party_email,party_address,party_created_by,country_id,city_id) VALUES ('" . $_GET['branch_id'] . "','" . $_GET['party_name'] . "','" . $_GET['party_contact'] . "','" . $_GET['party_email'] . "','" . $_GET['party_address'] . "','" . $_GET['party_created_by'] . "','" . $_GET['countries'] . "','" . $_GET['cities'] . "')";
    mysqli_query($con, $sql1);
    echo $sql1;
} elseif ($_GET['action'] == 'edit') {

    include_once '../shreeLib/DBAdapter.php';
    $dba = new DBAdapter();
    $id = $_GET['id'];
    if (!isset($_SESSION)) {
        session_start();
    }
    $cdba = new Controls();
    unset($_GET['action']);
    $sql2 = "update create_party set party_name='" . $_GET['party_name'] . "',party_contact='" . $_GET['party_contact'] . "', party_email='" . $_GET['party_email'] . "', party_address='" . $_GET['party_address'] . "',country_id='" . $_GET['countries'] . "',city_id='" . $_GET['cities'] . "' where id=" . $id;
    mysqli_query($con, $sql2);
//    echo $sql2;
}
?>



