<?php
include_once '../shreeLib/DBAdapter.php';
include '../shreeLib/session_info.php';

if (isset($_GET['type']) && isset($_GET['id'])) {
    $edba = new DBAdapter();
    $edata = $edba->getRow("add_quotation", array("*"), "id=" . $_GET['id']);
    echo "<input type='hidden' id='add_quotation_id' value='" . $_GET['id'] . "'>";
}if (isset($_SESSION['user_id'])) {

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
                echo 'Edit Add Quotation';
            } else {
                echo 'Add New Quotation';
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
                                    <h4 class="page-title">View Quotation</h4>
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
                                                        <th>No.</th>
                                                        <th>Supplier Name</th>
                                                        <th>Item Name</th>
                                                        <th></th>
                                                        <th>Unit</th>
                                                        <th>Qty.</th>
                                                        <th>Rate</th>
                                                        <th>Quotation Date</th>
                                                        <th>Remark</th>
                                                        <?php if ($role_data[0][1] == 1) { ?>
                                                            <th>Edit</th> <?php } ?>
                                                        <?php if ($role_data[0][2] == 1) { ?> <th>Delete</th><?php } ?>

                                                    </tr>
                                                </thead>

                                                <tbody>

                                                <form action="" method="POST">

                                                    <?php
                                                    include_once '../shreeLib/DBAdapter.php';
                                                    $dba = new DBAdapter();
                                                    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                    $sql = "select (add_quotation.id) as qid,supplier.sup_name,add_quotation.item_name,add_quotation.unit,add_quotation.qty,add_quotation.rate,add_quotation.quotation_date,add_quotation.remark,create_party.party_name,inquiry.id,add_quotation.inquiry_id,inquiry.inq_date,inquiry.inq_remark FROM add_quotation INNER JOIN inquiry ON add_quotation.inquiry_id=inquiry.id INNER JOIN create_party ON inquiry.party_id=create_party.id INNER JOIN supplier ON create_party.id=supplier.id  where add_quotation.branch_id=" . $last_id;
                                                    $result = mysqli_query($con, $sql);
//                                                                print_r($sql);
                                                    $count = count($sql);
//                                                                echo $count;
                                                    if ($count >= 1) {
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            echo "<tr>";
                                                            echo "<td>" . $row['qid'] . "</td>";
                                                            echo "<td>" . $row['sup_name'] . "</td>";
                                                            echo "<td>" . $row['item_name'] . "</td>";
                                                            $iid = $row['inquiry_id'];
                                                            $date1 = $row['inq_date'];
                                                            $dates1 = date("d-m-Y", strtotime($date1));
                                                            echo "<td><button type = 'submit' href = '#addparty' class = 'btn btn-primary waves-effect waves-light' data-toggle = 'modal' data-id = '$iid' data-party-name = '" . $row['party_name'] . "' data-date = '" . $dates1 . "' data-inq-remark='" . $row['inq_remark'] . "'><b>View Inquiry Item</b></button>";
                                                            echo "<td>" . $row['unit'] . "</td>";
                                                            echo "<td>" . $row['qty'] . "</td>";
                                                            echo "<td>" . $row['rate'] . "</td>";
                                                            $date = $row['quotation_date'];
                                                            $dates = date("d-m-Y", strtotime($date));
                                                            echo "<td>" . $dates . "</td>";
                                                            echo "<td>" . $row['remark'] . "</td>";

                                                            if ($role_data[0][1] == 1) {
                                                                echo "<td><a href = 'Quotation.php?type=edit&id=" . $row['qid'] . "' class = 'btn btn-primary' ><i class = 'fa fa-edit'></i> Edit</a></td>";
                                                            }
                                                            if ($role_data[0][2] == 1) {
                                                                echo "<td><button class = 'btn btn-danger' id = '" . $row['qid'] . "' onclick = 'SetForDelete(this.id);'><i class = 'fa fa-trash-o'>Delete</button></td></tr>";
                                                            }
                                                            echo '</tr>';
                                                        }
                                                    }
                                                    ?> 
                                                </form>

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
                                     <div class="modal fade" id="addparty" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title mt-0">View Item Inquiry</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <form action="javascript:void(0);" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" onsubmit="addParty();" >
                                        <div class="form-group row">
                                            <div class="col-sm-3">Party Name:</div>
                                            <div class="col-sm-9"><input style="border:0px; padding-bottom:11px;" type="text" value="" name="subject1" id="subject1"></div><br><br>
                                            <div class="col-sm-3">Inquiry Date:</div>
                                            <div class="col-sm-9"><input style="border:0px; padding-bottom:11px;" type="text" value="" name="subject2" id="subject2"></div><br><br>
                                            <div class="col-sm-3">Inquiry Remark:</div>
                                            <div class="col-sm-9"><input style="border:0px; padding-bottom:11px;" type="text" value="" name="subject3" id="subject3"></div><br><br>

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

                                            $('#addparty').on('show.bs.modal', function (e) {
                                                var i_Id = $(e.relatedTarget).data('id');
                                                $(e.currentTarget).find('input[name="subject"]').val(i_Id);
                                                var name = $(e.relatedTarget).data('party-name');
//                                    alert(name);
                                                $(e.currentTarget).find('input[name="subject1"]').val(name);
                                                var da = $(e.relatedTarget).data('date');
                                                $(e.currentTarget).find('input[name="subject2"]').val(da);
                                                var re = $(e.relatedTarget).data('inq-remark');
                                                $(e.currentTarget).find('input[name="subject3"]').val(re);
                                            });
                                        });
        </script>
        <script type="text/javascript">

            function SetForDelete(id) {
                location.href = "Delete.php?type=quotation&id=" + id;

            }
        </script>
    </body>

</html>


