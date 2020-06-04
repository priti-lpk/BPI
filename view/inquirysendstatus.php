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
        <title><?php
            if (isset($_GET['type'])) {
                echo 'Edit Add Inquiry Details';
            } else {
                echo 'Add New Inquiry Details';
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
                                    <h4 class="page-title">View Inquiry Send Details</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="page-content-wrapper">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">                   
                                            <form action="" id="form_data" class="form-horizontal" role="form" method="get" enctype="multipart/form-data" >  

                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Select Inquiry</label>
                                                    <div class="col-sm-5" id="godawn">       
                                                        <select class="form-control select2" name="i_id" id="i_id" required="">
                                                            <option>Select Inquiry Reference No.</option>
                                                            <?php
                                                            $dba = new DBAdapter();
//                                                    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                            $data = $dba->getRow("inquiry", array("id", "reference_no"), "status='on'");
                                                            foreach ($data as $subData) {
                                                                echo "<option value=" . $subData[1] . ">" . $subData[1] . "</option>";
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
                                </div> <!-- end col -->
                            </div> <!-- end row -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">
                                            <form action="customFile/purchase_listPro.php" method="POST">
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr id="totalrow">
                                                            <th>No.</th>
                                                            <th>Supplier Name</th>
                                                            <th>Item Name</th>
                                                            <th>Item Qty.</th>
                                                            <th>Item Rate</th>
                                                            <th>Item Amount</th>
                                                            <th>Note</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>


                                                        <?php
                                                        if (isset($_GET['i_id'])) {
                                                            $data = $dba->getLastID("roles_id", "create_user", "id=" . $_SESSION['user_id']);
                                                            $sql = "select create_user.roles_id,role_master.role_name FROM create_user INNER JOIN role_master ON create_user.roles_id=role_master.id where create_user.roles_id=" . $data;
//                    echo $sql;
                                                            $result = mysqli_query($con, $sql);
                                                            $row = mysqli_fetch_array($result);
                                                            $id = $row[1];
                                                            $inq_id = $_GET['i_id'];
                                                            if ($id != 'Manager') {
//                                                        $id = $row['roles_id'];

                                                                include_once '../shreeLib/DBAdapter.php';
                                                                $dba = new DBAdapter();
                                                                $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                                $sql = "SELECT supplier.sup_name,send_party_item_list.id,send_party_item_list.send_party_id,send_party_item_list.item_unit,send_party_item_list.item_name,send_party_item_status.new_qty,send_party_item_list.item_rate,send_party_item_list.item_amount,send_party_item_status.note,inquiry.reference_no,send_party.user_id,send_party.sup_id,send_party.id as sid,send_party.inquiry_no,send_pary_ite_list.item_id FROM send_party_item_status INNER JOIN send_party_item_list ON send_party_item_status.send_party_item_id=send_party_item_list.id INNER JOIN send_party ON send_party_item_list.send_party_id=send_party.id INNER JOIN add_quotation ON send_party.quo_id=add_quotation.id LEFT JOIN inquiry ON add_quotation.inquiry_id=inquiry.id INNER JOIN supplier ON add_quotation.supplier_id=supplier.id where send_party.user_id='" . $_SESSION['user_id'] . "' and inquiry.reference_no=" . $inq_id;
                                                                $result = mysqli_query($con, $sql);
                                                                //print_r($sql);
                                                                $i = 1;
                                                                while ($row = mysqli_fetch_array($result)) {
                                                                    echo "<tr>";
                                                                    echo "<td>" . $i++ . "</td>";
                                                                    echo "<td>" . $row['sup_name'] . "</td>";
                                                                    echo "<td>" . $row['item_name'] . "</td>";
                                                                    echo "<input class='form-control' type='hidden' name='sup_name[]' value= '" . $row['sup_name'] . "' >";
                                                                    echo "<input class='form-control' type='hidden' name='item_name[]' value= '" . $row['item_name'] . "' >";
                                                                    echo "<td><input class='form-control' type='text' name='qty[]' value= '" . $row['new_qty'] . "' > </td>";
                                                                    echo "<td><input class='form-control' type='text' name='rate[]' value= '" . $row['item_rate'] . "' ></td>";
                                                                    echo "<td><input class='form-control' type='text' name='total_amount[]' value= '" . $row['item_amount'] . "' ></td>";
                                                                    echo "<td>" . $row['note'] . "</td>";
                                                                    echo "<input class='form-control' type='hidden' name='inquiry_no[]' value= '" . $row['inquiry_no'] . "' >";
                                                                    echo "<input class='form-control' type='hidden' name='send_party_item_id[]' value= '" . $row['id'] . "' >";
                                                                    echo "<input class='form-control' type='hidden' name='user_id[]' value= '" . $row['user_id'] . "' >";
                                                                    echo "<input class='form-control' type='hidden' name='sup_id[]' value= '" . $row['sup_id'] . "' >";
                                                                    echo "<input class='form-control' type='hidden' name='send_party_id[]' value= '" . $row['sid'] . "' >";
                                                                    echo "<input class='form-control' type='hidden' name='unit[]' value= '" . $row['item_unit'] . "' >";
                                                                    echo "<input class='form-control' type='hidden' name='item_id[]' value= '" . $row['item_id'] . "' >";
//                                                        echo "<td><a href='selectsupplier.php?item_id=" . $row[2] . "' class='btn btn-primary' id='" . $row['id'] . "'><i class='fa fa-save'></i> Select Supplier</a>&nbsp;&nbsp;";
//                                                        echo "<a href='view/selectsupplier.php?inq_id=" . $row[0] . "' class='btn btn-primary' id='" . $row['id'] . "'><i class='fa fa-save'></i> View Item Supplier</a></td>";

                                                                    echo '</tr>';
                                                                }
                                                            } else {
                                                                include_once '../shreeLib/DBAdapter.php';
                                                                $dba = new DBAdapter();
                                                                $inq_id = $_GET['i_id'];
                                                                $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                                $sql = "SELECT supplier.sup_name,send_party_item_list.id,send_party_item_list.send_party_id,send_party_item_list.item_unit,send_party_item_list.item_name,send_party_item_status.new_qty,send_party_item_list.item_rate,send_party_item_list.item_amount,send_party_item_status.note,inquiry.reference_no,send_party.user_id,send_party.sup_id,send_party.id as sid,send_party.inquiry_no,send_party_item_list.item_id FROM send_party_item_status INNER JOIN send_party_item_list ON send_party_item_status.send_party_item_id=send_party_item_list.id INNER JOIN send_party ON send_party_item_list.send_party_id=send_party.id INNER JOIN add_quotation ON send_party.quo_id=add_quotation.id LEFT JOIN inquiry ON add_quotation.inquiry_id=inquiry.id INNER JOIN supplier ON add_quotation.supplier_id=supplier.id where inquiry.reference_no=" . $inq_id;
                                                                $result = mysqli_query($con, $sql);
//                                                                print_r($sql);
                                                                $i = 1;
                                                                $count = count($result);
                                                                if ($count >= 1) {
                                                                    while ($row = mysqli_fetch_array($result)) {
                                                                        echo "<tr>";
                                                                        echo "<td>" . $i++ . "</td>";
                                                                        echo "<td>" . $row['sup_name'] . "</td>";
                                                                        echo "<td>" . $row['item_name'] . "</td>";
                                                                        echo "<input class='form-control' type='hidden' name='sup_name[]' value= '" . $row['sup_name'] . "' >";
                                                                        echo "<input class='form-control' type='hidden' name='item_name[]' value= '" . $row['item_name'] . "' >";
                                                                        echo "<td id='qtn'><input class='form-control' type='text' id='qnty1' name='qty[]' value= '" . $row['new_qty'] . "' onchange='changeQnty(this);'> </td>";
                                                                        echo "<td><input class='form-control' type='text' id='rate1' name='rate[]' value= '" . $row['item_rate'] . "' ></td>";
                                                                        echo "<td><input class='form-control' type='text' id='total1' name='total_amount[]' value= '" . $row['item_amount'] . "' ></td>";
                                                                        echo "<td>" . $row['note'] . "</td>";
                                                                        echo "<input class='form-control' type='hidden' name='inquiry_no[]' value= '" . $row['inquiry_no'] . "' >";
                                                                        echo "<input class='form-control' type='hidden' name='send_party_item_id[]' value= '" . $row['id'] . "' >";
                                                                        echo "<input class='form-control' type='hidden' name='user_id[]' value= '" . $row['user_id'] . "' >";
                                                                        echo "<input class='form-control' type='hidden' name='sup_id[]' value= '" . $row['sup_id'] . "' >";
                                                                        echo "<input class='form-control' type='hidden' name='send_party_id[]' value= '" . $row['sid'] . "' >";
                                                                        echo "<input class='form-control' type='hidden' name='unit[]' value= '" . $row['item_unit'] . "' >";
                                                                        echo "<input class='form-control' type='hidden' name='item_id[]' value= '" . $row['item_id'] . "' >";
                                                                        echo '</tr>';
                                                                    }
                                                                } else {
                                                                    echo "No Data Found";
                                                                }
                                                            }
                                                        }
                                                        ?> 
                                                    </tbody>
                                                </table>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Select Godawn</label>
                                                    <div class="col-sm-4">
                                                        <select style='width:300px;' name='godawn_id' id = 'u_id' class ='form-control select2 godawn' required>
                                                            <?php
                                                            $dba = new DBAdapter();
                                                            $Names = $dba->getRow("create_godawn", array("id", "godawn_name"), "1");
                                                            $counts = count($Names);
                                                            echo "<option>Select Godawn</option>";

                                                            if ($counts >= 1) {
                                                                foreach ($Names as $name) {
                                                                    echo "<option value=" . $name[0] . ">" . $name[1] . "</option>";
                                                                }
                                                            } else {
                                                                
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Purchase Date</label>
                                                    <div class="col-sm-4">
                                                        <input type='date' name='purchase_date' id='datevalue' class='form-control' required></td>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="action" id="action" value="<?php echo (isset($_GET['id']) ? 'add' : 'add') ?>">
                                                <input type="hidden" name="id" id="id" value="<?php echo (isset($_GET['id']) ? $_GET['id'] : "") ?>">
                                                <button type="submit" id="btn_save" name="btn_save" class="btn btn-primary"><i class="fa fa-floppy-o"></i><b>Add Purchase</b></button>
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
        <script>
            (function () {
                "use strict";

                $("table").on("change", "input", function () {
                    var row = $(this).closest("tr");
                    var qty = parseFloat(row.find("input:eq(2)").val());
                    var price = parseFloat(row.find("input:eq(3)").val());
                    var total = qty * price;
                    row.find("input:eq(4)").val(isNaN(total) ? "" : parseFloat(total).toFixed(2));
                });
            })();
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


