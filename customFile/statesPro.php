<?php

include_once '../shreeLib/DBAdapter.php';

include_once '../shreeLib/dbconn.php';

$dba = new DBAdapter();

if ($_POST['action'] == 'add') {
    unset($_POST['action']);
    unset($_POST['id']);
    
    $dba->setData("states", $_POST);
//    echo "<script>alert('Successfully Inserted Main Category);top.location='../main_category.php';</script>";

    header('location:../states.php');
} elseif ($_POST['action'] == 'edit') {

    unset($_POST['action']);
    $id = $_POST['id'];
    //echo $id;
    
    if ($dba->updateRow("states", $_POST, "id=" . $id)) {

        $msg = " Edit Successfully";
//        echo "<script>alert('Successfully Edited Main Category);top.location='../main_category.php';</script>";

        header('location:../states.php');
    } else {

        $msg = "Edit Fail Try Again";
    }
}
?>



