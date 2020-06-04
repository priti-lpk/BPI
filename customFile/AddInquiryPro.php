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
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $cdba = new Controls();
        $createdby = $dba->createdby();
        $_POST['created_by_user'] = $createdby;
        $remark = $_POST['inq_remark'];
        if (isset($_POST['status'])) {
            if ($_POST['status'] == "on") {

                $_POST['status'] = "on";
            } else {

                $_POST['status'] = "off";
            }
        } else
            $_POST['status'] = "off";

        $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);

        $_POST['branch_id'] = $last_id;
        $id = 1; //example from session variable
        $cur_date = date('dmis'); //timestamp ticket submitted
        $reference_no = $id . '' . $cur_date;
        $date = date('Y-m-d', strtotime($_POST['inq_date']));
        $sql1 = "INSERT INTO inquiry (party_id,branch_id,inq_date,inq_remark,user_id,created_by_user,reference_no,status) VALUES ('" . $_POST['party_id'] . "','" . $_POST['branch_id'] . "','" . $date . "','" . $_POST['inq_remark'] . "'," . $_SESSION['user_id'] . ",'" . $_POST['created_by_user'] . "','" . $reference_no . "','" . $_POST['status'] . "')";
        mysqli_query($con, $sql1);
        $last_id = $dba->getLastID("id", "inquiry", "1");
        $totalrow = count($_POST['item_id']);
        $rowcount = $_POST['rowcount_no'];
        $sql = array();
        $sql = 'INSERT INTO  inquiry_item_list (inq_id , item_id , item_unit,item_quantity,remark) VALUES';
        for ($i = 0; $i < $totalrow; $i++) {
            if (!empty(($_POST['item_quantity'][$i]) & ($_POST['item_unit'][$i]))) {
                $sql .= "('" . $last_id . "','" . $_POST['item_id'][$i] . "','" . $_POST['item_unit'][$i] . "','" . $_POST['item_quantity'][$i] . "','" . $_POST['remark'][$i] . "'),";
            }
        }
        $sql2 = rtrim($sql, ',');
        mysqli_query($con, $sql2);
        echo "<script>alert('Successfully Inserted Inquiry');top.location='../Inquiry.php';</script>";
    }
} elseif ($_POST['action'] == 'edit') {

    $totalrowcount = count($_POST['item_id']);
    $cdba = new Controls();
    $dba = new DBAdapter();
    $id = $_POST['id'];
    $createdby = $dba->createdby();
    $_POST['created_by_user'] = $createdby;
    $remark = $_POST['inq_remark'];
    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);

    $_POST['branch_id'] = $last_id;
    // print_r($_POST['branch_id']);
    $rowcount = $_POST['rowcount_no'];
    $date = date('Y-m-d', strtotime($_POST['inq_date']));
    if (isset($_POST['status'])) {
        if ($_POST['status'] == "on") {

            $_POST['status'] = "on";
        } else {

            $_POST['status'] = "off";
        }
    } else
        $_POST['status'] = "off";
    
    if ($totalrowcount >= 1) {
        $query = "UPDATE inquiry set party_id='" . $_POST['party_id'] . "',inq_date='" . $date . "',inq_remark='" . $_POST['inq_remark'] . "',user_id=" . $_SESSION['user_id'] . ",created_by_user='" . $_POST['created_by_user'] . "',status='" . $_POST['status'] . "' WHERE id=" . $id;
        mysqli_query($con, $query);
//        print_r($query);

        for ($i = 0; $i < $rowcount; $i++) {
            $id1 = $_POST['i_id'][$i];
            $query1 = "UPDATE inquiry_item_list set item_id='" . $_POST['item_id'][$i] . "', item_unit='" . $_POST['item_unit'][$i] . "', item_quantity='" . $_POST['item_quantity'][$i] . "',remark='" . $_POST['remark'][$i] . "' WHERE id=" . $id1;
            mysqli_query($con, $query1);
//            print_r($query1);
        }
        if ($rowcount < $totalrowcount) {
            for ($i = $rowcount; $i < $totalrowcount; $i++) {
                $sql = "INSERT INTO  inquiry_item_list (inq_id , item_id , item_unit,item_quantity,remark) VALUES ('" . $id . "','" . $_POST['item_id'][$i] . "','" . $_POST['item_unit'][$i] . "','" . $_POST['item_quantity'][$i] . "','" . $_POST['remark'][$i] . "')";
                mysqli_query($con, $sql);
            }
        }
    }
    echo "<script>alert('Successfully Edited Inquiry');top.location='../Dashboard.php';</script>";
}
?>


