<?php
ob_start();
include './shreeLib/session_info.php';

include_once 'shreeLib/DBAdapter.php';
if (isset($_GET['type']) && isset($_GET['id'])) {
    $edba = new DBAdapter();
    $field = array("main_category.id,main_category.name");
    $edata = $edba->getRow("main_category", $field, "id=" . $_GET['id']);
    echo "<input type='hidden' id='main_category_id' value='" . $_GET['id'] . "'>";
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
    echo "<input type='hidden' id='user_id' value='" . $role_data[0][0] . "'>";
}
?>
<!DOCTYPE html>
<html lang="en" class="no-js">

    <head>
        <title>
            Add Main Category
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
                                        <li class="active">Add Main Category</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- main -->
                            <div class="content">
                                <div class="main-header">
                                    <h2>Create Category</h2>
                                    <em>Add New</em>
                                </div>
                                <div class="main-content">
                                    <!-- WYSIWYG EDITOR -->
                                    <form action="customFile/addMainCategoryPro.php" id="form_data" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" >  

                                        <div class="form-group">
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblcatname">Category Name</label>
                                            <div class="col-sm-3" id="partydue">
                                                <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][1] : '') ?>" name="name" id="name" class="form-control" placeholder="Category Name" required>
                                            </div>
                                        </div>
                                        <div class="widget-footer">
                                            <input type="hidden" name="action" id="action" value="<?php echo (isset($_GET['id']) ? 'edit' : 'add') ?>"/>
                                            <input type="hidden" name="id" id="id" value="<?php echo (isset($_GET['id']) ? $_GET['id'] : "") ?>">
                                            <button type="submit" id="btn_save" class="btn btn-primary"><i class="fa fa-floppy-o"></i> <?php echo (isset($_GET['type']) && isset($_GET['id']) ? 'Edit' : 'Save') ?></button>

                                        </div>
                                    </form>

                                    <div class="main-content">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="widget widget-table">
                                                    <div class="widget-header">
                                                        <h3><i class="fa fa-table"></i>Main Category List</h3>
                                                    </div>
                                                    <div class="widget-content">
                                                        <table id="featured-datatable" class="table table-sorting table-striped table-hover datatable">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Category Name</th>
                                                                    <?php if ($role_data[0][1] == 1) { ?>
                                                                        <th>Edit</th> <?php } ?>
                                                                    <?php //if ($role_data[0][2] == 1) { ?> 
<!--                                                                        <th>Delete</th>-->
                                                                    <?php //} ?>
                                                                </tr>
                                                            </thead>
                                                            <!--<tbody id="category_list">-->
                                                            <?php
                                                            include_once 'shreeLib/DBAdapter.php';
                                                            $dba = new DBAdapter();

                                                            $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);

                                                            $field = array("main_category.id,main_category.name");
                                                            $data = $dba->getRow("main_category", $field, "main_category.branch_id=" . $last_id);

                                                            $count = count($data);
                                                            if ($count >= 1) {
                                                                foreach ($data as $subData) {
                                                                    // if ($userid == $subData[2]) {
                                                                    echo "<tr>";
                                                                    echo "<td>" . $subData[0] . "</td>";
                                                                    echo "<td>" . $subData[1] . "</td>";
                                                                    if ($role_data[0][1] == 1) {
                                                                        echo "<td><a href='AddMainCategory.php?type=edit&id=" . $subData[0] . "' class='btn btn-primary' id='" . $subData[0] . "'><i class='fa fa-edit'></i> Edit</a></td>";
                                                                    }

//                                                                    if ($role_data[0][2] == 1) {
//                                                                        echo "<td> <button class='btn btn-danger btn_delete' id='" . $subData[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash-o'>  Delete</button></td>";
//                                                                    }
                                                                    echo '</tr>';
                                                                    // }
                                                                }
                                                            }
                                                            ?>  
                                                            <!--</tbody>-->
                                                        </table>
                                                    </div>
                                                </div> <!-- /widget widget-table -->
                                            </div>
                                        </div>
                                    </div>                                                      



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
        <!-- FOOTER -->
        <footer class="footer">
            2018 © <a href="http://lpktechnosoft.com" target="_blank">LPK Technosoft</a>
        </footer>  

        <script src="customFile/addCategoryJs.js" ></script>
        <!-- END FOOTER -->
        <!-- Javascript -->
        <script src="assets/js/jquery/jquery-2.1.0.min.js"></script>
        <script src="assets/js/jquery/jquery-1.12.4.min.js"></script>
        <script src="assets/js/bootstrap/bootstrap.js"></script>
        <script src="assets/js/plugins/modernizr/modernizr.js"></script>
        <script src="assets/js/plugins/bootstrap-tour/bootstrap-tour.custom.js"></script>
        <script src="assets/js/king-common.js"></script>
        <script src="demo-style-switcher/assets/js/deliswitch.js"></script>
        <!--        <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.7/summernote.css" rel="stylesheet">
                <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.7/summernote.js"></script>-->
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
                                location.href = "Delete.php?type=cat_list&id=" + id;
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
            //alert(btn_crate);

            if (btn_crate === 0) {
                $('#btn_save').prop('disabled', true);
            }
            if (btn_edit === 1) {
                $('#btn_save').prop('disabled', false);
            }

        </script>
    </body>
</html>







