<?php
ob_start();
include_once 'shreeLib/DBAdapter.php';
include_once 'shreeLib/dbconn.php';
include './shreeLib/session_info.php';
if (isset($_GET['type']) && isset($_GET['id'])) {
//echo'<br><br><br><br>';
    $iid = $_GET['id'];
    $edba = new DBAdapter();
    $field = array("inquiry.id,create_party.party_name,inquiry.inq_date,inquiry.inq_remark,inquiry.status");
    $edata = $edba->getRow("inquiry INNER JOIN create_party ON inquiry.party_id=create_party.id", $field, "inquiry.id=" . $_GET['id']);
    echo "<input type='hidden' id='id' value='" . $_GET['id'] . "'>";
    $field1 = array("count(inq_id)");
    $countrow = $edba->getRow("inquiry_item_list", $field1, "inq_id=" . $_GET['id']);
    echo "<input type='hidden' id='rowcount' value='" . $countrow[0][0] . "'>";
}
if (isset($_SESSION['user_id'])) {
    $edba = new DBAdapter();
    $servername1 = basename($_SERVER['PHP_SELF']);
    $field = array("role_rights.id");
    $mod_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " module.mod_pagename='" . $servername1 . "' and role_rights.user_id=" . $_SESSION['user_id']);
    echo "<input type='hidden' id='mod_id' value='" . $mod_data[0][0] . "'>";

    $field = array("role_rights.id,role_rights.role_edit,role_rights.role_delete,role_rights.role_create,role_rights.mod_id");
    $role_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " role_rights.id=" . $mod_data[0][0]);
    echo "<input type='hidden' id='u_id' value='" . $role_data[0][3] . "'>";
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>
            <?php
            if (isset($_GET['id'])) {
                echo 'Edit Inquiry';
            } else {
                echo 'Add New Inquiry';
            }
            ?>
        </title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="Themesbrand" name="author" />
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <link href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
        <link href="plugins/bootstrap-md-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
        <link href="plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

        <link href="plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
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
            .remark1{width:420px;}
            .snum{width: 40px;}
            #container{margin-left:180px;}
            #xyz{padding-right: 150px;}
            .short{float: right;}
            #partylist5{margin-left: -85px;}
            /*#item_code1{width: 200px;}*/
            .but{width:270px;background:#00BB64;border:1px solid #00BB64;height:40px;border-radius:3px;color:white;margin-top:10px;margin:0px 0px 0px 290px;}

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
                                    <h4 class="page-title">Fill Inquiry</h4>
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
                                                <div class="col-sm-12">
                                                    <h4><b><?php echo (isset($_GET['id']) ? 'Edit Inquiry' : '') ?></b></h4>
                                                    <?php
                                                    if (isset($_GET['id'])) {
                                                        ?>
                                                        <div class="short" style="margin-top: -50px">
                                                            <button type="button" id="enable" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#addparty"><b>Create Party</b></button>
                                                            &nbsp;<button type="button" id="enable" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#additem"><b>create Item</b></button>
                                                        </div>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <div class="short">
                                                            <button type="button" id="enable" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#addparty"><b>Create Party</b></button>
                                                            &nbsp;<button type="button" id="enable" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#additem"><b>create Item</b></button>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                            <br><br>
                                            <?php
//                                            if (isset($_GET['id'])) {
                                                ?>
                                                <form action="customFile/AddInquiryPro.php" style="margin-top: -50px" id="form_data" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" >  
                                                    <?php
//                                                } else {
                                                    ?>
                                                    <!--<form action="customFile/AddInquiryPro.php" style="margin-top: -50px" id="form_data" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" >-->  
                                                        <?php
//                                                    }
                                                    ?>
                                                    <div class="form-group row">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label" style="width:300px;">Select Party</label>
                                                        <div class="col-sm-5" id="partylist5">
                                                            <select class="form-control select2" name="party_id" id="create_party" required="">
                                                                <option>Select Party</option>
                                                                <?php
                                                                $dba = new DBAdapter();
                                                                $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                                $data = $dba->getRow("create_party", array("id", "party_name"), "1");
                                                                //print_r($data);
                                                                foreach ($data as $subData) {
                                                                    echo" <option " . ($subData[1] == $edata[0][1] ? 'selected' : '') . " value='" . $subData[0] . "'>" . $subData[1] . "</option> ";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <label for="example-date-input" class="col-sm-1 col-form-label">Date</label>
                                                        <div class="col-sm-3">
                                                            <input class="form-control"  id="datevalue" type="date" name="inq_date" id="inq_date" id="example-date-input" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][2] : ''); ?>" required="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-text-input" class="col-sm-1 col-form-label">Remark</label>
                                                        <div>
                                                            <textarea  class="form-control"  name="inq_remark" id="inq_remark" rows="2" cols="90" style="margin-left: 15px;"><?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][3] : '') ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-text-input" class="col-sm-1 col-form-label">Status</label>
                                                        <?php
                                                        if (isset($_GET['type']) && isset($_GET['id'])) {
                                                            // echo $edata[0][4];
                                                            if ($edata[0][4] == 'on') {
                                                                ?>
                                                                <input type="checkbox" id="switch" switch="none" name="status" checked />
                                                                <label for="switch" data-on-label="On"data-off-label="Off"</label>
                                                            <?php } elseif ($edata[0][4] == 'off') {
                                                                ?>
                                                                <input type="checkbox" id="switch" switch="none" name="status" />
                                                                <label for="switch" data-on-label="On"data-off-label="Off"</label>
                                                                <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <input type="checkbox" id="switch" switch="none" name="status" checked/>
                                                            <label for="switch" data-on-label="On"data-off-label="Off"></label>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="col-sm-9" id="rowcount1">
                                                        <input type="hidden" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $countrow[0][0] : '') ?>" name="rowcount_no" id="row_count"   class="form-control" placeholder="rowcount" required>

                                                    </div>
                                                    <table id="item_table" class="item_table" border="1" cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Sr No.</th>
                                                                <th>Select Item </th>
                                                                <!--<th>Item Name</th>-->
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
                                                                    <select style="width:250px;" name = 'item_id[]' id = 'item_code1' class = 'itemcode select2' onchange="getValue(this);" >
                                                                        <option>Select item</option>
                                                                        <?php
                                                                        $dba = new DBAdapter();
                                                                        $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                                        $data = $dba->getRow("create_item INNER JOIN main_category ON create_item.cat_id=main_category.id", array("create_item.id", "create_item.item_name"), "1");
                                                                        $count = count($data);
                                                                        if ($count >= 1) {
                                                                            foreach ($data as $subData) {
                                                                                echo "<option value='" . $subData[0] . "'>" . $subData[1] . "</option>";
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                                <!--<td><input type='text' id='item_name1' class='itemname' name='item_name[]' required/></td>-->
                                                                <td><input type='text' id='unit1' class='unit1' name='item_unit[]'  readonly=""/></td>
                                                                <td id="qtn"><input type='text' id='qnty1' class='qnty1' name='item_quantity[]' onchange="changeQnty(this);" required="" /> </td>
                                                                <td><input type='text' id='remark1' class='remark1' name='remark[]'  /> </td>
                                                            </tr>
                                                        </tbody>  
                                                    </table><br>
                                                    <button type="button" class='delete btn btn-primary waves-effect waves-light' onclick="deleterow(<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][0] : '0') ?>)"><b>- Delete</b></button>
                                                    <button type="button" class='addmore btn btn-primary waves-effect waves-light' id="add_more" onclick="addrow();" ><b>+ Add More</b></button>
                                                    <br><br>
                                                    <div class="button-items">
                                                        <input type="hidden" name="action" id="action" value="<?php echo (isset($_GET['id']) ? 'edit' : 'add') ?>"/>
                                                        <input type="hidden" name="id" id="id" value="<?php echo (isset($_GET['id']) ? $_GET['id'] : '') ?>"/>
                                                        <button type="submit" id="btn_save" class="btn btn-primary waves-effect waves-light" onclick="return  confirm('Do You want to Insert Data Y/N')"><?php echo (isset($_GET['type']) && isset($_GET['id']) ? 'Edit' : 'Save') ?></button>
                                                    </div>
                                                </form>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                            <!--end row-->


                        </div>

                        <!--end page content-->

                    </div> <!--container-fluid -->

                </div> <!--content -->
                <div class="col-sm-6 col-md-3 m-t-30">
                    <div class="modal fade" id="addparty" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title mt-0">Add New Party</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <form action="javascript:void(0);" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" onsubmit="addParty();" >
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-3 col-form-label">Party Name</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" type="text"  placeholder="Party Name" id="party_name" name="party_name" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][2] : ''); ?>" required="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-4 col-form-label">Party Contact</label>
                                            <div class="col-sm-8" style="margin-left: -40px;">
                                                <input class="form-control" type="text"  placeholder="Party Contact" id="party_contact" name="party_contact" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][3] : ''); ?>" required="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-3 col-form-label">Party Email</label>
                                            <div class="col-sm-8">  
                                                <input class="form-control" type="text"  placeholder="Party Email" id="party_email" name="party_email" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][4] : ''); ?>" required="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-4 col-form-label">Party Address</label>
                                            <div class="col-sm-8" style="margin-left: -40px;">
                                                <input class="form-control" type="text"  placeholder="Party Address" id="party_address" name="party_address" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][5] : ''); ?>" required="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-4 col-form-label">Select Country</label>
                                            <div class="col-sm-8" style="margin-left: -40px;">
                                                <select style = "width:300px;" class="form-control select2" name="country_id" id="countries" onchange="countrychange();" required="">
                                                    <option>Select Country</option>
                                                    <?php
                                                    $dba = new DBAdapter();
                                                    $sql = "select id,name from countries";
                                                    $result = mysqli_query($con, $sql);
