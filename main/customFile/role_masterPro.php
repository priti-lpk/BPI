<?php

//include '../shreeLib/session_info.php';
include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
date_default_timezone_set('Asia/Kolkata');
if ($_POST['action'] == 'add') {
    $dba = new DBAdapter();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $sql1 = "INSERT INTO role_master (role_name) VALUES ('" . $_POST['role_name'] . "')";
        mysqli_query($con, $sql1);
        $last_id = $dba->getLastID("id", "role_master", "1");
        $rowcount = count($_POST['mod_id']);
        $mod = $_POST['mod_role'];
//        print_r($_POST);
        for ($i = 1; $i <= $rowcount; $i++) {

            $modid = $_POST['mod_id'][$i - 1];
            $role_create = isset($_POST['role_create'][$i]) ? 1 : 0;
            $role_edit = isset($_POST['role_edit'][$i]) ? 1 : 0;
            $role_view = isset($_POST['role_view'][$i]) ? 1 : 0;
            $role_delete = isset($_POST['role_delete'][$i]) ? 1 : 0;

            $sql = "INSERT INTO  role_rights (role_id,mod_id,role_create,role_edit,role_view,role_delete) VALUES ('" . $last_id . "','" . $modid . "','" . $role_create . "','" . $role_edit . "','" . $role_view . "','" . $role_delete . "')";
            mysqli_query($con, $sql);
            // print_r($sql);
        }

        if ($mod[4] == 'inquiry') {

            $role_view = isset($_POST['role_view'][5]) ? 1 : 0;
            $role_delete = isset($_POST['role_delete'][5]) ? 1 : 0;

            if ($role_view == 1) {
                $sql2 = "INSERT INTO  role_rights (role_id,mod_id,role_create,role_edit,role_view,role_delete) VALUES ('" . $last_id . "','10','1','1','" . $role_view . "','" . $role_delete . "')";
                mysqli_query($con, $sql2);
               // print_r($sql2);

                $sql3 = "INSERT INTO  role_rights (role_id,mod_id,role_create,role_edit,role_view,role_delete) VALUES ('" . $last_id . "','11','1','1','" . $role_view . "','" . $role_delete . "')";
                mysqli_query($con, $sql3);
               // print_r($sql3);
                $sql4 = "INSERT INTO  role_rights (role_id,mod_id,role_create,role_edit,role_view,role_delete) VALUES ('" . $last_id . "','12','1','1','" . $role_view . "','" . $role_delete . "')";
                mysqli_query($con, $sql4);
            }
        }

        if ($mod[6] == 'user') {
            $role_view = isset($_POST['role_view'][7]) ? 1 : 0;
            $role_delete = isset($_POST['role_delete'][7]) ? 1 : 0;
            if ($role_view == 1) {
                $sql5 = "INSERT INTO  role_rights (role_id,mod_id,role_create,role_edit,role_view,role_delete) VALUES ('" . $last_id . "','9','1','1','" . $role_view . "','" . $role_delete . "')";
                mysqli_query($con, $sql5);
                //print_r($sql5);
            }
        }

        if ($mod[7] == 'quotation') {
            $role_view = isset($_POST['role_view'][8]) ? 1 : 0;
            $role_delete = isset($_POST['role_delete'][8]) ? 1 : 0;

            if ($role_view == 1) {
                $sql6 = "INSERT INTO  role_rights (role_id,mod_id,role_create,role_edit,role_view,role_delete) VALUES ('" . $last_id . "','13','1','1','" . $role_view . "','" . $role_delete . "')";
                mysqli_query($con, $sql6);
                //print_r($sql6);
            }
        }
        if ($mod[8] == 'purchase') {
            $role_view = isset($_POST['role_view'][9]) ? 1 : 0;
            $role_delete = isset($_POST['role_delete'][9]) ? 1 : 0;

            if ($role_view == 1) {
                $sql7 = "INSERT INTO  role_rights (role_id,mod_id,role_create,role_edit,role_view,role_delete) VALUES ('" . $last_id . "','16','1','1','" . $role_view . "','" . $role_delete . "')";
                mysqli_query($con, $sql7);
                //print_r($sql7);
            }
        }if ($mod[10] == 'invoice') {
            $role_view = isset($_POST['role_view'][11]) ? 1 : 0;
            $role_delete = isset($_POST['role_delete'][11]) ? 1 : 0;

            if ($role_view == 1) {
                $sql7 = "INSERT INTO  role_rights (role_id,mod_id,role_create,role_edit,role_view,role_delete) VALUES ('" . $last_id . "','18','1','1','" . $role_view . "','" . $role_delete . "')";
                mysqli_query($con, $sql7);
                //print_r($sql7);
            }
        }
        
        echo "<script>alert('Successfully Inserted Role');top.location='../role_master.php';</script>";
//        header('location:../role_master.php');
    }
} elseif ($_POST['action'] == 'edit') {

    $dba = new DBAdapter();

    $id = $_POST['id'];

    $rowcount = $_POST['r_count'];
    if ($rowcount >= 1) {
        $query = "UPDATE role_master set role_name='" . $_POST['role_name'] . "' WHERE id=" . $id;
        echo $query;
        mysqli_query($con, $query);

        for ($i = 1; $i <= $rowcount; $i++) {
            $id1 = $_POST['role_id'][$i - 1];
            $role_create = isset($_POST['role_create'][$i]) ? 1 : 0;
            $role_edit = isset($_POST['role_edit'][$i]) ? 1 : 0;
            $role_view = isset($_POST['role_view'][$i]) ? 1 : 0;
            $role_delete = isset($_POST['role_delete'][$i]) ? 1 : 0;
            $query1 = "UPDATE role_rights set role_id='" . $id . "', mod_id='" . $_POST['mod_id'][$i - 1] . "', role_create='" . $role_create . "',role_edit='" . $role_edit . "',role_view='" . $role_view . "', role_delete='" . $role_delete . "' WHERE id=" . $id1;
            mysqli_query($con, $query1);
        }
        if ($mod[4] == 'inquiry') {

            $role_view = isset($_POST['role_view'][5]) ? 1 : 0;
            $role_delete = isset($_POST['role_delete'][5]) ? 1 : 0;

            if ($role_view == 1) {
                $sql2 = "UPDATE role_rights set role_id='" . $last_id . "',mod_id='10',role_create='1',role_edit'1',role_view='1',role_delete='" . $role_delete . "' where id=" . $id1;
                mysqli_query($con, $sql2);
                print_r($sql2);

                $sql3 = "UPDATE role_rights set role_id='" . $last_id . "',mod_id='11',role_create='1',role_edit='1',role_view='" . $role_view . "',role_delete='" . $role_delete . "' where id=" . $id1;
                mysqli_query($con, $sql3);
                print_r($sql3);
            }
        }
        if ($mod[5] == 'send_inquiry') {
            $role_view = isset($_POST['role_view'][6]) ? 1 : 0;
            $role_delete = isset($_POST['role_delete'][6]) ? 1 : 0;

            if ($role_view == 1) {
                $sql4 = "update role_rights set role_id='" . $last_id . "',mod_id='12',role_create='1',role_edit='1',role_view='" . $role_view . "',role_delete'" . $role_delete . "' where id=" . $id1;
                mysqli_query($con, $sql4);
                print_r($sql4);
            }
        }
        if ($mod[6] == 'user') {
            $role_view = isset($_POST['role_view'][7]) ? 1 : 0;
            $role_delete = isset($_POST['role_delete'][7]) ? 1 : 0;
            if ($role_view == 1) {
                $sql5 = "update role_rights set role_id'" . $last_id . "',mod_id='9',role_create='1',role_edit='1',role_view='" . $role_view . "',role_delete='" . $role_delete . "' where id=" . $id1;
                mysqli_query($con, $sql5);
                print_r($sql5);
            }
        }

        if ($mod[7] == 'quotation') {
            $role_view = isset($_POST['role_view'][8]) ? 1 : 0;
            $role_delete = isset($_POST['role_delete'][8]) ? 1 : 0;

            if ($role_view == 1) {
                $sql6 = "update role_rights set role_id='" . $last_id . "',mod_id='13',role_create='1',role_edit='1',role_view='" . $role_view . "',role_delete='" . $role_delete . "' where id=" . $id1;
                mysqli_query($con, $sql6);
                print_r($sql6);
            }
        }
        if ($mod[8] == 'purchase') {
            $role_view = isset($_POST['role_view'][9]) ? 1 : 0;
            $role_delete = isset($_POST['role_delete'][9]) ? 1 : 0;

            if ($role_view == 1) {
                $sql7 = "update role_rights (role_id='" . $last_id . "',mod_id='16',role_create='1',role_edit'1',role_view'" . $role_view . "',role_delete='" . $role_delete . "' where id=" . $id;
                mysqli_query($con, $sql7);
                print_r($sql7);
            }
        }
        if ($mod[10] == 'invoice') {
            $role_view = isset($_POST['role_view'][11]) ? 1 : 0;
            $role_delete = isset($_POST['role_delete'][11]) ? 1 : 0;

            if ($role_view == 1) {
                $sql7 = "update role_rights (role_id='" . $last_id . "',mod_id='18',role_create='1',role_edit'1',role_view'" . $role_view . "',role_delete='" . $role_delete . "' where id=" . $id;
                mysqli_query($con, $sql7);
                print_r($sql7);
            }
        }
    }
        echo "<script>alert('Successfully Edited Role');top.location='../role_master.php';</script>";
} elseif ($_POST['action'] == "changeStatus") {

    include_once '../shreeLib/DBAdapter.php';

    $dba = new DBAdapter();

    $field = array("user_status" => $_POST['ustatus'], "user_created_date" => date("Y-m-d H:i"));

    $result = $dba->updateRow("create_user", $field, "id=" . $_POST['uid']);

    $responce = array();

    if ($result) {

        $responce = array("status" => TRUE, "msg" => "Operation Successful!");
    } else {

        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }

    echo json_encode($responce);
}
?>





