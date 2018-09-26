<?php
ob_start();
include './shreeLib/session_info.php';
include_once './shreeLib/dbconn.php';
include_once 'shreeLib/DBAdapter.php';
// echo $_SESSION['user_id'];
?>

<html lang="en" class="no-js">
    <head>
        <title>View Item Stock</title>

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
                            <li class="active">Item Stock</li>
                        </ul>
                    </div>
                </div>
                <!-- main -->
                <div class="content">
                    <div class="main-header">
                        <h2>Item Stock</h2>
                        <em>View Item Stock</em>
                    </div>

                    <div class="main-content">
                        <form action="" id="form_data" class="form-horizontal" role="form" method="get" enctype="multipart/form-data" >  

                            <div class="row"> 
                                <div class="form-group">
                                    <label for="ticket-name" class="col-sm-6 control-label" id="lblcatname">Select Category</label>
                                    <div class="col-sm-2" id="catlist">
                                        <select name="category_list" id="category_list" class="select2"   required>
                                            <option>Select Category</option>
                                            <?php
                                            if (!isset($_SESSION)) {
                                                session_start();
                                            }

                                            $dba = new DBAdapter();
                                            $last_id = $dba->getLastID("branch_id", "system_user", "id=" . $_SESSION['user_id']);
                                            $data = $dba->getRow("category_list", array("id", "category_name"), "branch_id=" . $last_id);
                                            foreach ($data as $subData) {
                                                echo "<option value=" . $subData[0] . ">" . $subData[1] . "</option>";
                                            }
                                            ?>
                                        </select>

                                    </div>
                                    <button type="submit" class='btn btn-primary' id="add_more"><b> Go </b></button>
                                </div>
                            </div>
                        </form>
                        <div class="main-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="widget widget-table">
                                        <div class="widget-header">
                                            <h3><i class="fa fa-table"></i>Item Stock List</h3>
                                        </div>

                                        <div class="widget-content">
                                            <div class="table-responsive">
                                                <table id="datatable-data-export" class="table table-sorting table-striped table-hover table-bordered datatable">
                                                    <thead>
                                                        <tr>
                                                            <th>Item ID</th>
                                                            
                                                            <th>Item Name</th>
                                                            <th>Item Rate</th>                                               
                                                            <th>Item Opening Stock</th>
                                                            <th>Available Stock</th> 
                                                        </tr>
                                                    </thead>
<!--                                                    <tbody id="item_stock_list">-->
                                                    <?php
                                                    if (isset($_GET['category_list'])) {
                                                        include_once 'shreeLib/DBAdapter.php';
                                                        $dba = new DBAdapter();
                                                        $last_id = $dba->getLastID("branch_id", "system_user", "id=" . $_SESSION['user_id']);
                                                        $field = array("item_list.id,item_list.item_name,item_list.item_rate,item_list.item_opstock,item_stock.qnty,item_list.category_id");
                                                        $data = $dba->getRow("item_list LEFT JOIN item_stock ON item_list.id=item_stock.item_id INNER JOIN category_list ON item_list.category_id=category_list.id", $field, "category_list.branch_id=" . $last_id . " and item_list.category_id=" . $_GET['category_list'] . "");

                                                        foreach ($data as $subData) {
                                                            echo "<tr>";
                                                            echo "<td>" . $subData[0] . "</td>";
                                                            echo "<td>" . $subData[1] . "</td>";
                                                            echo "<td>" . $subData[2] . "</td>";
                                                            echo "<td>" . $subData[3] . "</td>";
                                                            echo "<td>" . $subData[4] . "</td>";
                                                          

                                                            echo "</tr>";
                                                        }
                                                    } else {
                                                        // echo 'No Data Available';
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
        </div>               


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



