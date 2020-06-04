<?php
include_once '../shreeLib/DBAdapter.php';
//include '../shreeLib/session_info.php';


if (isset($_GET['type']) && isset($_GET['id'])) {
    $edba = new DBAdapter();
    $edata = $edba->getRow("inquiry_send_to", array("*"), "id=" . $_GET['id']);
    echo "<input type='hidden' id='inquiry_send_to_id' value='" . $_GET['id'] . "'>";
}

if (isset($_SESSION['user_id'])) {
    echo $_SESSION['user_id'];
    $edba = new DBAdapter();
    $servername1 = basename($_SERVER['PHP_SELF']);
    $field = array("role_rights.id");
    $data = $dba->getLastID("roles_id", "create_user", "id=" . $_SESSION['user_id']);

    $mod_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " module.mod_pagename='" . $servername1 . "' and role_rights.role_id=" . $data);
    echo "<input type='hidden' id='role_id' value='" . $mod_data[0][0] . "'>";
//print_r($mod_data);

    $field = array("role_rights.id,role_rights.role_edit,role_rights.role_delete,role_rights.role_create");
    $role_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " role_rights.id=" . $mod_data[0][0]);
    echo "<input type='hidden' id='role_id' value='" . $role_data[0][0] . "'>";
    echo $role_data[0][0];
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Create Invoice</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="Themesbrand" name="author" />
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <link href="../plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
        <link href="../plugins/bootstrap-md-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
        <link href="../plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="../plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />

        <!-- DataTables -->
        <link href="../plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="../plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="../plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/style.css" rel="stylesheet" type="text/css">
    </head>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <?php include '../topbar.php'; ?>
            <!-- Top Bar End -->

            <!-- ========== Left Sidebar Start ========== -->
            <?php include '../sidebar.php'; ?>
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
                                    <h4 class="page-title">View Invoice Item</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="page-content-wrapper">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">
                                            <form action="customFile/purchase_InvoicePro.php" method="POST">
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr id="totalrow">
                                                            <th>No.</th>
                                                            <th>Item Name</th>
                                                            <th>Item Unit</th>
                                                            <th>Item Qty.</th>
                                                            <th>Item Rate</th>
                                                            <th>Item Amount</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>


                                                        <?php
                                                        if (isset($_GET['id'])) {
                                                            include_once '../shreeLib/DBAdapter.php';
                                                            $dba = new DBAdapter();
                                                            $inq_id = $_GET['id'];
                                                            $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                            $sql = "SELECT invoice_list.* FROM `invoice_list` where reference_no=" . $inq_id;
                                                            $result = mysqli_query($con, $sql);
//                                                            print_r($sql);
                                                            $i = 1;
                                                            while ($row = mysqli_fetch_array($result)) {
                                                                echo "<tr>";
                                                                echo "<td>" . $i++ . "</td>";
                                                                echo "<td><input class='form-control' type='text' name='item_name[]' value= '" . $row['item_name'] . "' ></td>";
                                                                echo "<td><select class='form-control select2' name='unit[]' required='' style='width:150px !imporatant'>";
                                                                $dba = new DBAdapter();
                                                                $data = $dba->getRow("unit_list", array("id", "unit_name"), "1");
                                                                foreach ($data as $subData) {
                                                                    //echo $subData[0];
                                                                    echo "<option " . ($subData[1] == $row['unit'] ? 'selected' : '') . " value='" . $subData[1] . "'>" . $subData[1] . "</option> ";
                                                                }
                                                                "</select> </td>";
                                                                echo "<td>" . $row['qty'] . "</td>";
                                                                echo "<td>" . $row['rate'] . "</td>";
                                                                echo "<td>" . $row['total_amount'] . "</td>";
                                                                echo "<input class='form-control' type='hidden' name='item_id[]' value= '" . $row['item_id'] . "' >";
                                                                echo "<input class='form-control' type='hidden' name='qty[]' value= '" . $row['qty'] . "' >";
                                                                echo "<input class='form-control' type='hidden' name='rate[]' value= '" . $row['rate'] . "' >";
                                                                echo "<input class='form-control' type='hidden' name='total_amount[]' value= '" . $row['total_amount'] . "' >";
                                                                echo "<input class='form-control' type='hidden' name='reference_no[]' value= '" . $row['reference_no'] . "' >";
                                                                echo "<input class='form-control' type='hidden' name='purchase_id[]' value= '" . $row['purchase_id'] . "' >";
                                                                echo "<input class='form-control' type='hidden' name='pid[]' value= '" . $row['id'] . "' >";
                                                                echo '</tr>';
                                                            }
                                                        }
                                                        ?> 
                                                    </tbody>
                                                </table>

                                                <input type="hidden" name="action" id="action" value="<?php echo (isset($_GET['id']) ? 'edit' : 'edit') ?>">
                                                <input type="hidden" name="id" id="id" value="<?php echo (isset($_GET['id']) ? $_GET['id'] : "") ?>">
                                                <button type="submit" id="btn_save" name="btn_save" class="btn btn-primary"><i class="fa fa-floppy-o"></i><b>Edit Invoice</b></button>
                                            </form>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div>
                        </div>
                        <!-- end page content-->

                    </div> <!-- container-fluid -->

                </div> <!-- content -->

                <?php include '../footer.php' ?>

            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->


        <!-- jQuery  -->
        <!--<script src="customFile/AllCalculationFun.js"></script>-->
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
        <!-- Required datatable js -->
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

        <!-- Datatable init js -->
        <script src="assets/pages/datatables.init.js"></script>

        <script src="assets/pages/form-advanced.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>

        <script type="text/javascript">

            function SetForDelete(id) {
                location.href = "Delete.php?type=inquiry_send&id=" + id;

            }
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
    </body>

</html>


