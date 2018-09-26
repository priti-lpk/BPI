<?php
ob_start();
include_once 'shreeLib/DBAdapter.php';
include './shreeLib/session_info.php';
if (isset($_GET['type']) && isset($_GET['id'])) {
    $edba = new DBAdapter();
    $edata = $edba->getRow("sales_order_list", array("*"), "id=" . $_GET['id']);
    echo "<input type='hidden' id='sales_order_id' value='" . $_GET['id'] . "'>";
}
if (isset($_SESSION['user_id'])) {
    $edba = new DBAdapter();
    $servername1 = basename($_SERVER['PHP_SELF']);
    // echo $servername1;

    $field = array("role_rights.role_create");
    $sales_right = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " role_rights.role_create=1 and module.mod_pagename='AddSalesList.php' and role_rights.user_id=" . $_SESSION['user_id']);
    // echo $purchase_right[0][0];
    $field1 = array("role_rights.id");
    $mod_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field1, " module.mod_pagename='" . $servername1 . "' and role_rights.user_id=" . $_SESSION['user_id']);
    echo "<input type='hidden' id='user_id' value='" . $mod_data[0][0] . "'>";

    $field2 = array("role_rights.id,role_rights.role_edit,role_rights.role_delete");
    $role_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field2, "  role_rights.id=" . $mod_data[0][0]);
    //echo "<input type='hidden' id='user_id' value='" . $role_data[0][1] . "'>";
    $editdata = 0;
    $deletedata = 0;
    $sales_create = 0;
    if ($role_data[0][1] == 1) {
        $editdata = 1;
        //echo $editdata;
    }
    if ($role_data[0][2] == 1) {
        $deletedata = 1;
    }
    if ($sales_right[0][0] == 1) {
        $sales_create = 1;
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="no-js">

    <head>
        <title>
            <?php
            if (isset($_GET['type'])) {
                echo 'Edit Sales Order';
            } else {
                echo 'Add New Sales Order';
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
        <style type="text/css">
            @media print {
                table {
                    border: solid #000 !important;
                    border-width: 1px 0 0 1px !important;
                }
                th, td {
                    border: solid #000 !important;
                    border-width: 0 1px 1px 0 !important;
                }
                th:nth-child(5), th:nth-child(6), th:nth-child(7) {
                    display: none;
                }
                td:nth-child(5), td:nth-child(6), td:nth-child(7) {
                    display: none;
                }
            }
        </style>

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
                                        <li class="active">View Sales Order</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- main -->
                            <div class="content">
                                <div class="main-header">
                                    <h2>Sales Order</h2>
                                    <em>View Sales Order</em>
                                </div>
                                <div class="main-content">
                                    <!-- WYSIWYG EDITOR -->
                                    <form action="" id="form_data" class="form-horizontal" role="form" method="get" enctype="multipart/form-data" >  

                                        <div class="form-group">
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblfrom">From</label>
                                            <div class="col-sm-3" id="partydue">
                                                <input type="date" id="datevaluefrm" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][1] : '') ?>" name="from_date" id="from_date" class="form-control"  required>
                                            </div>
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblfrom">To</label>
                                            <div class="col-sm-3" id="partydue">
                                                <input type="date" id="datevalueto"  value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][1] : '') ?>" name="to_date" id="to_date" class="form-control"  required>
                                            </div>

                                            <div class="widget-footer">
                                                <button type="submit" id="btn_go" name="btn_go" class="btn btn-primary"><i class="fa fa-floppy-o"></i> <b> GO </b></button>
                                            </div>
                                        </div>
                                    </form>
                                    <form action="" id="form_data" class="form-horizontal" role="form" method="get" enctype="multipart/form-data" >  
                                        <input type="hidden" id="pdatevaluefrm"  name="pfrom_date" id="from_date" class="form-control"  required>
                                        <input type="hidden" id="pdatevalueto"  name="pto_date" id="to_date" class="form-control"  required>

                                        <label for="ticket-name" class="col-sm-2 control-label" id="lblselectparty">Select Party</label>
                                        <div class="col-sm-3" id="party">
                                            <select  name="party_id" id="party_list" class="select2" required>
                                                <option>Select Party</option>
                                                <?php
                                                $dba = new DBAdapter();
                                                $last_id = $dba->getLastID("branch_id", "system_user", "id=" . $_SESSION['user_id']);
                                                $data = $dba->getRow("party_list", array("id", "party_name"), "branch_id=" . $last_id);
                                                foreach ($data as $subData) {
                                                    echo "<option value=" . $subData[0] . ">" . $subData[1] . "</option>";
                                                }
                                                ?>
                                            </select>

                                        </div>
                                        <button type="submit" id="pbtn_go" name="btn_go" class="btn btn-primary"><i class="fa fa-floppy-o"></i><b> GO </b></button>

                                    </form>
                                    <div class="main-content">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="widget widget-table">
                                                    <div class="widget-header">
                                                        <h3><i class="fa fa-table"></i>View Sales Order</h3>
                                                    </div>
                                                    <div class="widget-content">
                                                        <table id="view_data" class="table table-sorting table-striped table-hover datatable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Sales No.</th>
                                                                    <th>Party Name</th>
                                                                    <th>Total Amount</th>
                                                                    <th>Notes</th>
                                                                    <?php if ($role_data[0][1] == 1) { ?>
                                                                        <th>Edit</th> <?php } ?>
                                                                    <?php if ($role_data[0][2] == 1) { ?> <th>Delete</th><?php } ?>
                                                                    <?php if ($sales_right[0][0] == 1) { ?> <th>Sales Now..</th><?php } ?>
                                                                </tr>
                                                            </thead>
                                                            <?php
                                                            if (isset($_GET['party_id'])) {

                                                                $userid = $_SESSION['user_id'];
                                                                $last_id = $dba->getLastID("branch_id", "system_user", "id=" . $_SESSION['user_id']);
                                                                $id = $_GET['party_id'];
                                                                $firstdate = $_GET['pfrom_date'];
                                                                $lastdate = $_GET['pto_date'];

                                                                $del = $deletedata;
                                                                $edit = $editdata;
                                                                $pur_create = $sales_create;

                                                                $sql = "SELECT sales_order_list.id,party_list.party_name,sales_order_list.total_amount,sales_order_list.note, sales_order_list.user_id FROM sales_order_list INNER JOIN party_list ON party_list.id = sales_order_list.party_id WHERE sales_order_list.sale_date >='" . $firstdate . "' AND sales_order_list.sale_date <='" . $lastdate . "' AND  sales_order_list.party_id=" . $id . " and party_list.branch_id=" . $last_id . " AND sales_order_list.order_status='Pending'";

                                                                $resultset = mysqli_query($con, $sql);
                                                                while ($rows = mysqli_fetch_array($resultset)) {
                                                                    echo "<tr>";
                                                                    echo "<td>" . $rows['id'] . "</td>";
                                                                    echo "<td>" . $rows['party_name'] . "</td>";
                                                                    echo "<td>" . $rows['total_amount'] . "</td>";

                                                                    echo "<td>" . $rows['note'] . "</td>";

                                                                    if ($edit == 1) {
                                                                        echo "<td><a href='AddSalesOrder.php?type=edit&id=" . $rows[0] . "' class='btn btn-primary' id='" . $rows[0] . "'><i class='fa fa-edit'></i> Edit</a></td>";
                                                                    }

                                                                    if ($del == 1) {
                                                                        echo "<td><button class='btn btn-danger' id='" . $rows[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash-o'></i>Delete</button></td>";
                                                                    }
                                                                    if ($pur_create == 1) {
                                                                        echo "<td><a href='AddSalesList.php?order_id=" . $rows[0] . "' class='btn btn-primary' id='" . $rows[0] . "'><i class='fa fa-save'></i> Sales Now..</a></td>";
                                                                    }

                                                                    echo '</tr>';
                                                                }
                                                            } elseif (isset($_GET['from_date']) && isset($_GET['to_date'])) {
                                                                $userid = $_SESSION['user_id'];
                                                                $last_id = $dba->getLastID("branch_id", "system_user", "id=" . $_SESSION['user_id']);
//                                                                $id = $_GET['party_id'];
                                                                $firstdate = $_GET['from_date'];
                                                                $lastdate = $_GET['to_date'];

                                                                $del = $deletedata;
                                                                $edit = $editdata;
                                                                $pur_create = $sales_create;

                                                                $sql = "SELECT sales_order_list.id,party_list.party_name,sales_order_list.total_amount,sales_order_list.note, sales_order_list.user_id FROM sales_order_list INNER JOIN party_list ON party_list.id = sales_order_list.party_id WHERE sales_order_list.sale_date >='" . $firstdate . "' AND sales_order_list.sale_date <='" . $lastdate . "' and party_list.branch_id=" . $last_id . " AND sales_order_list.order_status='Pending'";

                                                                $resultset = mysqli_query($con, $sql);
                                                                while ($rows = mysqli_fetch_array($resultset)) {
                                                                    echo "<tr>";
                                                                    echo "<td>" . $rows['id'] . "</td>";
                                                                    echo "<td>" . $rows['party_name'] . "</td>";
                                                                    echo "<td>" . $rows['total_amount'] . "</td>";

                                                                    echo "<td>" . $rows['note'] . "</td>";

                                                                    if ($edit == 1) {
                                                                        echo "<td><a href='AddSalesOrder.php?type=edit&id=" . $rows[0] . "' class='btn btn-primary' id='" . $rows[0] . "'><i class='fa fa-edit'></i> Edit</a></td>";
                                                                    }

                                                                    if ($del == 1) {
                                                                        echo "<td><button class='btn btn-danger' id='" . $rows[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash-o'></i>Delete</button></td>";
                                                                    }
                                                                    if ($pur_create == 1) {
                                                                        echo "<td><a href='AddSalesList.php?order_id=" . $rows[0] . "' class='btn btn-primary' id='" . $rows[0] . "'><i class='fa fa-save'></i> Sales Now..</a></td>";
                                                                    }

                                                                    echo '</tr>';
                                                                }
                                                            }
                                                            ?>

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

<!-- END FOOTER -->
<!-- Javascript -->
<script src="customFile/AddPurchaseList.js"></script>
<script src="assets/js/jquery/jquery-2.1.0.min.js"></script>
<script src="assets/js/jquery/jquery-1.12.4.min.js"></script>
<script src="assets/js/bootstrap/bootstrap.js"></script>
<script src="assets/js/plugins/modernizr/modernizr.js"></script>
<script src="assets/js/plugins/bootstrap-tour/bootstrap-tour.custom.js"></script>
<script src="assets/js/king-common.js"></script>
<script src="demo-style-switcher/assets/js/deliswitch.js"></script>
<link href="assets/js/datatable/css/summernote.css" rel="stylesheet">
<script src="assets/js/datatable/datatable-js/summernote.js"></script>
<script src="assets/js/plugins/markdown/markdown.js"></script>
<script src="assets/js/plugins/markdown/to-markdown.js"></script>
<script src="assets/js/plugins/markdown/bootstrap-markdown.js"></script>
<script src="assets/js/king-elements.js"></script>
<script src="assets/js/plugins/select2/select2.min.js"></script>
<script src="assets/js/plugins/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="assets/js/plugins/parsley-validation/parsley.min.js"></script>
<script src="assets/js/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="assets/js/plugins/datatable/exts/dataTables.colVis.bootstrap.js"></script>
<script src="assets/js/plugins/datatable/exts/dataTables.colReorder.min.js"></script>
<script src="assets/js/plugins/datatable/exts/dataTables.tableTools.min.js"></script>
<script src="assets/js/plugins/datatable/dataTables.bootstrap.js"></script>
<script src="assets/js/king-table.js"></script>
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
<script type="text/javascript">
    var today1 = new Date();
    var dd = today1.getDate();
    var mm = today1.getMonth() + 1;
    var yyyy = today1.getFullYear();
    if (dd < 10) {
        dd = "0" + dd;
    }
    if (mm < 10) {
        mm = "0" + mm;
    }
    var date = yyyy + "-" + mm + "-" + dd;
    var datefrm = yyyy + "-" + mm + "-01";
    document.getElementById("datevaluefrm").value = datefrm;
    document.getElementById("datevalueto").value = date;
</script>
<script type="text/javascript">
    $("#pbtn_go").on('click', function ()
    {
        var fdate = document.getElementById("datevaluefrm").value;
        var tdate = document.getElementById("datevalueto").value;
        $('#pdatevaluefrm').val(fdate);
        $('#pdatevalueto').val(tdate);

    });
</script>
<script>
//    $("#btn_go").on('click', function ()
//    {
//
//        var detedata =<?php echo (isset($_SESSION['user_id']) ? $deletedata : '') ?>;
//        var editdata =<?php echo (isset($_SESSION['user_id']) ? $editdata : '') ?>;
//        var purcs_data =<?php echo (isset($_SESSION['user_id']) ? $sales_create : '') ?>;
//
//        var f_date = $('#from_date').val();
//        var l_date = $('#to_date').val();
//        var party_id = $("#party_list").val();
//        var my_object = {"so_id": party_id, "f_date": f_date, "l_date": l_date, "dt_data": detedata, "ed_data": editdata, "sale_create": purcs_data};
//        //alert(my_object);
//
//        $.ajax({
//            url: 'getViewData.php',
//            dataType: "html",
//            data: my_object,
//            cache: false,
//            success: function (Data) {
//                //alert(Data);
//                $('#view_data1').html(Data);
//            },
//            error: function (errorThrown) {
//                alert(errorThrown);
//                alert("There is an error with AJAX!");
//            }
//        });
//    });
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
                        location.href = "Delete.php?type=sales_order_list&id=" + id;
                        swal("Deleted!", "Category has been deleted.", "success");
                    } else {
                        swal("Cancelled", "You have cancelled this :)", "error");
                    }
                });
    }
</script>
</body>
</html>




