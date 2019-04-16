<?php
include_once 'shreeLib/DBAdapter.php';
include_once 'shreeLib/dbconn.php';

if (isset($_GET['type']) && isset($_GET['id'])) {
    $edba = new DBAdapter();
    $edata = $edba->getRow("create_user", array("*"), "id=" . $_GET['id']);
    echo "<input type='hidden' id='create_user_id' value='" . $_GET['id'] . "'>";

    $field1 = array("COUNT(mod_id)");
    $countrow = $edba->getRow("role_rights", $field1, "user_id=" . $_GET['id']);
    //$crow= count($countrow[0][1]);
    echo "<input type='hidden' id='rowcount' value='" . $countrow[0][0] . "'>";
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Get Data</title>
        <link href="plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <form action="insertdata.php" id="form_data" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" style="margin-top: 40px;margin-left: 30px;">  
            <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">User Name</label>
                <div class="col-sm-4">
                    <input class="form-control" type="text"  placeholder="User Fullname" id="user_fullname" name="user_fullname" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][5] : ''); ?>" required="">
                </div>
            </div>
            <div class="form-group row" >
                <br><br><br>
                <label for="example-text-input" class="col-sm-2 col-form-label">Multiple Choose</label>
                <div class = "col-sm-4">
                    <select name="role_rights_id[]" id="role_master1" class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Choose ...">
                        <?php
                        $dba = new DBAdapter();
                        $data = $dba->getRow("create_branch", array("id", "branch_name"), "branch_status='true'");
                        foreach ($data as $subData) {
                            echo" <option " . ($subData[0] == $edata[0][1] ? 'selected' : '') . " value='" . $subData[0] . "'>" . $subData[1] . "</option> ";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row" style="margin-left: 250px;">
                <input type="hidden" name="action" id="action" value="<?php echo (isset($_GET['id']) ? 'edit' : 'add') ?>"/>
                <input type="hidden" name="id" id="id" value="<?php echo (isset($_GET['id']) ? $edata[0][0] : '') ?>"/>
                <button type="submit" id="btn_save" class="btn btn-primary waves-effect waves-light">Save</button>&nbsp;&nbsp;
                <button type="submit" id="btn_save" class="btn btn-primary waves-effect waves-light">Edit</button>
            </div>
        </form>
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/waves.min.js"></script>
        <script src="plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
        <script src="plugins/bootstrap-md-datetimepicker/js/moment-with-locales.min.js"></script>
        <script src="plugins/bootstrap-md-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
        <script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
        <script src="plugins/select2/js/select2.min.js"></script>
        <script src="plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
        <script src="plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js"></script>
        <script src="assets/pages/form-advanced.js"></script>
        <script src="assets/js/app.js"></script>
    </body>
</html>