<?php
//ob_start();
include './shreeLib/session_info.php';
include_once 'shreeLib/DBAdapter.php';
if (isset($_GET['type']) && isset($_GET['id'])) {

    $edba = new DBAdapter();
    $field = array("create_item.id, create_item.item_name, main_category.name, create_item.item_unit_id, unit_list.unit_name, create_item.remark, create_item.cat_id,create_item.hsn_code");
    $edata = $edba->getRow("unit_list INNER JOIN create_item ON unit_list.id=create_item.item_unit_id INNER JOIN main_category ON create_item.cat_id=main_category.id", $field, "create_item.id=" . $_GET['id']);
    //echo $edata[0][6];
    echo "<input type='hidden' id='item_id' value='" . $_GET['id'] . "'>";
}
if (isset($_SESSION['user_id'])) {

    $edba = new DBAdapter();
    $servername1 = basename($_SERVER['PHP_SELF']);
    $field = array("role_rights.id");
    $data = $dba->getLastID("roles_id", "create_user", "id=" . $_SESSION['user_id']);

    $mod_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " module.mod_pagename='" . $servername1 . "' and role_rights.role_id=" . $data);
    echo "<input type='hidden' id='role_id' value='" . $mod_data[0][0] . "'>";


    $field = array("role_rights.id,role_rights.role_edit,role_rights.role_delete,role_rights.role_create,role_rights.mod_id");
    $role_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " role_rights.id=" . $mod_data[0][0]);
    echo "<input type='hidden' id='role_id' value='" . $role_data[0][0] . "'>";
    // echo $role_data[0][4];
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title><?php
            if (isset($_GET['type']) && isset($_GET['id'])) {
                echo 'Edit Items';
            } else {
                echo 'Add Items';
            }
            ?></title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="Themesbrand" name="author" />
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <link href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
        <link href="plugins/bootstrap-md-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
        <link href="plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">

        <link href="plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
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
                                    <h4 class="page-title">Create Items</h4>
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
                                                    <h4><b><?php echo (isset($_GET['id']) ? 'Edit Items' : '') ?></b></h4>
                                                    <?php
                                                    if (isset($_GET['id'])) {
                                                        ?>
                                                        <button type="button"  style="float: right;margin-top: -50px"id="enable" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#addmaincategory"><b>Create Category</b></button><br><br>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <button type="button"  style="float: right;"id="enable" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#addmaincategory"><b>Create Category</b></button><br><br>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <?php
                                            if (isset($_GET['id'])) {
                                                ?>
                                                <form action="" style="margin-top: -50px" id="form_data" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" >  
                                                    <?php
                                                } else {
                                                    ?>
                                                    <form action="" id="form_data" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" >  
                                                        <?php
                                                    }
                                                    ?>
                                                    <div class="form-group row">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">Select Category</label>
                                                        <div class="col-sm-4" id="type1">
                                                            <select class="form-control select2" name="cat_id" id="main_category" onchange="item_val();" required="">
                                                                <option>Select Category</option>
                                                                <?php
                                                                $dba = new DBAdapter();
                                                                $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                                $data = $dba->getRow("main_category", array("id", "name"), "1");
                                                                foreach ($data as $subData) {
                                                                    //echo $subData[0];
                                                                    echo "<option " . ($subData[0] == $edata[0][6] ? 'selected' : '') . " value='" . $subData[0] . "'>" . $subData[1] . "</option> ";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">Item Name</label>
                                                        <div class="col-sm-4">
                                                            <input class="form-control" type="text"  placeholder="Item Name" id="item_name" name="item_name" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][1] : '') ?>" this.value = this.defaultValue;" onfocus="if (this.value == this.defaultValue)
                                                                    this.value = '';" required="" onfocusout="item_val();">
                                                            <div id="item-msg" class="text-danger"></div>

                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">HSN Code</label>
                                                        <div class="col-sm-4">
                                                            <input class="form-control" type="text"  placeholder="HSN Code" id="hsn_code" name="hsn_code" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][7] : ''); ?>">
                                                        </div>
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">Remark</label>
                                                        <div>
                                                            <textarea  class="form-control" name="remark" id="remark" rows="2" cols="32" style="margin-left: 15px;"><?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][5] : '') ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">Select Unit</label>
                                                        <div class="col-sm-4">
                                                            <select class="form-control select2" name="item_unit_id" id="unit_list" required="">
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
                                                    <div class="button-items">
                                                        <input type="hidden" name="action" id="action" value="<?php echo (isset($_GET['id']) ? 'edit' : 'add') ?>"/>
                                                        <input type="hidden" name="id" id="id" value="<?php echo (isset($_GET['id']) ? $_GET['id'] : '') ?>"/>
                                                        <button type="submit" id="btn_save" class="btn btn-primary waves-effect waves-light">Save</button>
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

                                            <h4 class="mt-0 header-title">View of Items</h4><br>
                                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Item Name</th>
                                                        <th>Category</th>
                                                        <th>Item Unit</th>
                                                        <th>HSN Code</th>
                                                        <?php if ($role_data[0][1] == 1) { ?>
                                                            <th>Edit</th> <?php } ?>
                                                        <?php if ($role_data[0][2] == 1) { ?> <th>Delete</th><?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody id="item_list">
                                                    <?php
                                                    include_once 'shreeLib/DBAdapter.php';
                                                    $dba = new DBAdapter();

                                                    //$last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);

                                                    $field = array("create_item.id,create_item.item_name,main_category.name,unit_list.unit_name,create_item.hsn_code");
                                                    $data = $dba->getRow("(create_item INNER JOIN unit_list ON unit_list.id=create_item.item_unit_id) INNER JOIN main_category ON create_item.cat_id=main_category.id", $field, "1");
                                                    $count = count($data);
                                                    if ($count >= 1) {
                                                        foreach ($data as $subData) {
                                                            echo "<tr>";
                                                            echo "<td>" . $subData[0] . "</td>";
                                                            echo "<td>" . ucwords($subData[1]) . "</td>";
                                                            echo "<td>" . $subData[2] . "</td>";
                                                            echo "<td>" . $subData[3] . "</td>";
                                                            echo "<td>" . $subData[4] . "</td>";
                                                            if ($role_data[0][1] == 1) {
                                                                echo "<td><a href='Items.php?type=edit&id=" . $subData[0] . "' target='_blank' class='btn btn-primary' id='" . $subData[0] . "'><i class='fa fa-edit'></i> Edit</a></td>";
                                                            }
                                                            if ($role_data[0][2] == 1) {
                                                                echo "<td> <button class='btn btn-danger btn_delete' id='" . $subData[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash'>  Delete</button></td>";
                                                            }
                                                            echo '</tr>';
                                                        }
                                                    } else {
                                                        //echo 'No Data Available';
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div>
                            <!--end row-->


                        </div>

                        <!--end page content-->

                    </div> <!--container-fluid -->

                </div> <!--content -->
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
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-4 col-form-label">Category Name</label>
                                            <div class="col-sm-6">                                        
                                                <input class="form-control" type="text"  placeholder="Category Name" value="" name="name" id="name" required="">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light"  data-toggle="modal" onClick="addmainCategory(); getmainCategory();">Save changes</button>
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
        <script src="customFile/createmaincategoryJs.js"></script>
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
        <script src="plugins/sweet-alert2/sweetalert2.min.js"></script>
        <script src="assets/pages/sweet-alert.init.js"></script>
        <script src="assets/pages/datatables.init.js"></script>

        <!-- Plugins Init js -->
        <script src="assets/pages/form-advanced.js"></script>
        <!-- App js -->
        <script src="assets/js/app.js"></script>
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
        <script type="text/javascript">
            $("#btn_save").on('click', function () {
                var main_category = document.getElementById("main_category").value;
                var item_name = document.getElementById("item_name").value;
                var hsn_code = document.getElementById("hsn_code").value;
                var remark = document.getElementById("remark").value;
                var unit_list = document.getElementById("unit_list").value;
                var act = document.getElementById("action").value;
                var eid = document.getElementById("id").value;
                alert(act);
                var dataString = {"cat_id": main_category, "item_name": item_name, "item_unit_id": unit_list, "remark": remark, "hsn_code": hsn_code, "action": act, "id": eid};
                $.ajax
                        ({
                            url: "customFile/addItemPro.php",
                            datatype: "html",
                            data: dataString,
                            cache: false,
                            success: function (Data)
                            {
//                                                            alert(Data);
                                alert("Success");
                            }

                        });
            });

        </script>
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
            function item_val() {
                var itemname = document.getElementById("item_name").value;
                if (itemname !== '') {
                    var cat = document.getElementById("main_category").value;
//                                                alert(cat);
                    if (cat !== 'Select Category') {
                        var itemname = document.getElementById("item_name").value;
                        //alert(itemname);
                        var my_object = {"category": cat, "item": itemname};
                        //alert(my_object);
                        $.ajax({
                            url: 'validation.php',
                            dataType: "html",
                            data: my_object,
                            cache: false,
                            success: function (Data) {
                                //  alert(Data);
                                var useri = Data;
                                if (useri == 1) {
                                    $("#item-msg").text("This item name already exist in this category!");
                                    $("#btn_save").prop('disabled', true);
                                } else {
                                    $("#item-msg").text("");
                                    $("#btn_save").prop('disabled', false);
                                }

                            },
                            error: function (errorThrown) {
                                alert(errorThrown);
                                alert("There is an error with AJAX!");
                            }
                        });
                    } else
                    {
                        $("#item-msg").text("Plz...! Select any category!");
                    }
                }
            }
            ;
        </script>
        <script type="text/javascript">

            function getmainCategory() {

                $.ajax({
                    url: 'getNewmainCategory.php',
                    dataType: "html",
                    cache: false,
                    success: function (Data) {
                        //alert(Data);

                        $('#type1').html(Data);
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
        <script type="text/javascript">

            function SetForDelete(id) {
                location.href = "Delete.php?type=create_item&id=" + id;

            }
        </script>
    </body>

</html>