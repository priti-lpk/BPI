<?php
ob_start();
include './shreeLib/session_info.php';
include_once './shreeLib/dbconn.php';
include_once 'shreeLib/DBAdapter.php';
if (isset($_GET['type']) && isset($_GET['id'])) {
    $iid = $_GET['id'];
    $edba = new DBAdapter();
    $field = array("inquiry.id,create_party.party_name,inquiry.inq_date,inquiry.remark,inquiry.user_id");
    $edata = $edba->getRow("inquiry INNER JOIN party_list ON inquiry.party_id=party_list.id", $field, "inquiry.id=" . $_GET['id']);
    echo "<input type='hidden' id='id' value='" . $_GET['id'] . "'>";
    $field1 = array("count(inq_id)");
    $countrow = $edba->getRow("inquiry_item_list", $field1, "inq_id=" . $_GET['id']);
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
            if (isset($_GET['type'])) {
                echo 'Edit Inquiry Main Details';
            } else {
                echo 'Add Inquiry Main Details';
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
                                    <h4 class="page-title">View Of Inquiry Main Details</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        <?php if (isset($_GET['id'])) { ?>
                            <div class="page-content-wrapper">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card m-b-20">
                                            <div class="card-body">
                                                <div class="col-sm-12" align="right">
                                                    <td><a href = '#addinstruction' style="color: black;margin-right: -0px;" data-toggle = 'modal'><i class="fa fa-info-circle"></i></a>
                                                </div>
                                                <?php
                                                include_once 'shreeLib/DBAdapter.php';
                                                if (isset($_GET['id'])) {
                                                    $id = $_GET['id'];
                                                    $dba = new DBAdapter();
                                                    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                    $field = array("inquiry.id,create_party.party_name,inquiry.inq_date,inquiry.inq_remark");
                                                    $data = $dba->getRow("inquiry inner join create_party on inquiry.party_id=create_party.id", $field, "inquiry.id=" . $id);

                                                    foreach ($data as $subData) {
                                                        ?>

                                                        <h4 class="mt-0 header-title">Textual inputs</h4>
                                                        <div class="form-group row">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">Party Name</label>
                                                            <div class="col-sm-4">
                                                                <input class="form-control" type="text"  placeholder="Party Name" id="godawn_name" name="godawn_name" value =  "<?php echo $subData[1] ?> " required="" disabled="">
                                                            </div>
                                                            <label for="ticket-name" class="col-sm-1 control-label" id="lblpartydate">Date</label>
                                                            <div class="col-sm-3" id="partydue">
                                                                <input type="date"  id="datevalueto" value="<?php echo $subData[2] ?>" name="to_date" id="to_date"  class="form-control" placeholder="Date" require2 disabled="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">Remark</label>
                                                            <div class="col-sm-4">
                                                                <input class="form-control" type="text"  placeholder="Remark" id="godawn_name" name="godawn_name" value="<?php echo $subData[3] ?>" required="" disabled="">
                                                            </div>
                                                            <label for="example-text-input" class="col-sm-2 col-form-label" style="margin-right: -88px;">Select User</label>
                                                            <div class="col-sm-4">
                                                                <?php
                                                                $i = 1;
                                                                echo "<select style='width:400px;' name='user_id[$i][]' id = 'u_id' class ='select2 select2-multiple' required  multiple >";
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
                                                            </div>
                                                            <input class="form-control" type="hidden" name='data' id='data'>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card m-b-20">
                                            <div class="card-body">
                                                <form action = "customFile/inquiry_main_detailsPro.php" id = "form_data" class = "form-horizontal" role = "form" method = "post" enctype = "multipart/form-data" >

                                                    <h4 class="mt-0 header-title">View Of Inquiry</h4>
                                                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>Sr No.</th>
                                                                <th>Item Name</th>
                                                                <th>Item Quantity</th>
                                                                <th>User</th>
                                                                <th>Due Date</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody id="view_data1" name="view_data">

                                                            <?php
                                                            if (!isset($_SESSION)) {
                                                                session_start();
                                                            }
                                                            include_once 'shreeLib/DBAdapter.php';
                                                            $dba = new DBAdapter();
                                                            $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                            $field = array("inquiry_item_list.id,create_item.item_name,inquiry_item_list.item_quantity,inquiry_item_list.item_id,inquiry_item_list.inq_id,inquiry.user_id");
                                                            $data = $dba->getRow("inquiry_item_list inner join create_item on inquiry_item_list.item_id=create_item.id INNER JOIN inquiry ON inquiry.id= inquiry_item_list.inq_id", $field, "inq_id=" . $_GET['id'] . " AND inquiry.branch_id=" . $last_id);
                                                            $count = count($data);
                                                            if ($count >= 1) {
                                                                foreach ($data as $subData) {
                                                                    echo "<tr>";
                                                                    echo "<td><input type='text' style{border: none} class='inquiry' name='inq_item_list_id[]' id='inq' value='" . $subData[0] . "' readonly></td>";
                                                                    echo "<td><input type='text' name='item_name[]' value='" . $subData[1] . "' readonly></td>";
                                                                    echo "<td><input type='text' name='item_qnty[]' value='" . $subData[2] . "' readonly></td>";
                                                                    echo "<td><input type='checkbox' class='user' name='user_id[]' id='" . $subData[0] . "' value='0' onclick='getuser(this.id)'></td>";
                                                                    echo "<td><input type='date' name='due_date[]' id='datevalue' class='form-control' required'></td>";
                                                                    echo "<input type='hidden' name='inq_id' value='$subData[4]'>";
                                                                    echo "</tr>";
                                                                }
                                                            } else {
                                                                
                                                            }
                                                            ?> 
                                                        </tbody> 
                                                    </table>
                                                    <input type="hidden" name="action" id="action" value="<?php echo (isset($_GET['id']) ? 'add' : 'add') ?>">
                                                    <input type="hidden" name="id" id="id" value="<?php echo (isset($_GET['id']) ? $_GET['id'] : "") ?>">
                                                    <button type="submit" id="btn_save" name="btn_save" class="btn btn-primary" onclick="GetSelected();"><i class="fa fa-floppy-o"></i><b> <?php echo (isset($_GET['type']) && isset($_GET['id']) ? 'Save' : 'Save') ?></b></button>

                                                </form>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div>
                            </div>
                        <?php } else {
                            ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">
                                            <div class="col-sm-12" align="right">
                                                <td><a href = '#addinstruction' style="color: black;margin-right: -0px;" data-toggle = 'modal'><i class="fa fa-info-circle"></i></a>
                                            </div>
                                            <h4 class="mt-0 header-title">View Of Inquiry List</h4><br>
                                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Reference No.</th>
                                                        <th>Date</th>
                                                        <th>Remark</th>
                                                        <th>Send</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include_once 'shreeLib/DBAdapter.php';
                                                    $dba = new DBAdapter();
                                                    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                    $field = array("inquiry.id,inquiry.inq_date,inquiry.inq_remark,inquiry_send_to.inq_id,inquiry.reference_no");
                                                    $data = $dba->getRow("inquiry  left join inquiry_send_to on inquiry.id=inquiry_send_to.inq_id", $field, "inquiry.status='on' AND inquiry_send_to.inq_id IS Null");
                                                    $count = count($data);
                                                    //print_r($count);
                                                    $i = 1;
                                                    if ($count >= 1) {
                                                        foreach ($data as $subData) {
                                                            echo "<tr>";
                                                            echo "<td>" . $i++ . "</td>";
                                                            // echo "<td>" . $subData[1] . "</td>";
                                                            echo "<td>" . $subData[4] . "</td>";
                                                            $date1 = $subData[1];
                                                            $dates1 = date("d-m-Y", strtotime($date1));
                                                            echo "<td>" . $dates1 . "</td>";
                                                            echo "<td>" . $subData[2] . "</td>";
                                                            echo "<td><a href='inquiry_main_details.php?id=" . $subData[0] . "' class='btn btn-primary' id='" . $subData[0] . "'><i class='fa fa-save'></i> Send</a></td>";
                                                            echo "</tr>";
                                                        }
                                                    } else {
                                                        // echo 'No Data Available';
                                                    }
                                                    ?> 
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> 
                                <!--end col--> 
                            </div>
                            <?php }
                        ?>
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
                                        <p><i class="fa fa-hand-point-right"></i> first of all select the users you want send the inquiry.</p>
                                        <p><i class="fa fa-hand-point-right"></i> After select the checkbox you want send the inquiry for its users.</p>
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
                                                            $(".user").val(user);
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


