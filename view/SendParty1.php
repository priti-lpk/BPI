<?php
include_once '../shreeLib/DBAdapter.php';
//include '../shreeLib/session_info.php';
include_once './numtoword.php';
$words = new numtoword();

if (isset($_GET['id'])) {
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

    $field = array("role_rights.id,role_rights.role_edit,role_rights.role_delete,role_rights.role_create");
    $role_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " role_rights.id=" . $mod_data[0][0]);
    echo "<input type='hidden' id='role_id' value='" . $role_data[0][0] . "'>";
}

function displaywords($number) {
    $words = array('0' => '', '1' => 'one', '2' => 'two',
        '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
        '7' => 'seven', '8' => 'eight', '9' => 'nine',
        '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
        '13' => 'thirteen', '14' => 'fourteen',
        '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
        '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
        '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
        '60' => 'sixty', '70' => 'seventy',
        '80' => 'eighty', '90' => 'ninety');
    $digits = array('', '', 'hundred', 'thousand', 'lakh', 'crore');

    $number = explode(".", $number);
    $result = array("", "");
    $j = 0;
    foreach ($number as $val) {
        // loop each part of number, right and left of dot
        for ($i = 0; $i < strlen($val); $i++) {
            // look at each part of the number separately  [1] [5] [4] [2]  and  [5] [8]

            $numberpart = str_pad($val[$i], strlen($val) - $i, "0", STR_PAD_RIGHT); // make 1 => 1000, 5 => 500, 4 => 40 etc.
            if ($numberpart <= 20) {
                $numberpart = 1 * substr($val, $i, 2);
                $i++;
                $result[$j] .= $words[$numberpart] . " ";
            } else {
                //echo $numberpart . "<br>\n"; //debug
                if ($numberpart > 90) {  // more than 90 and it needs a $digit.
                    $result[$j] .= $words[$val[$i]] . " " . $digits[strlen($numberpart) - 1] . " ";
                } else if ($numberpart != 0) { // don't print zero
                    $result[$j] .= $words[str_pad($val[$i], strlen($val) - $i, "0", STR_PAD_RIGHT)] . " ";
                }
            }
        }
        $j++;
    }
    if (trim($result[0]) != "")
        echo $result[0] . "Rupees ";
    if ($result[1] != "")
        echo $result[1] . "Paise";
    echo " Only";
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
        <style type="text/css">
            table,tr,td{
                border: 1px #ced4da solid;
            }
            @media print {
                @page {
                    /*size: A4 landscape;*/
                    size: auto;
                    margin: 0mm;
                    page-break-after: auto;
                    /*overflow: visible;*/
                }
                table{
                    page-break-after: auto;
                    /*overflow: visible;*/
                }
                html, body {
                    /*height:100vh;*/ 
                    margin: 0 !important; 
                    padding: 0 !important;
                    overflow: hidden;
                    border: 1px solid white;
                    height: 100%;
                    page-break-after: auto;
                    page-break-before: avoid;
                    font-size: 10px;
                }
                #print{
                    display: none;
                }
                .selectdata{
                    display: none;
                }
                .invoice{
                    /*overflow: visible;*/
                    /*                    width: 1050px;
                                        height: 1400px;*/
                }
                table, tr, th, td {
                    border: 1px #ced4da solid;
                }
                input{
                    border: 0 !important;
                    border-style: none !important;
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

                                            <div class="form-group row selectdata">
                                                <label for="example-text-input" class="col-sm-1 col-form-label">Select</label>
                                                <div class="col-sm-4" id="partylist5">       
                                                    <select class="form-control select2" name="party" id="data" required="">
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

                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-20">
                                        <div class="card-body invoice" id="invoice">

                                            <h4 class="mt-0 header-title">View Of Proforma Invoice</h4>
<!--                                            <button type="submit" name="print" id="print" class="btn btn-primary" onclick="window.print()"><i class="fa fa-print"> Print</i></button>
                                            <br><br>-->
                                            <!--<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">-->
                                            <form  id="form_data" class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" >                                      

                                                <table  width="900px;" height="auto" id="view_data" >                                                            
                                                    <tr>
                                                        <td rowspan="3" colspan="3"><u><b>EXPORTER:</b></u><br><u><b>BLUE PEARL INTERNATIONAL</b></u><br>
                                                            OPP. BHAKTI PARK, B/H. CHANAKYA ACADEMY,<br>
                                                            MUNDRA ROAD, BHUJ - KUTCH ( INDIA ) 370 001.<br>
                                                            TEL :- +91 - 2832 - 235056<br>
                                                            FAX :- +91 - 2832 - 235055<br>
                                                            E-MAIL :- bpi01@yahoo.co.uk<br>
                                                            IE CODE :- 2095000382 DT :- 20/10/1995
                                                        </td><input type="hidden" name="sup_id" class="sup_id" value="<?php echo $edata[0][3] ?>">
                                                    <input type="hidden" name="quo_id" class="quo_id" value="<?php echo $_GET['id'] ?>">
                                                    <input type="hidden"   value="<?php echo $edata[0][15]; ?>" name="user_id" class="user_id">

                                                    <td><b>P.INVOICE NO.:</b>&nbsp;<input type="text" name="p_invoice_no" id="p_invoice_no" class="p_invoice_no" style="border: double;width: 90px"><br></td>
                                                    <td><b>DATE:</b>&nbsp;<input type="date" name="invoice_date" class="invoice_date" id="datevalue2"style="border:none;width: 130px" ><br></td>
                                                    <td><b>EXPORTER'S NO.:</b><input type="text" name="exporter_no" class="exporter_no"  style="border: double;width: 90px"><br></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"><b>INQUIRY NO & DATE:&nbsp;<input type="text" name="inquiry_no" class="inquiry_no" value="<?php echo $_GET['inq_id'] ?>"style="border: none;"><BR>BUYER'S ORDER NO & DATE:-</b>&nbsp;
                                                            <input type="text" name="buyer_order_no" class="buyer_order_no" style="border: double;width: 100px"></td>
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
                                                                    <td colspan="2"><b>B/L NO.:-</b>&nbsp;&nbsp;<input type="text" name="bl_no" class="bl_no" style="border: double;width: 200px"><br><br><b>S.B No.:-</b>&nbsp;&nbsp;<input type="text" name="sb_no" class="sb_no" style="border: double;width: 200px"></td>
                                                                    <td><b>DATE:-&nbsp;</b><input type="date" name="bl_date" class="bl_date" id="datevalue" style="border:none" ><br><b>DATE:-</b>&nbsp;<input type="date" name="sb_date" class="sb_date" id="datevalue1" style="border:none" ></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><b><center>VESSEL/FLIGHT No.<center></b><br></td>
                                                                                        <td colspan="2"><b><center>PORT OF LOADING<center></b><br></td>
                                                                                                        <td colspan="3" rowspan="2"><b><center>TERMS OF DELIVERY AND PAYMENTS:</center><br>DELIVERY:-&nbsp;&nbsp;<input type="text" name="delivery" class="delivery" style="border: double;width: 390px"><br><br>PAYMENT:-&nbsp;&nbsp;&nbsp;<input type="text" name="payment" class="payment" style="border: double;width: 380px"></b><br><br></td>
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
                                                                                                                                            $id = $_GET['inq_id'];
                                                                                                                                            $last_id = $dba->getLastID("branch_id", "create_user", "1");
                                                                                                                                            $field = array("add_quotation.id,add_quotation.item_name,add_quotation.unit,add_quotation.qty,add_quotation.new_rate,add_quotation.remark,inquiry_item_list.item_id,add_quotation.party_id");
                                                                                                                                            $data = $dba->getRow("add_quotation INNER JOIN inquiry_item_list ON add_quotation.inquiry_item_id=inquiry_item_list.id", $field, "add_quotation.inquiry_id=" . $id . " AND add_quotation.new_rate IS NOT NULL AND add_quotation.status IS NOT NULL");
                                                                                                                                            $count = count($data);
                                                                                                                                            $i = 1;
                                                                                                                                            $totalrate = 0;
                                                                                                                                            $totalamt = 0;
                                                                                                                                            if ($count >= 1) {
                                                                                                                                                foreach ($data as $subData) {

                                                                                                                                                    echo "<tr>";
                                                                                                                                                    echo "<td>" . $i++ . "</td>";
                                                                                                                                                    echo "<input type='hidden' class='item_id' name='item_id[]'  value=" . $subData[6] . ">";
                                                                                                                                                    echo "<td style='width:400px;'>" . $subData[1] . "</td>";
                                                                                                                                                    echo "<input type='hidden' class='item_name' name='item_name[]'  value='" . $subData[1] . "'>";
                                                                                                                                                    echo "<td>" . $subData[5] . "</td>";
                                                                                                                                                    echo "<td>" . $subData[3] . "/" . $subData[2] . "</td>";
                                                                                                                                                    echo "<input type='hidden' class='item_qty' name='item_qty[]'  value=" . $subData[3] . ">";
                                                                                                                                                    echo "<input type='hidden' class='item_unit' name='item_unit[]'  value=" . $subData[2] . ">";
                                                                                                                                                    $value = "<input type='hidden' name='amount' id='amount'>";
                                                                                                                                                    echo $value;
                                                                                                                                                    echo "<input type='hidden' name='amount1' class='a1' id='amount1' value=" . $subData[4] . ">";
                                                                                                                                                    $usdvalue = "<input style='border:none;' type='text'  id='a2' class='convert1' name='item_rate[]'>";

                                                                                                                                                    echo "<td style='width:100px;'>" . $usdvalue . "</td>";
                                                                                                                                                    $amount = $subData[3] * $subData[4];
                                                                                                                                                    echo "<input type='hidden' name='amount4' id='amount4'  class='a4' value=" . $amount . ">";
                                                                                                                                                    echo "<td><input style='border:none;' type='text'  id='a5' class='convert' name='item_amount[]' ></td>";
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
                                                                                                                                                    echo "<input type='hidden' name = 'party_id' class='party_id' id = 'party_id' value = '" . $subData[7] . "'>";
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
                                                                                                                                                <td><input style='border:none;' type="text"  name="fob_value" id="fob2" class="fob_value"></td>
                                                                                                                                            </tr>            
                                                                                                                                            <tr  class="hideShowTr"id="cf"  style="display: none;">
                                                                                                                                                <td colspan = "3" style="text-align: right;"><b>FOB VALUE</b></td>

                                                                                                                                                <td></td>
                                                                                                                                                <td><input style='border:none;' type="text"  id="cf1"></td>
                                                                                                                                                <td><input style='border:none;' type="text" name="fob_value" id="cf2" class="fob_value"></td>
                                                                                                                                            </tr> 
                                                                                                                                            <tr  class="hideShowTr"id="cif"  style="display: none;">
                                                                                                                                                <td colspan = "3" style="text-align: right;"><b>FOB VALUE</b></td>

                                                                                                                                                <td></td>
                                                                                                                                                <td><input style='border:none;' type="text" id="cif1"></td>
                                                                                                                                                <td><input style='border:none;' type="text" name="fob_value" id="cif2" class="fob_value"></td>
                                                                                                                                            </tr> 
                                                                                                                                            <tr  class="hideShowTr"id="cf"  style="display: none;">
                                                                                                                                                <td colspan = "3" style="text-align: right;"><b>FREIGHT</b></td>

                                                                                                                                                <td></td>
                                                                                                                                                <td></td>
                                                                                                                                                <td><input type="text" id="cff1" name="cf_freight" value="0" class="cf_freight" style="border:groove;border-width: 3px;border-color: #dddada;" onchange="sum();" ></td>
                                                                                                                                            </tr>   
                                                                                                                                            <tr  class="hideShowTr"id="cif"  style="display: none;">
                                                                                                                                                <td colspan = "3" style="text-align: right;"><b>FREIGHT</b></td>

                                                                                                                                                <td></td>
                                                                                                                                                <td></td>
                                                                                                                                                <td><input type="text" id="ciff1" name="cif_freight" class="cif_freight" value="0" style="border:groove;border-width: 3px;border-color: #dddada;" onchange="sum2();"></td>
                                                                                                                                            </tr>            
                                                                                                                                            <tr  class="hideShowTr"id="cif"  style="display: none;">
                                                                                                                                                <td colspan = "3" style="text-align: right;"><b>CIF VALUE</b></td>

                                                                                                                                                <td></td>
                                                                                                                                                <td></td>
                                                                                                                                                <td><input type="text" id="cif13" name="cif_value" class="cif_value" value="0" style="border:groove;border-width: 3px;border-color: #dddada;" onchange="sum4();"></td>
                                                                                                                                            </tr>
                                                                                                                                            <tr  class="hideShowTr"id="cf"  style="display: none;">
                                                                                                                                                <td colspan = "3" style="text-align: right;"><b>C&F VALUE</b></td>

                                                                                                                                                <td></td>
                                                                                                                                                <td></td>
                                                                                                                                                <td><input type="text"id="cf11" name="cf_value" class="cf_value" value="0" style="border:groove;border-width: 3px;border-color: #dddada;" onchange="sum1();"></td>
                                                                                                                                            </tr>
                                                                                                                                            <tr  class="hideShowTr"id="cif"  style="display: none;">
                                                                                                                                                <td colspan = "3" style="text-align: right;"><b>INSURANCE</b></td>

                                                                                                                                                <td></td>
                                                                                                                                                <td></td>
                                                                                                                                                <td><input type="text" id="cif12" name="insurance" class="insurance" value="0" style="border:groove;border-width: 3px;border-color: #dddada;" onchange="sum4();"></td>
                                                                                                                                            </tr>
                                                                                                                                            <tr>
                                                                                                                                                <td colspan = "6"><b>AMT.$</b>&nbsp;&nbsp;<input style='border:none;' type="text" id="amt" style="border:groove;border-width: 3px;border-color: #dddada;" />
                                                                                                                                                    <!--<div id="word"><?php echo displaywords($amt); ?></div>-->
                                                                                                                                                    <input style='border:none;' type="hidden" name="total_amount" class="total_amount" id="amt1"><br><br><br><br></td>

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
                                                                                                                                            </table><br>
                                                                                                                                            <input type="hidden" name="action" id="action" value="add"/>
                                                                                                                                            <input type="hidden" name="id" id="id" value="<?php echo (isset($_GET['id']) ? $_GET['id'] : "") ?>">
                                                                                                                                            <!--<a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"></a>-->

                                                                                                                                            <a href="javascript:window.print()"><button type="submit" name="print" id="print" onclick="window.print()" class="btn btn-primary"><i class="fa fa-floppy-o"></i>Save & Print</button></a>
                                                                                                                                            </form>
                                                                                                                                            <!--</table>-->
                                                                                                                                            <iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>

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
                                                                                                                                                document.getElementById("datevalue").value = date;
                                                                                                                                                document.getElementById("datevalue1").value = date;
                                                                                                                                                document.getElementById("datevalue2").value = date;
                                                                                                                                            </script>
                                                                                                                                            <script>

                                                                                                                                                $("#print").click(function () {
                                                                                                                                                    //get the form values
                                                                                                                                                    var qid = $('.quo_id').val();
                                                                                                                                                    // alert(sid);
                                                                                                                                                    var pno = $('.p_invoice_no').val();
                                                                                                                                                    var invoice_date = $('.invoice_date').val();
                                                                                                                                                    var exporter_no = $('.exporter_no').val();
                                                                                                                                                    var inquiry_no = $('.inquiry_no').val();
                                                                                                                                                    var buyer_order_no = $('.buyer_order_no').val();
                                                                                                                                                    var bl_no = $('.bl_no').val();
                                                                                                                                                    var sb_no = $('.sb_no').val();
                                                                                                                                                    var bl_date = $('.bl_date').val();
                                                                                                                                                    var sb_date = $('.sb_date').val();
                                                                                                                                                    var delivery = $('.delivery').val();
                                                                                                                                                    var payment = $('.payment').val();
                                                                                                                                                    var fob_value = $('.fob_value').val();
                                                                                                                                                    var cf_freight = $('.cf_freight').val();
                                                                                                                                                    var cif_freight = $('.cif_freight').val();
                                                                                                                                                    var cf_value = $('.cf_value').val();
                                                                                                                                                    var insurance = $('.insurance').val();
                                                                                                                                                    var cif_value = $('.cif_value').val();
                                                                                                                                                    var total_amount = $('.total_amount').val();
//                                                                                                                                                    alert(total_amount);
                                                                                                                                                    var party_id = $('.party_id').val();
                                                                                                                                                    var sup_id = $('.sup_id').val();
                                                                                                                                                    var user_id = $('.user_id').val();
//                                                                                                                                                    alert(sid);
                                                                                                                                                    var id = document.getElementsByClassName("item_id");
                                                                                                                                                    var item_id = [];
                                                                                                                                                    for (var i = 0; i < id.length; i++) {
                                                                                                                                                        item_id.push(id[i].value);

                                                                                                                                                    }
                                                                                                                                                    item_id = item_id.join(",");
//                                                                                                                                                    var item_name = $('.item_name').val();
                                                                                                                                                    var item = document.getElementsByClassName("item_name");
                                                                                                                                                    var item_name = [];
                                                                                                                                                    for (var i = 0; i < item.length; i++) {
                                                                                                                                                        item_name.push(item[i].value);

                                                                                                                                                    }
                                                                                                                                                    item_name = item_name.join(",");
//                                                                                                                                                    alert(item_name);
//                                                                                                                                                    var item_qty = $('.item_qty').val();
                                                                                                                                                    var itemq = document.getElementsByClassName("item_qty");
                                                                                                                                                    var item_qty = [];
                                                                                                                                                    for (var i = 0; i < itemq.length; i++) {
                                                                                                                                                        item_qty.push(itemq[i].value);
                                                                                                                                                    }
                                                                                                                                                    item_qty = item_qty.join(",");
//                                                                                                                                                    var item_unit = $('.item_unit').val();
                                                                                                                                                    var itemu = document.getElementsByClassName("item_unit");
                                                                                                                                                    var item_unit = [];
                                                                                                                                                    for (var i = 0; i < itemu.length; i++) {
                                                                                                                                                        item_unit.push(itemu[i].value);
                                                                                                                                                    }
                                                                                                                                                    item_unit = item_unit.join(",");
//                                                                                                                                                    var item_rate = $('.convert1').val();
                                                                                                                                                    var itemr = document.getElementsByClassName("convert1");
                                                                                                                                                    var item_rate = [];
                                                                                                                                                    for (var i = 0; i < itemr.length; i++) {
                                                                                                                                                        item_rate.push(itemr[i].value);
                                                                                                                                                    }
                                                                                                                                                    item_rate = item_rate.join(",");
                                                                                                                                                    //alert(item_rate);
//                                                                                                                                                    var item_amount = $('.convert').val();
                                                                                                                                                    var itema = document.getElementsByClassName("convert");
                                                                                                                                                    var item_amount = [];
                                                                                                                                                    for (var i = 0; i < itema.length; i++) {
                                                                                                                                                        item_amount.push(itema[i].value);
                                                                                                                                                    }
                                                                                                                                                    item_amount = item_amount.join(",");
                                                                                                                                                    //make the postdata
                                                                                                                                                    var postData = 'quo_id[]=' + qid + '&p_invoice_no[]=' + pno + '&invoice_date[]=' + invoice_date + '&exporter_no[]=' + exporter_no + '&inquiry_no[]=' + inquiry_no + '&buyer_order_no[]=' + buyer_order_no + '&bl_no[]=' + bl_no + '&sb_no[]=' + sb_no + '&bl_date[]=' + bl_date + '&sb_date[]=' + sb_date + '&delivery[]=' + delivery + '&payment[]=' + payment + '&fob_value[]=' + fob_value + '&cf_freight[]=' + cf_freight + '&cif_freight[]=' + cif_freight + '&cf_value[]=' + cf_value + '&insurance[]=' + insurance + '&cif_value[]=' + cif_value + '&total_amount[]=' + total_amount + '&party_id[]=' + party_id + '&sup_id[]=' + sup_id + '&user_id=' + user_id + '&item_id[]=' + item_id + "&item_name[]=" + item_name + '&item_qty[]=' + item_qty + '&item_unit[]=' + item_unit + '&item_rate[]=' + item_rate + '&item_amount[]=' + item_amount;
                                                                                                                                                    //call your input.php script in the background, when it returns it will call the success function if the request was successful or the error one if there was an issue (like a 404, 500 or any other error status)
//                                                                                                                                                    alert(postData);
                                                                                                                                                    $.ajax({
                                                                                                                                                        type: "POST",
                                                                                                                                                        url: "customFile/addProformaInvoice.php",
                                                                                                                                                        data: postData,
                                                                                                                                                        success: function (data)
                                                                                                                                                        {
                                                                                                                                                            //alert('success');
//                                                                                                                                                            alert(data);
//                                                                                                                                                            console.log(data);
                                                                                                                                                        },
                                                                                                                                                        error: function (errorThrown) {
                                                                                                                                                            alert(errorThrown);
                                                                                                                                                            alert("There is an error with AJAX!");
                                                                                                                                                        }
                                                                                                                                                    });
                                                                                                                                                });
                                                                                                                                            </script>
                                                                                                                                            <script>
                                                                                                                                                function printDiv() {

                                                                                                                                                    var prtContent = document.getElementById('invoice');
                                                                                                                                                    var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
                                                                                                                                                    WinPrint.document.write(prtContent.innerHTML);
                                                                                                                                                    WinPrint.document.close();
                                                                                                                                                    WinPrint.focus();
                                                                                                                                                    WinPrint.print();
                                                                                                                                                    WinPrint.close();
                                                                                                                                                }
                                                                                                                                            </script>
                                                                                                                                            <script>

                                                                                                                                                $('#data').change(function () {
                                                                                                                                                    $('.hideShowTr').css('display', 'none');
                                                                                                                                                    $('tr#' + $(this).val()).css('display', '');
                                                                                                                                                });
                                                                                                                                            </script>
                                                                                                                                            <script>
                                                                                                                                                function convertVal(dval) {
                                                                                                                                                    var dval = document.getElementById("usd").value;
                                                                                                                                                    // alert(dval);
                                                                                                                                                    var a1 = document.getElementsByClassName('a1');
//                                                                                                                                                    alert(a1);
                                                                                                                                                    var total = "";
                                                                                                                                                    for (var i = 0; i < a1.length; i++) {
                                                                                                                                                        var amount1 = (a1[i].value / dval).toFixed(2);
                                                                                                                                                        //                                                                                                                                                               alert(amount1);
                                                                                                                                                        $(".convert1").each(function () {
                                                                                                                                                            var usdamount1 = $(this).val((a1[i].value / dval).toFixed(2));
                                                                                                                                                            //alert(usdamount1);
                                                                                                                                                            i++;
                                                                                                                                                        });
                                                                                                                                                    }
                                                                                                                                                    var t1 = (document.getElementById("totalrate").value / dval).toFixed(2); //                                                                                                                                                            alert(t1);
                                                                                                                                                    document.getElementById("fob1").value = t1;
                                                                                                                                                    document.getElementById("cf1").value = t1;
                                                                                                                                                    document.getElementById("cif1").value = t1;
                                                                                                                                                    var a4 = document.getElementsByClassName('a4');
//                                                                                                                                                    alert(a4);
                                                                                                                                                    for (var i = 0; i < a4.length; i++) {
                                                                                                                                                        $(".convert").each(function () {
                                                                                                                                                            var usdamount2 = $(this).val((a4[i].value / dval).toFixed(2));
//                                                                                                                                                            alert(usdamount2);
                                                                                                                                                            i++;
                                                                                                                                                        });
                                                                                                                                                    }
                                                                                                                                                    var t2 = (document.getElementById("totalamt").value / dval).toFixed(2); //                                                                                                                                                            alert(t2);
                                                                                                                                                    document.getElementById("fob2").value = t2;
                                                                                                                                                    document.getElementById("cf2").value = t2;
                                                                                                                                                    document.getElementById("cif2").value = t2;
                                                                                                                                                    document.getElementById("amt").value = t2 + "$";
                                                                                                                                                    document.getElementById("amt1").value = t2;
                                                                                                                                                }
                                                                                                                                                function sum() {
                                                                                                                                                    var cff1 = document.getElementById('cff1').value;
                                                                                                                                                    var cf2 = document.getElementById('cf2').value;
                                                                                                                                                    var totalcf = (parseFloat(cff1) + parseFloat(cf2)).toFixed(2); //                                                                                                                                                            alert(totalcf);
                                                                                                                                                    document.getElementById("amt").value = totalcf + "$";
                                                                                                                                                    document.getElementById("amt1").value = totalcf;
                                                                                                                                                }
                                                                                                                                                function sum1() {
                                                                                                                                                    var cff1 = document.getElementById('cff1').value;
                                                                                                                                                    var cf2 = document.getElementById('cf2').value;
                                                                                                                                                    var cf11 = document.getElementById('cf11').value;
                                                                                                                                                    var totalcf1 = (parseFloat(cff1) + parseFloat(cf2) + parseFloat(cf11)).toFixed(2); //                                                                                                                                                            alert(totalcf1);
                                                                                                                                                    document.getElementById("amt").value = totalcf1;
                                                                                                                                                    document.getElementById("amt1").value = totalcf1;
                                                                                                                                                }
                                                                                                                                                function sum2() {
                                                                                                                                                    var ciff1 = document.getElementById('ciff1').value;
                                                                                                                                                    var cif2 = document.getElementById('cif2').value;
                                                                                                                                                    var totalcf = (parseFloat(ciff1) + parseFloat(cif2)).toFixed(2); //                                                                                                                                                            alert(totalcf);
                                                                                                                                                    document.getElementById("amt").value = totalcf + "$";
                                                                                                                                                    document.getElementById("amt1").value = totalcf;
                                                                                                                                                }
                                                                                                                                                function sum3() {
                                                                                                                                                    var ciff1 = document.getElementById('ciff1').value;
                                                                                                                                                    var cif2 = document.getElementById('cif2').value;
                                                                                                                                                    var cif12 = document.getElementById('cif12').value;
                                                                                                                                                    var totalcf1 = (parseFloat(ciff1) + parseFloat(cif2) + parseFloat(cif12)).toFixed(2);
                                                                                                                                                    // alert(totalcf1);
                                                                                                                                                    document.getElementById("amt").value = totalcf1 + "$";
                                                                                                                                                    document.getElementById("amt1").value = totalcf1;
                                                                                                                                                }
                                                                                                                                                function sum4() {
                                                                                                                                                    var ciff1 = document.getElementById('ciff1').value;
                                                                                                                                                    //alert(ciff1);
                                                                                                                                                    var cif2 = document.getElementById('cif2').value;
                                                                                                                                                    // alert(cif2);
                                                                                                                                                    var cif12 = document.getElementById('cif12').value;
                                                                                                                                                    //alert(cif12);
                                                                                                                                                    var cif13 = document.getElementById('cif13').value;
                                                                                                                                                    // alert(cif13);
                                                                                                                                                    var totalcf1 = (parseFloat(ciff1) + parseFloat(cif2) + parseFloat(cif12) + parseFloat(cif13)).toFixed(2);
                                                                                                                                                    //alert(totalcf1);
                                                                                                                                                    document.getElementById("amt").value = totalcf1 + "$";
                                                                                                                                                    document.getElementById("amt1").value = totalcf1;
                                                                                                                                                }
                                                                                                                                            </script>
                                                                                                                                            </body>

                                                                                                                                            </html>


