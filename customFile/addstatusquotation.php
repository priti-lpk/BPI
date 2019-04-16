<?php
ob_start();
include_once '../shreeLib/Controls.php';
include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';
$dba = new DBAdapter();
$quo_id = $_POST['quotation_id'];
$status = $_POST['status1'];
$field = array("status" => $_POST['status1']);
$result = $dba->updateRow("add_quotation", $field, "id=" . $_POST['quotation_id']);
?>