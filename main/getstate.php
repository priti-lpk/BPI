<?php

include 'shreeLib/dbconn.php';
include_once 'shreeLib/DBAdapter.php';


$dba = new DBAdapter();
$data = $dba->getRow("states", array("id", "state_name"), "country_id='" . $_GET['countries'] . "'");

echo ' <select name = "state_id" id = "states" class = "form-control select2" required> ';
echo '<option>Select State</option>';


//print_r($data);
foreach ($data as $subData) {

    echo "<option value=" . $subData[0] . ">" . $subData[1] . "</option>";
}

echo '</select>';
?>
<script type="text/javascript">
    $(".form-control select2").select2("destroy");
    $(".form-control select2").select2();
</script>
