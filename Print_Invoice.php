<?php
ob_start();
include_once 'shreeLib/DBAdapter.php';
include_once 'shreeLib/dbconn.php';
include_once './numtoword.php';
$words = new numtoword();
if (isset($_GET['id'])) {
    $pid = $_GET['id'];
    $edba = new DBAdapter();
    $field = array("sales_list.id,party_list.party_name,sales_list.s_invoice_no,sales_list.sale_date,sales_list.total_amount,sales_list.pay_type,sales_list.note,party_list.party_address,party_list.party_gstno,sales_list.vehicle_no,sales_list.lr_no");
    $edata = $edba->getRow("sales_list INNER JOIN party_list ON sales_list.party_id=party_list.id", $field, "sales_list.id=" . $_GET['id']);
    echo "<input type='hidden' id='id' value='" . $_GET['id'] . "'>";
}
?>
<!DOCTYPE html>
<html lang="en" class="no-js">

    <head>
        <title>
            Print Invoice
        </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="Moltera Ceramic Pvt.Ltd">
        <meta name="author" content="LPK Technosoft">
        <style>
            body {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
                background-color: #FAFAFA;
                font: 12pt "Tahoma";
            }
            * {
                box-sizing: border-box;
                -moz-box-sizing: border-box;
            }
            .page {
                width: 200mm;
                min-height: 115mm;
                padding: 20mm;
                margin: 5.08mm auto;
                border: 1px #D3D3D3 solid;
                border-radius: 5px;
                background: white;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            }

            @page {
                size: A4;
                margin: 0;
            }
            @media print {
                html, body {
                    width: 210mm;
                    height: 297mm;        
                }
                .page {
                    margin: 0;
                    border: initial;
                    border-radius: initial;
                    width: initial;
                    min-height: initial;
                    box-shadow: initial;
                    background: initial;
                    page-break-after: always;
                }
                .tr td text-center namecon{
                    align-content: center;
                }
            }
            tr , td{
                font-size: 11px;
                border-bottom: 1px solid #ddd;
            }
         
            #print{
                width: 100px;
                height: 40px;
                margin-left: 630px;
                background-color: #000000;
                color: #FAFAFA;
            }
            #partyprint{
                width:200px;
            }
            #invoice{
                width: 1800px;
                margin-top: 10px;
            }
            .text-center namecon{
                
            }
        </style>

    </head>

    <body class="text-editor">

        <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <div class="contain">
            <form method="GET" class="form-horizontal">
                <div class="form-group" id="invoice">
                    <label for="ticket-name" class="col-sm-3 control-label" id="lblpartydue" >Sales Order No.</label>
                    <div class="col-sm-9" id="partyprint">
                        <input type="text" value="<?php echo isset($_GET['id']) ? $edata[0][0] : ''; ?>" name="id" id="iid" class="form-control" placeholder="Invoice No." required>
                    </div>
                    <button type="submit" class='btn btn-primary' id="btn_go">Go</button>

                </div>
            </form>
            <div class="page" id="page">

                <table class="table_invoice"  border="1" id="tid" >
                    <thead>
                        <tr>
                            <td colspan="8" class="noBorder">   
                               
                                GST No :<strong>24AALCM4324R1ZZ</strong>
                            </td>

                        </tr>
                        <tr>

                            <td class="text-center namecon" colspan="8" style="font-size: 30px;"><strong>Moltera Ceramic pvt. Ltd.</strong></td>

                        </tr>
                        <tr>

                            <td class="text-center" colspan="8" style="font-size: 20px;"><strong>Invoice</strong></td>

                        </tr>
                        <tr>
                            <td rowspan="3" colspan="5">
                                <strong><u>Details Of Receiver(Billed to):</u></strong><br>
                                <?php echo (isset($_GET['id']) ? $edata[0][1] : '') ?><br>
                                <?php echo (isset($_GET['id']) ? $edata[0][7] : '') ?>
                            </td>

                            <td class="text-right"  colspan="3" >
                                <strong>Original for recipient:</strong><br>
                            </td>

                        </tr>
                        <tr>
                            <td class="text-left" colspan="3">
                                Invoice No :<strong><?php echo (isset($_GET['id']) ? $edata[0][0] : '') ?></strong><br>
                                Invoice Date :<strong><?php echo (isset($_GET['id']) ? $edata[0][3] : '') ?></strong></td>
                        </tr>
                        <tr>
