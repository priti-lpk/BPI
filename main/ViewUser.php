<?php
include_once 'shreeLib/DBAdapter.php';
if (isset($_GET['type']) && isset($_GET['id'])) {
    $edba = new DBAdapter();
    $edata = $edba->getRow("create_user", array("*"), "id=" . $_GET['id']);
    echo "<input type='hidden' id='create_user_id' value='" . $_GET['id'] . "'>";
}
?>
<!DOCTYPE html>
<html lang="en" class="no-js">

    <head>
        <title>
            <?php
            if (isset($_GET['type'])) {
                echo 'Edit User';
            } else {
                echo 'Add New User';
            }
            ?>
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
                                        <li class="active">View User</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- main -->
                            <div class="content">
                                <div class="main-header">
                                    <h2>User</h2>
                                    <em>View User</em>
                                </div>
                                <div class="main-content">
                                    <!-- WYSIWYG EDITOR -->



                                    <div class="main-content">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="widget widget-table">
                                                    <div class="widget-header">
                                                        <h3><i class="fa fa-table"></i>View User</h3>
                                                    </div>
                                                    <div class="widget-content">
                                                        <table id="view_data" class="table table-sorting table-striped table-hover datatable">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>User Name</th>
                                                                    <th>Contact</th>
                                                                    <th>Email</th>
                                                                    <th>Login Username</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                include_once 'shreeLib/DBAdapter.php';
                                                                $dba = new DBAdapter();
                                                                $field = array("*");
                                                                $data = $dba->getRow("create_user", $field, "1");
                                                                $count = count($data);
                                                                if ($count >= 1) {
                                                                    foreach ($data as $subData) {
                                                                        echo "<tr>";
                                                                        echo "<td>" . $subData[0] . "</td>";
                                                                        echo "<td>" . $subData[4] . "</td>";
                                                                        echo "<td>" . $subData[5] . "</td>";
                                                                        echo "<td>" . $subData[6] . "</td>";
                                                                        echo "<td>" . $subData[7] . "</td>";
                                                                     
                                                                        if ($subData[8] == 'true') {
                                                                            echo "<td><li id='s" . $subData[0] . "' class='fa fa-eye fa-2x'></li></td>";
                                                                        } else {
                                                                            echo "<td><li id='s" . $subData[0] . "' class='fa fa-eye-slash fa-2x'></li></td>";
                                                                        }
                                                                        if ($subData[8] == 'false') {
                                                                            echo "<td><button class='btn btn-primary' id='" . $subData[0] . "' data-status='true' onclick='changeUserStatus(this.id);'><li id='li" . $subData[0] . "' class='fa fa-eye fa-2x'></li></button>";
                                                                            echo "<a href='../main/UserField.php?type=edit&id=" . $subData[0] . "' class='btn btn-primary' id='" . $subData[0] . "'><i class='fa fa-edit'></i> Edit</a></td></tr>";
                                                                        } else {
                                                                            echo "<td><button class='btn btn-primary' id='" . $subData[0] . "' data-status='false' onclick='changeUserStatus(this.id);'><li id='li" . $subData[0] . "' class='fa fa-eye-slash fa-2x'></li></button>";
                                                                            echo "<a href='../main/UserField.php?type=edit&id=" . $subData[0] . "' class='btn btn-primary' id='" . $subData[0] . "'><i class='fa fa-edit'></i> Edit</a></td></tr>";
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

    <!-- /wrapper -->
    <!-- FOOTER -->
    <footer class="footer">
        <b>Develop By : </b><a href="http://lpktechnosoft.com" target="_blank"> LPK Technosoft</a>
    </footer>  

    <!-- END FOOTER -->
    <!-- Javascript -->
    <script src="customFile/UserField.js"></script>
    <script src="assets/js/jquery/jquery-2.1.0.min.js"></script>        
    <script src="assets/js/bootstrap/bootstrap.js"></script>
    <script src="assets/js/plugins/modernizr/modernizr.js"></script>
    <script src="assets/js/plugins/bootstrap-tour/bootstrap-tour.custom.js"></script>
    <script src="assets/js/king-common.js"></script>
    <script src="assets/js/plugins/bootstrap-multiselect/bootstrap-multiselect.js"></script>
    <script src="assets/js/plugins/parsley-validation/parsley.min.js"></script>
<!--    <script src="assets/js/king-elements.js"></script>-->
    <script src="assets/js/plugins/datatable/jquery.dataTables.min.js"></script>
    <script src="assets/js/plugins/datatable/exts/dataTables.colVis.bootstrap.js"></script>
    <script src="assets/js/plugins/datatable/exts/dataTables.colReorder.min.js"></script>
    <script src="assets/js/plugins/datatable/exts/dataTables.tableTools.min.js"></script>
    <script src="assets/js/plugins/datatable/dataTables.bootstrap.js"></script>
    <script src="assets/js/king-table.js"></script>
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
            $('#view_data').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script> 
</body>
</html>






