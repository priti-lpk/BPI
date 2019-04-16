<?php

include 'shreeLib/dbconn.php';
include_once 'shreeLib/DBAdapter.php';


$dba = new DBAdapter();
$data = $dba->getRow("sub_category", array("id", "sub_cat_name"), "main_cat_id='" . $_GET['main_cat_id'] . "'");

echo '<select class="form-control select2" name="sub_cat_id" id="sub_cat_id" required="">';
echo '<option>Select Sub Category</option>';


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