<!--                            <td class="text-left"  colspan="3">Sale Type :<strong>Within Sate</strong><br>
                                Memo Type :<strong>Debit</strong></td>-->
                        </tr>

                        <tr>
                            <td rowspan="2" colspan="5"><u><b>Deatils Of Consignee (Shipped to):</b></u><br>
                                <?php echo (isset($_GET['id']) ? $edata[0][1] : '') ?><br>
                                <?php echo (isset($_GET['id']) ? $edata[0][7] : '') ?> 
                                State Code:<b>24</b><br>
                                GST No. :<b><?php echo (isset($_GET['id']) ? $edata[0][8] : '') ?></b>
                                PAN:<b>ALBPP4918N</b>
                            </td>
                            <td class="text-left" colspan="3">Transporter: *SELF<br><br>
                                L.R. No.:<b><?php echo (isset($_GET['id']) ? $edata[0][10] : '') ?></b><br>
                                Vehicle No.: <b><?php echo (isset($_GET['id']) ? $edata[0][9] : '') ?></b>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="8">Place Of Supply : Gujrat</td>
                        </tr>
                        <tr>

                            <td style="width:40px;" class="text-center"><strong>Sr No.</strong></td>
                            <td style="width:200px;" class="text-center"><strong>Item</strong></td>
                            <td style="width:50px;" class="text-center"><strong>Unit</strong></td>
                            <td style="width:50px;" class="text-center"><strong>Qty.</strong></td>
                            <td style="width:50px;" class="text-center"><strong>Rate</strong></td>
                            <td style="width:70px;" class="text-center"><strong>Sub Total</strong></td>
                            <td style="width:40px;" class="text-center"><strong>GST</strong></td>
                            <td style="width:90px;" class="text-center"><strong>Total Amount</strong></td>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'shreeLib/dbconn.php';
                        $sql = "SELECT sales_item_list.id,sales_item_list.sl_id,item_list.item_code,item_list.item_name,unit_list.unit_name,sales_item_list.item_qnty,sales_item_list.item_rate,sales_item_list.sub_total,sales_item_list.gst,sales_item_list.total FROM item_list INNER JOIN sales_item_list ON sales_item_list.item_id = item_list.id INNER JOIN unit_list ON item_list.item_unit_id= unit_list.id WHERE sales_item_list.sl_id=" . $edata[0][0];
                        $result = mysqli_query($con, $sql);
                        $rowcount = mysqli_num_rows($result);
                        $totalgst = 0;
                        $subtotal = 0;
                        $k = 1;
                        while ($row = mysqli_fetch_array($result)) {
                            ?>
                            <tr style="height:10px; font-size: 10px;">
                                <td class="text-center"><?= $k ?></td>
                                <td class="text-left"><?= $row['item_name'] ?></td>
                                <td class="text-center"><?= $row['unit_name'] ?></td>
                                <td class="text-center"><?= $row['item_qnty'] ?></td>
                                <td class="text-center"><?= $row['item_rate'] ?></td>
                                <td class="text-center"><?= $row['sub_total'] ?></td>
                                <td class="text-center"><?= $row['gst'] ?></td>
                                <td class="text-center"><?= $row['total'] ?></td>
                            </tr>
                            <?php
                            $k++;
                            $totalgst = ($totalgst + $row['gst']);
                            $subtotal = ($subtotal + $row['sub_total']);
                        } for ($i = $rowcount; $i < 7; $i++) {
                            ?>
                            <tr style="height:10px; font-size: 10px;">
                                <td class="text-center">&nbsp;</td>
                                <td class="text-left"> </td>
                                <td class="text-center"> </td>
                                <td class="text-center"> </td>
                                <td class="text-center"> </td>
                                <td class="text-center"> </td>
                                <td class="text-center"> </td>
                                <td class="text-center"> </td>
                            </tr>
                        <?php } ?>


                        <tr><td colspan="2"><b>Tax Payable on reverse charge basis.: NO </b></td>
                            <td></td>
                            <td></td>
                            <td class="text-center">Total:</td>
                            <td class="text-center"><b><?php echo $subtotal; ?></b></td>
                            <td></td>
                            <td class="text-center"><b><?php echo (isset($_GET['id']) ? $edata[0][4] : '') ?></b</td></tr>
                        <tr><td colspan="5">
                                <b> E Way Bill No. :</b></td>
                        </tr><td></td>
                    <tr>
                        <td colspan="5" rowspan="4" class="text-top"><b>Remarks :</b><br><?php echo (isset($_GET['id']) ? $edata[0][7] : '') ?></td></tr>
                    <tr></tr>
                    <tr>
                        <td colspan="5" >
                            Central GST :&nbsp;<?php echo ($totalgst / 2); ?> <br>State GST : &nbsp;<?php echo ($totalgst / 2); ?><br>
                            Integrated GST : 0
                        </td></tr>
                    <tr></tr>
                    <tr><td colspan="5" rowspan="2"><u><b>Total Invoice Amount In Words:</b></u><br>
                            <?php $words->codetoword(round($edata[0][4], 0)) ?></td></tr>
                    <tr><td colspan="5" ><strong>Total Amount : <?php echo (isset($_GET['id']) ? $edata[0][4] : '') ?></strong></td></tr>

                    <tr><td colspan="5" rowspan="3" ><u><b>Our Bank account Details:</b></u><br>
                            Bank Name:ICICI Bank, IFSC Code :- ICIC0000086
                            A/C No. 777705161015
                        </td></tr>
                    <tr><td colspan="5">Round Off : <?php echo (isset($_GET['id']) ? round(round($edata[0][4], 0) - $edata[0][4], 2) : '') ?></td></tr>
                    <tr><td colspan="5"><strong>Total Invoice Amount : <?php echo (isset($_GET['id']) ? round($edata[0][4], 0) : '') ?></strong></td></tr>
                    <tr>
                        <td colspan="5" rowspan="2" ><strong>Terms & Conditions: </strong><b>(1)</b>Goods once supplied would not be exchange or taken back. <b>(2)</b> Our responsibility cases on delivery from factory. <b>(3)</b> 24% annual interest will be charged. If payment is not done as per payment conditions.(4)Subject To BHUJ Juridiction.</td>
                    </tr>
                    <tr>
                        <td colspan="5" >Certified that the details given above are true and correct.<br>For, <strong>Moltera Ceramic pvt. Ltd.</strong>
                            <br>
                            <br>
                            <br>
                            <strong>Autorised Signature</strong></td>
                    </tr>
                    <tr>
                        <td colspan="8" >The goods covered and dispatched to you, as you are the purchase of the goods. 
                            You are hereby warned that you do not sale. covered goods to your subsequent dealers or 
                            ultimate consumer.by over and above of MAXIMUM RETAIL SALES PRICE. affired on packages 
                            which shown & covered under invoice. Thereafter.you are responsible for any breach of 
                            law or discrepancies detected by any Govt. agencies.</td>
                    </tr>
                    </tbody>
                </table>


            </div>
            <button id="print" onclick="javascript:printlayer('page')">Print</button>
            <!-- /wrapper -->
        </div>
        <footer class="footer">
            2018 © <a href="http://lpktechnosoft.com" target="_blank">LPK Technosoft</a>
        </footer> 
        <script src="view-source:http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
        <script type="text/javascript">
                function printlayer(layer)
                {
                    var generator = window.open("");
                    var layetext = document.getElementById(layer);
                    generator.document.write(layetext.innerHTML.replace("print Me"));
                    generator.document.close();
                    generator.print();
                    generator.close();
                }
        </script>
        <script type="text/javascript">
//            var txt = $("#iid").val();
//            if (txt == '') {
//               // $("#tid").is(":empty");
//                $("#tid").val("");
//            }
        </script>
    </body>
</html>

