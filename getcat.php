<?php
include 'shreeLib/dbconn.php';
include_once 'shreeLib/DBAdapter.php';


$dba = new DBAdapter();
$data = $dba->getRow("sub_category", array("id", "sub_cat_name"), "main_cat_id='" . $_GET['main_cat_id'] . "' and status='1'");

echo '<select class="form-control select2 chosen" name="sub_cat_id" id="sub_cat_id" required="">';
echo '<option>Select Sub Category</option>';


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

