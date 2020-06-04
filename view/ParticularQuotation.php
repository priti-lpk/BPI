<?php
include_once '../shreeLib/DBAdapter.php';
//include '../shreeLib/session_info.php';

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
        <link href="../plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">

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
            .fillrate{
                color: red;
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
                                    <h4 class="page-title">View Of Quotation</h4>
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
                                            </div><br>
                                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr id="0">
                                                        <th>No.</th>
                                                        <th>Supplier Name</th>
                                                        <th>Item Name</th>
                                                        <th>Item Unit</th>
                                                        <th>Item Qty.</th>
                                                        <th>Item Rate</th>
                                                        <th>Add Rate</th>
                                                        <th>Status</th>
                                                        <th>Quotation Date</th>
                                                        <th>Remark</th>
                                                        <th>New Rate</th>
                                                        <th>Edit</th> 
                                                        <th>Delete</th>
                                                        <th>Create Proforma Invoice</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php
                                                    $id = $_GET['id'];
                                                    include_once '../shreeLib/DBAdapter.php';
                                                    $dba = new DBAdapter();
                                                    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                    //print_r($last_id);
                                                    $field = array("add_quotation.id,supplier.sup_name,add_quotation.item_name,add_quotation.unit,add_quotation.qty,add_quotation.rate,add_quotation.quotation_date,add_quotation.remark,add_quotation.new_rate,add_quotation.inquiry_id");
                                                    $data = $dba->getRow("add_quotation INNER JOIN supplier ON add_quotation.supplier_id=supplier.id", $field, "add_quotation.inquiry_item_id=" . $id);
                                                    $count = count($data);
                                                    if ($count >= 1) {
                                                        foreach ($data as $subData) {
                                                            if ($subData[8] == NULL) {
                                                                echo "<div class='emptyrate'>";
                                                                echo "<tr id=" . $subData[0] . ">";
                                                                echo "<td id='quo_id'>" . $subData[0] . "</td>";
                                                                echo "<td>" . $subData[1] . "</td>";
                                                                echo "<td>" . $subData[2] . "</td>";
                                                                echo "<td>" . $subData[3] . "</td>";
                                                                echo "<td>" . $subData[4] . "</td>";
                                                                echo "<td>" . $subData[5] . "</td>";
                                                                $iid = $subData[0];
                                                                echo "<td id='rp" . $iid . "'><button style='padding: 0px 0px;' class='btn btn-primary waves-effect waves-light' data-id='" . $iid . "' data-status='true' onclick='setrateID(this.id);' data-toggle='modal' data-target='#addrate' ><li id='li" . $iid . "' class='btn btn-default btn-sm'><b>Set Rate</b></li></button>";
                                                                echo "<td><button style='padding: 0px 0px;' class='btn btn-primary waves-effect waves-light' id='" . $iid . "'value='" . $iid . "' onclick='doAction(this.value)'><li class='btn btn-default btn-sm'><b>Select</b></li></button>";

                                                                $date = $subData[6];
                                                                $dates = date("d-m-Y", strtotime($date));
                                                                echo "<td>" . $dates . "</td>";
                                                                echo "<td>" . $subData[7] . "</td>";
                                                                echo "<td id='nr" . $subData[0] . "'  class='send'>" . $subData[8] . "</td>";

                                                                echo "<td><a href='Quotation.php?type=edit&id=" . $subData[0] . "' target='_blank' class='btn btn-primary' id='" . $subData[0] . "'><i class='fa fa-edit'></i> Edit</a></td>";

                                                                echo "<td><button class='btn btn-danger' id='" . $subData[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash-o'>Delete</button></td>";
//                                                                        $timestamp = time() + 3600; // one hour
                                                                echo "<td><a href='view/SendParty1.php?inq_id=" . $subData[9] . "&id=" . $subData[0] . "' class='btn btn-primary' value='" . $subData[0] . "' id='sp" . $subData[0] . "' ><i class='fa fa-edit'></i>Create Proforma Invoice</a></td>";
                                                                echo '</tr>';
                                                                echo "</div>";
                                                            }else{
                                                                echo "<div id='fillrate'>";
                                                                echo "<tr id=" . $subData[0] . ">";
                                                                echo "<td class='fillrate' id='quo_id'>" . $subData[0] . "</td>";
                                                                echo "<td class='fillrate'>" . $subData[1] . "</td>";
                                                                echo "<td class='fillrate'>" . $subData[2] . "</td>";
                                                                echo "<td class='fillrate'>" . $subData[3] . "</td>";
                                                                echo "<td class='fillrate'>" . $subData[4] . "</td>";
                                                                echo "<td class='fillrate'>" . $subData[5] . "</td>";
                                                                $iid = $subData[0];
                                                                echo "<td id='rp" . $iid . "'><button style='padding: 0px 0px;' class='btn btn-primary waves-effect waves-light' data-id='" . $iid . "' data-status='true' onclick='setrateID(this.id);' data-toggle='modal' data-target='#addrate' ><li id='li" . $iid . "' class='btn btn-default btn-sm'><b>Set Rate</b></li></button>";
                                                                echo "<td><button style='padding: 0px 0px;' class='btn btn-primary waves-effect waves-light' id='" . $iid . "'value='" . $iid . "' onclick='doAction(this.value)'><li class='btn btn-default btn-sm'><b>Select</b></li></button>";

                                                                $date = $subData[6];
                                                                $dates = date("d-m-Y", strtotime($date));
                                                                echo "<td class='fillrate'>" . $dates . "</td>";
                                                                echo "<td class='fillrate'>" . $subData[7] . "</td>";
                                                                echo "<td class='fillrate' id='nr" . $subData[0] . "'  class='send'>" . $subData[8] . "</td>";

                                                                echo "<td><a href='Quotation.php?type=edit&id=" . $subData[0] . "' target='_blank' class='btn btn-primary' id='" . $subData[0] . "'><i class='fa fa-edit'></i> Edit</a></td>";

                                                                echo "<td><button class='btn btn-danger' id='" . $subData[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash-o'>Delete</button></td>";
//                                                                        $timestamp = time() + 3600; // one hour
                                                                echo "<td><a href='view/SendParty1.php?inq_id=" . $subData[9] . "&id=" . $subData[0] . "' class='btn btn-primary' value='" . $subData[0] . "' id='sp" . $subData[0] . "' ><i class='fa fa-edit'></i>Create Proforma Invoice</a></td>";
                                                                echo '</tr>';
                                                                echo "</div>";
                                                            }
                                                        }
                                                    } else {
                                                        //echo 'No Data Available';
                                                    }
                                                    ?>    
                                                </tbody>
                                            </table>
                                            <input name="status" id="status1" type="hidden" value="Confirm">

                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div>
                        </div>
                        <!-- end page content-->

                    </div> <!-- container-fluid -->

                </div> <!-- content -->
                <div class="col-sm-6 col-md-3 m-t-30">
                    <div class="modal fade" id="addrate" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title mt-0">Add New Rate</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <input name="quotation_id" id="quotation_id" type="hidden">

                                            <label for="example-text-input" class="col-sm-3 col-form-label">New Rate</label>
                                            <div class="col-sm-4">                                        
                                                <input class="form-control" type="text"  placeholder="New Rate" name="new_rate" id="new_rate" required="">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary waves-effect waves-light" id="sa-success" onclick = "addRate();">Save changes</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </div>
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
                                        <p><i class="fa fa-hand-point-right"></i> This is view of multiple quotation for one items.</p>
                                        <p><i class="fa fa-hand-point-right"></i> You can click the set rate then fill the rate of item.</p>
                                        <p><i class="fa fa-hand-point-right"></i> You can click the status button. it works the quotation is confirm or not.</p>
                                        <p><i class="fa fa-hand-point-right"></i> You can click the edit button then edit the quotation. And click the delete button the delete the quotation.</p>
                                        <p><i class="fa fa-hand-point-right"></i> You can click the proforma invoice button the fill the proforma invoice.</p>
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
        <script src = "customFile/newrateJs.js"></script>

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
        <script src="plugins/sweet-alert2/sweetalert2.min.js"></script>
        <script src="assets/pages/sweet-alert.init.js"></script>
        <!-- Datatable init js -->
        <script src="assets/pages/datatables.init.js"></script>

        <script src="assets/pages/form-advanced.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>
        <script>
                                        function doAction(value)
                                        {
                                            var id = value;
                                            //                            alert(id);
                                            var status = document.getElementById("status1").value = "Confirm";
                                            //                            alert(status);
                                            var my_object = {"quotation_id": id, "status1": status};

                                            $.ajax({
                                                type: "POST",
                                                url: "customFile/addstatusquotation.php",
                                                data: my_object,
                                                success: function (data) {
                                                    //                                    alert(data);
                                                    //alert("sucess");
                                                },
                                                error: function (errorThrown) {
                                                    alert(errorThrown);
                                                    alert("There is an error with AJAX!");
                                                }
                                            });
                                        }

        </script>

        <script>
            $(document).ready(function () {

                $('#addrate').on('show.bs.modal', function (e) {
                    var i_Id = $(e.relatedTarget).data('id');
                    // alert(i_Id);
                    $(e.currentTarget).find('input[name="quotation_id"]').val(i_Id);
                });
            });
        </script>
        <script type="text/javascript">
            // if a new rate has a null value then it will be disabled...
            $(".send").each(function () {
                var id = ($(this).attr('id'));
                var emptyval = document.getElementById(id).innerHTML;
                var spid = id.replace('nr', '');
                if (emptyval == '') {
                    $("#sp" + spid).css({'pointer-events': 'none', 'opacity': '0.5'});
                }
            });
        </script>
        <script type="text/javascript">

            function SetForDelete(id) {
                location.href = "Delete.php?type=quotation&id=" + id;

            }
        </script>
    </body>

</html>


