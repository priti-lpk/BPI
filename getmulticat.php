<?php

include 'shreeLib/dbconn.php';
include_once 'shreeLib/DBAdapter.php';

$dba = new DBAdapter();
$data = $dba->getRow("sub_category", array("id", "sub_cat_name"), "main_cat_id='" . $_GET['main_cat_id'] . "' and status='1'");

echo '<select name="sub_cat_id[]" id="sub_list" class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Choose ...">';
//print_r($data);
foreach ($data as $subData) {
    echo "<option value=" . $subData[0] . ">" . $subData[1] . "</option>";
}
echo '</select>';
?>


