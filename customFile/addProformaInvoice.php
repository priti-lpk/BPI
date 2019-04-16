<?php

ob_start();
include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/Controls.php';
if ($_POST['action'] == 'add') {
    $dba = new DBAdapter();
    $quo_id = $_POST['quo_id'];
    $link = $_POST['url_link'];
    $expiry = $_POST['time_stamp'];
    $urlmd5 = $_POST['md5'];
    $q_id = md5($_POST['quo_id']);
   // echo $_POST['bl_date'];
    $date = $expiry;
    $dates = date("d-m-Y", strtotime($date));

    unset($_POST['action']);
    $t = $_POST['total_amount'];
    $sql1 = "INSERT INTO send_party (quo_id , p_invoice_no , invoice_date,exporter_no,inquiry_no,buyer_order_no,bl_no,sb_no,bl_date,sb_date,delivery,payment,fob_value,cf_freight,cif_freight,cf_value,insurance,cif_value,total_amount,party_id) VALUES ('" . $_POST['quo_id'] . "','" . $_POST['p_invoice_no'] . "','" . $_POST['invoice_date'] . "','" . $_POST['exporter_no'] . "','" . $_POST['inquiry_no'] . "','" . $_POST['buyer_order_no'] . "','" . $_POST['bl_no'] . "','" . $_POST['sb_no'] . "','" . $_POST['bl_date'] . "','" . $_POST['sb_date'] . "','" . $_POST['delivery'] . "','" . $_POST['payment'] . "','" . $_POST['fob_value'] . "','" . $_POST['cf_freight'] . "','" . $_POST['cif_freight'] . "','" . $_POST['cf_value'] . "','" . $_POST['insurance'] . "','" . $_POST['cif_value'] . "','" . $_POST['total_amount'] . "','" . $_POST['party_id'] . "')";
    mysqli_query($con, $sql1);
   // echo $sql1;
    $last_id = $dba->getLastID("id", "send_party", "1");
    //echo $last_id;
    $totalrow = count($_POST['item_id']);
    for ($i = 0; $i < $totalrow; $i++) {
        $sql = "INSERT INTO  send_party_item_list (send_party_id,item_id,item_name,item_qty,item_unit,item_rate,item_amount) VALUES ('" . $last_id . "','" . $_POST['item_id'][$i] . "','" . $_POST['item_name'][$i] . "','" . $_POST['item_qty'][$i] . "','" . $_POST['item_unit'][$i] . "','" . $_POST['item_rate'][$i] . "','" . $_POST['item_amount'][$i] . "')";
        mysqli_query($con, $sql);
//        echo $sql;
    }

    $sql1 = "INSERT INTO link_master (quotation_id,url_link,expiry_date,q_id,send_party_id,s_id) VALUES ('" . $quo_id . "','" . $link . "','" . $expiry . "','" . $urlmd5 . "','" . $last_id . "','" . md5($last_id) . "')";
    mysqli_query($con, $sql1);

    $link = $_POST['url_link'];
    $quo_id = $_POST['md5'];
    $quo_id1 = $_POST['quo_id'];

    $query1 = "select q_id from link_master where url_link='$link'";
    $sql2 = mysqli_query($con, $query1);
//print_r($query1);
    $email_to = "preetihirani2909@gmail.com";
//    $ul = "Link: <a href=http://localhost/bpiindia/view/SendParty.php?id=" . str_replace("$quo_id", "$quo_id1", $quo_id);
    $expiry = $_POST['time_stamp'];
    $fromemail = "talk@lpktechnosoft.com";
    $email_subject = "Send Link";
    $headers = "From:" . $fromemail . "\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html;charset = ISO-8859-1\r\n";
    $headers .= "Reply-To: " . $fromemail . "\n";
    $message = "
    Link: <a href = http://localhost/bpiindia1/view/proforma_invoice.php?s_id=" . md5($last_id) . " target='_blank' onclick='setTimeout('alert(\'Surprise!\')', 1542542887)'>View Link</a><br>
    Expiry: " . $dates . "<br>
    Link Expired in 3 days...!!<br>
    ";
    echo $message;
    $sent = mail($email_to, $email_subject, $message, $headers);
    unset($_POST);
   //header('location:../view/Send_Party.php');
} elseif ($_POST['action'] == 'edit') {

    include_once '../shreeLib/DBAdapter.php';

    $dba = new DBAdapter();

    $cdba = new Controls();

    $id = $_POST['id'];
    unset($_POST['action']);

    $dba = new DBAdapter();
    $quo_id = $_POST['quo_id'];
    $link = $_POST['url_link'];
    $expiry = $_POST['time_stamp'];
    $urlmd5 = $_POST['md5'];
    $q_id = md5($_POST['quo_id']);
    $date = $expiry;
    $dates = date("d-m-Y", strtotime($date));

    $t = $_POST['total_amount'];
    print_r($t);
    if ($_POST['select1'] == 'cif') {

        $sql1 = "update send_party set quo_id='" . $_POST['quo_id'] . "' , p_invoice_no='" . $_POST['p_invoice_no'] . "' , invoice_date='" . $_POST['invoice_date'] . "',exporter_no='" . $_POST['exporter_no'] . "',inquiry_no='" . $_POST['inquiry_no'] . "',buyer_order_no='" . $_POST['buyer_order_no'] . "',bl_no='" . $_POST['bl_no'] . "',sb_no='" . $_POST['sb_no'] . "',bl_date='" . $_POST['bl_date'] . "',sb_date='" . $_POST['sb_date'] . "',delivery='" . $_POST['delivery'] . "',payment='" . $_POST['payment'] . "',fob_value='" . $_POST['fob_value'] . "',cf_freight='" . 0 . "',cif_freight='" . $_POST['cif_freight'] . "',cf_value='" . 0 . "',insurance='" . $_POST['insurance'] . "',cif_value='" . $_POST['cif_value'] . "',total_amount='" . $_POST['total_amount'] . "' where id=" . $_POST['id'];
        mysqli_query($con, $sql1);
        //print_r($sql1);
    }
    if ($_POST['select1'] == 'cf') {

        $sql1 = "update send_party set quo_id='" . $_POST['quo_id'] . "' , p_invoice_no='" . $_POST['p_invoice_no'] . "' , invoice_date='" . $_POST['invoice_date'] . "',exporter_no='" . $_POST['exporter_no'] . "',inquiry_no='" . $_POST['inquiry_no'] . "',buyer_order_no='" . $_POST['buyer_order_no'] . "',bl_no='" . $_POST['bl_no'] . "',sb_no='" . $_POST['sb_no'] . "',bl_date='" . $_POST['bl_date'] . "',sb_date='" . $_POST['sb_date'] . "',delivery='" . $_POST['delivery'] . "',payment='" . $_POST['payment'] . "',fob_value='" . $_POST['fob_value'] . "',cf_freight='" . $_POST['cf_freight'] . "',cif_freight='" . 0 . "',cf_value='" . $_POST['cf_value'] . "',insurance='" . 0 . "',cif_value='" . $_POST['cif_value'] . "',total_amount='" . $_POST['total_amount'] . "' where id=" . $_POST['id'];
        mysqli_query($con, $sql1);
        // print_r($sql1);
    }
    if ($_POST['select1'] == 'fob') {

        $sql1 = "update send_party set quo_id='" . $_POST['quo_id'] . "' , p_invoice_no='" . $_POST['p_invoice_no'] . "' , invoice_date='" . $_POST['invoice_date'] . "',exporter_no='" . $_POST['exporter_no'] . "',inquiry_no='" . $_POST['inquiry_no'] . "',buyer_order_no='" . $_POST['buyer_order_no'] . "',bl_no='" . $_POST['bl_no'] . "',sb_no='" . $_POST['sb_no'] . "',bl_date='" . $_POST['bl_date'] . "',sb_date='" . $_POST['sb_date'] . "',delivery='" . $_POST['delivery'] . "',payment='" . $_POST['payment'] . "',fob_value='" . $_POST['fob_value'] . "',cf_freight='" . 0 . "',cif_freight='" . 0 . "',cf_value='" . 0 . "',insurance='" . 0 . "',cif_value='" . 0 . "',total_amount='" . $_POST['total_amount'] . "' where id=" . $_POST['id'];
        mysqli_query($con, $sql1);
        //print_r($sql1);
    }

    $last_id = $dba->getLastID("id", "send_party", "1");
    $totalrow = count($_POST['item_id']);

    for ($i = 0; $i < $totalrow; $i++) {
        $sql = "update send_party_item_list set send_party_id='" . $last_id . "',item_id='" . $_POST['item_id'][$i] . "',item_name='" . $_POST['item_name'][$i] . "',item_qty='" . $_POST['item_qty'][$i] . "',item_unit='" . $_POST['item_unit'][$i] . "',item_rate='" . $_POST['item_rate'][$i] . "',item_amount='" . $_POST['item_amount'][$i] . "' where id=" . $_POST['id'];
        mysqli_query($con, $sql);
        // print_r($sql);
    }

    $sql2 = "update link_master set quotation_id='" . $quo_id . "',url_link='" . $link . "',expiry_date='" . $expiry . "',q_id='" . $urlmd5 . "',send_party_id='" . $_POST['id'] . "',s_id='" . md5($last_id) . "' where quotation_id=" . $_POST['quo_id'];
    mysqli_query($con, $sql2);
//    print_rq($sl2);
    $link = $_POST['url_link'];
    $quo_id = $_POST['md5'];
    $quo_id1 = $_POST['quo_id'];

    $query1 = "select q_id from link_master where url_link='$link'";
    $sql2 = mysqli_query($con, $query1);
//print_r($query1);
    $email_to = "preetihirani2909@gmail.com";
//    $ul = "Link: <a href=http://localhost/bpiindia/view/SendParty.php?id=" . str_replace("$quo_id", "$quo_id1", $quo_id);
    $expiry = $_POST['time_stamp'];
    $fromemail = "talk@lpktechnosoft.com";
    $email_subject = "Send Link";
    $headers = "From:" . $fromemail . "\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html;charset = ISO-8859-1\r\n";
    $headers .= "Reply-To: " . $fromemail . "\n";
    $message = "
    Link: <a href = http://localhost/bpiindia1/view/proforma_invoice.php?q_id=" . md5($last_id) . " target='_blank' onclick='setTimeout('alert(\'Surprise!\')', 1542542887)'>View Link</a><br>
    Expiry: " . $dates . "<br>
    Link Expired in 3 days...!!<br>
    ";
    echo $message;
    $sent = mail($email_to, $email_subject, $message, $headers);
    unset($_POST);
//    header('location:../view/Send_Party.php');
}
?>

