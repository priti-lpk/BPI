<?php
include_once '../shreeLib/DBAdapter.php';
//include '../shreeLib/session_info.php';

if (isset($_GET['type']) && isset($_GET['id'])) {
    $edba = new DBAdapter();
    $edata = $edba->getRow("inquiry_send_to", array("*"), "id=" . $_GET['id']);
    echo "<input type='hidden' id='inquiry_send_to_id' value='" . $_GET['id'] . "'>";
}
if (isset($_GET['inq_id']) && isset($_GET['sup_id'])) {
    $edba = new DBAdapter();
    $edata1 = $edba->getRow("supplier", array("supplier.sup_name", "supplier.sup_add", "supplier.sup_contact"), "supplier.id=" . $_GET['sup_id']);
    // echo $edata1[0][0];
}
if (isset($_GET['inq_id'])) {
    $edba = new DBAdapter();
    $edata2 = $edba->getRow("item_supplier INNER JOIN inquiry ON item_supplier.inq_id=inquiry.id", array("inquiry.id", "inquiry.reference_no"), "item_supplier.inq_id=" . $_GET['inq_id']);
    echo "<input type='hidden' id='inquiry_send_to_id' value='" . $_GET['inq_id'] . "'>";
}
if (isset($_SESSION['user_id'])) {
    $edba = new DBAdapter();
    $servername1 = basename($_SERVER['PHP_SELF']);
    $field = array("role_rights.id");
    $data = $dba->getLastID("roles_id", "create_user", "id=" . $_SESSION['user_id']);

    $mod_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " module.mod_pagename='" . $servername1 . "' and role_rights.role_id=" . $data);
    echo "<input type='text' id='role_id' value='" . $mod_data[0][0] . "'>";
