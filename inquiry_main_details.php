<?php
ob_start();
include './shreeLib/session_info.php';
include_once './shreeLib/dbconn.php';
include_once 'shreeLib/DBAdapter.php';
if (isset($_GET['type']) && isset($_GET['id'])) {
    $iid = $_GET['id'];
    $edba = new DBAdapter();
    $field = array("inquiry.id,create_party.party_name,inquiry.inq_date,inquiry.remark");
    $edata = $edba->getRow("inquiry INNER JOIN party_list ON inquiry.party_id=party_list.id", $field, "inquiry.id=" . $_GET['id']);
    echo "<input type='hidden' id='id' value='" . $_GET['id'] . "'>";
    $field1 = array("count(inq_id)");
    $countrow = $edba->getRow("inquiry_item_list", $field1, "inq_id=" . $_GET['id']);
    echo "<input type='hidden' id='rowcount' value='" . $countrow[0][0] . "'>";
}
?>

<html lang="en" class="no-js">
    <head>
        <title>View Inquiry Main Details</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="Moltera Ceramic Pvt.Ltd">
        <meta name="author" content="LPK Technosoft">

        <link href="assets/js/datatable/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
        <link href="assets/js/datatable/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css"> 
        <style>
            table{border-collapse:collapse;border-radius:0px;width:500px;}
            table, td, th{border:1px solid #00BB64;}
            tr,input{height:30px;border:1px solid #fff;}
            /*	input{text-align:center;}*/
            input:focus{border:1px solid yellow;} 
        </style>
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
                            <li class="active">Inquiry Details</li>
                        </ul>
                    </div>
                </div>
                <!-- main -->
                <div class="content">
                    <div class="main-header">
                        <h2>Inquiry Details</h2>
                        <em>View Inquiry Main Details</em>
                    </div>

                    <div class="main-content">
                        <?php
                        include_once 'shreeLib/DBAdapter.php';
                        if (isset($_GET['id'])) {
                            $id = $_GET['id'];
                            $dba = new DBAdapter();
                            $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                            $field = array("inquiry.id,inquiry.party_id,inquiry.inq_date,inquiry.inq_remark");
                            $data = $dba->getRow("inquiry", $field, "id=" . $id);

                            foreach ($data as $subData) {

                                echo '<div class = "form-group">';
                                echo '<label for = "ticket-name" class = "col-sm-2 control-label" id = "lblcatname">Select Party</label>';
                                echo '<div class = "col-sm-9" id = "partylist5">';
                                echo '<input type = "text" id = "datevalue" value = ' . $subData[1] . ' name = "inq_date" id = "inq_date" class = "form-control" placeholder = "Inquiry Date" required>';
                                echo '</div>';
                                echo '</div>';
                                echo '<div class="form-group">';
                                echo '<label for = "ticket-name" class = "col-sm-1 control-label" id = "lblpartydate">Date</label>';
                                echo '<div class = "col-sm-3" id = "partydue">';
                                echo '<input type = "date" id = "datevalue" value = ' . $subData[2] . ' name = "inq_date" id = "inq_date" class = "form-control" placeholder = "Inquiry Date" required>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '<div class = "form-group">';
                                echo '<label for = "ticket-name" class = "col-sm-2 control-label" id = "lblpartynote">Remark</label>';
                                echo '<div class = "col-sm-9" id = "partynote">';
                                echo '<input type = "text" value = ' . $subData[3] . ' name = "inq_remark" id = "inq_remark" class = "form-control" placeholder = "Remark" required>';
                                echo '</div>';
                                echo '</div>';
                            }
                            ?>
                            <div class = "row">
                                <div class = "col-md-12">
                                    <div class = "widget widget-table">
                                        <div class = "widget-header">
                                            <h3><i class = "fa fa-table"></i>Inquiry Main Details</h3>
                                        </div>
                                        <form action = "customFile/inquiry_main_detailsPro.php" id = "form_data" class = "form-horizontal" role = "form" method = "post" enctype = "multipart/form-data" >

                                            <div class = "widget-content">
                                                <div class = "table-responsive">
                                                    <table id = "datatable-data-export" class = "table table-sorting table-striped table-hover table-bordered datatable">
                                                        <thead>
                                                            <tr>
                                                            <th>Inquiry ID</th>
                                                            <th>Item Name</th>
                                                            <th>Item Quantity</th>
                                                            <th>Select User</th>
                                                            <th>Due Date</th>
                                                            </tr>
                                                        </thead>
                                                        <?php
                                                        if (!isset($_SESSION)) {
                                                            session_start();
                                                        }
                                                        include_once 'shreeLib/DBAdapter.php';
                                                        $dba = new DBAdapter();
                                                        $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                        //print_r($last_id);
                                                        $field = array("inquiry_item_list.id,create_item.item_name,inquiry_item_list.item_quantity,inquiry_item_list.item_id,inquiry_item_list.inq_id");
                                                        $data = $dba->getRow("inquiry_item_list inner join create_item on inquiry_item_list.item_id=create_item.id INNER JOIN inquiry ON inquiry.id= inquiry_item_list.inq_id", $field, "inq_id=" . $_GET['id'] . " AND inquiry.branch_id=" . $last_id);
                                                        //print_r($data);
                                                        foreach ($data as $subData) {
                                                            echo "<tr>";
                                                            echo "<td><input type='text' name=inq_item_list_id[]' value='" . $subData[0] . "'></td>";
                                                            echo "<td><input type='text' name=item_name[]' value='" . $subData[1] . "'></td>";
                                                            echo "<td><input type='text' name=item_qnty[]' value='" . $subData[2] . "'></td>";
                                                            echo "<td><select  name='user_id[]' id = 'item_code' class ='itemcode select2'> <option>Select User</option>";
                                                            $dba = new DBAdapter();
                                                            $Names = $dba->getRow("create_user", array("id,user_fullname"), "user_type='Other' and branch_id=" . $last_id);
                                                            $count = count($Names);
                                                            // print_r($count);
                                                            if ($count >= 1) {
                                                                foreach ($Names as $name) {
                                                                    echo" <option value='" . $name[0] . "'>" . $name[1] . "</option> ";
                                                                }
                                                                echo "</select></td>";
                                                            }
                                                            echo "<td><input type='date' id='datevalue' name='due_date[]' id='pl_date' class='form-control' required></td>";
                                                            echo "<input type='hidden' name=inq_id' value='$subData[0]'>";
                                                            echo "</tr>";
                                                        }
                                                        ?>  
                                                    </table>
                                                    <input type="hidden" name="action" id="action" value="<?php echo (isset($_GET['id']) ? 'add' : 'add') ?>">
                                                    <input type="hidden" name="id" id="id" value="<?php echo (isset($_GET['id']) ? $_GET['id'] : "") ?>">
                                                    <button type="submit" id="btn_save" name="btn_save" class="btn btn-primary"><i class="fa fa-floppy-o"></i><b> <?php echo (isset($_GET['type']) && isset($_GET['id']) ? 'Save' : 'Save') ?></b></button>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
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
                    //dom: 'Bfrtip',
                    //                    buttons: [
                    //                        'copy', 'csv', 'excel', 'pdf', 'print'
                    //                    ]
                });
            });
        </script> 

    </body>
</html>



