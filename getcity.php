<?php
include 'shreeLib/dbconn.php';
include_once 'shreeLib/DBAdapter.php';
$dba = new DBAdapter();
$sql = "select * from cities where country_id='" . $_GET['countries'] . "' ORDER BY name";
$data = mysqli_query($con, $sql);
//$data = $dba->getRow("cities", array("id", "name"), "country_id='" . $_GET['countries'] . "'");
echo '<select class="form-control select2" name="city_id" id="cities" required="">';
echo '<option>Select City</option>';
foreach ($data as $subData) {

    echo "<option value=" . $subData['id'] . ">" . $subData['name'] . "</option>";
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
