<?php
//ob_start();
include './shreeLib/session_info.php';

include_once 'shreeLib/DBAdapter.php';
if (isset($_GET['type']) && isset($_GET['id'])) {
    $edba = new DBAdapter();
    $field = array("create_item.id, create_item.item_name, sub_category.sub_cat_name, create_item.item_unit_id, unit_list.unit_name, create_item.remark, create_item.sub_cat_id");
    $edata = $edba->getRow("unit_list INNER JOIN create_item ON unit_list.id=create_item.item_unit_id INNER JOIN sub_category ON create_item.sub_cat_id=sub_category.id", $field, "create_item.id=" . $_GET['id']);

    echo "<input type='hidden' id='item_id' value='" . $_GET['id'] . "'>";
}
if (isset($_SESSION['user_id'])) {

    $edba = new DBAdapter();
    $servername1 = basename($_SERVER['PHP_SELF']);
    $field = array("role_rights.id");
    $mod_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " module.mod_pagename='" . $servername1 . "' and role_rights.user_id=" . $_SESSION['user_id']);
    echo "<input type='hidden' id='user_id' value='" . $mod_data[0][0] . "'>";


    $field = array("role_rights.id,role_rights.role_edit,role_rights.role_delete,role_rights.role_create");
    $role_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " role_rights.id=" . $mod_data[0][0]);
    echo "<input type='hidden' id='user_id' value='" . $role_data[0][0] . "'>";
}
?>
<!DOCTYPE html>
<html lang="en" class="no-js">

    <head>
        <title>
            Add Items
        </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="Moltera Ceramic Pvt.Ltd">
        <meta name="author" content="LPK Technosoft">
        <link href="assets/js/datatable/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
        <link href="assets/js/datatable/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css"> 
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
                                        <li><i class="fa fa-home"></i><a href="Home">Home</a></li>
                                        <li class="active">Add New Item</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="content">
                                <div class="main-header">
                                    <h2>Create Item</h2>
                                    <em>Add New</em>
                                </div>
                                <button type="submit" id="enable" class="btn btn-default btn-sm" data-toggle="modal" data-target="#addsubcategory"><b>Add New Sub Category</b></button><br><br>

                                <div class="main-content">
                                    <!-- WYSIWYG EDITOR -->
                                    <form action="customFile/addItemPro.php" id="form_data" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" >  
                                        <div class="form-group">
                                            <label for="ticket-name" class="col-sm-3 control-label" id="lblpartydue">Item Name</label>
                                            <div class="col-sm-3" id="partydue">
                                                <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][1] : '') ?>" name="item_name" id="item_name" class="form-control" placeholder="Item Name" required>
                                            </div>
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblcatname">Sub Category</label>
                                            <div class="col-sm-9" id="typelist1">

                                                <select name="sub_cat_id" id="sub_category" class="select2" required>
                                                    <option>Select Sub Category</option>
                                                    <?php
                                                    $dba = new DBAdapter();
                                                    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                    $data = $dba->getRow("sub_category", array("id", "sub_cat_name"), "sub_category.branch_id=" . $last_id);
                                                    foreach ($data as $subData) {
                                                        echo "<option " . ($subData[0] == $edata[0][6] ? 'selected' : '') . " value='" . $subData[0] . "'>" . $subData[1] . "</option> ";
                                                    }
                                                    ?>
                                                </select>
                                            </div>


                                        </div>
                                        <div class="form-group">
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblpartydue">Remark</label>
                                            <div class="col-sm-3">
                                                <textarea cols="1000"rows="2" value="" name="remark" id="remark" class="form-control" placeholder="Remark" required><?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][5] : '') ?></textarea>
                                            </div>
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblselectparty">Select Unit</label>
                                            <div class="col-sm-3" id="typelist">
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

                                        <div class="widget-footer">
