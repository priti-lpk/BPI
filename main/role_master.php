<?php
include_once 'shreeLib/DBAdapter.php';
include_once 'shreeLib/dbconn.php';

if (isset($_GET['type']) && isset($_GET['id'])) {
    $edba = new DBAdapter();
//    echo '<br><br><br>';
    $edata = $edba->getRow("role_master", array("*"), "id=" . $_GET['id']);
    echo "<input type='hidden' id='role_master_id' value='" . $_GET['id'] . "'>";

    $field1 = array("COUNT(mod_id)");
    $countrow = $edba->getRow("role_rights", $field1, "role_id=" . $_GET['id']);
    echo "<input type='hidden' id='rowcount' value='" . $countrow[0][0] . "'>";
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title><?php
            if (isset($_GET['type']) && isset($_GET['id'])) {
                echo 'Edit User Field';
            } else {
                echo 'Add User Field';
            }
            ?></title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="Themesbrand" name="author" />
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <link href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
        <link href="plugins/bootstrap-md-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
        <link href="plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

        <link href="plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    </head>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <?php include 'topbar.php'; ?>
            <!-- Top Bar End -->

            <!-- ========== Left Sidebar Start ========== -->
            <?php include 'sidebar.php'; ?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">User Field</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="page-content-wrapper">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">                   
                                            <form action="customFile/role_masterPro.php" id="form_data" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" >  
                                                <h4 class="mt-0 header-title">Textual inputs</h4>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Role Name</label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" type="text"  placeholder="Role Name" id="role_name" name="role_name" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][1] : ''); ?>" required="">
                                                    </div>
                                                </div><br>
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align:center; width: 70px;">ID</th>
                                                           <th style="text-align:center;width: 250px;">Module Name</th>
                                                           <th style="text-align:center;width: 100px;">Create&nbsp;&nbsp;&nbsp;<input class='check_all_create' id="ck_create" type='checkbox' onclick="select_all()"/></th>
                                                           <!--<th style="text-align:center;width: 100px;"><input class='check_all' type='checkbox' onclick="select_all()"/>&nbsp;Create</th>-->
                                                           <th style="text-align:center;width: 100px;">Edit&nbsp;&nbsp;&nbsp;<input class='check_all_edit' id="ck_edit" type='checkbox' onclick="select_all()"/></th>
                                                           <th style="text-align:center;width: 80px;">View&nbsp;&nbsp;&nbsp;<input class='check_all_view' id="ck_view" type='checkbox' onclick="select_all()"/></th>
                                                           <th style="text-align:center;width: 80px;">Delete&nbsp;&nbsp;&nbsp;<input class='check_all_delete' id="ck_delete" type='checkbox' onclick="select_all()"/></th>

                                                        </tr>
                                                    </thead>
                                                    <tbody id="view_data1" name="view_data">
                                                        <?php
                                                        $sql = "SELECT id, mod_name, mod_order,mod_role from module order by mod_order limit 10";
                                                        //print_r($sql);
                                                        $result = mysqli_query($con, $sql);
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            ?>
                                                            <tr>
                                                                <td style="text-align:center; width: 70px;"><span id = 'snum'><?= $row['mod_order'] ?></span></td>
                                                                <td style="text-align:center;width: 250px;"><?= $row['mod_name'] ?></td>
                    <!--                                                            <input type='text' id='module_name' class='module_name'  name='mod_name[]' value="<?= $row['mod_name'] ?>" disabled=""/></td>-->
                                                                <td style="text-align:center;width: 100px;"><input type = 'checkbox' class = 'create' name="role_create[<?= $row['mod_order'] ?>]" value=""/></td>
                                                                <td style="text-align:center;width: 100px;"><input type = 'checkbox' id="edit<?= $row['id'] ?>" class = 'edit'  name="role_edit[<?= $row['mod_order'] ?>]" onclick="edit(<?= $row['id'] ?>)" /></td>
                                                                <td style="text-align:center;width: 80px;"><input type = 'checkbox' id="view<?= $row['id'] ?>" class = 'view' name="role_view[<?= $row['mod_order'] ?>]" onclick="view(<?= $row['id'] ?>)" /></td>
                                                                <td style="text-align:center;width: 80px;"><input type = 'checkbox' class = 'delete1' name="role_delete[<?= $row['mod_order'] ?>]"/></td>
                                                        <input type='hidden' id='module_id' class='module_name' name='mod_id[]' value="<?= $row['id'] ?>" />
                                                        <input type = 'hidden' id = 'mod_role' class = 'module_name' name = 'mod_role[]' value = '<?php echo $row['mod_role']; ?>' />
                                                        <input type = 'hidden' id = 'mod_order' class = 'mod_order' name = 'mod_order[]' value = '<?php echo $row['mod_order']; ?>' />

                                                        </tr>

                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                                <div class="button-items">
                                                    <input type="hidden" name="action" id="action" value="<?php echo (isset($_GET['id']) ? 'edit' : 'add') ?>"/>
                                                    <input type="hidden" name="id" id="id" value="<?php echo (isset($_GET['id']) ? $_GET['id'] : "") ?>"/>
                                                    <input type="hidden" name="r_count" id="rid" value="<?php echo (isset($_GET['id']) ? $countrow[0][0] : "") ?>">
                                                    <button type="submit" id="btn_save" class="btn btn-primary waves-effect waves-light"><?php echo (isset($_GET['type']) && isset($_GET['id']) ? 'Edit' : 'Save') ?></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->
                            <!-- end row -->

                        </div>
                        <!-- end page content-->

                    </div> <!-- container-fluid -->

                </div>
            </div>

            <!-- end page content-->

        </div> <!-- container-fluid -->

    </div> <!-- content -->

    <?php include 'footer.php' ?>

</div>


<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->


</div>
<!-- END wrapper -->


<!-- jQuery  -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/metisMenu.min.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/waves.min.js"></script>

<script src="plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
<script src="plugins/bootstrap-md-datetimepicker/js/moment-with-locales.min.js"></script>
<script src="plugins/bootstrap-md-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<!-- Plugins js -->
<script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>

<script src="plugins/select2/js/select2.min.js"></script>
<script src="plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
<script src="plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js"></script>
<script src="plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js"></script>
<!--<script src="plugins/datatables/jquery.dataTables.min.js"></script>-->
<script src="plugins/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="plugins/datatables/dataTables.buttons.min.js"></script>
<script src="plugins/datatables/buttons.bootstrap4.min.js"></script>
<script src="plugins/datatables/jszip.min.js"></script>
<script src="plugins/datatables/pdfmake.min.js"></script>
<script src="plugins/datatables/vfs_fonts.js"></script>
<script src="plugins/datatables/buttons.html5.min.js"></script>
<script src="plugins/datatables/buttons.print.min.js"></script>
<script src="plugins/datatables/buttons.colVis.min.js"></script>
<!-- Responsive examples -->
<script src="plugins/datatables/dataTables.responsive.min.js"></script>
<script src="plugins/datatables/responsive.bootstrap4.min.js"></script>
<script src="assets/pages/datatables.init.js"></script>

<!-- Plugins Init js -->
<script src="assets/pages/form-advanced.js"></script>
<!-- App js -->
<script src="assets/js/app.js"></script>


<script type="text/javascript">
                                                                    function numbers() {
                                                                        var pidd =<?php echo (isset($_GET['id']) ? $edata[0][0] : '') ?>;
                                                                        // alert(pidd);
                                                                        var my_object = "user_id=" + pidd;
                                                                        $.ajax({
                                                                            url: './getViewData.php',
                                                                            dataType: "html",
                                                                            data: my_object,
//            cache: false,
                                                                            success: function (Data) {
                                                                                //alert(Data);
                                                                                $('#view_data1').html(Data);
                                                                            },
                                                                            error: function (errorThrown) {
                                                                                alert(errorThrown);
                                                                                alert("There is an error with AJAX!");
                                                                            }
                                                                        });
                                                                    }
                                                                    ;
                                                                    numbers();

</script>

<script>
    function edit(rowid) {

        if ($("#edit" + rowid).is(':checked')) {
            // $(".view").hide();
            $("#view" + rowid).prop("checked", true);
        } else {
            $("#view" + rowid).prop("checked", false);
        }

    }
    ;
    function view(rowno) {
        if ($("#edit" + rowno).is(':checked')) {
            // alert(rowid);
            $("#view" + rowno).prop("checked", true);
        } else {
            $("#edit" + rowno).prop("checked", false);
        }
    }
    ;
    
    function select_all() {
        if ($("#ck_create").is(':checked')) {
         
            $(".create").prop("checked", true);
           
        } else {
            $(".create").prop("checked", false);
        }
        if ($("#ck_edit").is(':checked')) {
         
            $(".edit").prop("checked", true);
            
        } else {
            $(".edit").prop("checked", false);
        }
        if ($("#ck_view").is(':checked')) {

            $(".view").prop("checked", true);
            
        } else {
            $(".view").prop("checked", false);
        }
        if ($("#ck_delete").is(':checked')) {

            $(".delete1").prop("checked", true);
            
        } else {
            $(".delete1").prop("checked", false);
        }
    }
    ;
</script>

<script type="text/javascript">
    function SetForDelete(id) {
        location.href = "Delete.php?type=main_category&id=" + id;
    }
</script>
</body>

</html>