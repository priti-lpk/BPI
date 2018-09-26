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

                header("location:AddCategory.php");
            } else {

                $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
            }
        }
        if ($_GET['type'] == 'create_item') {

//            $query = "Select item_list.id, item_list.item_code,item_list.item_name,unit_list.unit_name, item_list.item_rate, item_list.hsn_code FROM item_list INNER JOIN unit_list ON item_list.item_unit_id=unit_list.id where item_list.id=" . $id;
//            //print_r($query);
//            $result = mysqli_query($con, $query);
//            $dba = new DBAdapter();
//            $itemid = "";
//            $itemcode = "";
//            $itemname = "";
//            $hsncode = "";
//            $uniname = "";
//            $itemrate = "";
//            while ($rows = mysqli_fetch_array($result)) {
//                $itemid = $rows['id'];
//                $itemcode = $rows['item_code'];
//                $itemname = $rows['item_name'];
//                $uniname = $rows['unit_name'];
//                $hsncode = $rows['hsn_code'];
//                $itemrate = $rows['item_rate'];
//            }
//            $user = $_SESSION['user_name'];
//
//            $ip_id = $cdba->get_client_ip();
//
//            date_default_timezone_set('Asia/Kolkata');
//            $date = date('d-m-Y h:i:s');
//
//            $user_array = array($user, $ip_id, $date, "Item List", $itemid, $itemcode, $itemname, $uniname, $itemrate, $hsncode);
//
//            $user_delete = json_encode($user_array, TRUE);
//
//            $_POST['delete_info'] = $user_delete;
//
//            $result = $dba->setData("delete_user_info", $_POST);
//
//            if ($result) {

            $sql = "delete from create_item where id=" . $id;

            $result = mysqli_query($con, $sql);

            $responce = array("status" => TRUE, "msg" => "Operation Successful!");

            header("location:AddItems.php");
//            } else {
//
//                $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
//            }
        }
        if ($_GET['type'] == 'create_party') {

//            $cdba = new Controls();
//
//            $query = "SELECT id, party_name,party_contact,party_gstno,party_address FROM party_list WHERE id=" . $id;
//            print_r($query);
//            $result = mysqli_query($con, $query);
//            $dba = new DBAdapter();
//            $id = "";
//            $name = "";
//            $contact = "";
//            $gst_no = "";
//            // $amount = "";
//            $address = "";
//            while ($rows = mysqli_fetch_array($result)) {
//                $id = $rows['id'];
//                $name = $rows['party_name'];
//                $contact = $rows['party_contact'];
//                $gst_no = $rows['party_gstno'];
//                //$amount = $rows['party_amount'];
//                $address = $rows['party_address'];
//            }
//            $user = $_SESSION['user_name'];
//
//            $ip_id = $cdba->get_client_ip();
//
//            date_default_timezone_set('Asia/Kolkata');
//            $date = date('d-m-Y h:i:s');
//
//            $user_array = array($user, $ip_id, $date, "Party List", $id, $name, $contact, $gst_no, $address);
//
//            $user_delete = json_encode($user_array, TRUE);
//
//            $_POST['delete_info'] = $user_delete;
//
//            $result = $dba->setData("delete_user_info", $_POST);
//
//            if ($result) {

            $sql = "delete from create_party where id=" . $id;

            $result = mysqli_query($con, $sql);

            $responce = array("status" => TRUE, "msg" => "Operation Successful!");

            header("location:AddParty.php");
//            } else {
//
//                $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
//            }
        }
        if ($_GET['type'] == 'supplier') {

//            $query = "Select item_list.id, item_list.item_code,item_list.item_name,unit_list.unit_name, item_list.item_rate, item_list.hsn_code FROM item_list INNER JOIN unit_list ON item_list.item_unit_id=unit_list.id where item_list.id=" . $id;
//            //print_r($query);
//            $result = mysqli_query($con, $query);
//            $dba = new DBAdapter();
//            $itemid = "";
//            $itemcode = "";
//            $itemname = "";
//            $hsncode = "";
//            $uniname = "";
//            $itemrate = "";
//            while ($rows = mysqli_fetch_array($result)) {
//                $itemid = $rows['id'];
//                $itemcode = $rows['item_code'];
//                $itemname = $rows['item_name'];
//                $uniname = $rows['unit_name'];
//                $hsncode = $rows['hsn_code'];
//                $itemrate = $rows['item_rate'];
//            }
//            $user = $_SESSION['user_name'];
//
//            $ip_id = $cdba->get_client_ip();
//
//            date_default_timezone_set('Asia/Kolkata');
//            $date = date('d-m-Y h:i:s');
//
//            $user_array = array($user, $ip_id, $date, "Item List", $itemid, $itemcode, $itemname, $uniname, $itemrate, $hsncode);
//
//            $user_delete = json_encode($user_array, TRUE);
//
//            $_POST['delete_info'] = $user_delete;
//
//            $result = $dba->setData("delete_user_info", $_POST);
//
//            if ($result) {

            $sql = "delete from supplier where id=" . $id;

            $result = mysqli_query($con, $sql);

            $responce = array("status" => TRUE, "msg" => "Operation Successful!");

            header("location:AddSupplier.php");
//            } else {
//
//                $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
//            }
        }
        if ($_GET['type'] == 'purchase_list') {
            $query = "select item_id, item_qnty, total from purchase_item_list where purchase_item_list.pl_id=" . $id;
            //print_r($query);
            $result = mysqli_query($con, $query);
            $dba = new DBAdapter();

            $row_amount = 0;
            $txt_total = 0;
            $totalamount = 0;
            while ($rows = mysqli_fetch_array($result)) {
                $itemid = $rows['item_id'];
                $itemqnty = $rows['item_qnty'];
                $row_amount += $rows['total'];

                $dba->updateStock($itemid, $itemqnty);
            }

            $query1 = "select purchase_list.party_id, party_list.party_name, purchase_list.p_invoice_no , purchase_list.pl_date, purchase_list.pay_type, purchase_list.total_amount,purchase_list.note from purchase_list INNER JOIN party_list ON purchase_list.party_id=party_list.id where purchase_list.id=" . $id;
//              print_r($query1); 
//              echo '</br>';
            $result1 = mysqli_query($con, $query1);
            $purchase_id = $id;
            $pname = "";
            $pinvoiceno = "";
            $pldate = "";
            $paytype = "";
            $note = "";
            $amount = "";
            while ($rows = mysqli_fetch_array($result1)) {

                $pname = $rows['party_name'];
                print_r($pname);
                $pinvoiceno = $rows['p_invoice_no'];
                $pldate = $rows['pl_date'];
                $paytype = $rows['pay_type'];
                $note = $rows['note'];
                $amount = $rows['total_amount'];
                $pamount = $row_amount;
                if ($rows['pay_type'] == 'Debit') {

                    $pid = $rows['party_id'];

                    $totalamount = $rows['total_amount'];

                    $dba->updatePartyAmount($pid, $pamount, 'Debit');
                }
            }
            //print_r($row_amount);

            $user = $_SESSION['user_name'];

            $ip_id = $cdba->get_client_ip();

            date_default_timezone_set('Asia/Kolkata');
            $date = date('d-m-Y h:i:s');

            $user_array = array($user, $ip_id, $date, "Purchase List", $purchase_id, $pname, $pinvoiceno, $pldate, $paytype, $amount, $note);
            // print_r($user_array);
            $user_delete = json_encode($user_array, TRUE);

            $_POST['delete_info'] = $user_delete;

            $result = $dba->setData("delete_user_info", $_POST);

            if ($result) {

                $txt_total = $totalamount - $row_amount;

                $sql = "delete from purchase_item_list where purchase_item_list.pl_id=" . $id;
//             print_r($sql);
//             echo '</br>';
                $result2 = mysqli_query($con, $sql);

                $sql1 = "delete from purchase_list where id=" . $id;
                // print_r($sql1)
                $result3 = mysqli_query($con, $sql1);

                $responce = array("status" => TRUE, "msg" => "Operation Successful!");

                header("location:ViewPurchase.php");
            } else {

                $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
            }
        }
        if ($_GET['type'] == 'sales_list') {
            $query = "select item_id, item_qnty, total from sales_item_list where sales_item_list.sl_id=" . $id;
            //print_r($query);
            $result = mysqli_query($con, $query);
            $dba = new DBAdapter();
            $row_amount = 0;
            $txt_total = 0;
            $totalamount = 0;
            while ($rows = mysqli_fetch_array($result)) {
                $itemid = $rows['item_id'];
                $itemqnty = $rows['item_qnty'];
                $row_amount += $rows['total'];

                $dba->updateStock($itemid, $itemqnty * (-1));
            }

            $query1 = "select sales_list.party_id, party_list.party_name,sales_list.s_invoice_no ,sales_list.sale_date, sales_list.pay_type,sales_list.total_amount,sales_list.note FROM sales_list INNER JOIN party_list ON sales_list.party_id=party_list.id where sales_list.id=" . $id;
            // print_r($query1);
            $result1 = mysqli_query($con, $query1);

            $purchase_id = $id;
            $pname = "";
            $pinvoiceno = "";
            $pldate = "";
            $paytype = "";
            $note = "";
            $amount = "";
            while ($rows = mysqli_fetch_array($result1)) {

                $pname = $rows['party_name'];
                $pinvoiceno = $rows['s_invoice_no'];
                $pldate = $rows['sale_date'];
                $paytype = $rows['pay_type'];
                $note = $rows['note'];
                $amount = $rows['total_amount'];
                $pamount = $row_amount;
                if ($rows['pay_type'] == 'Credit') {

                    $pid = $rows['party_id'];

                    $totalamount = $rows['total_amount'];

                    $dba->updatePartyAmount($pid, $pamount, 'Credit');
                }
            }
            //print_r($row_amount);

            $user = $_SESSION['user_name'];

            $ip_id = $cdba->get_client_ip();

            date_default_timezone_set('Asia/Kolkata');
            $date = date('d-m-Y h:i:s');

            $user_array = array($user, $ip_id, $date, "Sales List", $purchase_id, $pname, $pinvoiceno, $pldate, $paytype, $amount, $note);

            $user_delete = json_encode($user_array, TRUE);

            $_POST['delete_info'] = $user_delete;

            $result = $dba->setData("delete_user_info", $_POST);

            if ($result) {

                $txt_total = $totalamount - $row_amount;

                $sql = "delete from purchase_item_list where sales_item_list.sl_id=" . $id;
                //print_r($sql);
                $result2 = mysqli_query($con, $sql);

                $sql1 = "delete from sales_list where id=" . $id;

                $result3 = mysqli_query($con, $sql1);

                $responce = array("status" => TRUE, "msg" => "Operation Successful!");

                header("location:ViewSales.php");
            } else {

                $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
            }
        }
        if ($_GET['type'] == 'sales_return') {
            $query = "select item_id, item_qnty, total from sales_return_item_list where sales_return_item_list.sr_id=" . $id;
            //print_r($query);
            $result = mysqli_query($con, $query);
            $dba = new DBAdapter();
            $row_amount = 0;
            $txt_total = 0;
            $totalamount = 0;
            while ($rows = mysqli_fetch_array($result)) {
                $itemid = $rows['item_id'];
                $itemqnty = $rows['item_qnty'];
                $row_amount += $rows['total'];

                $dba->updateStock($itemid, $itemqnty);
            }

            $query1 = "select sales_return.party_id, party_list.party_name, sales_return.s_invoice_no ,sales_return.sale_date, sales_return.pay_type, sales_return.total_amount, sales_return.note from sales_return INNER JOIN party_list ON sales_return.party_id=party_list.id where sales_return.id=" . $id;
            //  print_r($query1);
            $result1 = mysqli_query($con, $query1);

            $purchase_id = $id;
            $pname = "";
            $pinvoiceno = "";
            $pldate = "";
            $paytype = "";
            $note = "";
            $amount = "";
            while ($rows = mysqli_fetch_array($result1)) {

                $pname = $rows['party_name'];
                $pinvoiceno = $rows['s_invoice_no'];
                $pldate = $rows['sale_date'];
                $paytype = $rows['pay_type'];
                $note = $rows['note'];
                $amount = $rows['total_amount'];

                $pamount = $row_amount;
                if ($rows['pay_type'] == 'Debit') {

                    $pid = $rows['party_id'];

                    $totalamount = $rows['total_amount'];

                    $dba->updatePartyAmount($pid, $pamount, 'Debit');
                }
            }
            //print_r($row_amount);

            $user = $_SESSION['user_name'];

            $ip_id = $cdba->get_client_ip();

            date_default_timezone_set('Asia/Kolkata');
            $date = date('d-m-Y h:i:s');

            $user_array = array($user, $ip_id, $date, "Sales Return", $purchase_id, $pname, $pinvoiceno, $pldate, $paytype, $amount, $note);

            $user_delete = json_encode($user_array, TRUE);

            $_POST['delete_info'] = $user_delete;

            $result = $dba->setData("delete_user_info", $_POST);

            if ($result) {

                $txt_total = $totalamount - $row_amount;

                $sql = "delete from sales_return_item_list where sales_return_item_list.sr_id=" . $id;
                //  print_r($sql);
                $result2 = mysqli_query($con, $sql);

                $sql1 = "delete from sales_return where id=" . $id;

                $result = mysqli_query($con, $sql1);

                $responce = array("status" => TRUE, "msg" => "Operation Successful!");

                header("location:ViewSalesReturn.php");
            } else {

                $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
            }
        }
        if ($_GET['type'] == 'purchase_order_list') {

            $dba = new DBAdapter();

//            $query = "select item_id, item_qnty, total from purchase_order_item_list where purchase_order_item_list.prl_id=" . $id;
//
//            $result = mysqli_query($con, $query);
//            // print_r($query);
//            $rowcount = mysqli_num_rows($result);
//            //echo $rowcount;
//            $row_amount = 0;
//            $txt_total = 0;
//            $totalamount = 0;
//
//            while ($rows = mysqli_fetch_array($result)) {
//                $itemid = $rows['item_id'];
//                $itemqnty = $rows['item_qnty'];
//                $row_amount += $rows['total'];
//
//                $dba->updateStock($itemid, $itemqnty);
//            }


            $query1 = "select purchase_order_list.party_id, party_list.party_name , purchase_order_list.pl_date, purchase_order_list.total_amount, purchase_order_list.note FROM purchase_order_list INNER JOIN party_list ON purchase_order_list.party_id=party_list.id where purchase_order_list.id=" . $id;
            //  print_r($query1);
            $result1 = mysqli_query($con, $query1);

            $purchase_id = $id;
            $pname = "";
            $pldate = "";
            $paytype = "";
            $note = "";
            $amount = "";
            while ($rows = mysqli_fetch_array($result1)) {

                $pname = $rows['party_name'];
                $pldate = $rows['pl_date'];
                $note = $rows['note'];
                $amount = $rows['total_amount'];

                $pamount = $row_amount;
                if ($rows['pay_type'] == 'Debit') {
                    $pid = $rows['party_id'];
                    $totalamount = $rows['total_amount'];

                    // $dba->updatePartyAmount($pid, $pamount, 'Debit');
                }
            }

            $user = $_SESSION['user_name'];

            $ip_id = $cdba->get_client_ip();

            date_default_timezone_set('Asia/Kolkata');
            $date = date('d-m-Y h:i:s');

            $user_array = array($user, $ip_id, $date, "Purchase Order", $purchase_id, $pname, $pldate, $amount, $note);

            $user_delete = json_encode($user_array, TRUE);

            $_POST['delete_info'] = $user_delete;

            $result = $dba->setData("delete_user_info", $_POST);

            if ($result) {

                $sql = "delete from purchase_order_item_list where prl_id=" . $id;

                $result2 = mysqli_query($con, $sql);

                $sql = "delete from purchase_order_list where id=" . $id;

                $result3 = mysqli_query($con, $sql);

                $responce = array("status" => TRUE, "msg" => "Operation Successful!");

                header("location:ViewPurchaseOrder.php");
            } else {

                $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
            }
        }
        if ($_GET['type'] == 'sales_order_list') {
            $dba = new DBAdapter();

            $query1 = "select sales_order_list.party_id, party_list.party_name , sales_order_list.sale_date, sales_order_list.total_amount, sales_order_list.note FROM sales_order_list INNER JOIN party_list ON sales_order_list.party_id=party_list.id where sales_order_list.id=" . $id;
            //  print_r($query1);
            $result1 = mysqli_query($con, $query1);

            $purchase_id = $id;
            $pname = "";
            $pldate = "";
            $paytype = "";
            $note = "";
            $amount = "";
            while ($rows = mysqli_fetch_array($result1)) {

                $pname = $rows['party_name'];
                $pldate = $rows['sale_date'];
                $note = $rows['note'];
                $amount = $rows['total_amount'];

                $pamount = $row_amount;
                if ($rows['pay_type'] == 'Debit') {

                    $pid = $rows['party_id'];
                    $totalamount = $rows['total_amount'];

                    //$dba->updatePartyAmount($pid, $pamount, 'Debit');
                }
            }

            $user = $_SESSION['user_name'];

            $ip_id = $cdba->get_client_ip();

            date_default_timezone_set('Asia/Kolkata');
            $date = date('d-m-Y h:i:s');

            $user_array = array($user, $ip_id, $date, "Sales Order", $purchase_id, $pname, $pldate, $amount, $note);

            $user_delete = json_encode($user_array, TRUE);

            $_POST['delete_info'] = $user_delete;

            $result = $dba->setData("delete_user_info", $_POST);

            if ($result) {

                $sql = "delete from sales_order_item_list where srl_id=" . $id;

                $result2 = mysqli_query($con, $sql);

                $sql1 = "delete from sales_order_list where id=" . $id;

                $result3 = mysqli_query($con, $sql1);

                $responce = array("status" => TRUE, "msg" => "Operation Successful!");

                header("location:ViewSalesOrder.php");
            } else {

                $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
            }
        }
        if ($_GET['type'] == 'payment_list') {
            $dba = new DBAdapter();
            $query = "select payment_list.party_id, party_list.party_name,payment_list.party_due,payment_list.pay_crdb,payment_list.pay_amount,payment_list.remain_amount,payment_list.pay_type,payment_list.pay_note FROM payment_list INNER JOIN party_list ON payment_list.party_id=party_list.id where payment_list.id=" . $id;
            //print_r($query);
            $result = mysqli_query($con, $query);
            $partyname = "";
            $partydue = "";
            $paycrdb = "";
            $payamount = "";
            $remainamount = "";
            $paytype = "";
            $paynote = "";
            while ($rows = mysqli_fetch_array($result)) {
                $partyname = $rows['party_name'];
                $partydue = $rows['party_id'];
                $paycrdb = $rows['party_due'];
                $payamount = $rows['pay_amount'];
                $remainamount = $rows['remain_amount'];
                $paytype = $rows['pay_type'];
                $paynote = $rows['pay_note'];
                if ($rows['pay_crdb'] == 'Debit') {

                    $pid = $rows['party_id'];
                    $pamount = $rows['pay_amount'];

                    $dba->updatePartyAmount($pid, $pamount * (-1), 'Debit');
                } else {
                    $pid = $rows['party_id'];
                    $pamount = $rows['pay_amount'];

                    $dba->updatePartyAmount($pid, $pamount * (-1), 'Credit');
                }
            }
            $user = $_SESSION['user_name'];

            $ip_id = $cdba->get_client_ip();

            date_default_timezone_set('Asia/Kolkata');
            $date = date('d-m-Y h:i:s');

            $user_array = array($user, $ip_id, $date, "Payment List", $id, $partyname, $partydue, $paycrdb, $payamount, $remainamount, $paytype, $paynote);

            $user_delete = json_encode($user_array, TRUE);

            $_POST['delete_info'] = $user_delete;

            $result = $dba->setData("delete_user_info", $_POST);

            if ($result) {

                $sql = "delete from payment_list where id=" . $id;

                $result = mysqli_query($con, $sql);

                $responce = array("status" => TRUE, "msg" => "Operation Successful!");

                header("location:AddPayment.php");
            } else {

                $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
            }
        }
    } elseif (isset($_GET['purchase_id'])) {

        include_once 'shreeLib/Controls.php';
        // include 'shreeLib/session_info.php';

        $cdba = new Controls();

        $dba = new DBAdapter();

        $query = "SELECT purchase_item_list.pl_id, purchase_item_list.item_id, purchase_item_list.item_qnty, purchase_item_list.item_rate, purchase_item_list.sub_total, purchase_item_list.gst, purchase_item_list.total, item_list.item_name FROM purchase_item_list INNER JOIN item_list ON purchase_item_list.item_id=item_list.id WHERE purchase_item_list.id=" . $_GET['p_list_id'];
        //print_r($query);
        $result = mysqli_query($con, $query);

        $row_amount = 0;
        $txt_total = 0;
        $totalamount = 0;

        $id = $_GET['p_list_id'];
        $plid = "";
        $itemname = "";
        $itemqnty = "";
        $itemrate = "";
        $subtotal = "";
        $itemgst = "";
        $total = "";
        while ($rows = mysqli_fetch_array($result)) {
            $itemid = $rows['item_id'];
            //print_r($itemid);
            $itemqnty = $rows['item_qnty'];
            //print_r($itemqnty);
            $row_amount = $rows['total'];

            $dba->updateStock($itemid, $itemqnty);

            $plid = $rows['pl_id'];
            $itemname = $rows['item_name'];
            $itemqnty = $rows['item_qnty'];
            $itemrate = $rows['item_rate'];
            $subtotal = $rows['sub_total'];
            $itemgst = $rows['gst'];
            $total = $rows['total'];
        }

        $query1 = "select party_id, pay_type,total_amount FROM purchase_list where id=" . $_GET['purchase_id'];
        //print_r($query1);
        $result1 = mysqli_query($con, $query1);
        while ($rows = mysqli_fetch_array($result1)) {


            $totalamount = $rows['total_amount'];

            if ($rows['pay_type'] == 'Debit') {

                $pid = $rows['party_id'];
                $pamount = $row_amount;

                // $dba->updatePartyAmount($pid, $pamount, 'Debit');
            }
        }
        //print_r($row_amount);
        $txt_total = $totalamount - $row_amount;

        if (!isset($_SESSION)) {
            session_start();
        }
        $user = $_SESSION['user_name'];

        $ip_id = $cdba->get_client_ip();

        date_default_timezone_set('Asia/Kolkata');
        $date = date('d-m-Y h:i:s');

        $user_array = array($user, $ip_id, $date, "Purchase Item List", $id, $plid, $itemname, $itemqnty, $itemrate, $subtotal, $itemgst, $total);

        $user_delete = json_encode($user_array, TRUE);

        $_POST['delete_info'] = $user_delete;

        $result = $dba->setData("delete_user_info", $_POST);

        if ($result) {

            $sql = "delete from purchase_item_list where id=" . $_GET['p_list_id'];

            $result = mysqli_query($con, $sql);

            print_r($txt_total);

            //  $responce = array("status" => TRUE, "msg" => "Operation Successful!");
        } else {

            $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
        }
    } elseif (isset($_GET['purchase_order_id'])) {

        include_once 'shreeLib/Controls.php';
        // include 'shreeLib/session_info.php';

        $cdba = new Controls();

        $dba = new DBAdapter();

        $query = "SELECT purchase_order_item_list.prl_id, purchase_order_item_list.item_id, purchase_order_item_list.item_qnty, purchase_order_item_list.item_rate, purchase_order_item_list.sub_total, purchase_order_item_list.gst, purchase_order_item_list.total, item_list.item_name FROM purchase_order_item_list INNER JOIN item_list ON purchase_order_item_list.item_id=item_list.id where purchase_order_item_list.id=" . $_GET['pr_list_id'];
        //print_r($query);
        $result = mysqli_query($con, $query);

        $row_amount = 0;
        $txt_total = 0;
        $totalamount = 0;

        $id = $_GET['pr_list_id'];
        $plid = "";
        $itemname = "";
        $itemqnty = "";
        $itemrate = "";
        $subtotal = "";
        $itemgst = "";
        $total = "";

        while ($rows = mysqli_fetch_array($result)) {
            $itemid = $rows['item_id'];
            //print_r($itemid);
            $itemqnty = $rows['item_qnty'];
            //print_r($itemqnty);
            $row_amount = $rows['total'];
            $rowcount = mysqli_num_rows($result);
            $txt_total = $rowcount;

            // $dba->updateStock($itemid, $itemqnty);

            $plid = $rows['prl_id'];
            $itemname = $rows['item_name'];
            $itemqnty = $rows['item_qnty'];
            $itemrate = $rows['item_rate'];
            $subtotal = $rows['sub_total'];
            $itemgst = $rows['gst'];
            $total = $rows['total'];
        }

        $query1 = "select party_id,total_amount from purchase_order_list where id=" . $_GET['purchase_order_id'];
        //print_r($query1);
        $result1 = mysqli_query($con, $query1);
        while ($rows = mysqli_fetch_array($result1)) {
            $pamount = $row_amount;
            $pid = $rows['party_id'];
            $totalamount = $rows['total_amount'];
        }


        if (!isset($_SESSION)) {
            session_start();
        }
        $user = $_SESSION['user_name'];

        $ip_id = $cdba->get_client_ip();

        date_default_timezone_set('Asia/Kolkata');
        $date = date('d-m-Y h:i:s');

        $user_array = array($user, $ip_id, $date, "Purchase Order Item List", $id, $plid, $itemname, $itemqnty, $itemrate, $subtotal, $itemgst, $total);

        $user_delete = json_encode($user_array, TRUE);

        $_POST['delete_info'] = $user_delete;

        $result = $dba->setData("delete_user_info", $_POST);

        if ($result) {

            $sql = "delete from purchase_order_item_list where id=" . $_GET['pr_list_id'];

            $result = mysqli_query($con, $sql);
            //echo  $txt_total;          
            // $responce = array("status" => TRUE, "msg" => "Operation Successful!");
        } else {

            $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
        }
        print_r($txt_total);
    } elseif (isset($_GET['sales_return_id'])) {

        include_once 'shreeLib/Controls.php';
        // include 'shreeLib/session_info.php';

        $cdba = new Controls();

        $dba = new DBAdapter();

        $query = "SELECT sales_return_item_list.sr_id, sales_return_item_list.item_id, sales_return_item_list.item_qnty, sales_return_item_list.item_rate, sales_return_item_list.sub_total, sales_return_item_list.gst, sales_return_item_list.total, item_list.item_name FROM sales_return_item_list INNER JOIN item_list ON sales_return_item_list.item_id=item_list.id WHERE sales_return_item_list.id=" . $_GET['s_return_id'];
        //print_r($query);
        $result = mysqli_query($con, $query);

        $row_amount = 0;
        $txt_total = 0;
        $totalamount = 0;

        $id = $_GET['s_return_id'];
        $plid = "";
        $itemname = "";
        $itemqnty = "";
        $itemrate = "";
        $subtotal = "";
        $itemgst = "";
        $total = "";

        while ($rows = mysqli_fetch_array($result)) {
            $itemid = $rows['item_id'];
            //print_r($itemid);
            $itemqnty = $rows['item_qnty'];
            //print_r($itemqnty);
            $row_amount = $rows['total'];

            $dba->updateStock($itemid, $itemqnty);

            $plid = $rows['sr_id'];
            $itemname = $rows['item_name'];
            $itemqnty = $rows['item_qnty'];
            $itemrate = $rows['item_rate'];
            $subtotal = $rows['sub_total'];
            $itemgst = $rows['gst'];
            $total = $rows['total'];
        }

        $query1 = "select party_id,total_amount,pay_type from sales_return where id=" . $_GET['sales_return_id'];
        //print_r($query1);
        $result1 = mysqli_query($con, $query1);
        while ($rows = mysqli_fetch_array($result1)) {
            $pamount = $row_amount;
            $pid = $rows['party_id'];
            $totalamount = $rows['total_amount'];
            if ($rows['pay_type'] == 'Debit') {

                $pid = $rows['party_id'];
                $pamount = $row_amount;

                //  $dba->updatePartyAmount($pid, $pamount , 'Debit');
            }
        }

        $txt_total = $totalamount - $row_amount;

        if (!isset($_SESSION)) {
            session_start();
        }

        $user = $_SESSION['user_name'];

        $ip_id = $cdba->get_client_ip();

        date_default_timezone_set('Asia/Kolkata');
        $date = date('d-m-Y h:i:s');

        $user_array = array($user, $ip_id, $date, "Sales Return Item List", $id, $plid, $itemname, $itemqnty, $itemrate, $subtotal, $itemgst, $total);

        $user_delete = json_encode($user_array, TRUE);

        $_POST['delete_info'] = $user_delete;

        $result = $dba->setData("delete_user_info", $_POST);

        if ($result) {

            $sql = "delete from sales_return_item_list where id=" . $_GET['s_return_id'];

            $result2 = mysqli_query($con, $sql);

            print_r($txt_total);

            // $responce = array("status" => TRUE, "msg" => "Operation Successful!");
        } else {

            $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
        }
    } elseif (isset($_GET['sales_order_id'])) {

        include_once 'shreeLib/Controls.php';
        //include 'shreeLib/session_info.php';

        $cdba = new Controls();

        $dba = new DBAdapter();
        $txt_total = 0;
        $query = "SELECT sales_order_item_list.srl_id, sales_order_item_list.item_id, sales_order_item_list.item_qnty, sales_order_item_list.item_rate, sales_order_item_list.sub_total, sales_order_item_list.gst, sales_order_item_list.total, item_list.item_name FROM sales_order_item_list INNER JOIN item_list ON sales_order_item_list.item_id=item_list.id WHERE sales_order_item_list.id=" . $_GET['sr_list_id'];
//        //print_r($query);
        $result = mysqli_query($con, $query);
        $row_amount = 0;
        $totalamount = 0;

        $id = $_GET['sr_list_id'];
        $plid = "";
        $itemname = "";
        $itemqnty = "";
        $itemrate = "";
        $subtotal = "";
        $itemgst = "";
        $total = "";

        while ($rows = mysqli_fetch_array($result)) {
//            $itemid = $rows['item_id'];
//            $itemqnty = $rows['item_qnty'];
            $row_amount = $rows['total'];
//            $dba->updateStock($itemid, $itemqnty);

            $plid = $rows['srl_id'];
            $itemname = $rows['item_name'];
            $itemqnty = $rows['item_qnty'];
            $itemrate = $rows['item_rate'];
            $subtotal = $rows['sub_total'];
            $itemgst = $rows['gst'];
            $total = $rows['total'];
        }
        $query1 = "select party_id,total_amount from sales_order_list where id=" . $_GET['sales_order_id'];
        //print_r($query1);
        $result1 = mysqli_query($con, $query1);
        while ($rows = mysqli_fetch_array($result1)) {
            $pamount = $row_amount;
            //  $pid = $rows['party_id'];
            $totalamount = $rows['total_amount'];
        }
        $txt_total = $totalamount - $row_amount;

        if (!isset($_SESSION)) {
            session_start();
        }
        $user = $_SESSION['user_name'];

        $ip_id = $cdba->get_client_ip();

        date_default_timezone_set('Asia/Kolkata');
        $date = date('d-m-Y h:i:s');

        $user_array = array($user, $ip_id, $date, "Sales Order Item List", $id, $plid, $itemname, $itemqnty, $itemrate, $subtotal, $itemgst, $total);

        $user_delete = json_encode($user_array, TRUE);

        $_POST['delete_info'] = $user_delete;

        $result = $dba->setData("delete_user_info", $_POST);

        if ($result) {

            $sql = "delete from sales_order_item_list where id=" . $_GET['sr_list_id'];

            $result2 = mysqli_query($con, $sql);
            print_r($txt_total);
            // $responce = array("status" => TRUE, "msg" => "Operation Successful!");
        } else {

            $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
        }
    } elseif (isset($_GET['sales_id'])) {

        include_once 'shreeLib/Controls.php';
        // include 'shreeLib/session_info.php';

        $cdba = new Controls();

        $dba = new DBAdapter();

        $query = "SELECT sales_item_list.sl_id, sales_item_list.item_id, sales_item_list.item_qnty, sales_item_list.item_rate, sales_item_list.sub_total, sales_item_list.gst, sales_item_list.total, item_list.item_name FROM sales_item_list INNER JOIN item_list ON sales_item_list.item_id=item_list.id WHERE sales_item_list.id=" . $_GET['s_list_id'];
        //print_r($query);
        $result = mysqli_query($con, $query);

        $row_amount = 0;
        $txt_total = 0;
        $totalamount = 0;

        $id = $_GET['s_list_id'];
        $plid = "";
        $itemname = "";
        $itemqnty = "";
        $itemrate = "";
        $subtotal = "";
        $itemgst = "";
        $total = "";

        while ($rows = mysqli_fetch_array($result)) {
            $itemid = $rows['item_id'];
            //print_r($itemid);
            $itemqnty = $rows['item_qnty'];
            //print_r($itemqnty);
            $row_amount = $rows['total'];

            $dba->updateStock($itemid, $itemqnty * (-1));

            $plid = $rows['sl_id'];
            $itemname = $rows['item_name'];
            $itemqnty = $rows['item_qnty'];
            $itemrate = $rows['item_rate'];
            $subtotal = $rows['sub_total'];
            $itemgst = $rows['gst'];
            $total = $rows['total'];
        }

        $query1 = "select party_id, pay_type,total_amount from sales_list where id=" . $_GET['sales_id'];
        // print_r($query1);
        $result1 = mysqli_query($con, $query1);
        while ($rows = mysqli_fetch_array($result1)) {

            $pamount = $row_amount;
            $totalamount = $rows['total_amount'];
            $pid = $rows['party_id'];
            if ($rows['pay_type'] == 'Debit') {

                // $dba->updatePartyAmount($pid, $pamount, 'Debit');
            }
        }
        //print_r($row_amount);
        $txt_total = $totalamount - $row_amount;
        // print_r($txt_total);
        if (!isset($_SESSION)) {
            session_start();
        }
        $user = $_SESSION['user_name'];

        $ip_id = $cdba->get_client_ip();

        date_default_timezone_set('Asia/Kolkata');
        $date = date('d-m-Y h:i:s');

        $user_array = array($user, $ip_id, $date, "Sales Item List", $id, $plid, $itemname, $itemqnty, $itemrate, $subtotal, $itemgst, $total);

        $user_delete = json_encode($user_array, TRUE);

        $_POST['delete_info'] = $user_delete;

        $result = $dba->setData("delete_user_info", $_POST);

        if ($result) {

            $sql = "delete from sales_item_list where id=" . $_GET['s_list_id'];

            $result2 = mysqli_query($con, $sql);

            print_r($txt_total);

            // $responce = array("status" => TRUE, "msg" => "Operation Successful!");
        } else {

            $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
        }
    }
}
?>

