<?php
//echo "asd";
ob_start();
include_once '../shreeLib/Controls.php';
include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
$dba = new DBAdapter();
$sp_id = $_POST['s_id'];
//echo $sp_id;
$status = $_POST['status'];
$note = $_POST['note'];
$date= date("Y-m-d H:i:s"); 
//echo $date;

$field = array("status" => $_POST['status'],"note" => $_POST['note'],"date_time" => $date);
$result = $dba->updateRow("link_master", $field, "send_party_id=" . $_POST['s_id']);
?>