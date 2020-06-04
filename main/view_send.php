<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>View Inquiry</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="Themesbrand" name="author" />
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <link rel="stylesheet" href="plugins/morris/morris.css">
        <link href="plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    </head>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <?php include './topbar.php' ?>
            <!-- Top Bar End -->

            <!-- ========== Left Sidebar Start ========== -->
            <?php include './sidebar.php' ?>
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
                                    <h4 class="page-title">View Inquiry</h4>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item active"></li>
                                    </ol>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card m-b-20">
                                    <div class="card-body">

                                        <h4 class="mt-0 header-title">View Of Inquiry List</h4><br>
                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Reference No.</th>
                                                    <th>Date</th>
                                                    <th>Remark</th>
                                                    <!--<th>Send</th>--> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                include_once 'shreeLib/DBAdapter.php';
                                                $dba = new DBAdapter();
                                                $field = array("inquiry.id,inquiry.inq_date,inquiry.inq_remark,inquiry_send_to.inq_id,inquiry.reference_no");
                                                $data = $dba->getRow("inquiry  left join inquiry_send_to on inquiry.id=inquiry_send_to.inq_id", $field, "inquiry.status='on' AND inquiry_send_to.inq_id IS Null");
                                                $count = count($data);
                                                //print_r($count);
                                                $i = 1;
                                                if ($count >= 1) {
                                                    foreach ($data as $subData) {
                                                        echo "<tr>";
                                                        echo "<td>" . $i++ . "</td>";
                                                        // echo "<td>" . $subData[1] . "</td>";
                                                        echo "<td>" . $subData[4] . "</td>";
                                                        $date1 = $subData[1];
                                                        $dates1 = date("d-m-Y", strtotime($date1));
                                                        echo "<td>" . $dates1 . "</td>";
                                                        echo "<td>" . $subData[2] . "</td>";
//                                                        echo "<td><a href='inquiry_main_details.php?id=" . $subData[0] . "' class='btn btn-primary' id='" . $subData[0] . "'><i class='fa fa-save'></i> Send</a></td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    // echo 'No Data Available';
                                                }
                                                ?> 
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> 
                            <!--end col--> 
                        </div>
                        <!-- end row -->

                    </div> <!-- container-fluid -->

                </div> <!-- content -->
                <?php include './footer.php' ?>


            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->


        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/metisMenu.min.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/waves.min.js"></script>

        <script src="plugins/jquery-sparkline/jquery.sparkline.min.js"></script>

        <!-- Peity JS -->
        <script src="plugins/peity/jquery.peity.min.js"></script>

        <script src="plugins/morris/morris.min.js"></script>
        <script src="plugins/raphael/raphael-min.js"></script>
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

        <!-- Datatable init js -->
        <script src="assets/pages/datatables.init.js"></script>

        <script src="assets/pages/dashboard.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>
    </body>

</html>