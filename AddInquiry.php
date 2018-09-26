<?php
ob_start();
include_once 'shreeLib/DBAdapter.php';
include_once 'shreeLib/dbconn.php';
include './shreeLib/session_info.php';
if (isset($_GET['type']) && isset($_GET['id'])) {
    $iid = $_GET['id'];
    $edba = new DBAdapter();
    $field = array("inquiry.id,create_party.party_name,inquiry.inq_date,inquiry.remark");
    $edata = $edba->getRow("inquiry INNER JOIN party_list ON inquiry.party_id=party_list.id", $field, "inquiry.id=" . $_GET['id']);
    echo "<input type='hidden' id='id' value='" . $_GET['id'] . "'>";
    $field1 = array("count(inq_id)");
    $countrow = $edba->getRow("inquiry_item_list", $field1, "inq_id=" . $_GET['id']);
    echo "<input type='hidden' id='rowcount' value='" . $countrow[0][0] . "'>";
}
if (isset($_SESSION['user_id'])) {
    $edba = new DBAdapter();
    $servername1 = basename($_SERVER['PHP_SELF']);
    //echo $servername1;
    $field = array("role_rights.id");
    $mod_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " module.mod_pagename='" . $servername1 . "' and role_rights.user_id=" . $_SESSION['user_id']);
    echo "<input type='hidden' id='mod_id' value='" . $mod_data[0][0] . "'>";

    $field = array("role_rights.id,role_rights.role_edit,role_rights.role_delete,role_rights.role_create");
    $role_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " role_rights.id=" . $mod_data[0][0]);
    echo "<input type='hidden' id='u_id' value='" . $role_data[0][3] . "'>";
}
?>
<!DOCTYPE html>
<html lang="en" class="no-js">

    <head>
        <title>
            <?php
            if (isset($_GET['id'])) {
                echo 'Edit Inquiry';
            } else {
                echo 'Add New Inquiry';
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
            .remark{width:420px;}
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
                                        <li class="active">Add Inquiry</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- main -->
                            <div class="content">
                                <div class="main-header">
                                    <h2>Inquiry List</h2>
                                    <em>Add Inquiry</em>
                                </div>

                                <button type="submit" id="enable" class="btn btn-default btn-sm" data-toggle="modal" data-target="#addparty"><b>Add New Party</b></button>
                                &nbsp;<button type="submit" id="enable" class="btn btn-default btn-sm" data-toggle="modal" data-target="#additem"><b>Add New Item</b></button>

                                <br><br>
                                <div class="main-content">
                                    <!-- WYSIWYG EDITOR -->
                                    <form action="customFile/AddInquiryPro.php" id="form_data" class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" >                                      

                                        <div class="form-group">
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblcatname">Select Party</label>
                                            <div class="col-sm-9" id="partylist5">
                                                <select name="party_id" id="create_party" class="select2"  required>
                                                    <option>Select Party</option>
                                                    <?php
                                                    $partyname = "";
                                                    if (isset($_SESSION['partyid'])) {
                                                        $partyname = $_SESSION['partyid'];
                                                        print_r($partyname);
                                                    }
                                                    $dba = new DBAdapter();
                                                    $last_id = $dba->getLastID("branch_id", "create_user", "1");
                                                    $data = $dba->getRow("create_party", array("id", "party_name"), "create_party.branch_id=" . $last_id);
                                                    print_r($data);
                                                    //  echo "<option " . ($partyname == $partyname ? 'selected' : '') . " value='" . $partyname . "'>" . $partyname . "</option>";
                                                    foreach ($data as $subData) {

                                                        echo" <option " . ($subData[1] == $edata[0][1] ? 'selected' : '') . " value='" . $subData[0] . "'>" . $subData[1] . "</option> ";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <label for="ticket-name" class="col-sm-1 control-label" id="lblpartydate">Date</label>
                                            <div class="col-sm-3" id="partydue">
                                                <input type="date"  id="datevalue" value="<?php echo ( isset($_GET['type']) && isset($_GET['id']) ? $edata[0][2] : '') ?>" name="inq_date" id="inq_date" class="form-control" placeholder="Inquiry Date" required>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblpartynote">Remark</label>
                                            <div class="col-sm-8" id="partynote">
                                                <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][4] : '') ?>" name="inq_remark" id="inq_remark" class="form-control" placeholder="Remark" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-9" id="rowcount1">
                                            <input type="hidden" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $countrow[0][0] : '') ?>" name="rowcount_no" id="row_count"   class="form-control" placeholder="rowcount" required>

                                        </div>

                                        <table id="item_table" class="item_table" border="1" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th><input class='check_all' type='checkbox' onclick="select_all()"/></th>
                                                    <th>ID</th>
                                                    <th>Select Item </th>
                                                    <th>Item Name</th>
                                                    <th>Unit</th>
                                                    <th>Qnty</th>
                                                    <th>Remark</th>

                                                </tr>
                                            </thead>
                                            <tbody id="view_data1" name="view_data">
                                                <tr id = "row1" data='no'>
                                                    <td><input type = 'checkbox' class = 'case' id='check1' name='check[]' value='1'/></td>
                                                    <td><input type="text" id = 'snum1' value="1" class="snum" /></td>
                                                    <td>
                                                        <select name = 'item_id[]' id = 'item_code1' class = 'itemcode select2' onchange="getValue(this);">
                                                            <option>Select item</option>
                                                            <?php
                                                            $dba = new DBAdapter();

                                                            $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                            $data = $dba->getRow("create_item INNER JOIN sub_category ON create_item.sub_cat_id=sub_category.id", array("create_item.id", "create_item.item_name"), "sub_category.branch_id=" . $last_id);
                                                            $count = count($data);
                                                            if ($count >= 1) {
                                                                foreach ($data as $subData) {
                                                                    echo "<option value='" . $subData[0] . "'>" . $subData[1] . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td><input type='text' id='item_name1' class='itemname' name='item_name[]' required/></td>
                                                    <td><input type='text' id='unit1' class='unit1' name='item_unit[]' required/></td>
                                                    <td id="qtn"><input type='text' id='qnty1' class='qnty1' name='item_quantity[]' onchange="changeQnty(this);" required /> </td>
                                                    <td><input type='text' id='remark1' class='remark' name='remark[]' required /> </td>

                                                </tr>
                                            </tbody>   

                                        </table>
                                        <button type="button" class='delete' onclick="deleterow(<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][0] : '0') ?>)"><b>- Delete</b></button>
                                        <button type="button" class='addmore' id="add_more" onclick="addrow();" ><b>+ Add More</b></button>
                                        <div class="widget-footer">
                                            <input type="hidden" name="action" id="action" value="<?php echo (isset($_GET['id']) ? 'edit' : 'add') ?>">
                                            <input type="hidden" name="id" id="id" value="<?php echo (isset($_GET['id']) ? $_GET['id'] : "") ?>">
                                            <button type="submit" id="btn_save" name="btn_save" class="btn btn-primary" style="font-size: 16px; font-family: Cambria;"><i class="fa fa-floppy-o"></i><b> <?php echo (isset($_GET['type']) && isset($_GET['id']) ? 'Edit' : 'Save') ?></b></button>
                                        </div>
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
    <div class="modal fade" id="addparty" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                    <h4 class="modal-title" id="myModalLabel">Add New Party</h4>

                </div>

                <div class="modal-body">                                        
                    <div id="form">
                        <form action="javascript:void(0);" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" onsubmit="addParty();" >
                            <div class="form-group">
                                <label for="ticket-name" class="col-sm-3 control-label" id="lblcatname">Party Name</label>
                                <div class="col-sm-9">
                                    <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][1] : '') ?>" name="party_name" id="party_name" class="form-control" placeholder="Party name" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ticket-name" class="col-sm-3 control-label" id="lblcatname">Party Contact</label>
                                <div class="col-sm-9">
                                    <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][2] : '') ?>" name="party_contact" id="party_contact" class="form-control" placeholder="Enter Contact No here" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ticket-name" class="col-sm-3 control-label" id="lblcatname">Party Email</label>
                                <div class="col-sm-9">
                                    <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][3] : '') ?>" name="party_email" id="party_email" class="form-control" placeholder="Party Email" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ticket-name" class="col-sm-3 control-label" id="lblcatname">Party Address</label>
                                <div class="col-sm-9">
                                    <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][4] : '') ?>" name="party_address" id="party_address" class="form-control" placeholder="Party address" required>
                                </div>

                            </div>
                            <div class="form-group">

                                <label for="ticket-name" class="col-sm-3 control-label" id="lblcatname">Select Country</label>
                                <div class="col-sm-9" id="typelist1">

                                    <select name="country_id" id="countries" class="select2" required onchange="countrychange();">
                                        <option>Select Country</option>
                                        <?php
                                        $dba = new DBAdapter();
                                        $data = $dba->getRow("countries", array("id", "name"), "1");
                                        foreach ($data as $subData) {
                                            echo "<option " . ($subData[0] == $edata[0][9] ? 'selected' : '') . " value='" . $subData[0] . "'>" . $subData[1] . "</option> ";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ticket-name" class="col-sm-3 control-label">Select City</label>
                                <div class="col-sm-9" id="city_list">
                                    <select name="city_id" id="cities" class="select2" required>
                                        <option>Select City</option>

                                        <?php
                                        $dba = new DBAdapter();
                                        $data = $dba->getRow("cities", array("id", "name"), "1");
                                        foreach ($data as $subData) {
                                            echo "<option value=" . $subData[0] . ">" . $subData[1] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">

                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>

                                <button type="submit" id="btnparty" class="btn btn-custom-primary" ><i class="fa fa-check-circle" onclick="getparty();" ></i>Add</button>

                            </div>
                        </form>
                    </div>

                </div>

            </div>

        </div>

    </div>

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
                                <label for="ticket-name" class="col-sm-3 control-label">Item Name</label>
                                <div class="col-sm-9" >
                                    <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][1] : '') ?>" name="item_name" id="item_name" class="form-control" placeholder="Item Name" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ticket-name" class="col-sm-3 control-label" id="lblcatname">Sub Category</label>
                                <div class="col-sm-8" id="category1">
                                    <select name="sub_cat_id" id="sub_category" class="select2" required>
                                        <option>Select Sub Category</option>
                                        <?php
                                        $dba = new DBAdapter();
                                        $data = $dba->getRow("sub_category", array("id", "sub_cat_name"), "1");

                                        foreach ($data as $subData) {
                                            echo "<option " . ($subData[0] == $edata[0][6] ? 'selected' : '') . " value='" . $subData[0] . "'>" . $subData[1] . "</option> ";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <a href="#addsubcategory" data-toggle="modal" class="btn btn-primary btn-sm" data-dismiss="modal">...</a>

                            </div>
                            <div class="form-group">
                                <label for="ticket-name" class="col-sm-3 control-label" id="lblselectparty">Select Unit</label>
                                <div class="col-sm-9" id="typelist">
                                    <select name="item_unit_id" id="unit_list" class="select2" required>
                                        <option>Select Unit</option>
                                        <?php
                                        $dba = new DBAdapter();
                                        $data = $dba->getRow("unit_list", array("id", "unit_name"), "1");
                                        foreach ($data as $subData) {
                                            echo " <option " . ($subData[1] == $edata[0][4] ? 'selected' : '') . " value='" . $subData[0] . "'>" . $subData[1] . "</option> ";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ticket-name" class="col-sm-3 control-label">Remark</label>
                                <div class="col-sm-9">
                                    <textarea cols="1000"rows="2" value="" name="remark" id="remark" class="form-control" placeholder="Remark" required><?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][5] : '') ?></textarea>
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

    <div class="modal fade" id="addsubcategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                    <h4 class="modal-title" id="myModalLabel">Add New Main Category</h4>
                </div>
                <div class="modal-body">                                        
                    <div id="form">
                        <form action="javascript:void(0);" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" onsubmit="addmainCategory();" >

                            <div class="form-group">
                                <label for="ticket-name" class="col-sm-3 control-label" id="lblcatname">Category Name</label>
                                <div class="col-sm-6" id="partydue">
                                    <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][1] : '') ?>" name="name" id="name" class="form-control" placeholder="Category Name" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-custom-primary" data-target="#addsubcategory" id="add-cat"  ><i class="fa fa-check-circle" ></i>Add</button>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="modal-header">
                    <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
                    <h4 class="modal-title" id="myModalLabel">Add New Sub Category</h4>
                </div>
                <div class="modal-body">                                        
                    <div id="form">
                        <form action="javascript:void(0);" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" onsubmit="addsubCategory();" >

                            <div class="form-group">
                                <label for="ticket-name" class="col-sm-4 control-label" id="lblcatname">Select Main Category</label>
                                <div class="col-sm-3" id="partylist1" style="width:300px;">
                                    <select name="main_cat_id" id="main_category" class="select2" required>
                                        <option>Select Main Category</option>
                                        <?php
                                        $dba = new DBAdapter();
                                        $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);

                                        $data = $dba->getRow("main_category", array("id", "name"), "main_category.branch_id=" . $last_id);
                                        foreach ($data as $subData) {
                                            echo "<option " . ($subData[0] == $edata[0][1] ? 'selected' : '') . " value='" . $subData[0] . "'>" . $subData[1] . "</option> ";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <!--<a href="#addmaincategory" data-toggle="modal" class="btn btn-primary btn-sm" data-dismiss="modal">...</a>-->

                            </div>
                            <div class="form-group">
                                <label for="ticket-name" class="col-sm-4 control-label" id="lblcatname">Category Name</label>
                                <div class="col-sm-5" id="partydue" style="width:300px;">
                                    <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][2] : '') ?>" name="sub_cat_name" id="sub_cat_name" class="form-control" placeholder="Category Name" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
                                <button type="submit" class="btn btn-custom-primary" data-target="#additem" id="add-cat" data-toggle="modal" ><i class="fa fa-check-circle" ></i>Add</button>

                            </div>
                        </form>
                    </div>

                </div>

            </div>

        </div>

    </div>
    <!--    <div class="modal fade" id="addmaincategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    
            <div class="modal-dialog">
    
                <div class="modal-content">
    
                    <div class="modal-header">
    
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    
                        <h4 class="modal-title" id="myModalLabel">Add New Main Category</h4>
    
                    </div>
    
                    <div class="modal-body">                                        
                        <div id="form">
                            <form action="javascript:void(0);" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" onsubmit="addmainCategory();" >
    
                                <div class="form-group">
                                    <label for="ticket-name" class="col-sm-3 control-label" id="lblcatname">Category Name</label>
                                    <div class="col-sm-6" id="partydue">
                                        <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][1] : '') ?>" name="name" id="name" class="form-control" placeholder="Category Name" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
                                    <button type="submit" class="btn btn-custom-primary" data-target="#addsubcategory" id="add-cat" data-toggle="modal" ><i class="fa fa-check-circle" ></i>Add</button>
    
                                </div>
                            </form>
                        </div>
    
                    </div>
    
                </div>
    
            </div>
    
        </div>-->
    <!-- FOOTER -->
    <footer class="footer">
        2018 © <a href="http://lpktechnosoft.com" target="_blank">LPK Technosoft</a>
    </footer>        
    <!-- END FOOTER -->
    <!-- Javascript -->
    <script src="customFile/createitemJs.js"></script>
    <script src="customFile/createsubcategoryJs.js"></script>
    <script src="customFile/createmaincategoryJs.js"></script>
    <script src="customFile/createpartyJs.js"></script>

    <script src="assets/js/jquery/jquery-2.1.0.min.js"></script>

    <script src="assets/js/bootstrap/bootstrap.js"></script>

    <script src="assets/js/plugins/modernizr/modernizr.js"></script>

    <script src="assets/js/plugins/bootstrap-tour/bootstrap-tour.custom.js"></script>

    <script src="assets/js/king-common.js"></script>

    <script src="assets/js/plugins/bootstrap-multiselect/bootstrap-multiselect.js"></script>

    <script src="assets/js/plugins/parsley-validation/parsley.min.js"></script>

    <script src="assets/js/plugins/datatable/jquery.dataTables.min.js"></script>

    <script src="assets/js/plugins/datatable/exts/dataTables.colVis.bootstrap.js"></script>

    <script src="assets/js/plugins/datatable/exts/dataTables.colReorder.min.js"></script>

    <script src="assets/js/plugins/datatable/exts/dataTables.tableTools.min.js"></script>

    <script src="assets/js/plugins/datatable/dataTables.bootstrap.js"></script>

    <script src="assets/js/king-table.js"></script>
    <script src="assets/js/sweetalert2.min.js"></script>

    <script src="assets/js/plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="customFile/AllCalculationFun.js"></script>

    <script type="text/javascript">
                            function numbers() {
                                var pidd =<?php echo (isset($_GET['id']) ? $edata[0][0] : '') ?>;
                                var my_object = "inq_id=" + pidd;
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
            var totalstock = parseInt(label) + parseInt(qnty);
            $('#itemstock' + i).text(totalstock);
        }
        ;
        function getparty() {

            $.ajax({
                url: 'getNewParty.php',
                dataType: "html",
                cache: false,
                success: function (Data) {
                    // alert(Data);
                    $('#partylist5').html(Data);
                },
                error: function (errorThrown) {
                    alert(errorThrown);
                    alert("There is an error with AJAX!");
                }
            });
        }
        ;
        function getCategory() {

            $.ajax({
                url: 'getNewsubCategory.php',
                dataType: "html",
                cache: false,
                success: function (Data) {
                    //alert(Data);
                    $('#category1').html(Data);
                },
                error: function (errorThrown) {
                    alert(errorThrown);
                    alert("There is an error with AJAX!");
                }
            });
        }
        ;

        function getmainCategory() {

            $.ajax({
                url: 'getNewmainCategory.php',
                dataType: "html",
                cache: false,
                success: function (Data) {
                    //alert(Data);

                    $('#partylist1').html(Data);
                    $('#addsubcategory').model('show');
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

        function deleterow(purchase_order_id) {

            var values = $('input:checked').map(function () {
                return this.value;
            }).get();
            //  alert(values);
            var rowattri = document.getElementById('row' + values).getAttribute('data');
            // alert(rowattri);
            var totalamount = 0;
            var n = 1;
            var count = $('#view_data1 tr ').length;
            var amtremove = parseFloat(document.getElementById('total' + values).value);
            // alert(amtremove);
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
// alert(rowattri);
                        $('.case:checkbox:checked').parents("tr").remove();
                    } else {
                        var id = document.getElementById('pr_id' + values).value;
                        var my_object = {"pr_list_id": id, "purchase_order_id": purchase_order_id};
                        $.ajax({
                            url: 'Delete.php',
                            dataType: "html",
                            data: my_object,
                            cache: false,
                            success: function (Data) {
                                // alert(Data);
                                $('.case:checkbox:checked').parents("tr").remove();
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
//$('#qnty' + n).removeAttr("onchange");
//$('#qnty' + n).attr("onchange","changeQnty("+ n +");")
//  var clickfun = $('#qnty' + n).attr("onchange");
//  var funname = clickfun.substring(0, clickfun.indexOf("("));
//  alert(clickfun);
//                        $('#qnty' + n).attr("onchange", funname + "(this)");
//                        var button = document.getElementById('qnty' + n);
//                        button.setAttribute("onchange", "changeQnty(this)");

//                                var clickfun = $('#rate' + n).attr("onchange");
//                        var funname = clickfun.substring(0, clickfun.indexOf("("));
//  alert(clickfun);
// $('#rate' + n).attr("onchange", funname + "(" + n + ")");

//                        var clickfun = $('#gst' + n).attr("onchange");
                    //                        var funname = clickfun.substring(0, clickfun.indexOf("("));
                    //alert(clickfun);
                    // $('#gst' + n).attr("onchange", funname + "(" + n + ")");

//                        var clickfun = $('#item_code' + n).attr("onchange");
//                        var funname = clickfun.substring(0, clickfun.indexOf("("));
// alert(clickfun);
                    // $('#item_code' + n).attr("onchange", funname + "(" + n + ")");

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

        var btn_crate =<?php echo (isset($_SESSION['user_id']) ? $role_data[0][3] : '') ?>;

        var btn_edit =<?php echo (isset($_GET['id']) ? 1 : 0) ?>;

        if (btn_crate === 0) {
            $('#btn_save').prop('disabled', true);
        }
        if (btn_edit === 1) {
            $('#btn_save').prop('disabled', false);
            $("#party_list option:not(:selected)").prop("disabled", true);
        }

    </script>
    <script type="text/javascript">
        function countrychange()
        {

            var country1 = document.getElementById("countries").value;
            //alert(country1);
            var dataString = 'countries=' + country1;
            //alert(dataString);
            $.ajax
                    ({

                        url: "getcity.php",
                        datatype: "html",
                        data: dataString,
                        cache: false,
                        success: function (html)
                        {
                            //alert(html);
                            $("#city_list").html(html);
                        },
                        error: function (errorThrown) {
                            alert(errorThrown);
                            alert("There is an error with AJAX!");
                        }
                    });
        }
        ;
    </script>
</body>
</html>




