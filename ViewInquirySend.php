<?php
ob_start();
include './shreeLib/session_info.php';
include_once './shreeLib/dbconn.php';
include_once 'shreeLib/DBAdapter.php';
// echo $_SESSION['user_id'];
?>

<html lang="en" class="no-js">
    <head>
        <title>View Inquiry</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="Moltera Ceramic Pvt.Ltd">
        <meta name="author" content="LPK Technosoft">

        <link href="assets/js/datatable/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
        <link href="assets/js/datatable/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css"> 

    </head>

    <body class="form-val topnav-fixed ">
        <!-- WRAPPER -->
        <div id="wrapper" class="wrapper">
            <?php include './topbar.php'; ?>
            <?php include './sidebar.php'; ?>
            <!-- content-wrapper -->

            <div id="main-content-wrapper" class="content-wrapper">
                <!-- top general alert -->
                <!-- end top general alert -->

                <div class="row">
                    <div class="col-lg-4 ">
                        <ul class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="Home">Home</a></li>
                            <li class="active">Inquiry Send</li>
                        </ul>
                    </div>
                </div>
                <!-- main -->
                <div class="content">
                    <div class="main-header">
                        <h2>Inquiry</h2>
                        <em>View Inquiry Send</em>
                    </div>
                    <div class="main-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="widget widget-table">
                                    <div class="widget-header">
                                        <h3><i class="fa fa-table"></i>Inquiry Send List</h3>
                                    </div>

                                    <div class="widget-content">
                                        <div class="table-responsive">
                                            <table id="datatable-data-export" class="table table-sorting table-striped table-hover table-bordered datatable">
                                                <thead>
                                                    <tr>
                                                    <th>ID</th>
                                                    <th>User Name</th>
                                                    </tr>
                                                </thead>
<!--                                                    <tbody id="item_stock_list">-->
                                                <?php
                                                include_once 'shreeLib/DBAdapter.php';
                                                $dba = new DBAdapter();
                                                $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                $field = array("inquiry_send_to.id,create_user.user_fullname");
                                                $data = $dba->getRow("inquiry INNER JOIN inquiry_send_to ON inquiry.id=inquiry_send_to.inq_id INNER JOIN create_user ON create_user.id=inquiry_send_to.user_id", $field, "inquiry.branch_id=".$last_id);
                                                $count = count($data);
                                                //print_r($count);
                                                if ($count >= 1) {
                                                    foreach ($data as $subData) {
                                                        echo "<tr>";
                                                        echo "<td>" . $subData[0] . "</td>";
                                                        echo "<td>" . $subData[1] . "</td>";

                                                        echo "</tr>";
                                                    }
                                                }
                                                ?>      
                                                <!--</tbody>-->
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /main-content -->



        <?php include './footer.php'; ?>  
        <script src="customFile/getItemStock.js" ></script>

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
                $('#datatable-data-export').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
            });
        </script> 

    </body>
</html>





