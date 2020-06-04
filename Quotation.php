<?php
ob_start();
include_once 'shreeLib/DBAdapter.php';
include_once 'shreeLib/dbconn.php';
include './shreeLib/session_info.php';
if (isset($_GET['type']) && isset($_GET['id'])) {

    $edba = new DBAdapter();
    $edata = $edba->getRow("add_quotation", array("*"), "id=" . $_GET['id']);
    echo "<input type='hidden' id='add_quotation_id' value='" . $_GET['id'] . "'>";

    $field1 = array("COUNT(mod_id)");
    $countrow = $edba->getRow("role_rights", $field1, "user_id=" . $_GET['id']);
    echo "<input type='hidden' id='rowcount' value='" . $countrow[0][0] . "'>";
}
if (isset($_GET['inquiry_id'])) {
//    echo'<br><br><br><br><br><br>';
    $id = $_GET['inquiry_id'];
//    echo $id;
    $order_data = new DBAdapter();
    $field = array("inquiry_item_list.id,inquiry_item_list.inq_id,create_item.item_name,unit_list.unit_name,inquiry_item_list.item_quantity,inquiry.reference_no,inquiry.party_id,inquiry.user_id");
    $orderdata = $order_data->getRow("inquiry INNER JOIN inquiry_item_list ON inquiry.id=inquiry_item_list.inq_id INNER JOIN create_item ON inquiry_item_list.item_id=create_item.id INNER JOIN unit_list ON create_item.item_unit_id=unit_list.id", $field, "inquiry_item_list.id=" . $id);
}
if (isset($_SESSION['user_id'])) {
    $edba = new DBAdapter();
    $servername1 = basename($_SERVER['PHP_SELF']);
    $field = array("role_rights.id");
    $mod_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " module.mod_pagename='" . $servername1 . "' and role_rights.role_id=" . $_SESSION['user_id']);
    echo "<input type='hidden' id='role_id' value='" . $mod_data[0][0] . "'>";

    $field = array("role_rights.id,role_rights.role_edit,role_rights.role_delete,role_rights.role_create");
    $role_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " role_rights.id=" . $mod_data[0][0]);
    echo "<input type='hidden' id='role_id' value='" . $role_data[0][3] . "'>";
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
                echo 'Edit Quotation';
            } else {
                echo 'Add New Quotation';
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
            .snum{width: 20px;}
            #container{margin-left:180px;}
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
                                    <h4 class="page-title">Add Quotation</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        <?php
                        if (isset($_GET['inquiry_id'])) {
                            $id = $_GET['inquiry_id'];
//                            echo $id;
                            ?>
                            <div class="page-content-wrapper">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card m-b-20">
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <h4><b><?php // echo (isset($_GET['inquiry_id']) ? 'Ad Quotation' : '') ?></b></h4>
                                                        <?php
                                                        if (isset($_GET['inquiry_id'])) {
                                                            ?>
                                                            <div class="short" style=" margin-top:-20px;">
                                                                <button type="button" style="float: right;" id="enable" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#addsupplier"><b>Add New Supplier</b></button>
                                                            </div>                                      
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <div class="short" style=" margin-bottom:50px;">
                                                                <button type="button" style="float: right;" id="enable" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#addsupplier"><b>Add New Supplier</b></button>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>


                                                <form action="customFile/AddQuotationPro.php" id="form_data" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" >  

                                                    <div class="form-group row">
                                                        <input type="hidden" name="inquiry_item_id" value="<?php
                                                        if (isset($_GET['id'])) {
                                                            echo ( isset($_GET['type']) && isset($_GET['id']) ? $edata[0][1] : '');
                                                        } elseif (isset($_GET['inquiry_id'])) {
                                                            echo $orderdata[0][0];
                                                        } else {
                                                            echo '';
                                                        }
                                                        ?>"/>
                                                        <input type="hidden" name="inquiry_id" value="<?php
                                                        if (isset($_GET['id'])) {
                                                            echo ( isset($_GET['type']) && isset($_GET['id']) ? $edata[0][2] : '');
                                                        } elseif (isset($_GET['inquiry_id'])) {
                                                            echo $orderdata[0][1];
                                                        } else {
                                                            echo '';
                                                        }
                                                        ?>"/>
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">Select Party</label>
                                                        <div class="col-sm-4" id="supplierlist">
                                                            <select class="form-control select2" name="supplier_id" id="supplier" required="">
                                                                <option>Select Supplier</option>
                                                                <?php
                                                                $dba = new DBAdapter();
                                                                $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                                $data = $dba->getRow("supplier", array("id", "sup_name"), "1");
                                                                foreach ($data as $subData) {

                                                                    echo" <option " . ($subData[0] == $edata[0][3] ? 'selected' : '') . " value='" . $subData[0] . "'>" . $subData[1] . "</option> ";
                                                                }
                                                                ?>
                                                            </select>

                                                        </div>
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">Item Name</label>
                                                        <div class="col-sm-4">
                                                            <input class="form-control" type="text"  placeholder="Item Name" value="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo ( isset($_GET['type']) && isset($_GET['id']) ? $edata[0][4] : '');
                                                            } elseif (isset($_GET['inquiry_id'])) {
                                                                echo $orderdata[0][2];
                                                            } else {
                                                                echo '';
                                                            }
                                                            ?>" name="item_name" id="item_name" required="">
                                                        </div>
                                                        <input type="hidden" value="<?php
                                                        if (isset($_GET['id'])) {
                                                            echo ( isset($_GET['type']) && isset($_GET['id']) ? $edata[0][13] : '');
                                                        } elseif (isset($_GET['inquiry_id'])) {
                                                            echo $orderdata[0][5];
                                                        } else {
                                                            echo '';
                                                        }
                                                        ?>" name="reference_no" id="reference_no" class="form-control"required>
                                                        <input type="hidden" value="<?php
                                                        if (isset($_GET['id'])) {
                                                            echo ( isset($_GET['type']) && isset($_GET['id']) ? $edata[0][14] : '');
                                                        } elseif (isset($_GET['inquiry_id'])) {
                                                            echo $orderdata[0][6];
                                                        } else {
                                                            echo '';
                                                        }
                                                        ?>" name="party_id" id="party_id" class="form-control"required>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">Select Unit</label>
                                                        <div class="col-sm-4">
                                                            <select class="form-control select2" name="unit" id="unit_list" required="">
                                                                <option>Select Unit</option>
                                                                <?php
                                                                $dba = new DBAdapter();
                                                                $data = $dba->getRow("unit_list", array("id", "unit_name"), "1");
                                                                foreach ($data as $subData) {
                                                                    if (isset($_GET['id'])) {
                                                                        echo " <option " . ($subData[1] == $edata[0][5] ? 'selected' : '') . " value='" . $subData[1] . "'>" . $subData[1] . "</option> ";
                                                                    } elseif (isset($_GET['inquiry_id'])) {
                                                                        echo " <option " . ($subData[1] == $orderdata[0][3] ? 'selected' : '') . " value='" . $subData[1] . "'>" . $subData[1] . "</option> ";
                                                                    } else {
                                                                        echo" <option " . ($subData[0] == $edata[0][5] ? 'selected' : '') . " value='" . $subData[0] . "'>" . $subData[1] . "</option> ";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>

                                                        </div>
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">QTY.</label>
                                                        <div class="col-sm-4">
                                                            <input class="form-control" type="text"  placeholder="Item Qty." value="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo ( isset($_GET['type']) && isset($_GET['id']) ? $edata[0][6] : '');
                                                            } elseif (isset($_GET['inquiry_id'])) {
                                                                echo $orderdata[0][4];
                                                            } else {
                                                                echo '';
                                                            }
                                                            ?>" name="qty" id="qty" required="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">

                                                        <label for="example-text-input" class="col-sm-2 col-form-label">Rate</label>
                                                        <div class="col-sm-4">
                                                            <input class="form-control" type="text"  placeholder="Item Rate" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][7] : '') ?>" name="rate" id="rate" required="">
                                                        </div>
                                                        <label for="example-date-input" class="col-sm-2 col-form-label">Date</label>
                                                        <div class="col-sm-4">
                                                            <input class="form-control"  id="datevalue" type="date" id="datevalue" value="<?php echo ( isset($_GET['type']) && isset($_GET['id']) ? $edata[0][8] : '') ?>" name="quotation_date" id="quotation_date" id="example-date-input"  required="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">

                                                        <label for="example-text-input" class="col-sm-2 col-form-label">Remark</label>
                                                        <div class="col-sm-4">
                                                            <input class="form-control" type="text"  placeholder="Remark" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][9] : '') ?>" name="remark" id="remark">
                                                        </div>
                                                    </div>
                                                    <input class="form-control" type="hidden"   value="<?php echo (isset($_GET['inquiry_id']) ? $orderdata[0][7] : ''); ?>" name="user_id" id="user_id">

                                                    <div class="button-items">
                                                        <input type="hidden" name="action" id="action" value="<?php echo (isset($_GET['id']) ? 'edit' : 'add') ?>"/>
                                                        <input type="hidden" name="id" id="id" value="<?php echo (isset($_GET['id']) ? $_GET['id'] : '') ?>"/>
                                                        <button type="submit" id="btn_save" class="btn btn-primary waves-effect waves-light"><?php echo (isset($_GET['type']) && isset($_GET['id']) ? 'Edit' : 'Save') ?></button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <!--end row-->


                            </div>
                            <?php
                        } elseif (isset($_GET['type']) && isset($_GET['id'])) {
                            ?>
                            <div class="page-content-wrapper">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card m-b-20">
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <h4><b><?php echo (isset($_GET['id']) ? 'Edit Quotation' : '') ?></b></h4>
                                                        <?php
                                                        if (isset($_GET['id'])) {
                                                            ?>
                                                            <div class="short" style=" margin-top: -50px">
                                                                <button type="button" style="float: right;" id="enable" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#addsupplier"><b>Add New Supplier</b></button>
                                                            </div>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <div class="short" style=" margin-bottom:50px;">
                                                                <button type="button" style="float: right;" id="enable" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#addsupplier"><b>Add New Supplier</b></button>
                                                            </div>          
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                                if (isset($_GET['id'])) {
                                                    ?>
                                                    <form action="customFile/AddQuotationPro.php" style="" id="form_data" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" >  
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <form action="customFile/AddQuotationPro.php" id="form_data" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" >  
                                                            <?php
                                                        }
                                                        ?>
                                                        <div class="form-group row">
                                                            <input type="hidden" name="inquiry_item_id" value="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo ( isset($_GET['type']) && isset($_GET['id']) ? $edata[0][1] : '');
                                                            } elseif (isset($_GET['inquiry_id'])) {
                                                                echo $orderdata[0][0];
                                                            } else {
                                                                echo '';
                                                            }
                                                            ?>"/>
                                                            <input type="hidden" name="inquiry_id" value="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo ( isset($_GET['type']) && isset($_GET['id']) ? $edata[0][2] : '');
                                                            } elseif (isset($_GET['inquiry_id'])) {
                                                                echo $orderdata[0][1];
                                                            } else {
                                                                echo '';
                                                            }
                                                            ?>"/>
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">Select Party</label>
                                                            <div class="col-sm-4" id="supplierlist">
                                                                <select class="form-control select2" name="supplier_id" id="supplier" required="">
                                                                    <option>Select Supplier</option>
                                                                    <?php
                                                                    $dba = new DBAdapter();
                                                                    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                                    $data = $dba->getRow("supplier", array("id", "sup_name"), "1");
                                                                    print_r($data);
                                                                    foreach ($data as $subData) {

                                                                        echo" <option " . ($subData[0] == $edata[0][3] ? 'selected' : '') . " value='" . $subData[0] . "'>" . $subData[1] . "</option> ";
                                                                    }
                                                                    ?>
                                                                </select>

                                                            </div>
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">Item Name</label>
                                                            <div class="col-sm-4">
                                                                <input class="form-control" type="text"  placeholder="Item Name" value="<?php
                                                                if (isset($_GET['id'])) {
                                                                    echo ( isset($_GET['type']) && isset($_GET['id']) ? $edata[0][4] : '');
                                                                } elseif (isset($_GET['inquiry_id'])) {
                                                                    echo $orderdata[0][2];
                                                                } else {
                                                                    echo '';
                                                                }
                                                                ?>" name="item_name" id="item_name" required="">
                                                            </div>
                                                            <input type="hidden" value="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo ( isset($_GET['type']) && isset($_GET['id']) ? $edata[0][13] : '');
                                                            } elseif (isset($_GET['inquiry_id'])) {
                                                                echo $orderdata[0][5];
                                                            } else {
                                                                echo '';
                                                            }
                                                            ?>" name="reference_no" id="reference_no" class="form-control"required>
                                                            <input type="hidden" value="<?php
                                                            if (isset($_GET['id'])) {
                                                                echo ( isset($_GET['type']) && isset($_GET['id']) ? $edata[0][14] : '');
                                                            } elseif (isset($_GET['inquiry_id'])) {
                                                                echo $orderdata[0][6];
                                                            } else {
                                                                echo '';
                                                            }
                                                            ?>" name="party_id" id="party_id" class="form-control"required>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">Select Unit</label>
                                                            <div class="col-sm-4">
                                                                <select class="form-control select2" name="unit" id="unit_list" required="">
                                                                    <option>Select Unit</option>
                                                                    <?php
                                                                    $dba = new DBAdapter();
                                                                    $data = $dba->getRow("unit_list", array("id", "unit_name"), "1");
                                                                    foreach ($data as $subData) {
                                                                        if (isset($_GET['id'])) {
                                                                            echo " <option " . ($subData[1] == $edata[0][5] ? 'selected' : '') . " value='" . $subData[1] . "'>" . $subData[1] . "</option> ";
                                                                        } elseif (isset($_GET['inquiry_id'])) {
                                                                            echo " <option " . ($subData[1] == $orderdata[0][3] ? 'selected' : '') . " value='" . $subData[1] . "'>" . $subData[1] . "</option> ";
                                                                        } else {
                                                                            echo" <option " . ($subData[0] == $edata[0][5] ? 'selected' : '') . " value='" . $subData[0] . "'>" . $subData[1] . "</option> ";
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>

                                                            </div>
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">QTY.</label>
                                                            <div class="col-sm-4">
                                                                <input class="form-control" type="text"  placeholder="Item Qty." value="<?php
                                                                if (isset($_GET['id'])) {
                                                                    echo ( isset($_GET['type']) && isset($_GET['id']) ? $edata[0][6] : '');
                                                                } elseif (isset($_GET['inquiry_id'])) {
                                                                    echo $orderdata[0][4];
                                                                } else {
                                                                    echo '';
                                                                }
                                                                ?>" name="qty" id="qty" required="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">

                                                            <label for="example-text-input" class="col-sm-2 col-form-label">Rate</label>
                                                            <div class="col-sm-4">
                                                                <input class="form-control" type="text"  placeholder="Item Rate" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][7] : '') ?>" name="rate" id="rate" required="">
                                                            </div>
                                                            <label for="example-date-input" class="col-sm-2 col-form-label">Date</label>
                                                            <div class="col-sm-4">
                                                                <input class="form-control"  id="datevalue" type="date" id="datevalue" value="<?php echo ( isset($_GET['type']) && isset($_GET['id']) ? $edata[0][8] : '') ?>" name="quotation_date" id="quotation_date" id="example-date-input"  required="">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">

                                                            <label for="example-text-input" class="col-sm-2 col-form-label">Remark</label>
                                                            <div class="col-sm-4">
                                                                <input class="form-control" type="text"  placeholder="Remark" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][9] : '') ?>" name="remark" id="remark">
                                                            </div>
                                                        </div>
                                                        <input class="form-control" type="hidden"   value="<?php echo (isset($_GET['inquiry_id']) ? $orderdata[0][7] : ''); ?>" name="user_id" id="user_id">

                                                        <div class="button-items">
                                                            <input type="hidden" name="action" id="action" value="<?php echo (isset($_GET['id']) ? 'edit' : 'add') ?>"/>
                                                            <input type="hidden" name="id" id="id" value="<?php echo (isset($_GET['id']) ? $_GET['id'] : '') ?>"/>
                                                            <button type="submit" id="btn_save" class="btn btn-primary waves-effect waves-light"><?php echo (isset($_GET['type']) && isset($_GET['id']) ? 'Edit' : 'Save') ?></button>
                                                        </div>
                                                    </form>

                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <!--end row-->


                            </div>
                        <?php } ?>
                        <!--end page content-->

                    </div> <!--container-fluid -->

                </div> <!--content -->
                <div class="col-sm-6 col-md-3 m-t-30">
                    <div class="modal fade" id="addsupplier" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title mt-0">Add New Supplier</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <form action="javascript:void(0);" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" onsubmit="addParty();" >
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-4 col-form-label">Supplier Name</label>
                                            <div class="col-sm-7">
                                                <input class="form-control" type="text"  placeholder="Supplier Name" id="sup_name" name="sup_name" value="" required="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-4 col-form-label">Supplier Address</label>
                                            <div class="col-sm-7">
                                                <input class="form-control" type="text"  placeholder="Supplier Address" id="sup_add" name="sup_add" value="" required="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-4 col-form-label">Supplier Contact</label>
                                            <div class="col-sm-7">  
                                                <input class="form-control" type="text"  placeholder="Supplier Contact" id="sup_contact" name="sup_contact" value="" required="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-4 col-form-label">Supplier Email</label>
                                            <div class="col-sm-7">
                                                <input class="form-control" type="text"  placeholder="Supplier Email" id="sup_email" name="sup_email" value="" required="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-4 col-form-label">GST No.</label>
                                            <div class="col-sm-7">
                                                <input class="form-control" type="text"  placeholder="GST No." id="sup_gstno" name="sup_gstno" value="" required="">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-5 col-form-label">Select Country</label>
                                            <div class="col-sm-7" style="margin-left: -40px;">
                                                <select style = "width:250px;" class="form-control select2" name="country_id" id="countries" onchange="countrychange();" required="">
                                                    <option>Select Country</option>
                                                    <?php
                                                    $dba = new DBAdapter();
                                                    $sql = "select id,name from countries";
                                                    $result = mysqli_query($con, $sql);
