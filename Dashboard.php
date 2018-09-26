<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <title>Welcome To Blue Parl Import Export Admin Panel</title>
        <link href="assets/js/datatable/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
        <link href="assets/js/datatable/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">

    </head>
    <body class="topnav-fixed dashboard">
        <!-- WRAPPER -->
        <div id="wrapper" class="wrapper">
            <!-- TOP BAR -->
            <?php include './topbar.php' ?>
            <!-- /top -->
            <!-- BOTTOM: LEFT NAV AND RIGHT MAIN CONTENT -->

            <!-- left sidebar -->
            <?php include './sidebar.php' ?>
            <!-- end left sidebar -->
            <!-- content-wrapper -->
            <div id="main-content-wrapper" class="content-wrapper ">
                <div class="row">
                    <div class="col-md-4 ">
                        <ul class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="Home">Home</a></li>
                            <li class="active">Dashboard</li>
                        </ul>
                    </div>
                </div>
                <!-- main -->
                <div class="content">
                    <div class="main-header">
                        <h2>DASHBOARD</h2>
                        <em>Welcome to Blue Parl Import Export</em>
                    </div>
                    <div class="main-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="widget widget-table">
                                    <div class="widget-header">
                                        <h3><i class="fa fa-table"></i>Inquiry List</h3>
                                    </div>

                                    <div class="widget-content">
                                        <div class="table-responsive">
                                            <table id="datatable-data-export" class="table table-sorting table-striped table-hover table-bordered datatable">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Party Name</th>
                                                        <th>Date</th>
                                                        <th>Remark</th>
                                                        <th>Send</th> 
                                                    </tr>
                                                </thead>
                                                <?php
                                                include_once 'shreeLib/DBAdapter.php';
                                                $dba = new DBAdapter();
                                                $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                $field = array("inquiry.id,create_party.party_name,inquiry.inq_date,inquiry.inq_remark");
                                                $data = $dba->getRow("inquiry INNER JOIN create_party ON inquiry.party_id=create_party.id", $field, "inquiry.branch_id=" . $last_id);
                                                $count = count($data);
                                                //print_r($count);
                                                if ($count >= 1) {
                                                    foreach ($data as $subData) {
                                                        echo "<tr>";
                                                        echo "<td>" . $subData[0] . "</td>";
                                                        echo "<td>" . $subData[1] . "</td>";
                                                        echo "<td>" . $subData[2] . "</td>";
                                                        echo "<td>" . $subData[3] . "</td>";
                                                        echo "<td><a href='inquiry_main_details.php?id=" . $subData[0] . "' class='btn btn-primary' id='" . $subData[0] . "'><i class='fa fa-save'></i> Send</a></td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    // echo 'No Data Available';
                                                }
                                                ?>      
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /main-content -->
                </div>
                <!-- /main -->

            </div>
            <!-- /content-wrapper -->

        </div>
        <!-- /row -->

        <!-- /wrapper -->
        <!-- FOOTER -->
        <script src="assets/js/jquery/jquery-2.1.0.min.js"></script>
        <script src="assets/js/bootstrap/bootstrap.js"></script>
        <script src="assets/js/plugins/modernizr/modernizr.js"></script>
        <script src="assets/js/plugins/bootstrap-tour/bootstrap-tour.custom.js"></script>
        <script src="assets/js/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="assets/js/king-common.js"></script>
        <script src="demo-style-switcher/assets/js/deliswitch.js"></script>
        <script src="assets/js/plugins/stat/jquery.easypiechart.min.js"></script>
        <script src="assets/js/plugins/raphael/raphael-2.1.0.min.js"></script>
        <script src="assets/js/plugins/stat/flot/jquery.flot.min.js"></script>
        <script src="assets/js/plugins/stat/flot/jquery.flot.resize.min.js"></script>
        <script src="assets/js/plugins/stat/flot/jquery.flot.time.min.js"></script>
        <script src="assets/js/plugins/stat/flot/jquery.flot.pie.min.js"></script>
        <script src="assets/js/plugins/stat/flot/jquery.flot.tooltip.min.js"></script>
        <script src="assets/js/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
        <script src="assets/js/plugins/datatable/jquery.dataTables.min.js"></script>
        <script src="assets/js/plugins/datatable/dataTables.bootstrap.js"></script>
        <script src="assets/js/plugins/jquery-mapael/jquery.mapael.js"></script>
        <script src="assets/js/plugins/raphael/maps/usa_states.js"></script>
        <script src="assets/js/king-chart-stat.js"></script>
        <script src="assets/js/king-table.js"></script>
        <script src="assets/js/king-components.js"></script>
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