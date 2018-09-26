<?php
ob_start();
include_once 'shreeLib/DBAdapter.php';
include_once 'shreeLib/dbconn.php';
include './shreeLib/session_info.php';
if (isset($_GET['type']) && isset($_GET['id'])) {
    $sid = $_GET['id'];
    $edba = new DBAdapter();
    $field = array("sales_list.id,party_list.party_name,sales_list.s_invoice_no,sales_list.sale_date,sales_list.total_amount,sales_list.pay_type,sales_list.note,sales_list.vehicle_no,sales_list.lr_no,sales_list.pay_tax");
    $edata = $edba->getRow("sales_list INNER JOIN party_list ON sales_list.party_id=party_list.id", $field, "sales_list.id=" . $_GET['id']);
    echo "<input type='hidden' id='id' value='" . $_GET['id'] . "'>";

    $field1 = array("count(sl_id)");
    $countrow = $edba->getRow("sales_item_list", $field1, "sl_id=" . $_GET['id']);
    echo "<input type='hidden' id='rowcount' value='" . $countrow[0][0] . "'>";
}
if (isset($_GET['order_id'])) {
    $id = $_GET['order_id'];
    $order_data = new DBAdapter();
    $field = array("sales_order_list.id,party_list.party_name, sales_order_list.sale_date,sales_order_list.total_amount,sales_order_list.pay_tax,sales_order_list.note");
    $orderdata = $order_data->getRow("sales_order_list INNER JOIN party_list ON sales_order_list.party_id = party_list.id", $field, "sales_order_list.id=" . $id);

    $edba = new DBAdapter();
    $field1 = array("count(srl_id)");
    $countrow_order = $edba->getRow("sales_order_item_list", $field1, "srl_id=" . $_GET['order_id']);
    echo "<input type='hidden' id='rowcount' value='" . $countrow_order[0][0] . "'>";
}
if (isset($_SESSION['user_id'])) {
    $edba = new DBAdapter();
    $servername1 = basename($_SERVER['PHP_SELF']);
    //echo $servername1;
    $field = array("role_rights.id");
    $mod_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " module.mod_pagename='" . $servername1 . "' and role_rights.user_id=" . $_SESSION['user_id']);
    echo "<input type='hidden' id='user_id' value='" . $mod_data[0][0] . "'>";


    $field = array("role_rights.id,role_rights.role_edit,role_rights.role_delete,role_rights.role_create");
    $role_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " role_rights.id=" . $mod_data[0][0]);
    echo "<input type='hidden' id='user_id' value='" . $role_data[0][3] . "'>";
}
?>
<!DOCTYPE html>
<html lang="en" class="no-js">

    <head>
        <title>
            <?php
            if (isset($_GET['id'])) {
                echo 'Edit Sales List';
            } else {
                echo 'Add New Sales List';
            }
            ?>
        </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <meta name="description" content="Moltera Ceramic Pvt.Ltd">
        <meta name="author" content="LPK Technosoft">
        <style>
            @font-face{font-family: Lobster;src: url('Lobster.otf');}
            h1{font-family: Lobster;text-align:center;}
            table{border-collapse:collapse;border-radius:25px;width:500px;}
            table, td, th{border:1px solid #00BB64;}
            tr,input{height:30px;border:1px solid #fff;}
            /*	input{text-align:center;}*/
            input:focus{border:1px solid yellow;} 
            .space{margin-bottom: 2px;}
            .itemcode{width:70px;}
            .itemname{width:300px;}
            .unit1{width:80px;}
            .qnty1{width:80px;}
            .rate1{width:80px;}
            .subtotal{width:120px;}
            .gst1{width:80px;}
            .total1{width:120px;}
            .snum{width: 20px;}
            #container{margin-left:180px;}
            .but{width:270px;background:#00BB64;border:1px solid #00BB64;height:40px;border-radius:3px;color:white;margin-top:10px;margin:0px 0px 0px 290px;}
        </style>
    </head>

    <body class="text-editor">
        <!-- WRAPPER -->
        <div class="wrapper">				
            <!-- BOTTOM: LEFT NAV AND RIGHT MAIN CONTENT -->
            <?php include 'topbar.php'; ?>
            <div class="bottom">
                <div class="container">
                    <div class="row">
                        <!-- left sidebar -->
                        <?php include 'sidebar.php'; ?>
                        <!-- end left sidebar -->
                        <!-- content-wrapper -->
                        <div class="col-md-10 content-wrapper">
                            <div class="row">
                                <div class="col-lg-4 ">
                                    <ul class="breadcrumb">
                                        <li><i class="fa fa-home"></i><a href="start">Home</a></li>
                                        <li class="active">Add Sales</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- main -->
                            <div class="content">
                                <div class="main-header">
                                    <h2>Sales List</h2>
                                    <em>Add Sales</em>
                                </div>
                                &nbsp;<button type="submit" id="enable" class="btn btn-default btn-sm" data-toggle="modal" data-target="#additem"><b>Add New Item</b></button><br><br>

                                <div class="main-content">
                                    <!-- WYSIWYG EDITOR -->

                                    <form action="customFile/AddSalesListPro.php" id="form_data" class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" >                                      

                                        <div class="form-group">
                                            <label for="ticket-name" class="col-sm-3 control-label" id="lblcatname">Select Party</label>
                                            <div class="col-sm-9" id="partylist">
                                                <select name="party_id" id="party_list" class="select2"  required>
                                                    <option value="">Select Party</option>
                                                    <?php
                                                    $dba = new DBAdapter();
                                                    $last_id = $dba->getLastID("branch_id", "system_user", "id=" . $_SESSION['user_id']);
                                                    $data = $dba->getRow("party_list", array("id", "party_name"), "branch_id=" . $last_id);
                                                    $party_name = "";
                                                    if (isset($_GET['id'])) {
                                                        echo $party_name = $edata[0][1];
                                                    } elseif (isset($_GET['order_id'])) {
                                                        echo $party_name = $orderdata[0][1];
                                                    }
                                                    foreach ($data as $subData) {
                                                        echo" <option " . ($subData[1] == $party_name ? 'selected' : '') . " value='" . $subData[0] . "'>" . $subData[1] . "</option> ";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <label for="ticket-name" class="col-sm-3 control-label" id="lblinvoice">Invoice No.</label>
                                            <div class="col-sm-9" id="partyin">
                                                <input type="text" value="<?php echo ( isset($_GET['type']) && isset($_GET['id']) ? $edata[0][2] : '') ?>" name="s_invoice_no" id="partyinvoiceno" class="form-control" placeholder="InvoiceNo." required>
                                            </div>
                                            <label for="ticket-name" class="col-sm-3 control-label" id="lblpartydate">Date</label>
                                            <div class="col-sm-9" id="partydue">

                                                <input type="date" id="datevalue" value="<?php
                                                if (isset($_GET['id'])) {
                                                    echo ( isset($_GET['type']) && isset($_GET['id']) ? $edata[0][3] : '');
                                                } elseif (isset($_GET['order_id'])) {
                                                    echo $orderdata[0][2];
                                                } else {
                                                    echo '';
                                                }
                                                ?>" name="sale_date" id="sale_date" class="form-control" placeholder="Date" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="ticket-name" class="col-sm-3 control-label" id="lblpartydate">Total</label>
                                            <div class="col-sm-9" id="partydue">

                                                <input type="text" value="<?php
                                                if (isset($_GET['id'])) {
                                                    echo ( isset($_GET['type']) && isset($_GET['id']) ? $edata[0][4] : '');
                                                } elseif (isset($_GET['order_id'])) {
                                                    echo $orderdata[0][3];
                                                } else {
                                                    echo '';
                                                }
                                                ?>" name="total_amount" id="txt_total"   class="form-control" placeholder="Total" readonly required>
                                            </div>

                                            <input type="hidden" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][4] : '') ?>" name="sl_amount" id="sl_total">

                                            <label for="ticket-name" class="col-sm-3 control-label" id="lblpartydate">Type</label>
                                            <div class="col-sm-9" id="typelist">
                                                <input type="hidden" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][5] : '') ?>" name="s_type" id="s_typel" >
                                                <select name="pay_type" id="type" class="select2" required>
                                                    <?php if (isset($_GET['id'])) { ?>
                                                        <option value = "Cash"<?php echo $edata[0][5] == 'Cash' ? ' selected="selected"' : '';
                                                        ?>>Cash</option>
                                                        <option value="Credit"<?php echo $edata[0][5] == 'Credit' ? ' selected="selected"' : ''; ?>>Credit</option>
                                                    <?php } else {
                                                        ?>
                                                        <option value="">Select Pay</option>
                                                        <option value="Cash">Cash</option>
                                                        <option value="Credit">Credit</option>
                                                    <?php }
                                                    ?>

                                                </select>
                                            </div>

                                            <label for="ticket-name" class="col-sm-6 control-label" id="lbltax">Pay Tax</label>
                                            <div class="col-sm-9" id="typelist">
                                                <!--<input type="hidden" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][5] : '') ?>" name="p_type" id="p_typel" >-->
                                                <select name="pay_tax" id="type" class="select2" required>
                                                    <?php if (isset($_GET['id'])) { ?>
                                                        <option value = "GST"<?php echo $edata[0][9] == 'GST' ? ' selected="selected"' : '';
                                                        ?>>GST</option>
                                                        <option value="WGST"<?php echo $edata[0][9] == 'WGST' ? ' selected="selected"' : ''; ?>>WGST</option>
                                                    <?php } elseif (isset($_GET['order_id'])) { ?>
                                                        <option value = "GST"<?php echo $orderdata[0][4] == 'GST' ? ' selected="selected"' : '';
                                                        ?>>GST</option>
                                                        <option value="WGST"<?php echo $orderdata[0][4] == 'WGST' ? ' selected="selected"' : ''; ?>>WGST</option>
                                                    <?php } else {
                                                        ?>
                                                        <option value="">Select Tax</option>
                                                        <option value="GST">GST</option>
                                                        <option value="WGST">WGST</option>
                                                    <?php }
                                                    ?>

                                                </select>

                                            </div>

                                            <label for="ticket-name" class="col-sm-3 control-label" id="lblpartydue">Vehicle No.</label>
                                            <div class="col-sm-9" id="partydue">
                                                <input type="text" value="<?php echo ( isset($_GET['type']) && isset($_GET['id']) ? $edata[0][7] : '') ?>" name="vehicle_no" id="vehicle_no" class="form-control" placeholder="Vehicle No." required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="ticket-name" class="col-sm-3 control-label" id="lbllrno">L.R. No.</label>
                                            <div class="col-sm-9" id="partydue">
                                                <input type="text" value="<?php echo ( isset($_GET['type']) && isset($_GET['id']) ? $edata[0][8] : '') ?>" name="lr_no" id="lr_no" class="form-control" placeholder="L.R. No." required>
                                            </div>



                                            <label for="ticket-name" class="col-sm-3 control-label" id="lblpartydate">Note</label>
                                            <div class="col-sm-9" id="partynote">
                                                <input type="text" value="<?php
                                                if (isset($_GET['id'])) {
                                                    echo ( isset($_GET['type']) && isset($_GET['id']) ? $edata[0][6] : '');
                                                } elseif (isset($_GET['order_id'])) {
                                                    echo $orderdata[0][5];
                                                } else {
                                                    echo '';
                                                }
                                                ?>" name="note" id="note" class="form-control" placeholder="Note" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-9" id="rowcount2">
                                            <input type="hidden" value="<?php
                                            if (isset($_GET['id'])) {
                                                echo (isset($_GET['type']) && isset($_GET['id']) ? $countrow[0][0] : '');
                                            } elseif (isset($_GET['order_id'])) {
                                                echo $countrow_order[0][0];
                                            }
                                            ?>" name="rowcount_no" id="row_count"   class="form-control">
                                        </div>
                                        <table id="item_table" class="item_table" border="1" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th><input class='check_all' type='checkbox' onclick="select_all()"/></th>
                                                    <th>ID</th>
                                                    <th>Select Item</th>
                                                    <th>Item Name</th>
                                                    <th>Unit</th>
                                                    <th>Qnty</th>
                                                    <th>Rate</th>
                                                    <th>Sub Total</th>
                                                    <th>GST(%)</th>
                                                    <th>Total</th>
                                                    <th style="border: none;">Ava Stock</th>
                                                </tr>
                                            </thead>
                                            <tbody id="view_data1" name="view_data">
                                                <tr id = "row1" data='no'>
                                                    <td><input type = 'checkbox' class = 'case' id='check1' name='check[]' value='1'/></td>
                                                    <td><input type="text" id = 'snum1' value="1" class="snum" /></td>
                                                    <td>
                                                        <select name = 'item_id[]' id = 'item_code1' class = 'itemcode select2' onchange="getValue(this);">
                                                            <option>Select Item</option>
                                                            <?php
                                                            $dba = new DBAdapter();

                                                            $last_id = $dba->getLastID("branch_id", "system_user", "id=" . $_SESSION['user_id']);

                                                            $data = $dba->getRow("item_list INNER JOIN category_list ON item_list.category_id=category_list.id", array("item_list.id", "item_list.item_code"), "category_list.branch_id=" . $last_id . " order by item_list.id asc");
                                                            foreach ($data as $subData) {
                                                                echo "<option value='" . $subData[0] . "'>" . $subData[1] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td><input type='text' id='item_name1' class='itemname' name='item_name[]' required/></td>
                                                    <td><input type='text' id='unit1' class='unit1' name='unit[]' required/></td>
                                                    <td><input type='text' id='qnty1' class='qnty1' name='item_qnty[]' onchange="changeQnty(this);" required /> </td>
                                                    <td><input type='text' id='rate1' class='rate1' name='item_rate[]' onchange="changerate(this);" required/></td>
                                                    <td><input type='text' id='sub_total1' class='subtotal' name='sub_total[]' required readonly/> </td>
                                                    <td><input type='text' id='gst1' class='gst1' name='gst[]' value="0.0" onchange="changegst(this);" required/> </td>
                                                    <td><input type='text' id='total1' class='total1' value="0.0" name='total[]' required readonly/> </td>
                                                    <td style="border: none;"> <label for="ticket-name" class="col-sm-1 control-label" id="itemstock1">0</label> </td>
                                            <input type='hidden' id='dbstock1' class="dbitemstock" value="0"  name='dbitemstock[]' />

                                            </tr>
                                            </tbody>   

                                        </table>
                                        <button type="button" class='delete' onclick="deleterow(<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][0] : '0') ?>)"><b>- Delete</b></button>
                                        <button type="button" class='addmore' id="add_more" onclick="addrow();" ><b>+ Add More</b></button>
                                        <div class="widget-footer">
                                            <input type="hidden" name="user_info" id="user_info" value="<?php echo (isset($_SESSION['user_id']) ? $_SESSION['user_name'] : "") ?>"/>
                                            <input type="hidden" name="action" id="action" value="<?php echo (isset($_GET['id']) ? 'edit' : 'add') ?>">
                                            <input type="hidden" name="id" id="id" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][0] : '') ?>">
                                            <input type="hidden" name="order_id" id="orderid" value="<?php echo (isset($_GET['order_id']) ? $_GET['order_id'] : "") ?>">
                                            <button type="submit" id="btn_save" name="btn_save" class="btn btn-primary" style="font-size: 16px; font-family: Cambria;"><i class="fa fa-floppy-o"></i><b> <?php echo (isset($_GET['type']) && isset($_GET['id']) ? 'Edit' : 'Save') ?></b></button>
                                        </div>

                                    </form>
                                </div>
                                <!-- /main-content -->
                            </div>
                            <!-- /content -->
                        </div>
                        <!-- /content-wrapper -->
                    </div>
                    <!-- /row -->
                </div>
                <!-- /container -->
            </div>
            <!-- END BOTTOM: LEFT NAV AND RIGHT MAIN CONTENT -->
        </div>
        <!-- /wrapper -->
        <div class="modal fade" id="additem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                        <h4 class="modal-title" id="myModalLabel">Add New Item</h4>

                    </div>

                    <div class="modal-body">                                        
                        <div id="form">
                            <form action="javascript:void(0);" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" onsubmit="addItem();" >
                                <div class="form-group">
                                    <label  for="ticket-name" class="col-sm-2 control-label">Select Category</label>
                                    <div class="col-sm-9" id="catlist">
                                        <select name="category_id" id="category_list" class="select2" required>
                                            <option>Select Category</option>
                                            <?php
                                            if (!isset($_SESSION)) {
                                                session_start();
                                            }
                                            $dba = new DBAdapter();

                                            $last_id = $dba->getLastID("branch_id", "system_user", "id=" . $_SESSION['user_id']);

                                            $data = $dba->getRow("category_list", array("id", "category_name, branch_id"), "branch_id=" . $last_id);
                                            //$userid = $_SESSION['user_id'];
                                            foreach ($data as $subData) {
                                                echo" <option value='" . $subData[0] . "'>" . $subData[1] . "</option> ";
                                            }
                                            ?>
                                        </select>                                    
                                    </div>
                                    <a href="#addcategory" data-toggle="modal" class="btn btn-primary btn-sm" data-dismiss="modal">...</a>
                                    <!--<button type="submit" id="enable" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addparty"><b>....</b></button>-->

                                </div>

                                <div class="form-group">
                                    <label for="ticket-name" class="col-sm-2 control-label">Item Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" value="" name="item_name" id="item_name" class="form-control" placeholder="Item Name" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ticket-name" class="col-sm-2 control-label">Select Unit</label>
                                    <div class="col-sm-10">
                                        <select name="item_unit_id" id="unit_list" class="select2" required>
                                            <option>Select Unit</option>
                                            <?php
                                            $dba = new DBAdapter();
                                            $data = $dba->getRow("unit_list", array("id", "unit_name"), "1");
                                            foreach ($data as $subData) {
                                                echo" <option  value='" . $subData[0] . "'>" . $subData[1] . "</option> ";
                                            }
                                            ?>
                                        </select>                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ticket-name" class="col-sm-2 control-label">Item OpStock</label>
                                    <div class="col-sm-10">
                                        <input type="text" value="" name="item_opstock" id="item_opstock" class="form-control" placeholder="Item Opening Stock" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ticket-name" class="col-sm-2 control-label">Item Rate</label>
                                    <div class="col-sm-10">
                                        <input type="text" value="" name="item_rate" id="item_rate" class="form-control" placeholder="Item Rate" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ticket-name" class="col-sm-2 control-label">GST Rate</label>
                                    <div class="col-sm-10">
                                        <input type="text" value="" name="gst_rate" id="gst_rate" class="form-control" placeholder="Item GST Rate" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ticket-name" class="col-sm-2 control-label">HSN Code</label>
                                    <div class="col-sm-10">
                                        <input type="text" value="" name="hsn_code" id="hsn_code" class="form-control" placeholder="Item HSN Code" required>
                                    </div>
                                </div>


                                <div class="modal-footer">
                            <!--<input type="hidden" name="action" id="action" value="add"/>-->
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>

                                    <button type="submit" id="btnparty" class="btn btn-custom-primary" ><i class="fa fa-check-circle"></i>Add</button>

                                </div>
                            </form>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="modal fade" id="addcategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                        <h4 class="modal-title" id="myModalLabel">Add New Category</h4>

                    </div>

                    <div class="modal-body">                                        
                        <div id="form">
                            <form action="javascript:void(0);" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" onsubmit="addCategory();" >
                                <div class="form-group">
                                    <label  for="ticket-name" class="col-sm-4 control-label" id="lblcatname">Category Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="category_name" id="category_name" class="form-control" placeholder="Category Name" required="">
                                    </div>
                                </div>

                                <div class="modal-footer">
                            <!--<input type="hidden" name="action" id="action" value="add"/>-->
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>

                                    <button type="submit" class="btn btn-custom-primary" data-target="#additem" id="add-cat" data-toggle="modal" ><i class="fa fa-check-circle" ></i>Add</button>
                                    <!--// <a href="#additem" data-toggle="modal" class="btn btn-primary btn-sm" data-dismiss="modal">...</a>-->

                                </div>
                            </form>
                        </div>

                    </div>

                </div>

            </div>

        </div>
        
        <!-- FOOTER -->
        <footer class="footer">
            2018 © <a href="http://lpktechnosoft.com" target="_blank">LPK Technosoft</a>
        </footer>        
        <!-- END FOOTER -->
        <!-- Javascript -->
        <script src="customFile/createitemJs.js"></script>
        <script src="customFile/createcategoryJs.js"></script>
        <script src="assets/js/jquery/jquery-2.1.0.min.js"></script>
        <script src="assets/js/jquery/jquery-1.12.4.min.js"></script>
        <script src="assets/js/bootstrap/bootstrap.js"></script>
        <script src="assets/js/plugins/modernizr/modernizr.js"></script>
        <script src="assets/js/plugins/bootstrap-tour/bootstrap-tour.custom.js"></script>
        <script src="assets/js/king-common.js"></script>
        <script src="demo-style-switcher/assets/js/deliswitch.js"></script>
        <script src="assets/js/plugins/markdown/markdown.js"></script>
        <script src="assets/js/plugins/markdown/to-markdown.js"></script>
        <script src="assets/js/plugins/markdown/bootstrap-markdown.js"></script>
        <!--<script src="assets/js/king-elements.js"></script>-->
        <script src="assets/js/plugins/select2/select2.min.js"></script>
        <script type="text/javascript" src="customFile/AllCalculationFun.js"></script>

        <script type="text/javascript">
                                function numbers() {
                                    var sidd =<?php echo (isset($_GET['id']) ? $edata[0][0] : '') ?>;

                                    var my_object = "sales_id=" + sidd;
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
    //                                            ;
                                numbers();



        </script>
        
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
</script>

        <script type="text/javascript">
            function sumvalue(i) {
                var qnty = document.getElementById("qnty" + i).value;
                var label = document.getElementById("dbstock" + i).value;
                var totalstock = parseInt(label) - parseInt(qnty);
                $('#itemstock' + i).text(totalstock);
            }
            ;

            function getCategory() {

                $.ajax({
                    url: 'getNewCategory.php',
                    dataType: "html",
                    cache: false,
                    success: function (Data) {

                        $('#additem').modal('show');
                        $('#catlist').html(Data);
                        ;
                    },
                    error: function (errorThrown) {
                        alert(errorThrown);
                        alert("There is an error with AJAX!");
                    }
                });
            }
            ;
        </script>
        
        <script>

            function deleterow(sales_id)
            {
                var values = $('input:checked').map(function () {
                    return this.value;
                }).get();

                var rowattri = document.getElementById('row' + values).getAttribute('data');

                var totalamount = 0;
                var n = 1;
                var count = $('#view_data1 tr ').length;
                var amtremove = parseFloat(document.getElementById('total' + values).value);
                for (var i = 1; i <= count; ++i) {

                    var amt = parseFloat(document.getElementById('total' + i).value);
                    totalamount = totalamount + amt;

                    var snumber = document.getElementById('snum' + i);
                    var totaln = document.getElementById('total' + i);
                    var cb = document.getElementById('check' + i);
                    var iqnty = document.getElementById('qnty' + i);
                    var icode = document.getElementById('item_code' + i);
                    var irate = document.getElementById('rate' + i);
                    var isubtotal = document.getElementById('sub_total' + i);
                    var igst = document.getElementById('gst' + i);
                    var iname = document.getElementById('item_name' + i);
                    var iunit = document.getElementById('unit' + i);
                    var rowid = document.getElementById('row' + i);

                    if (cb.checked) {
                        if (rowattri === 'no') {
                            //  alert(rowattri);
                            $('.case:checkbox:checked').parents("tr").remove();
                            //  document.getElementById("txt_total").value = parseFloat(totalamount - amtremove).toFixed(2);

                        } else {

                            var id = document.getElementById('s_id' + values).value;
                            // alert(id);
                            var my_object = {"s_list_id": id, "sales_id": sales_id};
                            $.ajax({
                                url: 'Delete.php',
                                dataType: "html",
                                data: my_object,
                                cache: false,
                                success: function (Data) {
                                    // alert(Data);
                                    $('.case:checkbox:checked').parents("tr").remove();
                                    // var rows = document.getElementById('item_table').getElementsByTagName("tbody")[0].getElementsByTagName("tr").length;
                                    var rowcount = <?php echo (isset($_GET['type']) && isset($_GET['id']) ? $countrow[0][0] : '0') ?>;
                                    document.getElementById("row_count").value = rowcount - 1;

                                },
                                error: function (errorThrown) {
                                    alert(errorThrown);
                                    alert("There is an error with AJAX!");
                                }
                            });
                        }
                    } else {
                        snumber.id = 'snum' + n;
                        snumber.value = n;
                        cb.id = 'check' + n;
                        cb.value = n;
                        icode.id = 'item_code' + n;
                        iqnty.id = 'qnty' + n;
                        totaln.id = 'total' + n;
                        irate.id = 'rate' + n;
                        isubtotal.id = 'sub_total' + n;
                        igst.id = 'gst' + n;
                        iname.id = 'item_name' + n;
                        iunit.id = 'unit' + n;
                        rowid.id = 'row' + n;

                        n++;
                    }
                }
                document.getElementById("txt_total").value = parseFloat(totalamount - amtremove).toFixed(2);
            }
            ;

            function select_all() {
                $('input[class=case]:checkbox').each(function () {
                    if ($('input[class=check_all]:checkbox:checked').length === 0) {
                        $(this).prop("checked", false);
                    } else {
                        $(this).prop("checked", true);
                    }
                });
            }

            function check() {
                obj = $('table tr').find('span');
                $.each(obj, function (key, value) {
                    id = value.id;
                    $('#' + id).html(key + 1);
                });
            }

        </script>
        
        <script type="text/javascript">
            function getordervalue() {
                var value = <?php echo ( isset($_GET['order_id']) ? $orderdata[0][0] : '') ?>;

                var dataString = 'sales_order_id=' + value;

                $.ajax({
                    url: 'suggestvalue.php',
                    dataType: "html",
                    data: dataString,
                    cache: false,
                    success: function (Data) {
                        // alert(Data);
                        $('#view_data1').html(Data);

                    },
                    error: function (errorThrown) {
                        alert(errorThrown);
                        alert("There is an error with AJAX!");
                    }
                });
            }
            ;
            getordervalue();
        </script>
        
        <script type="text/javascript">

            var btn_crate =<?php echo (isset($_SESSION['user_id']) ? $role_data[0][3] : '') ?>;

            var btn_edit =<?php echo (isset($_GET['id']) ? 1 : 0) ?>;

            if (btn_crate === 0) {
                $('#btn_save').prop('disabled', true);
            }
            if (btn_edit === 1) {
                $('#btn_save').prop('disabled', false);
            }

        </script>
    </body>
</html>




