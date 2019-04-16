<?php

ob_start();
include 'shreeLib/dbconn.php';
include_once 'shreeLib/DBAdapter.php';

if (!isset($_SESSION)) {
    session_start();
}

$dba = new DBAdapter();
$last_id1 = $dba->getLastID("id", "supplier", "1");
 //print_r($last_id1);
echo ' <select name = "supplier_id" id = "supplier" class = "form-control select2" required> ';
echo '<option>Select Supplier</option>';

$last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
$data = $dba->getRow("supplier", array("id", "sup_name"), "1");
print_r($data);
foreach ($data as $subData) {

    echo" <option " . ($subData[0] == $last_id1 ? 'selected' : '') . " value='" . $subData[0] . "'>" . $subData[1] . "</option> ";
}

echo '</select>';
?>
<script type="text/javascript">
    
$(".change_item_dropdown_ajax").select2("destroy");
$(".change_item_dropdown_ajax").select2();

</script>
