<?php

ob_start();
require_once "shreeLib/session_info.php";
include_once 'shreeLib/DBAdapter.php';
include_once 'shreeLib/dbconn.php';
$edba = new DBAdapter();
// delete from gallary_list.php
if ($_GET['type'] == 'main_category') {
    $id = $_GET['id'];
    $sql = "select * from main_category where id=" . $id;
    $result = mysqli_query($con, $sql);

    $row = mysqli_fetch_array($result);
    $image_name = $row['main_image'];
    $file = "Images/main/" . $image_name;

    $sql1 = "DELETE FROM `main_category` WHERE `id`=" . $id;
    if (mysqli_query($con, $sql1)) {
        unlink($file);
        echo "<script>alert('successfully  Detail deleted!');top.location='main_category.php';</script>";
    } else {
        echo "<script>alert('Oops, Could not delete the Image\nTry Again!');</script>";
    }
    // delete from admission_list.php
} elseif ($_GET['type'] == 'sub_category') {
    $id = $_GET['id'];
    $sql = "select * from sub_category where id=" . $id;
    $result = mysqli_query($con, $sql);

    $row = mysqli_fetch_array($result);
    $image_name = $row['sub_image'];
    $file = "Images/sub/" . $image_name;

    $sql1 = "DELETE FROM `sub_category` WHERE `id`=" . $id;
    if (mysqli_query($con, $sql1)) {
        unlink($file);
        echo "<script>alert('successfully  Detail deleted!');top.location='sub_category.php';</script>";
    } else {
        echo "<script>alert('Oops, Could not delete the Image\nTry Again!');</script>";
    }
    // delete from admission_list.php
} elseif ($_GET['type'] == 'tag_list') {
    $id = $_GET['id'];

    $sql1 = "DELETE FROM `tag_list` WHERE `id`=" . $id;
    mysqli_query($con, $sql1);
   if (mysqli_query($con, $sql1)) {
      
        echo "<script>alert('successfully  Detail deleted!');top.location='tag_list.php';</script>";
    } else {
        echo "<script>alert('Oops, Could not delete the Image\nTry Again!');</script>";
    }
    // delete from admission_procedure.php
}elseif ($_GET['type'] == 'question') {
    $id = $_GET['id'];
//    printf($id);
    $sql = "select * from question_master where id=" . $id;
    $result = mysqli_query($con, $sql);

    $row = mysqli_fetch_array($result);
    $image_name = $row['image'];
    $file = "Images/question/" . $image_name;

    $sql1 = "DELETE FROM `question_master` WHERE `id`=" . $id;
    if (mysqli_query($con, $sql1)) {
        unlink($file);
        echo "<script>alert('successfully  Detail deleted!');top.location='add_question.php';</script>";
    } else {
        echo "<script>alert('Oops, Could not delete the Image\nTry Again!');</script>";
    }
    // delete from admission_list.php
}elseif ($_GET['type'] == 'country') {
    $id = $_GET['id'];

    $sql1 = "DELETE FROM `countries` WHERE `id`=" . $id;
    mysqli_query($con, $sql1);
    if (mysqli_query($con, $sql1)) {
        echo "<script>alert('successfully  Detail deleted!');top.location='countries.php';</script>";
    } else {
        echo "<script>alert('Oops, Could not delete the Image\nTry Again!');</script>";
    }
    // delete from admission_procedure.php
}elseif ($_GET['type'] == 'state') {
    $id = $_GET['id'];

    $sql1 = "DELETE FROM `states` WHERE `id`=" . $id;
    mysqli_query($con, $sql1);
    if (mysqli_query($con, $sql1)) {
        echo "<script>alert('successfully  Detail deleted!');top.location='states.php';</script>";
    } else {
        echo "<script>alert('Oops, Could not delete the Image\nTry Again!');</script>";
    }
    // delete from admission_procedure.php
}
?>

