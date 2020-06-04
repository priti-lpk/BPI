<?php
include_once '../shreeLib/DBAdapter.php';
//include '../shreeLib/session_info.php';

if (isset($_GET['id'])) {
    $edba = new DBAdapter();
    $edata = $edba->getRow("send_party_item_list", array("*"), "id=" . $_GET['id']);
    echo "<input type='hidden' id='send_party_item_list_id' value='" . $_GET['id'] . "'>";
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
                echo 'Edit Send Party Item List';
            } else {
                echo 'Add Send Party Item List';
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
                                    <h4 class="page-title">View Of Send Party Item List</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="page-content-wrapper">
                            <!--<div class="row">
                                                            <div class="col-12">
                                                                <div class="card m-b-20">
                                                                    <div class="card-body">                   
                                                                        <form action="" id="form_data" class="form-horizontal" role="form" method="get" enctype="multipart/form-data" >  
                            
                                                                            <div class="form-group row">
                                                                                <label for="example-text-input" class="col-sm-2 col-form-label">Select Party</label>
                                                                                <div class="col-sm-5" id="godawn">       
                                                                                    <select class="form-control select2" name="godawn_id" id="godawn_id" required="">
                                                                                        <option>Select Godawn</option>
                            <?php
                            $dba = new DBAdapter();
//                                                    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                            $data = $dba->getRow("create_godawn", array("id", "godawn_name"), "1");
                            foreach ($data as $subData) {
                                echo "<option value=" . $subData[0] . ">" . $subData[1] . "</option>";
                            }
                            ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class = "button-items">
                                                                                    <button type = "submit" id="btn_go" name="btn_go" class = "btn btn-primary waves-effect waves-light"><i class="fa fa-search"></i></button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>  end col 
                                                        </div>  end row -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">
                                            <div class="col-sm-12" align="right">
                                                <td><a href = '#addinstruction' style="color: black;margin-right: -0px;" data-toggle = 'modal'><i class="fa fa-info-circle"></i></a>
                                            </div>
                                            <form action="customFile/editsendpartyitem.php" method="POST">
                                                <h4 class="mt-0 header-title">View Of Party Item List</h4>
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Item Name</th>
                                                            <th style="width: 10px !important;">Item Qty.</th>
                                                            <!--<th>Item Unit</th>-->
                                                            <th>Item Rate</th>
                                                            <th>Item Amount</th>
                                                            <th>New Qty</th>
                                                            <th>Note</th>
                                                            <th>Status</th>

                                                        </tr>
                                                    </thead>

                                                    <tbody>

                                                        <?php
                                                        include_once '../shreeLib/DBAdapter.php';
                                                        $dba = new DBAdapter();
//                                                                $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                        $sql = "SELECT id,item_id,item_name,item_qty,item_unit,item_rate,item_amount FROM `send_party_item_list` where send_party_id=" . $_GET['id'];
//                                                                print_r($sql);

                                                        $result = mysqli_query($con, $sql);
                                                        $i = 1;
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            echo "<tr>";
                                                            echo "<td>" . $i++ . "</td>";
                                                            echo "<td>" . $row['item_name'] . "</td>";
                                                            echo "<td style='width: 10px !important;'>" . $row['item_qty'] . "</td>";
//                                                            echo "<td>" . $row['item_unit'] . "</td>";
                                                            echo "<td>" . $row['item_rate'] . "</td>";
                                                            echo "<td>" . $row['item_amount'] . "</td>";
                                                            echo "<td><input type='text' name='new_qty[]' id='new_qty' class='form-control' value='" . $row['item_qty'] . "'></td>";
                                                            echo "<td><input type='text' name='note[]' id='note' class='form-control'></td>";
                                                            $iid = $row['id'];
//                                                            echo $iid;
                                                            echo "<input type='hidden' name='item_id[]' id='item_id' class='form-control' value='" . $row['item_id'] . "'>";
                                                            echo "<input type='hidden' name='iid[]' id='iid' class='form-control' value='" . $iid . "'>";
                                                            echo "<td><button type='button' style='padding: 0px 0px;' id='" . $iid . "' value='approved' class='btn btn-primary waves-effect waves-light'onclick='status(this.id)'><li id='li" . $iid . "' class='btn btn-default btn-sm'><b>Approved</b></li></button>&nbsp;&nbsp;";
                                                            echo "<button type='button' id='" . $iid . "' style='padding: 0px 0px;' value='reject' class='btn btn-primary waves-effect waves-light' onclick='statusr(this.id)'><li id='li" . $iid . "' class='btn btn-default btn-sm'><b>Reject</b></li></button>";

                                                            echo "<input type='hidden' name='status[]' id='status" . $iid . "' class='form-control'>";
                                                            echo '</tr>';
                                                        }
                                                        ?> 
                                                    </tbody>

                                                </table><br>
                                                <div class="button-items">
                                                    <input type="hidden" name="action" id="action" value="add"/>
                                                    <input type="hidden" name="id" id="id" value="<?php echo (isset($_GET['id']) ? $_GET['id'] : '') ?>"/>
                                                    <button type="submit" id="btn_save" class="btn btn-primary waves-effect waves-light">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div>
                        </div>
                        <!-- end page content-->

                    </div> <!-- container-fluid -->

                </div> <!-- content -->
                <!--                <div class="col-sm-6 col-md-3 m-t-30">
                                    <div class="modal fade" id="addrate" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title mt-0">Add Status</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                                                        <div class="form-group row">
                                                            <input name="send_party_item_id" id="send_party_item_id" type="hidden">
                                                            <label for="example-text-input" class="col-sm-3 col-form-label">New Qty</label>
                                                            <div class="col-sm-7">                                        
                                                                <input class="form-control" type="text"  placeholder="New Qty" name="new_qty" id="new_qty">
                                                            </div>
                                                            <label for="example-text-input" class="col-sm-3 col-form-label" style="margin-top: 5px;">Status</label>
                                                            <div class="col-sm-7" style="margin-top: 15px;"> 
                                                                <input type = "button" class = "btn btn-primary waves-effect waves-light" id = "approved" value = "Approved" onclick="">
                                                                <input type = "button" value = "Destroy" id="reject" class = 'btn btn-primary waves-effect waves-light' data-id = 1  data-toggle = 'modal' data-target = '' onclick = ''><br><br><br>
                                                            </div>
                                                            <label for="example-text-input" class="col-sm-3 col-form-label" style="margin-top: -27px;">Note</label>
                                                            <div class="col-sm-7"  style="margin-top: -27px;">                                        
                                                                <input class="form-control" type="text"  placeholder="Note" name="note" id="note" disabled="">
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary waves-effect waves-light" id="sa-success" onclick = "addStatus();">Save changes</button>
                                                </div>
                                            </div> /.modal-content 
                                        </div> /.modal-dialog 
                                    </div> /.modal 
                                </div>-->
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
                                        <p><i class="fa fa-hand-point-right"></i> It is a view of send party items.</p>
                                        <p><i class="fa fa-hand-point-right"></i> You can click the approved or reject status for this item.</p>
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
        <!--<script src="customFile/newStatus.js"></script>-->
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
            function status(id) {

                $("#status" + id).each(function () {
                    var a = document.getElementById("status" + id).value = "Approved";
                });
            }
            function statusr(id) {
//                alert(id);
                $("#status" + id).each(function () {
                    var r = document.getElementById("status" + id).value = "Reject";
                });
            }

        </script>
        <script>
            $(document).ready(function () {

                $('#addrate').on('show.bs.modal', function (e) {
                    var i_Id = $(e.relatedTarget).data('id');
                    // alert(i_Id);
                    $(e.currentTarget).find('input[name="send_party_item_id"]').val(i_Id);
                });
            });
            function myFunction() {
                document.getElementById("status").value = "Destroy";
            }
            function myFunction1() {
                var id = document.getElementById("s_id").value;
                // alert(id);
                var status = document.getElementById("status1").value;
                //alert(status);
                var note = document.getElementById("note1").value;
                //alert(note);
                var my_object = {'s_id': id, 'status': status, 'note': ' '};
                $.ajax({
                    type: "POST",
                    url: "addStatus.php",
                    data: my_object,
                    success: function (data) {
                        //alert(data);
                        //alert("sucess");
                    },
                    error: function (errorThrown) {
                        alert(errorThrown);
                        alert("There is an error with AJAX!");
                    }
                });
            }
        </script>

    </body>

</html>


