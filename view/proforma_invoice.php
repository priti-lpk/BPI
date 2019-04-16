<?php
include_once '../shreeLib/Controls.php';
include_once '../shreeLib/DBAdapter.php';
include_once '../shreeLib/dbconn.php';

if (isset($_GET['s_id'])) {
    $edba = new DBAdapter();
    $quotation_id = $_GET['s_id'];
    // echo $quotation_id;
    $query1 = "select link_master.quotation_id,add_quotation.inquiry_id ,send_party.quo_id from send_party INNER JOIN add_quotation ON send_party.quo_id=add_quotation.id inner join link_master on add_quotation.id=link_master.send_party_id where q_id='$quotation_id'";
     //print_r($query1);
    $sql2 = mysqli_query($con, $query1);
    while ($row = mysqli_fetch_array($sql2)) {
        $id = $row['quotation_id'];
        $i_id = $row['inquiry_id'];
        $q_id = $row['quo_id'];
    }
}
if (isset($_GET['s_id'])) {
    $edba = new DBAdapter();
    $edata = $edba->getRow("send_party INNER JOIN link_master ON send_party.id=link_master.send_party_id", array("*"), "s_id='" . $_GET['s_id'] . "'");
    echo "<input type='hidden' id='send_party_id' value='" . $_GET['s_id'] . "'>";
}
?>
<!DOCTYPE html>
<html lang="en" class="no-js">

    <head>
        <title>
            <?php
            if (isset($_GET['type'])) {
                echo 'Edit Add Quotation';
            } else {
                echo 'Add New Quotation';
            }
            ?>
        </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="Moltera Ceramic Pvt.Ltd">
        <meta name="author" content="LPK Technosoft">	
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
        <style type="text/css">
            @media print and (max-height: 280mm) {
                @page {
                    margin: 2.0cm; 
                    /*size: 139mm 215mm;*/
                    /*height: 215mm;*/
                    /*width: 169mm;*/
                    /*margin: -10cm;*/
                }
                html {
                    /*width: 139mm;*/
                    /*height: 215mm;*/
                    margin: 0;
                }
                div.row > div {
                    /*display: inline-block;*/  
                    /*margin: 0.2cm;*/
                }

                #approved {
                    display: none;
                }
                #print{
                    display: none;
                }
                #reject{
                    display: none;
                }


            }
        </style>
    </head>

    <body class="text-editor">
        <!-- WRAPPER -->
        <div class="wrapper">				
            <!-- BOTTOM: LEFT NAV AND RIGHT MAIN CONTENT -->

            <div class="bottom">
                <div class="container">
                    <div class="row col-md-10">

                        <div class="col-md-10">
                            <button type="submit" name="print" id="print" class="btn btn-primary" onclick="window.print()"><i class="fa fa-print"> Print</i></button>

                            <table border="3" width="1000px;" id="view_data">                                                            
                                <tr>
                                    <td rowspan="3" colspan="3" ><u><b>EXPORTER:</b></u><br><u><b>BLUE PEARL INTERNATIONAL</b></u><br>
                                        OPP. BHAKTI PARK, B/H. CHANAKYA ACADEMY,<br>
                                        MUNDRA ROAD, BHUJ - KUTCH ( INDIA ) 370 001.<br>
                                        TEL :- +91 - 2832 - 235056<br>
                                        FAX :- +91 - 2832 - 235055<br>
                                        E-MAIL :- bpi01@yahoo.co.uk<br>
                                        IE CODE :- 2095000382 DT :- 20/10/1995
                                    </td><input type="hidden" name="quo_id" value="<?php echo $edata[0][1]; ?>">
                                <td><b>P. INVOICE NO.:</b>&nbsp;<input type="text" name="p_invoice_no" style="border: none;width: 100px" value="<?php echo $edata[0][2]; ?>"><br></td>
                                <td><b>DATE:</b>&nbsp;<input  name="invoice_date" style="border:none;width: 130px" value="<?php
                                    $date1 = $edata[0][3];
                                    $dates1 = date("d-m-Y", strtotime($date1));
                                    echo $dates1;
                                    ?>"><br></td>
                                <td><b>EXPORTER'S NO.:</b><input type="text" name="exporter_no"  style="border: none;width: 100px" value="<?php echo $edata[0][4]; ?>"><br></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><b>INQUIRY NO & DATE:&nbsp;<input type="text" name="inquiry_no" value="<?php echo $edata[0][5]; ?>"style="border: none;"><BR>BUYER'S ORDER NO & DATE:-</b>&nbsp;
                                        <input type="text" name="buyer_order_no" style="border: none;width: 100px" value="<?php echo $edata[0][6]; ?>"></td>
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
                                                <td colspan="2"><b>B/L NO.:-</b>&nbsp;&nbsp;<input type="text" name="bl_no"style="border: none;"value="<?php echo $edata[0][7]; ?>"><br><b>S.B No.:-</b>&nbsp;&nbsp;<input type="text" name="sb_no" style="border: none;width: 200px" value="<?php echo $edata[0][7]; ?>"></td>
                                                <td><b>DATE:-&nbsp;</b><input  name="bl_date"style="border:none;width: 100px" value="<?php
                                                    $date1 = $edata[0][9];
                                                    $dates1 = date("d-m-Y", strtotime($date1));
                                                    echo $dates1;
                                                    ?>"><br><b>DATE:-</b>&nbsp;<input name="sb_date" style="border:none;width: 100px" value="<?php
                                                                               $date1 = $edata[0][10];
                                                                               $dates1 = date("d-m-Y", strtotime($date1));
                                                                               echo $dates1;
                                                                               ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td><b><center>VESSEL/FLIGHT No.<center></b><br></td>
                                                                    <td colspan="2"><b><center>PORT OF LOADING<center></b><br></td>
                                                                                    <td colspan="3" rowspan="2"><b><center>TERMS OF DELIVERY AND PAYMENTS:</center><br>DELIVERY:-&nbsp;&nbsp;<input type="text" name="delivery" style="border: none;width: 200px" value="<?php echo $edata[0][11]; ?>"><br>PAYMENT:-&nbsp;&nbsp;&nbsp;<input type="text" name="payment" style="border: none;width: 200px" value="<?php echo $edata[0][12]; ?>"></b><br><br></td>
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

                                                                                                                        $id = $_GET['s_id'];
                                                                                                                        $last_id = $dba->getLastID("branch_id", "create_user", "1");
                                                                                                                        $field = array("send_party.*,send_party_item_list.*,create_item.*");
                                                                                                                        $data = $dba->getRow("`send_party` INNER JOIN send_party_item_list ON send_party.id=send_party_item_list.send_party_id INNER JOIN link_master ON send_party.id=link_master.send_party_id inner join create_item on send_party_item_list.item_id=create_item.id", $field, "link_master.s_id='" . $id . "'");
                                                                                                                        $count = count($data);
                                                                                                                        $i = 1;
                                                                                                                        $totalrate = 0;
                                                                                                                        $totalamt = 0;
                                                                                                                        if ($count >= 1) {
                                                                                                                            foreach ($data as $subData) {

                                                                                                                                echo "<tr>";
                                                                                                                                echo "<td>" . $i++ . "</td>";
                                                                                                                                echo "<input type='hidden' name='s_id' id='s_id' value=" . $subData[0] . ">";
                                                                                                                                echo "<input name = 'status' id = 'status1' type = 'hidden' value = 'Approved'>";
                                                                                                                                echo "<input name = 'note1' id = 'note1' type = 'hidden' value = ''>";
                                                                                                                                echo "<input type='hidden' name='item_id[]'  value=" . $subData[6] . ">";
                                                                                                                                echo "<td>" . $subData[24] . "</td>";
                                                                                                                                echo "<input type='hidden' name='item_name[]'  value=" . $subData[1] . ">";
                                                                                                                                echo "<td>" . $subData[35] . "</td>";
                                                                                                                                echo "<td>" . $subData[25] . "/" . $subData[26] . "</td>";
                                                                                                                                echo "<input type='hidden' name='item_qty[]'  value=" . $subData[3] . ">";
                                                                                                                                echo "<input type='hidden' name='item_unit[]'  value=" . $subData[2] . ">";
                                                                                                                                $value = "<input type='hidden' name='amount' id='amount'>";
                                                                                                                                echo $value;
                                                                                                                                echo "<input type='hidden' name='amount1' class='a1' id='amount1' value=" . $subData[4] . ">";
                                                                                                                                $usdvalue = "<input style='border:none;' type='text' id='a2' class='convert1' name='item_rate[]' value=" . $subData[27] . "$>";

                                                                                                                                echo "<td>" . $usdvalue . "</td>";
                                                                                                                                $amount = $subData[3] * $subData[4];
                                                                                                                                echo "<input type='hidden' name='amount4' id='amount4'  class='a4' value=" . $amount . ">";
                                                                                                                                echo "<td><input style='border:none;' type='text' id='a5' class='convert' name='item_amount[]' value=" . $subData[28] . "$></td>";
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
                                                                                                                                echo "</tr>";
                                                                                                                            }
                                                                                                                            $total_amount = "<input style='border:none;' type='hidden' name='total_amount' id='amt1'>";
                                                                                                                            echo $total_amount;
                                                                                                                            echo "<input type='hidden'  id='totalrate' value=" . $totalrate . ">";
                                                                                                                            echo "<input type='hidden'  id='totalamt' value=" . $totalamt . ">";
//                                                                                                                                                            $convert = $words->codetoword(round($total_amount));
//                                                                                                                                                            echo $convert;
//                                                                                                                                                            echo "<input type='text' value=" . $convert . ">";
                                                                                                                        }
                                                                                                                        ?>
                                                                                                                        <tr>
                                                                                                                            <td colspan = "3"><center>(Quantity 10% Plus Or Minus is Allowed)</center></td>
                                                                                                                        <td></td>
                                                                                                                        <td></td>
                                                                                                                        <td></td>
                                                                                                                        </tr>
                                                                                                                        <tr class="hideShowTr"id="fob"  >
                                                                                                                            <td colspan = "3" style="text-align: right;"><b>FOB VALUE</b></td>

                                                                                                                            <td></td>
                                                                                                                            <td><input style='border:none;' type="text" id="fob1"></td>
                                                                                                                            <td><input style='border:none;' type="text" name="fob_value" id="fob2" value="<?php echo $edata[0][13]; ?>"></td>
                                                                                                                        </tr>            
                                                                                                                        <tr  class="hideShowTr"id="cf"  style="display: none;">
                                                                                                                            <td colspan = "3" style="text-align: right;"><b>FOB VALUE</b></td>

                                                                                                                            <td></td>
                                                                                                                            <td><input style='border:none;' type="text"  id="cf1"></td>
                                                                                                                            <td><input style='border:none;' type="text" name="fob_value" id="cf2" value="<?php echo $edata[0][13]; ?>"></td>
                                                                                                                        </tr> 
                                                                                                                        <tr  class="hideShowTr"id="cif"  style="display: none;">
                                                                                                                            <td colspan = "3" style="text-align: right;"><b>FOB VALUE</b></td>

                                                                                                                            <td></td>
                                                                                                                            <td><input style='border:none;' type="text" id="cif1"></td>
                                                                                                                            <td><input style='border:none;' type="text" name="fob_value" id="cif2" value="<?php echo $edata[0][13]; ?>"></td>
                                                                                                                        </tr> 
                                                                                                                        <tr  class="hideShowTr"id="cf" >
                                                                                                                            <td colspan = "3" style="text-align: right;"><b>C&F FREIGHT</b></td>

                                                                                                                            <td></td>
                                                                                                                            <td></td>
                                                                                                                            <td><input type="text" id="cff1" name="cf_freight"  style="border:none;border-width: 3px;border-color: #dddada;" onchange="sum();" value="<?php echo $edata[0][14]; ?>" ></td>
                                                                                                                        </tr>   
                                                                                                                        <tr  class="hideShowTr"id="cif"  >
                                                                                                                            <td colspan = "3" style="text-align: right;"><b>CIF FREIGHT</b></td>

                                                                                                                            <td></td>
                                                                                                                            <td></td>
                                                                                                                            <td><input type="text" id="ciff1" name="cif_freight" style="border:none;border-width: 3px;border-color: #dddada;" onchange="sum2();" value="<?php echo $edata[0][15]; ?>"></td>
                                                                                                                        </tr>            

                                                                                                                        <tr  class="hideShowTr"id="cif"  >
                                                                                                                            <td colspan = "3" style="text-align: right;"><b>CIF VALUE</b></td>

                                                                                                                            <td></td>
                                                                                                                            <td></td>
                                                                                                                            <td><input type="text" id="cif13" name="cif_value"  style="border:none;border-width: 3px;border-color: #dddada;" onchange="sum4();" value="<?php echo $edata[0][16]; ?>"></td>
                                                                                                                        </tr>


                                                                                                                        <tr  class="hideShowTr"id="cf"  >
                                                                                                                            <td colspan = "3" style="text-align: right;"><b>C&F VALUE</b></td>

                                                                                                                            <td></td>
                                                                                                                            <td></td>
                                                                                                                            <td><input type="text"id="cf11" name="cf_value"style="border:none;border-width: 3px;border-color: #dddada;" onchange="sum1();" value="<?php echo $edata[0][18]; ?>"></td>
                                                                                                                        </tr>
                                                                                                                        <tr  class="hideShowTr"id="cif" >
                                                                                                                            <td colspan = "3" style="text-align: right;"><b>INSURANCE</b></td>

                                                                                                                            <td></td>
                                                                                                                            <td></td>
                                                                                                                            <td><input type="text" id="cif12" name="insurance" style="border:none;border-width: 3px;border-color: #dddada;" onchange="sum3();" value="<?php echo $edata[0][17]; ?>"></td>
                                                                                                                        </tr>
                                                                                                                        <tr>
                                                                                                                            <?php

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
                                                                                                                            <td colspan = "6"><b>AMT.$</b>&nbsp;&nbsp;<input style='border:none;' type="text" id="amt" style="border:groove;border-width: 3px;border-color: #dddada;" value="<?php echo $edata[0][19]; ?>$"><br>(<?php echo displaywords($edata[0][19]) ?>)
                                                                                                                                <input style='border:none;' type="hidden" name="total_amount" id="amt1" value="">

                                                                                                                                <br><br></td>
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
                                                                                                                        <button type = "submit" class = "btn btn-primary waves-effect waves-light" id = "approved" value = "Approved" onclick="myFunction1();">Approved</button>
                                                                                                                        <button value = "Destroy" id="reject" class = 'btn btn-primary waves-effect waves-light' data-id = 1  data-toggle = 'modal' data-target = '#addnote' onclick = 'myFunction();'>Reject</button><br><br><br>

                                                                                                                        <!-- /main -->

                                                                                                                        <!--</div>-->

                                                                                                                        </div>
                                                                                                                        <!-- /main-content -->
                                                                                                                        </div>
                                                                                                                        <!-- /main -->
                                                                                                                        </div>
                                                                                                                        <!-- /content-wrapper -->
                                                                                                                        </div>
                                                                                                                        <!-- /row -->
                                                                                                                        </div>
                                                                                                                        <!-- /container -->
                                                                                                                        </div>
                                                                                                                        <!--<div class="col-sm-6 col-md-3 m-t-30">-->


                                                                                                                            <div class="modal fade" id="addnote" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                                                                                                <div class="modal-dialog modal-dialog-centered">
                                                                                                                                    <div class="modal-content">
                                                                                                                                        <div class="modal-header">
                                                                                                                                            <h5 class="modal-title mt-0">Add Note</h5>
                                                                                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                                                                        </div>
                                                                                                                                        <div class="modal-body">
                                                                                                                                            <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                                                                                                                                                <div class="form-group row">
                                                                                                                                                    <input name="id" id="id" type="hidden">
                                                                                                                                                    <input name="status" id="status" type="hidden">
                                                                                                                                                    <label for="example-text-input" class="col-sm-3 col-form-label">Note</label>
                                                                                                                                                    <div class="col-sm-4">                                        
                                                                                                                                                        <input class="form-control" type="text"  placeholder="Note" name="note" id="note" required="">
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            </form>
                                                                                                                                        </div>
                                                                                                                                        <div class="modal-footer">
                                                                                                                                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                                                                                                                            <button type="button" class="btn btn-primary waves-effect waves-light" id="sa-success" onclick = "addNote();">Save changes</button>
                                                                                                                                        </div>
                                                                                                                                    </div><!-- /.modal-content -->
                                                                                                                                </div><!-- /.modal-dialog -->
                                                                                                                            </div><!-- /.modal -->
                                                                                                                        <!--</div>-->
                                                                                                                        <!-- END BOTTOM: LEFT NAV AND RIGHT MAIN CONTENT -->

                                                                                                                        <!-- /wrapper -->
                                                                                                                        <!-- FOOTER -->
                                                                                                                        <!--    <footer class="footer">
                                                                                                                                <b>Develop By : </b><a href="http://lpktechnosoft.com" target="_blank"> LPK Technosoft</a>
                                                                                                                            </footer>  -->

                                                                                                                        <!-- END FOOTER -->
                                                                                                                        <!-- Javascript -->


                                                                                                                        <script src="../customFile/newNote.js"></script>
                                                                                                                        <script src="../assets/js/jquery.min.js"></script>
                                                                                                                        <script src="../assets/js/bootstrap.bundle.min.js"></script>
                                                                                                                        <script src="../assets/js/metisMenu.min.js"></script>
                                                                                                                        <script src="../assets/js/jquery.slimscroll.js"></script>
                                                                                                                        <script src="../assets/js/waves.min.js"></script>

                                                                                                                        <script src="../plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
                                                                                                                        <script src="../plugins/bootstrap-md-datetimepicker/js/moment-with-locales.min.js"></script>
                                                                                                                        <script src="../plugins/bootstrap-md-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

                                                                                                                        <!-- Plugins js -->
                                                                                                                        <script src="../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>

                                                                                                                        <script src="../plugins/select2/js/select2.min.js"></script>
                                                                                                                        <script src="../plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
                                                                                                                        <script src="../plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js"></script>
                                                                                                                        <script src="../plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js"></script>
                                                                                                                        <!-- Required datatable js -->
                                                                                                                        <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
                                                                                                                        <script src="../plugins/datatables/dataTables.bootstrap4.min.js"></script>
                                                                                                                        <!-- Buttons examples -->
                                                                                                                        <script src="../plugins/datatables/dataTables.buttons.min.js"></script>
                                                                                                                        <script src="../plugins/datatables/buttons.bootstrap4.min.js"></script>
                                                                                                                        <script src="../plugins/datatables/jszip.min.js"></script>
                                                                                                                        <script src="../plugins/datatables/pdfmake.min.js"></script>
                                                                                                                        <script src="../plugins/datatables/vfs_fonts.js"></script>
                                                                                                                        <script src="../plugins/datatables/buttons.html5.min.js"></script>
                                                                                                                        <script src="../plugins/datatables/buttons.print.min.js"></script>
                                                                                                                        <script src="../plugins/datatables/buttons.colVis.min.js"></script>
                                                                                                                        <!-- Responsive examples -->
                                                                                                                        <script src="../plugins/datatables/dataTables.responsive.min.js"></script>
                                                                                                                        <script src="../plugins/datatables/responsive.bootstrap4.min.js"></script>
                                                                                                                        <script src="../plugins/sweet-alert2/sweetalert2.min.js"></script>
                                                                                                                        <script src="../assets/pages/sweet-alert.init.js"></script>
                                                                                                                        <!-- Datatable init js -->
                                                                                                                        <script src="../assets/pages/datatables.init.js"></script>

                                                                                                                        <script src="../assets/pages/form-advanced.js"></script>

                                                                                                                        <!-- App js -->
                                                                                                                        <script src="../assets/js/app.js"></script>
                                                                                                                        <script type="text/javascript">
                                                                                                                                                $(document).ready(function () {

                                                                                                                                                    $('#addnote').on('show.bs.modal', function (e) {
                                                                                                                                                        var i_Id = document.getElementById("s_id").value;
                                                                                                                                                    //alert(i_Id);
                                                                                                                                                        $(e.currentTarget).find('input[name="id"]').val(i_Id);
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
