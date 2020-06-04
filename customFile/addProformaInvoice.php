<?php

ob_start();
include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/Controls.php';
//echo 'das';
if ($_POST) {
//    echo "df";
    $dba = new DBAdapter();
    unset($_POST['action']);


//    echo $sql1;

    $totalrow = count($_POST['item_id']);
    for ($i = 0; $i < $totalrow; $i++) {
//        $_POST['invoice_date'][$i] = date('Y-m-d', strtotime($_POST['invoice_date'][$i]));
//        $_POST['bl_date'][$i] = date('Y-m-d', strtotime($_POST['bl_date'][$i]));
//        $_POST['sb_date'][$i] = date('Y-m-d', strtotime($_POST['sb_date'][$i]));
        $quo_id = $_POST['quo_id'][$i];
//        echo $quo_id;
        $p_invoice_no = $_POST['p_invoice_no'][$i];
//        echo $p_invoice_no;
        $invoice_date = $_POST['invoice_date'][$i];
//        echo $invoice_date;
        $exporter_no = $_POST['exporter_no'][$i];
//         echo $exporter_no;
        $inquiry_no = $_POST['inquiry_no'][$i];
//         echo $inquiry_no;
        $buyer_order_no = $_POST['buyer_order_no'][$i];
//          echo $buyer_order_no;
        $bl_no = $_POST['bl_no'][$i];
//         echo $bl_no;
        $sb_no = $_POST['sb_no'][$i];
//         echo $sb_no;
        $bl_date = $_POST['bl_date'][$i];
//         echo $bl_date;
        $sb_date = $_POST['sb_date'][$i];
//         echo $sb_date;
        $delivery = $_POST['delivery'][$i];
//         echo $delivery;
        $payment = $_POST['payment'][$i];
//         echo $payment;
        $fob_value = $_POST['fob_value'][$i];
//        echo $fob_value;
        $cf_freight = $_POST['cf_freight'][$i];
//         echo $cf_freight;
        $cif_freight = $_POST['cif_freight'][$i];
//        echo $cif_freight;
        $cf_value = $_POST['cf_value'][$i];
//        echo $cf_value;
        $insurance = $_POST['insurance'][$i];
//        echo $insurance;
        $cif_value = $_POST['cif_value'][$i];
//        echo $cif_value;
        $total_amount = $_POST['total_amount'][$i];
//        echo $total_amount;
        $party_id = $_POST['party_id'][$i];
//        echo $party_id;
        $sup_id = $_POST['sup_id'][$i];
//        echo $sup_id;
        $user_id = $_POST['user_id'][$i];
        $sql1 = "INSERT INTO send_party (quo_id , p_invoice_no , invoice_date,exporter_no,inquiry_no,buyer_order_no,bl_no,sb_no,bl_date,sb_date,delivery,payment,fob_value,cf_freight,cif_freight,cf_value,insurance,cif_value,total_amount,party_id,sup_id,user_id) VALUES ('" . $quo_id . "','" . $p_invoice_no . "','" . $invoice_date . "','" . $exporter_no . "','" . $inquiry_no . "','" . $buyer_order_no . "','" . $bl_no . "','" . $sb_no . "','" . $bl_date . "','" . $sb_date . "','" . $delivery . "','" . $payment . "','" . $fob_value . "','" . $cf_freight . "','" . $cif_freight . "','" . $cf_value . "','" . $insurance . "','" . $cif_value . "','" . $total_amount . "','" . $party_id . "','" . $sup_id . "','" . $user_id . "')";
        mysqli_query($con, $sql1);
//        echo $sql1;   
        $last_id = $dba->getLastID("id", "send_party", "1");
        $item_id = (explode(",", $_POST['item_id'][$i]));
        $item_name = (explode(",", $_POST['item_name'][$i]));
        $item_qty = (explode(",", $_POST['item_qty'][$i]));
        $item_unit = (explode(",", $_POST['item_unit'][$i]));
        $item_rate = (explode(",", $_POST['item_rate'][$i]));
        $item_amount = (explode(",", $_POST['item_amount'][$i]));
        $arraySize = sizeof($item_id);
        for ($p = 0; $p < $arraySize; $p++) {
            $sql = "INSERT INTO  send_party_item_list (send_party_id,item_id,item_name,item_qty,item_unit,item_rate,item_amount) VALUES ('" . $last_id . "','" . $item_id[$p] . "','" . $item_name[$p] . "','" . $item_qty[$p] . "','" . $item_unit[$p] . "','" . $item_rate[$p] . "','" . $item_amount[$p] . "')";
            mysqli_query($con, $sql);
//            echo $sql;
        }
    }
//    header('location:../view/InquirySend.php');
}
?>