//    print_r($mod_data);

    $field = array("role_rights.id,role_rights.role_edit,role_rights.role_delete,role_rights.role_create");
    $role_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " role_rights.id=" . $mod_data[0][0]);
    echo "<input type='text' id='role_id' value='" . $role_data[0][0] . "'>";
    $editdata = 0;
    $deletedata = 0;
    if ($role_data[0][1] == 1) {
        $editdata = 1;
//        echo $editdata;
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
        <title>View Item of Supplier</title>
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
            @media print {
                h4{
                    display: none !important;
                }
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
                                    <h4 class="page-title">View Of Supplier Item List</h4>
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
                                            <form action="" id="form_data" class="form-horizontal" role="form" method="get" enctype="multipart/form-data" >  

                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Select Supplier</label>
                                                    <div class="col-sm-5" id="godawn">
                                                        <input type="hidden" name="inq_id" id="inq_id" value="<?php echo $edata2[0][0]; ?>"/>

                                                        <select class="form-control select2" name="sup_id" id="sup_id" required="">
                                                            <option>Select Supplier</option>
                                                            <?php
                                                            $dba = new DBAdapter();
//                                                    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                            $data = $dba->getRow("supplier", array("id", "sup_name"), "1");
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
                                </div> <!-- end col -->
                            </div> <!-- end row -->
                            <div class="row">
                                <div class="col-12" >
                                    <div class="card m-b-20" >
                                        <div class="card-body" >
                                            <div id="printlist">
                                                <h4 class="mt-0 header-title">Supplier Item List</h4>
                                                <table id="" class="table table-striped table-bordered dt-responsive nowrap" >
                                                    <tr>
                                                        <td rowspan="2" colspan="3" style="font-size: 12px; font-family:Arial;" ><u><b>EXPORTER:</b></u><br><u><b>BLUE PEARL INTERNATIONAL</b></u><br>
                                                            B/H. CHANAKYA ACADEMY, OPP. BHAKTI PARK,<br>
                                                            MUNDRA ROAD, BHUJ-KUTCH ( INDIA ) 370 001.<br>
                                                            TEL :- +91 - 02832 - 235056<br>
                                                            FAX :- +91 - 02832 - 235057<br>
                                                            E-MAIL :- bpi01@yahoo.co.uk<br>
                                                            IE CODE :- 2095000382 DT :- 20/10/1995
                                                        </td>
                                                        <td colspan="2"style="font-size: 12px; font-family:Arial; width: auto;"><b>Supplier Name:</b>&nbsp;<label name="p_invoice_no" style="border: none;width:auto;"><?php
                                                                if (isset($_GET['inq_id']) && isset($_GET['sup_id'])) {
                                                                    echo $edata1[0][0];
                                                                }
                                                                ?></label><br><b>Address:</b>&nbsp;<label  name="p_invoice_no" style="border: none;width: auto;"><?php
                                                                if (isset($_GET['inq_id']) && isset($_GET['sup_id'])) {
                                                                    echo $edata1[0][1];
                                                                }
                                                                ?></label><br><b>Contact:</b>&nbsp;<label name="p_invoice_no" style="border: none;width: auto;" ><?php
                                                                    if (isset($_GET['inq_id']) && isset($_GET['sup_id'])) {
                                                                        echo $edata1[0][2];
                                                                    }
                                                                    ?></label><br></td>

                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" style="font-size: 12px; font-family:Arial; width: 150px;"><b>Reference No.:</b>&nbsp;<label style="border:none;width: 100px" ><?php
                                                                if (isset($_GET['inq_id'])) {
                                                                    echo $edata2[0][1];
                                                                }
                                                                ?></label><br></td></tr>
                                                    <tr>
                                                        <td style="font-size: 12px; font-family:Arial; width: 50px;"><b>NO.</b></td>
                                                        <td style="font-size: 12px; font-family:Arial;"><b>ITEM NAME</b></td>
                                                        <td style="font-size: 12px; font-family:Arial;width: 80px;"><b>QTY/UNIT</b></td>
                                                        <td style="font-size: 12px; font-family:Arial;"><b>RATE USD</b></td>
                                                        <td style="font-size: 12px; font-family:Arial;"><b>AMOUNT USD</b></td>
                                                    </tr>
                                                    <?php
                                                    if (isset($_GET['inq_id']) && isset($_GET['sup_id'])) {
                                                        include_once '../shreeLib/DBAdapter.php';
                                                        $dba = new DBAdapter();
                                                        $id = $_GET['sup_id'];
                                                        $sql = "SELECT item_supplier.item_name,item_supplier.item_qty FROM item_supplier  WHERE find_in_set('" . $id . "',item_supplier.supplier_id)";
                                                        $result = mysqli_query($con, $sql);
                                                        // print_r($sql);
                                                        $i = 1;
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            echo "<tr>";
                                                            echo "<td>" . $i++ . "</td>";
                                                            echo "<td>" . $row['item_name'] . "</td>";
                                                            echo "<td>" . $row['item_qty'] . "</td>";
                                                            echo "<td></td>";
                                                            echo "<td></td>";
                                                            echo "</tr>";
                                                        }
                                                    }
                                                    ?>


<!--                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Item Name</th>
                                                            <th>Item Qty.</th>

                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                    <?php
                                                    if (isset($_GET['sup_id'])) {
                                                        include_once '../shreeLib/DBAdapter.php';
                                                        $dba = new DBAdapter();
                                                        $id = $_GET['sup_id'];
                                                        $sql = "SELECT create_item.item_name,inquiry_item_list.item_quantity FROM item_supplier INNER JOIN inquiry_item_list ON item_supplier.item_id=inquiry_item_list.id INNER JOIN create_item ON inquiry_item_list.item_id=create_item.id  WHERE FIND_IN_SET('" . $id . "',item_supplier.supplier_id)";
                                                        $result = mysqli_query($con, $sql);
//                                                                    print_r($sql);
                                                        $i = 1;
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            echo "<tr>";
                                                            echo "<td>" . $i++ . "</td>";
                                                            echo "<td>" . $row['item_name'] . "</td>";
                                                            echo "<td>" . $row['item_quantity'] . "</td>";

                                                            echo "</tr>";
                                                        }
                                                    }
                                                    ?>

                                                    </tbody>-->

                                                </table>
                                            </div>
                                            <input type="button" value="Create PDF" id="btPrint" class="btn btn-primary" onclick="createPDF();" />                                 
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
                                        <p><i class="fa fa-hand-point-right"></i> It is a view of suppplier's items.</p>
                                        <p><i class="fa fa-hand-point-right"></i> First of  all you select the supplier then search the supplier's items.</p>
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
                                                function createPDF() {
                                                    var sTable = document.getElementById('printlist').innerHTML;

                                                    var style = "<style>";
                                                    style = style + "table {width: 100%;font: 17px Calibri;}";
                                                    style = style + "table, th, td {border: solid 1px #DDD; border-collapse: collapse;";
                                                    style = style + "padding: 2px 3px;text-align: center;}";
                                                    style = style + "</style>";

                                                    // CREATE A WINDOW OBJECT.
                                                    var win = window.open('', '', 'height=700,width=700');

                                                    win.document.write('<html><head>');
                                                    win.document.write('<title>Supplier List</title>');   // <title> FOR PDF HEADER.
                                                    win.document.write(style);          // ADD STYLE INSIDE THE HEAD TAG.
                                                    win.document.write('</head>');
                                                    win.document.write('<body>');
                                                    win.document.write(sTable);         // THE TABLE CONTENTS INSIDE THE BODY TAG.
                                                    win.document.write('</body></html>');

                                                    win.document.close(); 	// CLOSE THE CURRENT WINDOW.

                                                    win.print();    // PRINT THE CONTENTS.
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


