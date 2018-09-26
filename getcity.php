<?php

ob_start();
include 'shreeLib/dbconn.php';
include_once 'shreeLib/DBAdapter.php';

if (!isset($_SESSION)) {
    session_start();
}

$dba = new DBAdapter();
$data = $dba->getRow("cities", array("id", "name"), "country_id='" . $_GET['countries'] . "'");
$count = count($data);
//print_r($count);
echo ' <select name = "city_id" id = "cities" class = "change_item_dropdown_ajax" required> ';
echo '<option>Select City</option>';


//print_r($data);
foreach ($data as $subData) {

    echo "<option value=" . $subData[0] . ">" . $subData[1] . "</option>";
}

echo '</select>';
?>
<script type="text/javascript">
    $(".change_item_dropdown_ajax").select2("destroy");
    $(".change_item_dropdown_ajax").select2();
</script>
