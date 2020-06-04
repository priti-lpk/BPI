<?php
ob_start();
//require_once "./shreeLib/session_info.php";
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Blue Pearl International Dashboard</title>
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
                                    <h4 class="page-title">Dashboard</h4>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item active">Welcome to Blue Pearl International Dashboard</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class = "col-xl-4 col-md-6">
                                <div class = "card bg-primary mini-stat position-relative">
                                    <div class = "card-body">
                                        <div class = "mini-stat-desc" style="font-size: 20px;">
                                            <div class="text-white">
                                                <?php
                                                include_once './shreeLib/DBAdapter.php';
                                                $dba = new DBAdapter();
                                                $data = $dba->getRow("inquiry left join inquiry_send_to on inquiry.id=inquiry_send_to.inq_id", array("count(inquiry.id) as total"), " inquiry_send_to.inq_id IS Null");
                                                $i = 1;
                                                if (!empty($data)) {

                                                    foreach ($data as $row) {
                                                        ?>
                                                        <button class="totalpost"><h3 style="font-size: 22px;"><?= $row[0] ?></h3></button>&nbsp;&nbsp;Total Inquiry
                                                        <hr>
                                                        <span class = "ml-2 viewpost"><a href="view_send.php">View Inquiry</a></span>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class = "col-xl-4 col-md-6">
                                <div class = "card bg-primary mini-stat position-relative">
                                    <div class = "card-body">
                                        <div class = "mini-stat-desc" style="font-size: 20px;">
                                            <div class = "text-white">
                                                <?php
                                                include_once './shreeLib/DBAdapter.php';
                                                $dba = new DBAdapter();
                                                $data = $dba->getRow("add_quotation", array("count(id) as total"), "1");
                                                $i = 1;
                                                if (!empty($data)) {
                                                    foreach ($data as $row) {
                                                        ?>
                                                        <button class="totalpost"><h3 style="font-size: 22px;"><?= $row[0] ?></h3></button>&nbsp;&nbsp;Total Quotation
                                                        <hr>
                                                        <span class = "ml-2 viewpost"><a href="view/Quotation.php">View Quotation</a></span>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class = "col-xl-4 col-md-6">
                                <div class = "card bg-primary mini-stat position-relative">
                                    <div class = "card-body">
                                        <div class = "mini-stat-desc" style="font-size: 20px;">
                                            <div class = "text-white">
                                                <?php
                                                include_once './shreeLib/DBAdapter.php';
                                                $dba = new DBAdapter();
                                                $data = $dba->getRow("purchase_list", array("count(id) as total"), "1");
                                                $i = 1;
                                                if (!empty($data)) {
                                                    foreach ($data as $row) {
                                                        ?>
                                                        <button class="totalpost"><h3 style="font-size: 22px;"><?= $row[0] ?></h3></button>&nbsp;&nbsp;Total Purchase
                                                        <hr>
                                                        <span class = "ml-2 viewpost"><a href="view/Purchase.php">View Purchase</a></span>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
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
<!--        <script>
            window.onbeforeunload = function (event) {
                var message = 'Important: Please click on \'Save\' button to leave this page.';
                if (typeof event == 'undefined') {
                    event = window.event;
                }
                if (event) {
                    event.returnValue = message;
                }
                return message;
            };
        </script>-->

<!--        <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
 <script>
     var OneSignal = window.OneSignal || [];
     OneSignal.push(function () {
         OneSignal.init({
             appId: "c76f642c-0cee-4596-bb34-f06ba04bcce3",
         });
     });
     if ('serviceWorker' in navigator) {
         window.addEventListener('load', function () {
             navigator.serviceWorker.register('/sw.js').then(function (registration) {
                 // Registration was successful
                 console.log('ServiceWorker registration successful with scope: ', registration.scope);
             }, function (err) {
                 // registration failed :(
                 console.log('ServiceWorker registration failed: ', err);
             });
         });
     }

 </script>-->
    </body>

</html>