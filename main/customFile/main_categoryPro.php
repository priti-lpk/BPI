<?php

include_once '../shreeLib/DBAdapter.php';

include_once '../shreeLib/dbconn.php';

$dba = new DBAdapter();

if ($_POST['action'] == 'add') {
    unset($_POST['action']);
    unset($_POST['id']);
    $image_name = "";
    $k = 1;

    $filename = $_FILES["main_image"]["name"];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $lastID = $dba->getLastID("id", "main_category", "1");
    $imgefolder = ($lastID + 1) . "." . $ext;
    // $image_name = trim(($image_name . "," . $imgefolder), ',');
    $file = array("jpg", "jpeg", "png");
    move_uploaded_file($_FILES['main_image']['tmp_name'], '../Images/main/' . $imgefolder);
    if ($_FILES['main_image']['name']) {

        $_POST['main_image'] = $imgefolder;
    } else {

        $_POST['main_image'] = "";
    }
    $dba->setData("main_category", $_POST);
//    echo "<script>alert('Successfully Inserted Main Category);top.location='../main_category.php';</script>";

    header('location:../main_category.php');
} elseif ($_POST['action'] == 'edit') {

    unset($_POST['action']);
    $id = $_POST['id'];
    //echo $id;
    $image_name = "";
    $k = 1;
    $filename = $_FILES["main_image"]["name"];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $imgefolder = ($id) . "." . $ext;
    // $image_name = trim(($image_name . "," . $imgefolder), ',');
    $file = array("jpg", "jpeg", "png");
    move_uploaded_file($_FILES['main_image']['tmp_name'], '../Images/main/' . $imgefolder);
    if ($_FILES['main_image']['name']) {

        $_POST['main_image'] = $imgefolder;
    } else {

        $_POST['main_image'] = "";
    }
    if ($dba->updateRow("main_category", $_POST, "id=" . $id)) {

        $msg = " Edit Successfully";
//        echo "<script>alert('Successfully Edited Main Category);top.location='../main_category.php';</script>";

        header('location:../main_category.php');
    } else {

        $msg = "Edit Fail Try Again";
    }
}
?>