//                                                    $data = $dba->getRow("countries", array("id", "name"), "1");
                                                    foreach ($result as $subData) {
                                                        echo "<option " . ($subData['id'] == $edata[0][8] ? 'selected' : '') . " value='" . $subData['id'] . "'>" . $subData['name'] . "</option> ";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-4 col-form-label">Select City</label>
                                            <div class="col-sm-8" id="city_list" style="margin-left: -40px;">
                                                <select style = "width:300px;" class="form-control select2" name="city_id" id="cities" required="">
                                                    <option>Select City</option>
                                                    <?php
                                                    $city = $edata[0][10];
                                                    $editdata = isset($_GET['type']);
                                                    if ($editdata == 1) {
                                                        $dba = new DBAdapter();
                                                        $data = $dba->getRow("cities", array("id", "name"), "country_id=" . $edata[0][8]);
                                                        foreach ($data as $subData) {
                                                            echo "<option " . ($subData[0] == $edata[0][9] ? 'selected' : '') . " value=" . $subData[0] . ">" . $subData[1] . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light"  data-toggle="modal" onClick="addParty(); getparty();">Save changes</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </div>
                <div class="col-sm-6 col-md-3 m-t-30">
                    <div class="modal fade" id="additem" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title mt-0">Add New Item</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <form action="javascript:void(0);" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" onsubmit="addItem();" >
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-4 col-form-label">Select Category</label>
                                            <div class="col-sm-6" id="category12" style="margin-left: -40px;">
                                                <select style = "width:220px;" class="form-control select2" name="cat_id" id="main_category" required="">
                                                    <option>Select Category</option>
                                                    <?php
                                                    $dba = new DBAdapter();
                                                    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                    $data = $dba->getRow("main_category", array("id", "name"), "1");
                                                    foreach ($data as $subData) {
                                                        echo "<option " . ($subData[0] == $edata[0][3] ? 'selected' : '') . " value='" . $subData[0] . "'>" . $subData[1] . "</option> ";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <a href="#addmaincategory" data-toggle="modal" class="btn btn-primary btn-sm" data-dismiss="modal">...</a>

                                        </div>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-3 col-form-label">Item Name</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" type="text"  placeholder="Item Name" id="item_name" name="item_name" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][1] : '') ?>" this.value = this.defaultValue;" onfocus="if (this.value == this.defaultValue)
                                                        this.value = '';" required="">
                                                <div id="item-msg" class="text-danger"></div>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-3 col-form-label">HSN Code</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" type="text"  placeholder="HSN Code" id="hsn_code" name="hsn_code" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][7] : ''); ?>" required="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-3 col-form-label">Remark</label>
                                            <div>
                                                <textarea required class="form-control" name="remark" rows="2" cols="32" style="margin-left: 15px;"><?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][5] : '') ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-3 col-form-label">Select Unit</label>
                                            <div class="col-sm-8">
                                                <select style = "width:300px;" class="form-control select2" name="item_unit_id" id="unit_list" required="">
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
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light"  data-toggle="modal" onClick="addItem();">Save changes</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </div>
                <div class="col-sm-6 col-md-3 m-t-30">
                    <div class="modal fade" id="addmaincategory" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title mt-0">Add New Category</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <form action="javascript:void(0);" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" onsubmit="addmainCategory();" >
                                        <div class="form-group row" style="margin-left: -20px;">
                                            <label for="example-text-input" class="col-sm-4 col-form-label">Category Name</label>
                                            <div class="col-sm-6">                                        
                                                <input class="form-control" type="text"  placeholder="Category Name" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][1] : '') ?>" name="name" id="name" required="">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="btnparty" data-toggle="modal" onClick="addmainCategory(); getmainCategory();">Save changes</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </div>
                <?php include 'footer.php'
                ?>

            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->


        <!-- jQuery  -->
        <script type="text/javascript" src="customFile/AllCalculationFun.js"></script>
        <script src="customFile/createitemJs.js"></script>
        <script src="customFile/createsubcategoryJs.js"></script>
        <script src="customFile/createmaincategoryJs.js"></script>
        <script src="customFile/createpartyJs.js"></script>
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
        <!--<script src="plugins/datatables/jquery.dataTables.min.js"></script>-->

        <!-- Plugins Init js -->
        <script src="assets/pages/form-advanced.js"></script>
        <!-- App js -->
        <script src="assets/js/app.js"></script>
        <script type="text/javascript">
                                        $(function ()
                                        {
                                            $('#form_data').submit(function () {
                                                $("input[type='submit']", this)
                                                        .val("Please Wait...")
                                                        .attr('disabled', 'disabled');
                                                return true;
                                            });
                                        });
        </script>
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


            function getmainCategory() {

                $.ajax({
                    url: 'getNewmainCategory.php',
                    dataType: "html",
                    cache: false,
                    success: function (Data) {
                        //alert(Data);

                        $('#category12').html(Data);
                        //$('#addsubcategory').model('show');
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
            function deleterow(inquiry_id)
            {
    //                alert(inquiry_id);

                var values = document.querySelector('.case:checked').value;
                var rowattri = document.getElementById('row' + values).getAttribute('data');
                var n = 1;
                var count = $('#view_data1 tr ').length;

                for (var i = 1; i <= count; ++i) {

                    var snumber = document.getElementById('snum' + i);
                    var cb = document.getElementById('check' + i);
                    var iqnty = document.getElementById('qnty' + i);
                    var icode = document.getElementById('item_code' + i);
                    var iunit = document.getElementById('unit' + i);
                    var rowid = document.getElementById('row' + i);

                    if (cb.checked) {
                        if (rowattri === 'no') {
                            $('.case:checkbox:checked').parents("tr").remove();
                        } else {
                            var id = document.getElementById('i_id' + values).value;
    //                            alert(id);
                            var my_object = {"i_list_id": id, "inquiry_id": inquiry_id};
                            $.ajax({
                                url: 'Delete.php',
                                dataType: "html",
                                data: my_object,
                                cache: false,
                                success: function (Data) {
                                    $('.case:checkbox:checked').parents("tr").remove();
    //                                    alert(Data);
                                    var rowcount = <?php echo (isset($_GET['type']) && isset($_GET['id']) ? $countrow[0][0] : '0') ?>;
                                    document.getElementById("row_count").value = rowcount - 1;
    //                                    alert(rowcount);
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
                        iunit.id = 'unit' + n;
                        rowid.id = 'row' + n;
                        n++;
                    }
                }
            }
            ;


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