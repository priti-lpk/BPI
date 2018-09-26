<?php

include './shreeLib/dbconn.php';

if (isset($_GET)) {


    if ($_GET['type'] == 'branch_list') {

        $id = $_GET['id'];

        $sql = "delete from branch_list where id=" . $id;

        $result = mysqli_query($con, $sql);

        print_r($sql);

        header('location:AddBranch.php');
    }
}
?>