//                                                    $data = $dba->getRow("countries", array("id", "name"), "1");
                                                    foreach ($result as $subData) {
                                                        echo "<option value='" . $subData['id'] . "'>" . $subData['name'] . "</option> ";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-5 col-form-label">Select City</label>
                                            <div class="col-sm-7" id="city_list" style="margin-left: -40px;">
                                                <select style = "width:250px;" class="form-control select2" name="city_id" id="cities" required="">
                                                    <option>Select City</option>

                                                    <?php
                                                    $city = $edata[0][10];
                                                    $editdata = isset($_GET['type']);
                                                    if ($editdata == 1) {
                                                        $dba = new DBAdapter();
                                                        $data = $dba->getRow("cities", array("id", "name"), "country_id=" . $edata[0][9]);
                                                        foreach ($data as $subData) {
                                                            echo "<option value=" . $subData[0] . ">" . $subData[1] . "</option>";
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
                                    <button type="submit" class="btn btn-primary waves-effect waves-light"  data-toggle="modal" onclick="addSupplier(); getsupplier();">Save changes</button>
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
        <script src="customFile/createsupplier.js"></script>

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
        <script src="assets/pages/datatables.init.js"></script>

        <!-- Plugins Init js -->
        <script src="assets/pages/form-advanced.js"></script>
        <!-- App js -->
        <script src="assets/js/app.js"></script>

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
        <script type="text/javascript">

            function sumvalue(i) {
                var qnty = document.getElementById("qnty" + i).value;
                var label = document.getElementById("dbstock" + i).value;
                var totalstock = parseInt(label) + parseInt(qnty);
                $('#itemstock' + i).text(totalstock);
            }
            ;
            function getsupplier() {

                $.ajax({
                    url: 'getNewSupplier.php',
                    dataType: "html",
                    cache: false,
                    success: function (Data) {
                        // alert(Data);
                        $('#supplierlist').html(Data);
                    },
                    error: function (errorThrown) {
                        alert(errorThrown);
                        alert("There is an error with AJAX!");
                    }
                });
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
                var values = $('input:checked').map(function () {
                    return this.value;
                }).get();
                //alert(values);
                var rowattri = document.getElementById('row' + values).getAttribute('data');
                //alert(rowattri);
                //            var totalamount = 0;
                var n = 1;
                var count = $('#view_data1 tr ').length;
                //alert(count);
                //var amtremove = parseFloat(document.getElementById('total' + values).value);

                for (var i = 1; i <= count; ++i) {

                    //                var amt = parseFloat(document.getElementById('total' + i).value);
                    //                totalamount = totalamount + amt;

                    var snumber = document.getElementById('snum' + i);
                    //alert(snumber);
                    //                var totaln = document.getElementById('total' + i);
                    var cb = document.getElementById('check' + i);
                    //alert(cb);
                    var iqnty = document.getElementById('qnty' + i);
                    //var icode = document.getElementById('item_code' + i);
                    //                var irate = document.getElementById('rate' + i);
                    //                var isubtotal = document.getElementById('sub_total' + i);
                    //                var igst = document.getElementById('gst' + i);
                    var iunit = document.getElementById('unit' + i);
                    var rowid = document.getElementById('row' + i);
                    //                var idbstock = document.getElementById('dbstock' + i);
                    //                var itemstock = document.getElementById('itemstock' + i);

                    if (cb.checked) {

                        if (rowattri === 'no') {
                            // alert(rowattri);
                            $('.case:checkbox:checked').parents("tr").remove();
                            // document.getElementById("txt_total").value = parseFloat(totalamount - amtremove).toFixed(2);

                        } else {
                            var id = document.getElementById('i_id' + values).value;
                            //print(id);
                            var my_object = {"i_list_id": id, "inquiry_id": inquiry_id};
                            $.ajax({
                                url: 'Delete.php',
                                dataType: "html",
                                data: my_object,
                                cache: false,
                                success: function (Data) {
                                    //alert(Data);
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
                        //                    icode.id = 'item_code' + n;
                        iqnty.id = 'qnty' + n;
                        //                    totaln.id = 'total' + n;
                        //                    irate.id = 'rate' + n;
                        //                    isubtotal.id = 'sub_total' + n;
                        //                    igst.id = 'gst' + n;
                        //                        iname.id = 'item_name' + n;
                        iunit.id = 'unit' + n;
                        rowid.id = 'row' + n;
                        //                    itemstock.id = 'itemstock' + n;
                        //                    idbstock.id = 'dbstock' + n;

                        n++;
                    }
                }
                //            document.getElementById("txt_total").value = parseFloat(totalamount - amtremove).toFixed(2);
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