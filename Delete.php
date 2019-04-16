<?php

ob_start();
include_once 'shreeLib/DBAdapter.php';
include_once 'shreeLib/dbconn.php';

if (isset($_GET)) {
    if (isset($_GET['id'])) {

        include_once 'shreeLib/Controls.php';
        include 'shreeLib/session_info.php';

        $cdba = new Controls();
        $pid = "";

        $id = $_GET['id'];
        if ($_GET['type'] == 'cat_list') {

            $query = "Select id, category_name FROM category_list WHERE id=" . $id;
            //print_r($query);
            $result = mysqli_query($con, $query);
            $dba = new DBAdapter();
            $itemid = "";
            $itemcode = "";

            while ($rows = mysqli_fetch_array($result)) {
                $itemid = $rows['id'];
                $itemcode = $rows['category_name'];
            }
            $user = $_SESSION['user_name'];

            $ip_id = $cdba->get_client_ip();

            date_default_timezone_set('Asia/Kolkata');
            $date = date('d-m-Y h:i:s');

            $user_array = array($user, $ip_id, $date, "Category List", $itemid, $itemcode);

            $user_delete = json_encode($user_array, TRUE);

            $_POST['delete_info'] = $user_delete;

            $result = $dba->setData("delete_user_info", $_POST);

            if ($result) {

                $sql = "delete from category_list where id=" . $id;

                $result = mysqli_query($con, $sql);

                $responce = array("status" => TRUE, "msg" => "Operation Successful!");

                header("location:Category.php");
            } else {

                $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
            }
        }
        if ($_GET['type'] == 'create_item') {

            $sql = "delete from create_item where id=" . $id;

            $result = mysqli_query($con, $sql);

            $responce = array("status" => TRUE, "msg" => "Operation Successful!");

            header("location:Items.php");
        }
        if ($_GET['type'] == 'create_party') {

            $sql = "delete from create_party where id=" . $id;

            $result = mysqli_query($con, $sql);

            $responce = array("status" => TRUE, "msg" => "Operation Successful!");

            header("location:Party.php");
        }
        if ($_GET['type'] == 'supplier') {

            $sql = "delete from supplier where id=" . $id;

            $result = mysqli_query($con, $sql);

            $responce = array("status" => TRUE, "msg" => "Operation Successful!");

            header("location:Supplier.php");
        }
        if ($_GET['type'] == 'inquiry') {
            $sql = "delete from inquiry_item_list where inq_id=" . $id;
            //print_r($sql);
            $result2 = mysqli_query($con, $sql);
            $sql1 = "delete from inquiry where id=" . $id;
            $result3 = mysqli_query($con, $sql1);
            $responce = array("status" => TRUE, "msg" => "Operation Successful!");
            header("location:view/Inquiry.php");
        }
        if ($_GET['type'] == 'quotation') {

            $sql = "delete from add_quotation where id=" . $id;
            $result = mysqli_query($con, $sql);
            $responce = array("status" => TRUE, "msg" => "Operation Successful!");
            header("location:view/Quotation.php");
        }
        if ($_GET['type'] == 'godawn') {

            $sql = "delete from create_godawn where id=" . $id;

            $result = mysqli_query($con, $sql);

            $responce = array("status" => TRUE, "msg" => "Operation Successful!");

            header("location:Godawn.php");
        }
        if ($_GET['type'] == 'purchase') {

            $sql = "delete from purchase_list where id=" . $id;

            $result = mysqli_query($con, $sql);

            $responce = array("status" => TRUE, "msg" => "Operation Successful!");

            header("location:view/purchase.php");
        }
        if ($_GET['type'] == 'inquiry_send') {

            $sql = "delete from inquiry_send_to where id=" . $id;

            $result = mysqli_query($con, $sql);

            $responce = array("status" => TRUE, "msg" => "Operation Successful!");

            header("location:view/InquiryMainDetails.php");
        }
    } elseif (isset($_GET['inquiry_id'])) {

        include_once 'shreeLib/Controls.php';
        $cdba = new Controls();
        $dba = new DBAdapter();

        $query = "SELECT inquiry_item_list.item_id,inquiry_item_list.item_unit, inquiry_item_list.item_quantity,create_item.item_name FROM inquiry_item_list INNER JOIN create_item ON inquiry_item_list.item_id=create_item.id WHERE inquiry_item_list.id=" . $_GET['i_list_id'];
        //print_r($query);
        $result = mysqli_query($con, $query);

        $id = $_GET['i_list_id'];
        $plid = "";
        $itemname = "";
        $itemunit = "";
        $itemqnty = "";

        while ($rows = mysqli_fetch_array($result)) {
            $itemid = $rows['item_id'];
            $itemqnty = $rows['item_qnty'];
            $plid = $rows['pl_id'];
            $itemname = $rows['item_name'];
            $itemunit = $rows['item_unit'];
            $itemqnty = $rows['item_qnty'];
        }
        if ($result) {

            $sql = "delete from inquiry_item_list where id=" . $_GET['i_list_id'];
            $result = mysqli_query($con, $sql);
            //  $responce = array("status" => TRUE, "msg" => "Operation Successful!");
        } else {

            $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
        }
    }
}
?>

