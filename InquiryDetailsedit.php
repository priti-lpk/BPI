<?php
ob_start();
//include './shreeLib/session_info.php';
include_once './shreeLib/dbconn.php';
include_once 'shreeLib/DBAdapter.php';
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title><?php
            if (isset($_GET['id'])) {
                echo 'Edit Inquiry Details';
            } else {
                echo 'Add New Inquiry Details';
            }
            ?></title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="Themesbrand" name="author" />
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <link href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
        <link href="plugins/bootstrap-md-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
        <link href="plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />

        <!-- DataTables -->
        <link href="plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
        <style>
            table{border-collapse:collapse;border-radius:0px;width:500px;}
            table, td, th{border:1px solid #00BB64;}
            tr,input{height:30px;border:1px solid #fff;}
            /*	input{text-align:center;}*/
            input:focus{border:1px solid yellow;} 
        </style>
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
                                    <h4 class="page-title">View Of Inquiry Details</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="page-content-wrapper">

                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">
                                            <div class="col-sm-12" align="right">
                                                <td><a href = '#addinstruction' style="color: black;margin-right: -0px;" data-toggle = 'modal'><i class="fa fa-info-circle"></i></a>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <h4><b><?php echo (isset($_GET['id']) ? 'Edit Send Inquiry' : '') ?></b></h4>
                                                </div>
                                            </div>
                                            
                                            <form action = "customFile/inquiry_main_detailsPro.php" id = "form_data" class = "form-horizontal" role = "form" method = "post" enctype = "multipart/form-data" >
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label" style="margin-right: -88px;">Select User</label>
                                                    <div class="col-sm-4">
                                                        <?php
                                                        $i = 1;
                                                        echo "<select style='width:400px;' name='user_id[$i][]' id = 'u_id' class ='select2 select2-multiple'   multiple >";
                                                        $dba = new DBAdapter();
                                                        $Names = $dba->getRow("module INNER JOIN role_rights ON module.id=role_rights.mod_id INNER JOIN role_master ON role_rights.role_id=role_master.id INNER JOIN create_user ON role_master.id=create_user.roles_id", array("create_user.id", "create_user.user_login_username"), "role_rights.role_create=1 AND role_rights.mod_id=8");
                                                        $counts = count($Names);
                                                        if ($counts >= 1) {
                                                            foreach ($Names as $name) {
                                                                echo "<option value=" . $name[0] . ">" . $name[1] . "</option>";
                                                            }
                                                        }
                                                        ?>
                                                        </select>
                                                        <input class="form-control" type="hidden" name='data' id='data'>

                                                    </div>
                                                </div>
                                                <h4 class="mt-0 header-title">View Of Inquiry</h4>
                                                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Inquiry ID</th>
                                                            <th>Item Name</th>
                                                            <th>Item Quantity</th>
                                                            <th>Select User</th>
                                                            <th>Due Date</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody id="view_data1" name="view_data">
                                                        <?php
                                                        $id = $_GET['id'];
                                                        include_once 'shreeLib/DBAdapter.php';
                                                        $dba = new DBAdapter();
                                                        $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                        $field = array("inquiry_send_to.id,inquiry_send_to.inq_id,create_item.item_name,inquiry_item_list.item_quantity,inquiry_send_to.user_id,inquiry_send_to.due_date,inquiry_item_list.id");
                                                        $data = $dba->getRow("inquiry_send_to INNER JOIN inquiry_item_list ON inquiry_send_to.inq_item_list_id=inquiry_item_list.id INNER JOIN create_item ON inquiry_item_list.item_id=create_item.id", $field, "inquiry_send_to.id=" . $_GET['id']);
                                                        $i = 1;
                                                        $inq = '';
                                                        $count = count($data);
                                                        if ($count >= 1) {
                                                            foreach ($data as $subData) {
                                                                $inq = $subData[1];
                                                                echo "<tr>";
                                                                echo "<td><input type='text' name='id[]' value='" . $subData[0] . "'></td>";
                                                                echo "<td><input type='text' name='inq_id[]' value='" . $subData[2] . "'></td>";
                                                                echo "<input type='hidden' name='inq_item_list_id[]' value='" . $subData[6] . "'>";
                                                                echo "<td><input type='text' name='item_qty[]' value='" . $subData[3] . "'></td>";
                                                                if ($subData['4'] == '0') {
                                                                    echo "<td><input type='checkbox' name='user_id' id='" . $subData[6] . "' value='0' onclick='getuser(this.id)'></td>";
                                                                } else {
                                                                    echo "<td><input type='checkbox' name='user_id' id='" . $subData[6] . "' value='" . $subData[4] . "' onclick='getuser(this.id)' checked></td>";
                                                                }
                                                                echo "<td><input type='date' name='due_date' id='datevalue' value='" . $subData[5] . "'class='form-control' required'></td>";
                                                                echo "</tr>";
                                                                $i++;
                                                            }
                                                        } else {
                                                            
                                                        }
                                                        ?>
                                                    </tbody> 
                                                </table>
                                                <input type="hidden" name="inq_id" id="inq_id" value="<?php echo $inq; ?>">

                                                <input type="hidden" name="action" id="action" value="<?php echo (isset($_GET['id']) ? 'edit' : 'add') ?>">
                                                <input type="hidden" name="id" id="id" value="<?php echo (isset($_GET['id']) ? $_GET['id'] : "") ?>">
                                                <button type="submit" id="btn_save" name="btn_save" class="btn btn-primary"><i class="fa fa-floppy-o"></i><b> <?php echo (isset($_GET['type']) && isset($_GET['id']) ? 'Save' : 'Save') ?></b></button>

                                            </form>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div>
                        </div>
                        <!-- end page content-->

                    </div> <!-- container-fluid -->

                </div> <!-- content -->

                <?php include 'footer.php' ?>

            </div>
            <div class="col-sm-6 col-md-3 m-t-30">
                <div class="modal fade" id="addinstruction" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mt-0">View Instruction</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <p><i class="fa fa-hand-point-right"></i> This is view of Allocate User Inquiry.</p>
                                        <p><i class="fa fa-hand-point-right"></i> First of all select the user than click the checkbox what you allocate the inquiry.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
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
        <script>
            $("#u_id").on('change', function () {
                var selected = new Array();
                var countries = [];
                $.each($(".select2 option:selected"), function () {
                    countries.push($(this).val());
                });
                var user = countries.join(",");
                document.getElementById('data').value = user;
            }
            );
        </script>
        <script>
            function getuser(iid) {
                var data = document.getElementById('data').value;
                if (document.getElementById(iid).checked) {
                    document.getElementById(iid).value = data;
                } else {
                    document.getElementById(iid).value = "";
                }
            }
        </script>
        <script type="text/javascript">
            function numbers() {
                var pidd =<?php echo (isset($_GET['id']) ? $edata[0][0] : '') ?>;
                var my_object = "inq_main_id=" + pidd;
                $.ajax({
                    url: 'getViewData.php',
                    dataType: "html",
                    data: my_object,
                    cache: false,
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
    </body>

</html>


