<?php
include_once '../shreeLib/DBAdapter.php';
//include '../shreeLib/session_info.php';

if (isset($_GET['type']) && isset($_GET['id'])) {
    $edba = new DBAdapter();
    $edata = $edba->getRow("send_party", array("*"), "id=" . $_GET['id']);
    echo "<input type='hidden' id='send_party_id' value='" . $_GET['id'] . "'>";
}if (isset($_SESSION['user_id'])) {

    $edba = new DBAdapter();
    $servername1 = basename($_SERVER['PHP_SELF']);
    $field = array("role_rights.id");
    $data = $dba->getLastID("roles_id", "create_user", "id=" . $_SESSION['user_id']);

    $mod_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " module.mod_pagename='" . $servername1 . "' and role_rights.role_id=" . $data);
    echo "<input type='hidden' id='role_id' value='" . $mod_data[0][0] . "'>";

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
        <title>Proforma Invoice</title>
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
                                    <h4 class="page-title">View Proforma Invoice</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="page-content-wrapper">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">                   

                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-1 col-form-label">Select</label>
                                                <div class="col-sm-4" id="partylist5">       
                                                    <select class="form-control select2" name="party_id" id="data" required="">
                                                        <option value="#">Select</option>
                                                        <option value="fob">FOB VALUE</option>
                                                        <option value="cf">C&F VALUE</option>
                                                        <option value="cif">CIF VALUE</option>
                                                    </select>
                                                </div>
                                                <label for="example-text-input" class="col-sm-1 col-form-label">USD($)</label>
                                                <div class="col-sm-2">
                                                    <input class="form-control" type="text"  placeholder="USD Amount" name="usd" id="usd" value="" onchange="convertVal(this.value)" required="">
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

                                            <h4 class="mt-0 header-title">View Of Proforma Invoice</h4>
                                            <button type="submit" name="print" id="print" class="btn btn-primary" onclick="window.print()"><i class="fa fa-print"> Print</i></button>
                                            <br><br>
                                            <!--<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">-->
                                            <form action="customFile/addProformaInvoice.php" id="form_data" class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" >                                      

                                                <table border="3" width="1000px;" id="view_data datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap">                                                            
                                                    <tr>
                                                        <td rowspan="3" colspan="3"><u><b>EXPORTER:</b></u><br><u><b>BLUE PEARL INTERNATIONAL</b></u><br>
                                                            OPP. BHAKTI PARK, B/H. CHANAKYA ACADEMY,<br>
                                                            MUNDRA ROAD, BHUJ - KUTCH ( INDIA ) 370 001.<br>
                                                            TEL :- +91 - 2832 - 235056<br>
                                                            FAX :- +91 - 2832 - 235055<br>
                                                            E-MAIL :- bpi01@yahoo.co.uk<br>
                                                            IE CODE :- 2095000382 DT :- 20/10/1995
                                                        </td><input type="hidden" name="quo_id" value="<?php echo $_GET['id'] ?>">
                                                    <td><b>P. INVOICE NO.:</b>&nbsp;<input type="text" name="p_invoice_no" style="border: double;width: 100px"><br></td>
                                                    <td><b>DATE:</b>&nbsp;<input type="date" name="invoice_date" style="border:none;width: 130px" ><br></td>
                                                    <td><b>EXPORTER'S NO.:</b><input type="text" name="exporter_no"  style="border: double;width: 100px"><br></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"><b>INQUIRY NO & DATE:&nbsp;<input type="text" name="inquiry_no" value="<?php echo $_GET['id'] ?>"style="border: none;"><BR>BUYER'S ORDER NO & DATE:-</b>&nbsp;
                                                            <input type="text" name="buyer_order_no" style="border: double;width: 100px"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"><u><b>BANK DETAILS</b></u><br><br><br><br><br></td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2" colspan="3"><u><b>CONSIGNEE:<br><br><br><br><br></b></u></td>
                                                        <td><b>COUNTRY OF ORIGIN<br><br></b></td>
                                                        <td colspan="2"><b>COUNTRY OF FINAL DESTINATION<br><br></b></td>

                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"><b>BUYER OTHER THAN CONSIGNEE:<br><br></b></td> 
                                                    </tr>
                                                    <tr>
                                                        <td><center><b>PRE-CARRIAGE BY</b></center><br></td>
                                                    <td colspan="2"><b><center>PRE-CARRIAGE RECEIPT AT<center></b><br></td>       
                                                                    <td colspan="2"><b>B/L NO.:-</b>&nbsp;&nbsp;<input type="text" name="bl_no"style="border: double;width: 200px"><br><br><b>S.B No.:-</b>&nbsp;&nbsp;<input type="text" name="sb_no" style="border: double;width: 200px"></td>
                                                                    <td><b>DATE:-&nbsp;</b><input type="date" name="bl_date"style="border:none" ><br><b>DATE:-</b>&nbsp;<input type="date" name="sb_date" style="border:none" ></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><b><center>VESSEL/FLIGHT No.<center></b><br></td>
                                                                                        <td colspan="2"><b><center>PORT OF LOADING<center></b><br></td>
                                                                                                        <td colspan="3" rowspan="2"><b><center>TERMS OF DELIVERY AND PAYMENTS:</center><br>DELIVERY:-&nbsp;&nbsp;<input type="text" name="delivery" style="border: double;width: 400px"><br><br>PAYMENT:-&nbsp;&nbsp;&nbsp;<input type="text" name="payment" style="border: double;width: 400px"></b><br><br></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><b><center>PORT OF DISCHARGE<center></b><br></td>
                                                                                                                            <td colspan="2"><b><center>FINAL DESTINATION<center></b><br></td>
                                                                                                                                            </tr>
                                                                                                                                            <tr>
                                                                                                                                                <td><b>MARK & CONT.NO.</b></td>
                                                                                                                                                <td><b>NO. & KIND PACKING</b></td>
                                                                                                                                                <td><b>DESCRIPTION OF GOODS</b></td>
                                                                                                                                                <td><b>QTY/UNIT</b></td>
                                                                                                                                                <td><b>RATE USD</b></td>
                                                                                                                                                <td><b>AMOUNT USD</b></td>
                                                                                                                                            </tr>
                                                                                                                                            <?php
                                                                                                                                            include_once '../shreeLib/DBAdapter.php';
                                                                                                                                            $dba = new DBAdapter();
                                                                                                                                            $id = $_GET['id'];
                                                                                                                                            $last_id = $dba->getLastID("branch_id", "create_user", "1");
                                                                                                                                            $field = array("add_quotation.id,add_quotation.item_name,add_quotation.unit,add_quotation.qty,add_quotation.new_rate,add_quotation.remark,inquiry_item_list.item_id,add_quotation.party_id");
                                                                                                                                            $data = $dba->getRow("add_quotation INNER JOIN inquiry_item_list ON add_quotation.inquiry_item_id=inquiry_item_list.id INNER JOIN send_party ON add_quotation.id = send_party.quo_id", $field, "send_party.id=" . $id . " AND add_quotation.new_rate IS NOT NULL");
                                                                                                                                            $count = count($data);
                                                                                                                                            $i = 1;
                                                                                                                                            $totalrate = 0;
                                                                                                                                            $totalamt = 0;
                                                                                                                                            if ($count >= 1) {
                                                                                                                                                foreach ($data as $subData) {

                                                                                                                                                    echo "<tr>";
                                                                                                                                                    echo "<td>" . $i++ . "</td>";
                                                                                                                                                    echo "<input type='hidden' name='item_id[]'  value=" . $subData[6] . ">";
                                                                                                                                                    echo "<td>" . $subData[1] . "</td>";
                                                                                                                                                    echo "<input type='hidden' name='item_name[]'  value=" . $subData[1] . ">";
                                                                                                                                                    echo "<td>" . $subData[5] . "</td>";
                                                                                                                                                    echo "<td>" . $subData[3] . "/" . $subData[2] . "</td>";
                                                                                                                                                    echo "<input type='hidden' name='item_qty[]'  value=" . $subData[3] . ">";
                                                                                                                                                    echo "<input type='hidden' name='item_unit[]'  value=" . $subData[2] . ">";
                                                                                                                                                    $value = "<input type='hidden' name='amount' id='amount'>";
                                                                                                                                                    echo $value;
                                                                                                                                                    echo "<input type='hidden' name='amount1' class='a1' id='amount1' value=" . $subData[4] . ">";
                                                                                                                                                    $usdvalue = "<input style='border:none;' type='text' id='a2' class='convert1' name='item_rate[]'>";

                                                                                                                                                    echo "<td>" . $usdvalue . "</td>";
                                                                                                                                                    $amount = $subData[3] * $subData[4];
                                                                                                                                                    echo "<input type='hidden' name='amount4' id='amount4'  class='a4' value=" . $amount . ">";
                                                                                                                                                    echo "<td><input style='border:none;' type='text' id='a5' class='convert' name='item_amount[]' ></td>";
                                                                                                                                                    $totalrate += $subData[4];
                                                                                                                                                    $totalamt += $amount;
                                                                                                                                                    $offset = strtotime("+3 day");
                                                                                                                                                    $timestamp = date("Y-m-d", $offset);
                                                                                                                                                    //$timestamp = time() + 3600; // one hour
                                                                                                                                                    $md5url = md5(" . $subData[0] . " - " . $timestamp . ");
                                                                                                                                                    echo "<input type='hidden' id='md5' name='md5' value='" . $md5url . "'>";
                                                                                                                                                    echo "<input type='hidden' id='q_id' name='q_id' value='" . $subData[0] . "'>";
                                                                                                                                                    echo "<input type='hidden' id='url_link' name='url_link' value='http://localhost/bpiindia/view/SendParty.php?id=" . $md5url . "'>";
                                                                                                                                                    echo "<input type='hidden' id='time_stamp' name='time_stamp' value='" . $timestamp . "'>";
                                                                                                                                                    echo "<input type='hidden' name = 'party_id' id = 'party_id' value = '" . $subData[7] . "'>";
                                                                                                                                                    echo "</tr>";
                                                                                                                                                }


                                                                                                                                                echo "<input type='hidden'  id='totalrate' value=" . $totalrate . ">";
                                                                                                                                                echo "<input type='hidden'  id='totalamt' value=" . $totalamt . ">";
                                                                                                                                                $amt = "<input  type='text' name='total_amount' id='amt1'>";
//                                                                                                                                                            echo displaywords($amt);
                                                                                                                                            }
                                                                                                                                            ?>
                                                                                                                                            <tr>
                                                                                                                                                <td colspan = "3"><center>(Quantity 10% Plus Or Minus is Allowed)</center></td>
                                                                                                                                            <td></td>
                                                                                                                                            <td></td>
                                                                                                                                            <td></td>
                                                                                                                                            </tr>
                                                                                                                                            <tr class="hideShowTr"id="fob"  style="display: none;">
                                                                                                                                                <td colspan = "3" style="text-align: right;"><b>FOB VALUE</b></td>

                                                                                                                                                <td></td>
                                                                                                                                                <td><input style='border:none;' type="text" id="fob1"></td>
                                                                                                                                                <td><input style='border:none;' type="text" name="fob_value" id="fob2"></td>
                                                                                                                                            </tr>            
                                                                                                                                            <tr  class="hideShowTr"id="cf"  style="display: none;">
                                                                                                                                                <td colspan = "3" style="text-align: right;"><b>FOB VALUE</b></td>

                                                                                                                                                <td></td>
                                                                                                                                                <td><input style='border:none;' type="text"  id="cf1"></td>
                                                                                                                                                <td><input style='border:none;' type="text" name="fob_value" id="cf2"></td>
                                                                                                                                            </tr> 
                                                                                                                                            <tr  class="hideShowTr"id="cif"  style="display: none;">
                                                                                                                                                <td colspan = "3" style="text-align: right;"><b>FOB VALUE</b></td>

                                                                                                                                                <td></td>
                                                                                                                                                <td><input style='border:none;' type="text" id="cif1"></td>
                                                                                                                                                <td><input style='border:none;' type="text" name="fob_value" id="cif2"></td>
                                                                                                                                            </tr> 
                                                                                                                                            <tr  class="hideShowTr"id="cf"  style="display: none;">
                                                                                                                                                <td colspan = "3" style="text-align: right;"><b>FREIGHT</b></td>

                                                                                                                                                <td></td>
                                                                                                                                                <td></td>
                                                                                                                                                <td><input type="text" id="cff1" name="cf_freight" value="0" style="border:groove;border-width: 3px;border-color: #dddada;" onchange="sum();" ></td>
                                                                                                                                            </tr>   
                                                                                                                                            <tr  class="hideShowTr"id="cif"  style="display: none;">
                                                                                                                                                <td colspan = "3" style="text-align: right;"><b>FREIGHT</b></td>

                                                                                                                                                <td></td>
                                                                                                                                                <td></td>
                                                                                                                                                <td><input type="text" id="ciff1" name="cif_freight" value="0" style="border:groove;border-width: 3px;border-color: #dddada;" onchange="sum2();"></td>
                                                                                                                                            </tr>            

                                                                                                                                            <tr  class="hideShowTr"id="cif"  style="display: none;">
                                                                                                                                                <td colspan = "3" style="text-align: right;"><b>CIF VALUE</b></td>

                                                                                                                                                <td></td>
                                                                                                                                                <td></td>
                                                                                                                                                <td><input type="text" id="cif13" name="cif_value" value="0" style="border:groove;border-width: 3px;border-color: #dddada;" onchange="sum4();"></td>
                                                                                                                                            </tr>


                                                                                                                                            <tr  class="hideShowTr"id="cf"  style="display: none;">
                                                                                                                                                <td colspan = "3" style="text-align: right;"><b>C&F VALUE</b></td>

                                                                                                                                                <td></td>
                                                                                                                                                <td></td>
                                                                                                                                                <td><input type="text"id="cf11" name="cf_value" value="0" style="border:groove;border-width: 3px;border-color: #dddada;" onchange="sum1();"></td>
                                                                                                                                            </tr>
                                                                                                                                            <tr  class="hideShowTr"id="cif"  style="display: none;">
                                                                                                                                                <td colspan = "3" style="text-align: right;"><b>INSURANCE</b></td>

                                                                                                                                                <td></td>
                                                                                                                                                <td></td>
                                                                                                                                                <td><input type="text" id="cif12" name="insurance" value="0" style="border:groove;border-width: 3px;border-color: #dddada;" onchange="sum3();"></td>
                                                                                                                                            </tr>
                                                                                                                                            <tr>
                                                                                                                                                <td colspan = "6"><b>AMT.$</b>&nbsp;&nbsp;<input style='border:none;' type="text" id="amt" style="border:groove;border-width: 3px;border-color: #dddada;" />
                                                                                                                                                    <!--<div id="word"><?php echo displaywords($amt); ?></div>-->
                                                                                                                                                    <input style='border:none;' type="hidden" name="total_amount" id="amt1"><br><br><br><br></td>

                                                                                                                                            </tr>
                                                                                                                                            <tr>
                                                                                                                                                <td colspan = "6"><b><u>DECLARATION:</u></b></td>
                                                                                                                                            </tr>
                                                                                                                                            <tr>
                                                                                                                                                <td colspan = "6">We Declare that this invoice shows the actual price of the goods Described and that particulars are true and correct.</td>
                                                                                                                                            </tr>
                                                                                                                                            <tr>
                                                                                                                                                <td colspan = "6"><b><u>JURISDICTION:</u></b> Subject to BHUJ Jurisdiction.</td>
                                                                                                                                            </tr>
                                                                                                                                            </table>
                                                                                                                                            <input type="hidden" name="action" id="action" value="add"/>
                                                                                                                                            <input type="hidden" name="id" id="id" value="<?php echo (isset($_GET['id']) ? $_GET['id'] : "") ?>">
                                                                                                                                            <button type="submit" id="btn_save" class="btn btn-primary"><i class="fa fa-floppy-o"></i>Send to Party</button>
                                                                                                                                            </form>
                                                                                                                                            <!--</table>-->

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

                                                                                                                                                            $('#data').change(function () {
                                                                                                                                                                $('.hideShowTr').css('display', 'none');
                                                                                                                                                                $('tr#' + $(this).val()).css('display', '');
                                                                                                                                                            });
                                                                                                                                                        </script>

                                                                                                                                                        <script>
                                                                                                                                                            function convertVal(dval) {
                                                                                                                                                                var dval = document.getElementById("usd").value;
                                                                                                                                                                var a1 = document.getElementsByClassName('a1');
                                                                                                                                                                var total = "";
                                                                                                                                                                for (var i = 0; i < a1.length; i++) {
                                                                                                                                                                    var amount1 = (a1[i].value / dval).toFixed(2);                                                                                                                                                                    //                                                                                                                                                               alert(amount1);
                                                                                                                                                                    $(".convert1").each(function () {
                                                                                                                                                                        var usdamount1 = $(this).val((a1[i].value / dval).toFixed(2));                                                                                                                                                                        //                                                                                                                                                                    alert(usdamount1);
                                                                                                                                                                        i++;
                                                                                                                                                                    });
                                                                                                                                                                }
                                                                                                                                                                var t1 = (document.getElementById("totalrate").value / dval).toFixed(2);                                                                                                                                                                //                                                                                                                                                            alert(t1);
                                                                                                                                                                document.getElementById("fob1").value = t1;
                                                                                                                                                                document.getElementById("cf1").value = t1;
                                                                                                                                                                document.getElementById("cif1").value = t1;
                                                                                                                                                                var a4 = document.getElementsByClassName('a4');
                                                                                                                                                                for (var i = 0; i < a4.length; i++) {
                                                                                                                                                                    $(".convert").each(function () {
                                                                                                                                                                        var usdamount2 = $(this).val((a4[i].value / dval).toFixed(2));                                                                                                                                                                        //                                                                                                                                                                    alert(usdamount2);
                                                                                                                                                                        i++;
                                                                                                                                                                    });
                                                                                                                                                                }
                                                                                                                                                                var t2 = (document.getElementById("totalamt").value / dval).toFixed(2);                                                                                                                                                                //                                                                                                                                                            alert(t2);
                                                                                                                                                                document.getElementById("fob2").value = t2;
                                                                                                                                                                document.getElementById("cf2").value = t2;
                                                                                                                                                                document.getElementById("cif2").value = t2;
                                                                                                                                                                document.getElementById("amt").value = t2 + "$";
                                                                                                                                                                document.getElementById("amt1").value = t2;
                                                                                                                                                            }
                                                                                                                                                            function sum() {
                                                                                                                                                                var cff1 = document.getElementById('cff1').value;
                                                                                                                                                                var cf2 = document.getElementById('cf2').value;
                                                                                                                                                                var totalcf = (parseFloat(cff1) + parseFloat(cf2)).toFixed(2);                                                                                                                                                                //                                                                                                                                                            alert(totalcf);
                                                                                                                                                                document.getElementById("amt").value = totalcf + "$";
                                                                                                                                                                document.getElementById("amt1").value = totalcf;
                                                                                                                                                            }
                                                                                                                                                            function sum1() {
                                                                                                                                                                var cff1 = document.getElementById('cff1').value;
                                                                                                                                                                var cf2 = document.getElementById('cf2').value;
                                                                                                                                                                var cf11 = document.getElementById('cf11').value;
                                                                                                                                                                var totalcf1 = (parseFloat(cff1) + parseFloat(cf2) + parseFloat(cf11)).toFixed(2);                                                                                                                                                                //                                                                                                                                                            alert(totalcf1);
                                                                                                                                                                document.getElementById("amt").value = totalcf1;
                                                                                                                                                                document.getElementById("amt1").value = totalcf1;
                                                                                                                                                            }
                                                                                                                                                            function sum2() {
                                                                                                                                                                var ciff1 = document.getElementById('ciff1').value;
                                                                                                                                                                var cif2 = document.getElementById('cif2').value;
                                                                                                                                                                var totalcf = (parseFloat(ciff1) + parseFloat(cif2)).toFixed(2);                                                                                                                                                                //                                                                                                                                                            alert(totalcf);
                                                                                                                                                                document.getElementById("amt").value = totalcf + "$";
                                                                                                                                                                document.getElementById("amt1").value = totalcf;
                                                                                                                                                            }
                                                                                                                                                            function sum3() {
                                                                                                                                                                var ciff1 = document.getElementById('ciff1').value;
                                                                                                                                                                var cif2 = document.getElementById('cif2').value;
                                                                                                                                                                var cif12 = document.getElementById('cif12').value;
                                                                                                                                                                var totalcf1 = (parseFloat(ciff1) + parseFloat(cif2) + parseFloat(cif12)).toFixed(2);                                                                                                                                                                //                                                                                                                                                            alert(totalcf1);
                                                                                                                                                                document.getElementById("amt").value = totalcf1 + "$";
                                                                                                                                                                document.getElementById("amt1").value = totalcf1;
                                                                                                                                                            }
                                                                                                                                                            function sum4() {
                                                                                                                                                                var ciff1 = document.getElementById('ciff1').value;
                                                                                                                                                                var cif2 = document.getElementById('cif2').value;
                                                                                                                                                                var cif12 = document.getElementById('cif12').value;
                                                                                                                                                                var cif13 = document.getElementById('cif13').value;
                                                                                                                                                                var totalcf1 = (parseFloat(ciff1) + parseFloat(cif2) + parseFloat(cif12) + parseFloat(cif13)).toFixed(2);                                                                                                                                                                //                                                                                                                                                            alert(totalcf1);
                                                                                                                                                                document.getElementById("amt").value = totalcf1 + "$";
                                                                                                                                                                document.getElementById("amt1").value = totalcf1;

                                                                                                                                                            }
                                                                                                                                                        </script>

                                                                                                                                            </body>

                                                                                                                                            </html>


