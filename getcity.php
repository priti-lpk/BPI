<?php
include 'shreeLib/dbconn.php';
include_once 'shreeLib/DBAdapter.php';
$dba = new DBAdapter();
$data = $dba->getRow("cities", array("id", "name"), "country_id='" . $_GET['countries'] . "'");
echo '<select class="form-control select2" name="city_id" id="cities" required="">';
echo '<option>Select City</option>';
foreach ($data as $subData) {

    echo "<option value=" . $subData[0] . ">" . $subData[1] . "</option>";
}
echo '</select>';
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('.select2').select2();
    });

</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('select').on(
                'select2:close',
                function () {
                    $(this).focus();
                }
        );
    });
</script>
