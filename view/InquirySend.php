<?php
ob_start();
include_once '../shreeLib/dbconn.php';
include_once '../shreeLib/DBAdapter.php';
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>View Inquiry</title>
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
        <style>
            .label-danger {
                background-color: #d9534f;
                display: inline;
                border-radius: 0;
                font-weight: normal;
                padding: .5em .6em;
                font-size: 95%;
                // font-weight: 700;
                line-height: 1;
                color: #fff;
                text-align: center;
                white-space: nowrap;
                vertical-align: baseline;
                // border-radius: .25em;
            }
            .btn .badge {
                position: relative;
                background-color: #E60404 !important;
                font-weight: 400;
                display: inline-block;
                min-width: 10px;
                padding: 5px 6px;
                line-height: 1;
                color: #fff;
                text-align: center;
                white-space: nowrap;
                vertical-align: middle;
                //background-color: #777;
                border-radius: 10px;
            }
        </style>
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
                                    <h4 class="page-title">View Inquiry Send</h4>
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

                                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Party Name</th>
                                                        <th>Item Name</th>
                                                        <th>Unit</th>
                                                        <th>Qty.</th>
                                                        <th>Remark</th>
                                                        <th>Due Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php
                                                    include_once '../shreeLib/DBAdapter.php';
                                                    $dba = new DBAdapter();
                                                    $i = 1;
                                                    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                    $field = array("inquiry_item_list.id,create_item.item_name,inquiry_item_list.item_unit,inquiry_item_list.item_quantity,inquiry_item_list.remark,inquiry_send_to.due_date,inquiry_send_to.inquiry_created_date,inquiry_item_list.inq_id,create_party.party_name,inquiry.inq_date,inquiry.inq_remark,create_user.user_login_username");
                                                    $data = $dba->getRow("inquiry_item_list INNER JOIN create_item ON inquiry_item_list.item_id=create_item.id INNER JOIN inquiry_send_to ON inquiry_item_list.id=inquiry_send_to.inq_item_list_id INNER JOIN inquiry ON inquiry_send_to.inq_id=inquiry.id INNER JOIN create_party ON inquiry.party_id=create_party.id INNER JOIN create_user ON create_user.id=inquiry_send_to.user_id", $field, "inquiry_send_to.branch_id=" . $last_id . " AND inquiry.user_id=" . $_SESSION['user_id']);
                                                    $count = count($data);
                                                    if ($count >= 1) {
                                                        foreach ($data as $subData) {
                                                            echo "<tr>";
                                                            echo "<td>" . $i++ . "</td>";
                                                            echo "<td>" . $subData[8] . "</td>";
                                                            echo "<td>" . $subData[1] . "</td>";
                                                            echo "<td>" . $subData[2] . "</td>";
                                                            echo "<td>" . $subData[3] . "</td>";
                                                            echo "<td>" . $subData[4] . "</td>";
                                                            $date = $subData[5];
                                                            $dates = date("Y-m-d", strtotime($date));
                                                            $dates1 = date("d-m-Y", strtotime($date));
                                                            $current_date = date('Y-m-d');
                                                            if ($current_date >= $dates) {
                                                                echo "<td style='padding: 17px 12px;'><span class='label label-danger'><b>" . $dates1 . "</b></span></td>";
                                                            } else {
                                                                echo "<td>" . $dates1 . "</td>";
                                                            }
                                                            $field1 = array("add_quotation.id");
                                                            $data1 = $dba->getRow("add_quotation", $field1, "inquiry_item_id=" . $subData[0]);
                                                            $count1 = count($data1);
                                                            $iid = $subData[0];
                                                            $date1 = $subData[9];
                                                            $dates1 = date("d-m-Y", strtotime($date1));

                                                            echo "<td><a href='Quotation.php?inquiry_id=" . $subData[0] . "' class='btn btn-primary' id='" . $subData[0] . "'><i class='fa fa-plus'></i> Add Quotation..</a>&nbsp;&nbsp;";
                                                            echo "<a href='view/ParticularQuotation.php?id=" . $subData[0] . "' class='btn btn-primary' id='" . $subData[0] . "'><i class='fa fa-list fw'></i> View Quotation<span class='count' style='position: absolute;'>&nbsp;&nbsp;<span class='badge red-bg' style='top: -15px;'><b>$count1</b></span></span></a>&nbsp;&nbsp;";
                                                            echo "&nbsp;&nbsp;<button type = 'submit' href = '#addinq' class = 'btn btn-primary' data-toggle = 'modal' data-id = '$iid' data-party-name = '" . $subData[8] . "' data-inq-date = '" . $dates1 . "'data-inq-remark = '" . $subData[10] . "'data-item-name = '" . $subData[1] . "' data-unit = '" . $subData[2] . "'data-quantity = '" . $subData[3] . "'data-item-remark = '" . $subData[4] . "'>View Inquiry</button></td>";

                                                            echo "</tr>";
                                                        }
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
                <div class="col-sm-6 col-md-3 m-t-30">
                    

                    <div class="modal fade" id="addinq" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title mt-0">View Item Inquiry</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <form action="javascript:void(0);" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" onsubmit="addParty();" >
                                        <div class="form-group row">
                                            <input name="quotation_id" id="quotation_id" type="hidden">

                                            <div class="col-sm-3">Party Name:</div>
                                            <div class="col-sm-9"><input style="border:0px; padding-bottom:11px;" type="text" value="" name="subject1" id="subject1"></div><br><br>
                                            <div class="col-sm-3">Inquiry Date:</div>
                                            <div class="col-sm-9"><input style="border:0px; padding-bottom:11px;" type="text" value="" name="subject2" id="subject2"></div><br><br>
                                            <div class="col-sm-3">Inquiry Remark:</div>
                                            <div class="col-sm-9"><input style="border:0px; padding-bottom:11px;" type="text" value="" name="subject3" id="subject3"></div><br><br>
                                            <div class="col-sm-3">Item Name:</div>
                                            <div class="col-sm-9"><input style="border:0px; padding-bottom:11px;" type="text" value="" name="subject4" id="subject4"></div><br><br>
                                            <div class="col-sm-3">Unit:</div>
                                            <div class="col-sm-9"><input style="border:0px; padding-bottom:11px;" type="text" value="" name="subject5" id="subject5"></div><br><br>
                                            <div class="col-sm-3">Qty:</div>
                                            <div class="col-sm-9"><input style="border:0px; padding-bottom:11px;" type="text" value="" name="subject6" id="subject6"></div><br><br>
                                            <div class="col-sm-3">Remark:</div>
                                            <div class="col-sm-9"><input style="border:0px; padding-bottom:11px;" type="text" value="" name="subject7" id="subject7"></div><br><br>

                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </div>
                <?php include '../footer.php' ?>

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
            $(document).ready(function () {

                $('#addinq').on('show.bs.modal', function (e) {
                    var i_Id = $(e.relatedTarget).data('id');
//                    alert(i_Id);
                    $(e.currentTarget).find('input[name="subject"]').val(i_Id);
                    var name = $(e.relatedTarget).data('party-name');
                    $(e.currentTarget).find('input[name="subject1"]').val(name);
                    var date = $(e.relatedTarget).data('inq-date');
                    $(e.currentTarget).find('input[name="subject2"]').val(date);
                    var inq_remark = $(e.relatedTarget).data('inq-remark');
                    $(e.currentTarget).find('input[name="subject3"]').val(inq_remark);
                    var item = $(e.relatedTarget).data('item-name');
                    $(e.currentTarget).find('input[name="subject4"]').val(item);
                    var unit = $(e.relatedTarget).data('unit');
                    $(e.currentTarget).find('input[name="subject5"]').val(unit);
                    var qua = $(e.relatedTarget).data('quantity');
                    $(e.currentTarget).find('input[name="subject6"]').val(qua);
                    var remark = $(e.relatedTarget).data('item-remark');
                    $(e.currentTarget).find('input[name="subject7"]').val(remark);


                });
            });
        </script>
    
    </body>

</html>


