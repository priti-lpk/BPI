<?php
ob_start();
include './shreeLib/session_info.php';

include_once 'shreeLib/DBAdapter.php';
if (isset($_GET['type']) && isset($_GET['id'])) {
    $edba = new DBAdapter();
    $field = array("main_category.id,main_category.name");
    $edata = $edba->getRow("main_category", $field, "id=" . $_GET['id']);
    echo "<input type='hidden' id='main_category_id' value='" . $_GET['id'] . "'>";
}
if (isset($_SESSION['user_id'])) {

    $edba = new DBAdapter();
    $servername1 = basename($_SERVER['PHP_SELF']);
    //echo $servername1;
    $field = array("role_rights.id");
    $data = $dba->getLastID("roles_id", "create_user", "id=" . $_SESSION['user_id']);

    $mod_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " module.mod_pagename='" . $servername1 . "' and role_rights.role_id=" . $data);
    echo "<input type='hidden' id='role_id' value='" . $mod_data[0][0] . "'>";

    $field = array("role_rights.id,role_rights.role_edit,role_rights.role_delete,role_rights.role_create");
    $role_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " role_rights.id=" . $mod_data[0][0]);
    echo "<input type='hidden' id='role_id' value='" . $role_data[0][0] . "'>";
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
                echo 'Edit Main Category';
            } else {
                echo 'Add Main Category';
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
                                    <h4 class="page-title">Main Category</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="page-content-wrapper">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">  
                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <h4><b><?php echo (isset($_GET['id']) ? 'Edit Category' : '') ?></b></h4>
                                                </div>
                                            </div>
                                            <form action="customFile/addMainCategoryPro.php" id="form_data" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" >  
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Main Catgeory</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" type="text"  placeholder="Main Category Name" id="name" name="name" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][1] : ''); ?>" required="">
                                                    </div>
                                                </div>
                                                <div class="button-items">
                                                    <input type="hidden" name="action" id="action" value="<?php echo (isset($_GET['id']) ? 'edit' : 'add') ?>"/>
                                                    <input type="hidden" name="id" id="id" value="<?php echo (isset($_GET['id']) ? $_GET['id'] : '') ?>"/>
                                                    <button type="submit" id="btn_save" class="btn btn-primary waves-effect waves-light">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">

                                            <h4 class="mt-0 header-title">View of Main Category</h4><br>
                                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th> Main Category Name</th>
                                                        <th>Edit</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include_once 'shreeLib/DBAdapter.php';
                                                    $dba = new DBAdapter();

                                                    //$last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);

                                                    $field = array("main_category.id,main_category.name");
                                                    $data = $dba->getRow("main_category", $field, "1");

                                                    $count = count($data);
                                                    if ($count >= 1) {
                                                        foreach ($data as $subData) {
                                                            // if ($userid == $subData[2]) {
                                                            echo "<tr>";
                                                            echo "<td>" . $subData[0] . "</td>";
                                                            echo "<td>" . $subData[1] . "</td>";
                                                            if ($role_data[0][1] == 1) {
                                                                echo "<td><a href='MainCategory.php?type=edit&id=" . $subData[0] . "' target='_blank' class='btn btn-primary' id='" . $subData[0] . "'><i class='fa fa-edit'></i> Edit</a></td>";
                                                            }

//                                                                    if ($role_data[0][2] == 1) {
//                                                                        echo "<td> <button class='btn btn-danger btn_delete' id='" . $subData[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash-o'>  Delete</button></td>";
//                                                                    }
                                                            echo '</tr>';
                                                            // }
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div>
                            <!--end row-->


                        </div>

                        <!--end page content-->

                    </div> <!--container-fluid -->

                </div> <!--content -->

                <?php include 'footer.php'
                ?>

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
        <script src="plugins/datatables/jquery.dataTables.min.js"></script>
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
            $(function ()
            {
                $('#form_data').submit(function () {
                    $("input[type='submit']", this)
                            .val("Please Wait...")
                            .attr('disabled', 'disabled');
                    return true;
                });
            });
        </script>

        <script type="text/javascript">

            function SetForDelete(id) {
                location.href = "Delete.php?type=main_category&id=" + id;

            }
        </script>
    </body>

</html>