<!--                                            <input type="hidden" name="user_info" id="user_info" value="<?php echo (isset($_SESSION['user_id']) ? $_SESSION['user_name'] : "") ?>"/>-->
                                            <input type="hidden" name="action" id="action" value="<?php echo (isset($_GET['id']) ? 'edit' : 'add') ?>"/>
                                            <input type="hidden" name="id" id="id" value="<?php echo (isset($_GET['id']) ? $_GET['id'] : "") ?>">
                                            <button type="submit" id="btn_save" class="btn btn-primary"><i class="fa fa-floppy-o"></i> <?php echo (isset($_GET['type']) && isset($_GET['id']) ? 'Edit' : 'Save') ?></button>
                                        </div>
                                    </form>
                                </div>

                                <div class="main-content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="widget widget-table">
                                                <div class="widget-header">
                                                    <h3><i class="fa fa-table"></i>Item List</h3>
                                                </div>
                                                <div class="widget-content">
                                                    <table id="featured-datatable" class="table table-sorting table-striped table-hover datatable">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>

                                                                <th>Item Name</th>
                                                                <th>Category</th>
                                                                <th>Item Unit</th>

                                                                <?php if ($role_data[0][1] == 1) { ?>
                                                                    <th>Edit</th> <?php } ?>
                                                                <?php if ($role_data[0][2] == 1) { ?> <th>Delete</th><?php } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="item_list">
                                                            <?php
                                                            include_once 'shreeLib/DBAdapter.php';
                                                            $dba = new DBAdapter();

                                                            $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);

                                                            $field = array("create_item.id,create_item.item_name,sub_category.sub_cat_name,unit_list.unit_name");
                                                            $data = $dba->getRow("(create_item INNER JOIN unit_list ON unit_list.id=create_item.item_unit_id) INNER JOIN sub_category ON create_item.sub_cat_id=sub_category.id", $field, "sub_category.branch_id=" . $last_id);
                                                            $count = count($data);
                                                            if ($count >= 1) {
                                                                foreach ($data as $subData) {
                                                                    // if ($userid == $subData[7]) {
                                                                    echo "<tr>";
                                                                    echo "<td>" . $subData[0] . "</td>";
                                                                    echo "<td>" . $subData[1] . "</td>";
                                                                    echo "<td>" . $subData[2] . "</td>";
                                                                    echo "<td>" . $subData[3] . "</td>";

                                                                    if ($role_data[0][1] == 1) {
                                                                        echo "<td><a href='AddItems.php?type=edit&id=" . $subData[0] . "' class='btn btn-primary' id='" . $subData[0] . "'><i class='fa fa-edit'></i> Edit</a></td>";
                                                                    }

                                                                    if ($role_data[0][2] == 1) {
                                                                        echo "<td> <button class='btn btn-danger btn_delete' id='" . $subData[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash-o'>  Delete</button></td>";
                                                                    }
                                                                    echo '</tr>';
                                                                }
                                                            } else {
                                                                //echo 'No Data Available';
                                                            }
                                                            ?>  
                                                        </tbody>
                                                    </table>
                                                </div><!-- /widget-content -->
                                            </div>
                                        </div>
                                    </div><!-- /row -->
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
        <div class="modal fade" id="addsubcategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                        <h4 class="modal-title" id="myModalLabel">Add New Sub Category</h4>

                    </div>

                    <div class="modal-body">                                        
                        <div id="form">
                            <form action="javascript:void(0);" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" onsubmit="addsubCategory();" >
                                <div class="form-group">
                                    <label for="ticket-name" class="col-sm-4 control-label" id="lblcatname">Select Main Category</label>
                                    <div class="col-sm-3" id="partylist2" style="width:300px;">
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
                                    <a href="#addmaincategory" data-toggle="modal" class="btn btn-primary btn-sm" data-dismiss="modal">...</a>

                                </div>
                                <div class="form-group">
                                    <label  for="ticket-name" class="col-sm-3 control-label" id="lblcatname">Category Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="sub_cat_name" id="sub_cat_name" class="form-control" placeholder="Category Name" required="">
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
                                    <button type="submit" class="btn btn-custom-primary" ><i class="fa fa-check-circle" ></i>Add</button>

                                </div>
                            </form>
                        </div>

                    </div>

                </div>

            </div>

        </div>
        <div class="modal fade" id="addmaincategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

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

        </div>
        <!-- FOOTER -->
        <footer class="footer">
            2018 © <a href="http://lpktechnosoft.com" target="_blank">LPK Technosoft</a>
        </footer>  
        <!-- END FOOTER -->
        <!-- Javascript -->
        <script src="customFile/createsubcategoryJs.js"></script>
        <script src="customFile/createmaincategoryJs.js"></script>
<!--        <script src="customFile/addItemJs.js"></script>-->
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
        <script src="assets/js/datatable/datatable-js/jquery.dataTables.min.js"></script>
        <script src="assets/js/datatable/datatable-js/dataTables.buttons.min.js"></script>
        <script src="assets/js/datatable/datatable-js/buttons.flash.min.js"></script>
        <script src="assets/js/datatable/datatable-js/pdfmake.min.js"></script>
        <script src="assets/js/datatable/datatable-js/jszip.min.js"></script>
        <script src="assets/js/datatable/datatable-js/vfs_fonts.js"></script>
        <script src="assets/js/datatable/datatable-js/buttons.html5.min.js"></script>        
        <script src="assets/js/datatable/datatable-js/buttons.print.min.js"></script>        
        <script>
                                $(document).ready(function () {
                                    $('#featured-datatable').DataTable({
                                        dom: 'Bfrtip',
                                        buttons: [
                                            'copy', 'csv', 'excel', 'pdf', 'print'
                                        ]
                                    });
                                });
        </script> 

        <script type="text/javascript">
            function getCategory() {

                $.ajax({
                    url: 'getNewsubCategory.php',
                    dataType: "html",
                    cache: false,
                    success: function (Data) {
                        //alert(Data);
                        $('#typelist1').html(Data);
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

                        $('#partylist2').html(Data);
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
                swal({
                    title: "Are you sure?",
                    text: "This will remove all data related to this?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                location.href = "Delete.php?type=create_item&id=" + id;
                                swal("Deleted!", "Category has been deleted.", "success");
                            } else {
                                swal("Cancelled", "You have cancelled this :)", "error");
                            }
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
            }

        </script>
    </body>
</html>


