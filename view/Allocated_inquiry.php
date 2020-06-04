<?php
ob_start();
//include '../shreeLib/session_info.php';
include_once '../shreeLib/DBAdapter.php';

if (isset($_GET['type']) && isset($_GET['id'])) {
    $edba = new DBAdapter();
    $edata = $edba->getRow("inquiry", array("*"), "id=" . $_GET['id']);
    echo "<input type='hidden' id='inquiry_id' value='" . $_GET['id'] . "'>";
}
if (isset($_SESSION['user_id'])) {
    $edba = new DBAdapter();
    $servername1 = basename($_SERVER['PHP_SELF']);
// echo $servername1;
    $field = array("role_rights.id");
    $data = $dba->getLastID("roles_id", "create_user", "id=" . $_SESSION['user_id']);

    $mod_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " module.mod_pagename='" . $servername1 . "' and role_rights.role_id=" . $data);
    echo "<input type='hidden' id='role_id' value='" . $mod_data[0][0] . "'>";

    $field = array("role_rights.id,role_rights.role_edit,role_rights.role_delete");
    $role_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, "  role_rights.id=" . $mod_data[0][0]);
    echo "<input type='hidden' id='role_id' value='" . $role_data[0][1] . "'>";
    $editdata = 0;
    $deletedata = 0;
    if ($role_data[0][1] == 1) {
        $editdata = 1;
//echo $editdata;
    }
    if ($role_data[0][2] == 1) {
        $deletedata = 1;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title><?php
            if (isset($_GET['type'])) {
                echo 'Edit Inquiry';
            } else {
                echo 'Add New Inquiry';
            }
            ?></title>
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
                                    <h4 class="page-title">View Allocated Inquiry</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="page-content-wrapper">
                            <!-- end row -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">
                                            <div class="col-sm-12" align="right">
                                                <td><a href = '#addinstruction' style="color: black;margin-right: -0px;" data-toggle = 'modal'><i class="fa fa-info-circle"></i></a>
                                            </div>
                                            <h4 class="mt-0 header-title">View Of Allocated Inquiry</h4>
                                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Inquiry No.</th>
                                                        <th>Inquiry Date</th>
                                                        <th>Reference No.</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php
//                                                                   
                                                    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                    $userid = $_SESSION['user_id'];
                                                    include_once("../shreeLib/dbconn.php");
                                                    $sql = "SELECT inquiry_send_to.inq_id,inquiry.reference_no,inquiry.inq_date FROM `inquiry_send_to` INNER JOIN inquiry ON inquiry_send_to.inq_id=inquiry.id WHERE inquiry.status='on' GROUP BY inq_id";
//                                                                print_r($sql);
                                                    $resultset = mysqli_query($con, $sql);
                                                    $i = 1;
                                                    while ($rows = mysqli_fetch_array($resultset)) {
                                                        echo "<tr>";
                                                        echo "<td>" . $rows['inq_id'] . "</td>";

                                                        $date = $rows['inq_date'];
                                                        $dates = date("d-m-Y", strtotime($date));
                                                        echo "<td>" . $dates . "</td>";
                                                        echo "<td>" . $rows['reference_no'] . "</td>";
                                                        echo "<td><a href='inquiry_list.php?id=" . $rows[0] . "' class='btn btn-primary' id='" . $rows[0] . "'><i class='fa fa-eye'></i> View Details</a></td>";
                                                        echo '</tr>';
                                                        //}
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>

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
                                        <p><i class="fa fa-hand-point-right"></i> This is view of Allocate inquiry for users.</p>
                                        <p><i class="fa fa-hand-point-right"></i> You can click the View Details button then view the Where users allocate the inquiry.</p>
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
        <script type="text/javascript">
            var today1 = new Date();
            var dd = today1.getDate();
            var mm = today1.getMonth() + 1;
            var yyyy = today1.getFullYear();
            if (dd < 10) {
                dd = "0" + dd;
            }
            if (mm < 10) {
                mm = "0" + mm;
            }
            var date = yyyy + "-" + mm + "-" + dd;
            var datefrm = yyyy + "-" + mm + "-01";
            document.getElementById("datevaluefrm").value = datefrm;
            document.getElementById("datevalueto").value = date;
        </script>
        <script type="text/javascript">
            $("#pbtn_go").on('click', function ()
            {
                var fdate = document.getElementById("datevaluefrm").value;
                var tdate = document.getElementById("datevalueto").value;
                $('#pdatevaluefrm').val(fdate);
                $('#pdatevalueto').val(tdate);

            });
        </script>
        <script type="text/javascript">
            function mainchange()
            {

                var cat = document.getElementById("main_cat_id").value;
                //alert(country1);
                var dataString = 'main_cat_id=' + cat;
                //alert(dataString);
                $.ajax
                        ({

                            url: "getcat.php",
                            datatype: "html",
                            data: dataString,
                            cache: false,
                            success: function (html)
                            {
                                //alert(html);
                                $("#sub_list").html(html);
                            },
                            error: function (errorThrown) {
                                alert(errorThrown);
                                alert("There is an error with AJAX!");
                            }
                        });
            }
            ;
        </script>
    </body>

</html>


