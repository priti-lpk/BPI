<?php
include './shreeLib/session_info.php';

include_once 'shreeLib/DBAdapter.php';
if (isset($_GET['type']) && isset($_GET['id'])) {
    $edba = new DBAdapter();
    $field = array("*");
    $edata = $edba->getRow("create_branch", $field, "id=" . $_GET['id']);
    echo "<input type='hidden' id='branch_id' value='" . $_GET['id'] . "'>";
}
?>
<!DOCTYPE html>
<html lang="en" class="no-js">

    <head>
        <title>
            Add Branch
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
                                        <li class="active">Add New Branch</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- main -->
                            <div class="content">
                                <div class="main-header">
                                    <h2>Create Branch</h2>
                                    <em>Add New</em>
                                </div>
                                <div class="main-content">
                                    <!-- WYSIWYG EDITOR -->
                                    <form action="customFile/addBranchPro.php" id="form_data" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" >  

                                        <div class="form-group">
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblusername">Branch Name</label>
                                            <div class="col-sm-3" id="branchid">
                                                <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][1] : '') ?>" name="branch_name" id="branch_name" class="form-control" placeholder="Branch Name" required>
                                            </div>
                                            <!--                                        </div>
                                                                                    <div class="form-group">-->
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblusername">Branch Address</label>
                                            <div class="col-sm-3" id="branchid">
                                                <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][2] : '') ?>" name="branch_address" id="branch_name" class="form-control" placeholder="Branch Address" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblusername">Branch Contact</label>
                                            <div class="col-sm-3" id="branchid">
                                                <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][3] : '') ?>" name="branch_contact" id="branch_contact" class="form-control" placeholder="Branch Contact" required>
                                            </div>
                                            <!--                                        </div>
                                                                                    <div class="form-group">-->
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblusername">Branch Email</label>
                                            <div class="col-sm-3" id="branchid">
                                                <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][4] : '') ?>" name="branch_email" id="branch_email" class="form-control" placeholder="Branch Email" required>
                                            </div>
                                        </div>
                                        

                                        <div class="form-group">
                                            <label for="ticket-name" class="col-sm-3 control-label" id="lblusername">Branch Status</label>
                                            <div class="control-inline onoffswitch">
                                                <input type="checkbox" name="branch_status" id="branch_status" class="onoffswitch-checkbox" <?php echo (isset($_GET['type']) && isset($_GET['id']) ? ($edata[0][8] == 'false' ? '' : 'checked') : 'checked') ?>>
                                                <label class="onoffswitch-label" for="branch_status">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
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
                                                        <h3><i class="fa fa-table"></i>Branch List</h3>
                                                    </div>
                                                    <div class="widget-content">
                                                        <table id="featured-datatable" class="table table-sorting table-striped table-hover datatable">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Branch Name</th>
                                                                    <th>Branch Address</th> 
                                                                    <th>Branch Contact</th>
                                                                    <th>Branch Email</th>
                                                                    
                                                                    <th>Branch Status</th> 
                                                                    <th>Action</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody id="branch_list">
                                                                <?php
                                                                include_once 'shreeLib/DBAdapter.php';
                                                                $dba = new DBAdapter();
                                                                $field = array("create_branch.id,create_branch.branch_name,create_branch.branch_address,create_branch.branch_contact,create_branch.branch_email,create_branch.branch_status");
                                                                $data = $dba->getRow("create_branch", $field, "1");
                                                                $count = count($data);
                                                                if ($count >= 1) {
                                                                    foreach ($data as $subData) {
                                                                        echo "<tr>";
                                                                        echo "<td>" . $subData[0] . "</td>";
                                                                        echo "<td>" . $subData[1] . "</td>";
                                                                        echo "<td>" . $subData[2] . "</td>";
                                                                        echo "<td>" . $subData[3] . "</td>";
                                                                        echo "<td>" . $subData[4] . "</td>";
                                                                     

                                                                        if ($subData[5] == 'true') {
                                                                            echo "<td><li id='s" . $subData[0] . "' class='fa fa-eye fa-2x'></li></td>";
                                                                        } else {
                                                                            echo "<td><li id='s" . $subData[0] . "' class='fa fa-eye-slash fa-2x'></li></td>";
                                                                        }
                                                                        if ($subData[5] == 'false') {
                                                                            echo "<td><button class='btn btn-primary' id='" . $subData[0] . "' data-status='true' onclick='changeBranchStatus(this.id);'><li id='li" . $subData[0] . "' class='fa fa-eye fa-2x'></li></button>";
                                                                            echo "<a href='AddBranch.php?type=edit&id=" . $subData[0] . "' class='btn btn-primary' id='" . $subData[0] . "'><i class='fa fa-edit'></i> Edit</a></td></tr>";
                                                                        } else {
                                                                            echo "<td><button class='btn btn-primary' id='" . $subData[0] . "' data-status='false' onclick='changeBranchStatus(this.id);'><li id='li" . $subData[0] . "' class='fa fa-eye-slash fa-2x'></li></button>";
                                                                            echo "<a href='AddBranch.php?type=edit&id=" . $subData[0] . "' class='btn btn-primary' id='" . $subData[0] . "'><i class='fa fa-edit'></i> Edit</a></td></tr>";
                                                                        }
//                                                                  
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
                                            </div>
                                        </div>
                                    </div>                                                      

                                    <!-- /main-content -->

                                </div>

                                <!-- /main -->

                            </div>

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
    <!-- END BOTTOM: LEFT NAV AND RIGHT MAIN CONTENT -->
</div>
<!-- /wrapper -->
<!-- FOOTER -->
<footer class="footer">
    2018 © <a href="http://lpktechnosoft.com" target="_blank">LPK Technosoft</a>
</footer>  

<script src="customFile/addBranchJs.js" ></script>
<!-- END FOOTER -->
<!-- Javascript -->
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
    function getbranch() {
        $.ajax({
            url: 'getNewBranch.php',
            dataType: "html",
            cache: false,
            success: function (Data) {
                // alert(Data);
                $('#branchid').html(Data);
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




