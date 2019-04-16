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

                $_POST['status'] = "1";
            } else {

                $_POST['status'] = "0";
            }
        } else
            $_POST['status'] = "0";


        $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);

        $_POST['branch_id'] = $last_id;
        $id = 1; //example from session variable
        $cur_date = date('dmi'); //timestamp ticket submitted
        $reference_no = $id . '' . $cur_date;
        //echo $cur_date;
        $sql1 = "INSERT INTO inquiry (party_id,branch_id,inq_date,inq_remark,user_id,created_by_user,reference_no,status) VALUES ('" . $_POST['party_id'] . "','" . $_POST['branch_id'] . "','" . $_POST['inq_date'] . "','" . $_POST['inq_remark'] . "'," . $_SESSION['user_id'] . ",'" . $_POST['created_by_user'] . "','" . $reference_no . "','".$_POST['status']."')";
        mysqli_query($con, $sql1);
       // print_r($sql1);
        $last_id = $dba->getLastID("id", "inquiry", "1");

        $totalrow = count($_POST['item_id']);

        $rowcount = $_POST['rowcount_no'];

        for ($i = 0; $i < $totalrow; $i++) {
            $sql = "INSERT INTO  inquiry_item_list (inq_id , item_id , item_unit,item_quantity,remark) VALUES ('" . $last_id . "','" . $_POST['item_id'][$i] . "','" . $_POST['item_unit'][$i] . "','" . $_POST['item_quantity'][$i] . "','" . $_POST['remark'][$i] . "')";
            mysqli_query($con, $sql);
           // print_r($sql);
        }
        echo "<script>alert('Successfully Inserted Inquiry');top.location='../Inquiry.php';</script>";
//        header('location:../Inquiry.php');
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
    print_r($_POST['branch_id']);
    $rowcount = $_POST['rowcount_no'];

    if ($totalrowcount >= 1) {
        $query = "UPDATE inquiry set party_id='" . $_POST['party_id'] . "',inq_date='" . $_POST['inq_date'] . "',inq_remark='" . $_POST['inq_remark'] . "',user_id=" . $_SESSION['user_id'] . ",created_by_user='" . $_POST['created_by_user'] . "' WHERE id=" . $id;
        mysqli_query($con, $query);
        print_r($query);

        for ($i = 0; $i < $rowcount; $i++) {
            $id1 = $_POST['i_id'][$i];
            $query1 = "UPDATE inquiry_item_list set item_id='" . $_POST['item_id'][$i] . "', item_unit='" . $_POST['item_unit'][$i] . "', item_quantity='" . $_POST['item_quantity'][$i] . "',remark='" . $_POST['remark'][$i] . "' WHERE id=" . $id1;
            mysqli_query($con, $query1);
            print_r($query1);
            $itemid = $_POST['item_id'][$i];
            $qntynew = $_POST['item_quantity'][$i];
            $qntyold = $_POST['i_quantity'][$i];
            $qnty = ($qntynew - $qntyold) * (-1);
        }
        if ($rowcount < $totalrowcount) {
            for ($i = $rowcount; $i < $totalrowcount; $i++) {
                $sql = "INSERT INTO  inquiry_item_list (inq_id , item_id , item_unit,item_quantity,remark) VALUES ('" . $id . "','" . $_POST['item_id'][$i] . "','" . $_POST['item_unit'][$i] . "','" . $_POST['item_quantity'][$i] . "','" . $_POST['remark'][$i] . "')";
                mysqli_query($con, $sql);
                print_r($sql);
                $itemid = $_POST['item_id'][$i];
                $itemqnty = $_POST['item_quantity'][$i];
                $qnty = ($itemqnty * (-1));
            }
        }
    }
    echo "<script>alert('Successfully Edited Inquiry');top.location='../Inquiry.php';</script>";
}
?>


