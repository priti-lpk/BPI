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
        //print_r($sql1);
        $last_id = $dba->getLastID("id", "role_master", "1");
        //$totalrow = count($_POST['user_fullname']);
        $rowcount = count($_POST['mod_id']);

        for ($i = 1; $i <= $rowcount; $i++) {

            $modid = $_POST['mod_id'][$i - 1];
         
            $role_create = isset($_POST['role_create'][$i]) ? 1 : 0;
            $role_edit = isset($_POST['role_edit'][$i]) ? 1 : 0;
            $role_view = isset($_POST['role_view'][$i]) ? 1 : 0;
            $role_delete = isset($_POST['role_delete'][$i]) ? 1 : 0;

            $sql = "INSERT INTO  role_rights (role_id,mod_id,role_create,role_edit,role_view,role_delete) VALUES ('" . $last_id . "','" . $modid . "','" . $role_create . "','" . $role_edit . "','" . $role_view . "','" . $role_delete . "')";
            //print_r($sql);
            mysqli_query($con, $sql);

        }

        header('location:../role_master.php');
    }
    //  }
} elseif ($_POST['action'] == 'edit') {

    $dba = new DBAdapter();

    $id = $_POST['id'];

    $rowcount = $_POST['r_count'];
    if ($rowcount >= 1) {
        $query = "UPDATE role_master set role_name='" . $_POST['role_name'] . "' WHERE id=" . $id;
        print_r($query);
        mysqli_query($con, $query);

        for ($i = 1; $i <= $rowcount; $i++) {
            $id1 = $_POST['role_id'][$i - 1];
            $role_create = isset($_POST['role_create'][$i]) ? 1 : 0;
            $role_edit = isset($_POST['role_edit'][$i]) ? 1 : 0;
            $role_view = isset($_POST['role_view'][$i]) ? 1 : 0;
            $role_delete = isset($_POST['role_delete'][$i]) ? 1 : 0;
            $query1 = "UPDATE role_rights set user_id='" . $id . "', mod_id='" . $_POST['mod_id'][$i - 1] . "', role_create='" . $role_create . "',role_edit='" . $role_edit . "',role_view='" . $role_view . "', role_delete='" . $role_delete . "' WHERE id=" . $id1;
//           print_r($query1);
//            echo '<br>';
            mysqli_query($con, $query1);
        }
    }
    header('location:../role_master.php');
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





