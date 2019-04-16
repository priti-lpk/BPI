<?php
include 'shreeLib/dbconn.php';
include_once 'shreeLib/DBAdapter.php';


$dba = new DBAdapter();
$data = $dba->getRow("cities", array("id", "name"), "country_id='" . $_GET['countries'] . "'");
//$count = count($data);
//echo json_encode($data);
//print_r($count);
echo '<select class="form-control select2 chosen" tabindex="8" name="city_id" id="cities" required="">';
echo '<option>Select City</option>';


//print_r($data);
foreach ($data as $subData) {

    echo "<option value=" . $subData[0] . ">" . $subData[1] . "</option>";
}

echo '</select>';
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('.chosen').select2();
    });
    
</script>

<!--<script type="text/javascript" src="customFile/getcityJS.js"></script>-->