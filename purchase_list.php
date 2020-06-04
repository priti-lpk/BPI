<?php
ob_start();
include './shreeLib/session_info.php';
include_once './shreeLib/dbconn.php';
include_once 'shreeLib/DBAdapter.php';
if (isset($_GET['type']) && isset($_GET['id'])) {
    $iid = $_GET['id'];
    $edba = new DBAdapter();
    $field = array("inquiry.id,create_party.party_name,inquiry.inq_date,inquiry.remark,inquiry.user_id");
    $edata = $edba->getRow("inquiry INNER JOIN party_list ON inquiry.party_id=party_list.id", $field, "inquiry.id=" . $_GET['id']);
    echo "<input type='hidden' id='id' value='" . $_GET['id'] . "'>";
    $field1 = array("count(inq_id)");
    $countrow = $edba->getRow("inquiry_item_list", $field1, "inq_id=" . $_GET['id']);
    echo "<input type='hidden' id='rowcount' value='" . $countrow[0][0] . "'>";
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title><?php
            if (isset($_GET['type'])) {
                echo 'Edit Purchase List';
            } else {
                echo 'Add Purchase List';
            }
            ?></title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="Themesbrand" name="author" />
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <link href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
        <link href="plugins/bootstrap-md-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
        <link href="plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />

        <!-- DataTables -->
        <link href="plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
        <style>
            @font-face{font-family: Lobster;src: url('Lobster.otf');}
            h1{font-family: Lobster;text-align:center;}
            table{border-collapse:collapse;border-radius:25px;width:500px;}
            table, td, th{border:1px solid #00BB64;}
            tr,input{height:30px;border:1px solid #fff;}
            /*	input{text-align:center;}*/
            input:focus{border:1px solid yellow;} 
            .space{margin-bottom: 2px;}
            .quotation_id{width:70px;}
            .itemname{width:200px;}
            .unit{width:70px;}
            .qty{width:70px;}
            .rate{width:70px;}
            .godawn{width: 70px;}
            #container{margin-left:180px;}
            .but{width:270px;background:#00BB64;border:1px solid #00BB64;height:40px;border-radius:3px;color:white;margin-top:10px;margin:0px 0px 0px 290px;}

        </style>
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
                                    <h4 class="page-title">Add of Purchase List</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        <?php if (isset($_GET['id'])) { ?>
                            <div class="page-content-wrapper">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card m-b-20">
                                            <div class="card-body">  
                                                <?php
                                                include_once 'shreeLib/DBAdapter.php';
                                                if (isset($_GET['id'])) {
                                                    $id = $_GET['id'];
                                                    $dba = new DBAdapter();
                                                    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                    $field = array("create_party.party_name,inquiry.inq_date,add_quotation.id");
                                                    $data = $dba->getRow("create_party INNER JOIN inquiry ON create_party.id=inquiry.party_id INNER JOIN add_quotation ON inquiry.id=add_quotation.inquiry_id", $field, "add_quotation.id=" . $id);

                                                    foreach ($data as $subData) {
                                                        ?>

                                                        <h4 class="mt-0 header-title">Textual inputs</h4>
                                                        <div class="form-group row">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">Select Party</label>
                                                            <div class="col-sm-4">
                                                                <input class="form-control" type="text"  placeholder="Godawn Name" id="godawn_name" name="godawn_name" value =  <?php echo $subData[0] ?> required="">
                                                            </div>
                                                            <label for="ticket-name" class="col-sm-1 control-label" id="lblpartydate">Date</label>
                                                            <div class="col-sm-3" id="partydue">
                                                                <input type="date"  id="datevalueto" value="<?php echo $subData[1] ?>" name="to_date" id="to_date"  class="form-control" placeholder="Inquiry Date" require>
                                                            </div>
                                                        </div>

                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card m-b-20">
                                            <div class="card-body">
                                                <form action = "customFile/purchase_listPro.php" id = "form_data" class = "form-horizontal" role = "form" method = "post" enctype = "multipart/form-data" >

                                                    <h4 class="mt-0 header-title">View Of Inquiry Main Details</h4>
                                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th width="5%">Quotation ID</th>
                                                                <th>Item Name</th>
                                                                <th>Item Unit</th>
                                                                <th>Item Quantity</th>
                                                                <th>Item Rate</th>
                                                                <!--<th>Send User</th>-->
                                                                <th>Select Godawn</th>
                                                                <th>Purchase Date</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody id="view_data1" name="view_data">

                                                            <?php
                                                            if (!isset($_SESSION)) {
                                                                session_start();
                                                            }
                                                            include_once 'shreeLib/DBAdapter.php';
                                                            $dba = new DBAdapter();
                                                            $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                            $field = array("add_quotation.id,add_quotation.item_name,add_quotation.unit,add_quotation.qty,add_quotation.new_rate");
                                                            $data = $dba->getRow("add_quotation", $field, "add_quotation.id=" . $_GET['id']);
                                                            $count = count($data);
                                                            $i = 1;
                                                            if ($count >= 1) {
                                                                foreach ($data as $subData) {
                                                                    echo "<tr>";
                                                                    echo "<td><input type='text' class='quotation_id' name='quotation_id' value='" . $subData[0] . "'></td>";
                                                                    echo "<td style='width:100px;'><input style='width:100px;' type='text' class='itemname' name='item_name' value='" . $subData[1] . "'></td>";
                                                                    echo "<td style='width:50px;'><input style='width:50px;' type='text' class='unit' name='unit' value='" . $subData[2] . "'></td>";
                                                                    echo "<td style='width:50px;'><input style='width:50px;' type='text' class='qty' name='qty' value='" . $subData[3] . "'></td>";
                                                                    echo "<td><input type='text'  class='rate'name='rate' value='" . $subData[4] . "'></td>";

                                                                    echo "<td><select style='width:100px;' name='godawn_id' id = 'u_id' class ='form-control select2 godawn' required>";
                                                                    $dba = new DBAdapter();
                                                                    $Names = $dba->getRow("create_godawn", array("id", "godawn_name"), "1");
                                                                    $counts = count($Names);
                                                                    echo "<option>Select Godawn</option>";

                                                                    if ($counts >= 1) {
                                                                        foreach ($Names as $name) {
                                                                            echo "<option value=" . $name[0] . ">" . $name[1] . "</option>";
                                                                        }
                                                                    } else {
                                                                        
                                                                    }
                                                                    echo "</select>";
                                                                    echo "<td><input type='date' name='purchase_date' id='datevalue' class='form-control' required'></td>";
                                                                    echo "<input type='hidden' name='inq_id' value='$subData[0]'>";
                                                                    echo "</tr>";
                                                                    $i++;
                                                                }
                                                            } else {
                                                                
                                                            }
                                                            ?> </tbody> 
                                                    </table>
                                                    <input type="hidden" name="action" id="action" value="<?php echo (isset($_GET['id']) ? 'add' : 'add') ?>">
                                                    <input type="hidden" name="id" id="id" value="<?php echo (isset($_GET['id']) ? $_GET['id'] : "") ?>">
                                                    <button type="submit" id="btn_save" name="btn_save" class="btn btn-primary"><i class="fa fa-floppy-o"></i><b> <?php echo (isset($_GET['type']) && isset($_GET['id']) ? 'Save' : 'Save') ?></b></button>

                                                </form>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div>
                            </div>
                            <!-- end page content-->
                        <?php } ?>
                    </div> <!-- container-fluid -->

                </div> <!-- content -->

                <?php include 'footer.php' ?>

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
        <script src="plugins/bootstrap-md-datetimepicker/js/moment-with-locales.min.js"></script>
        <script src="plugins/bootstrap-md-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

        <!-- Plugins js -->
        <script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>

        <script src="plugins/select2/js/select2.min.js"></script>
        <script src="plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
        <script src="plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js"></script>
        <script src="plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js"></script>
        <!-- Required datatable js -->
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

        <script src="assets/pages/form-advanced.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>
        <script type="text/javascript">
            function numbers() {
                var pidd =<?php echo (isset($_GET['id']) ? $edata[0][0] : '') ?>;
                var my_object = "inq_main_id=" + pidd;
                $.ajax({
                    url: 'getViewData.php',
                    dataType: "html",
                    data: my_object,
                    cache: false,
                    success: function (Data) {
                        //alert(Data);
                        $('#view_data1').html(Data);
                    },
                    error: function (errorThrown) {
                        alert(errorThrown);
                        alert("There is an error with AJAX!");
                    }
                });
            }
            ;
            numbers();
        </script>
    </body>

</html>


