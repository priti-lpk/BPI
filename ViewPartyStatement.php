<?php
ob_start();
include_once 'shreeLib/DBAdapter.php';
include './shreeLib/session_info.php';
//if (isset($_GET['type']) && isset($_GET['id'])) {
//    $edba = new DBAdapter();
//    $edata = $edba->getRow("purchase_list", array("*"), "id=" . $_GET['id']);
//    echo "<input type='hidden' id='purchase_id' value='" . $_GET['id'] . "'>";
//}
?>
<!DOCTYPE html>
<html lang="en" class="no-js">

    <head>
        <title>
            View Party Statement
        </title>
        <link href="assets/js/datatable/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
        <link href="assets/js/datatable/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css"> 
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="Moltera Ceramic Pvt.Ltd">
        <meta name="author" content="LPK Technosoft">

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
                                        <li class="active">View Party Statement</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- main -->
                            <div class="content">
                                <div class="main-header">
                                    <h2>Party Statement</h2>
                                    <em>View Party Statement</em>
                                </div>
                                <div class="main-content">
                                    <form action="" id="form_data" class="form-horizontal" role="form" method="get" enctype="multipart/form-data" >  

                                        <!-- WYSIWYG EDITOR -->
                                        <div class="form-group">
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblfrom">From</label>
                                            <div class="col-sm-3" id="partydue">
                                                <input type="date" id="datevaluefrm"  value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][1] : '') ?>" name="from_date" id="from_date" class="form-control"  required>
                                            </div>
                                            <!--                                    </div><br><Br><br>
                                                                                <div class="form-group">-->
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblfrom">To</label>
                                            <div class="col-sm-3" id="partydue">
                                                <input type="date" id="datevalueto" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][1] : '') ?>" name="to_date" id="to_date" class="form-control"  required>
                                            </div>
                                            <!--                                    </div><br><br>
                                                                                <div class="form-group">-->
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblcatname">Select Party</label>
                                            <div class="col-sm-3" id="catlist">
                                                <select name="party_id" id="party_list" class="select2" required>
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
                                        </div><br><Br>
                                        <div class="widget-footer">
                                            <button type="submit" id="btn_go" name="btn_go" class="btn btn-primary"><i class="fa fa-floppy-o"></i> <b> GO </b></button>

                                        </div>
                                    </form>
                                    <div class="main-content">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="widget widget-table">
                                                    <div class="widget-header">
                                                        <h3><i class="fa fa-table"></i>View Party Statement</h3>
                                                    </div>
                                                    <div class="widget-content">
                                                        <table id="view_data" class="table table-sorting table-striped table-hover datatable">
                                                            <?php
                                                            if (isset($_GET['party_id'])) {
                                                                $id = $_GET['party_id'];
                                                                $firstdate = $_GET['from_date'];
                                                                $lastdate = $_GET['to_date'];
                                                                include_once("shreeLib/dbconn.php");
                                                                $sql = "SELECT pt.paydate, pt.id, party_list.party_name, pt.type, pt.credit, pt.debit FROM(select id, party_id, party_due As amount, pay_date As paydate, 'Payment' As type, pay_amount as credit, 0 As debit from payment_list where pay_crdb = 'Credit' union all select id, party_id, party_due As amount, pay_date As paydate, 'Payment' As type, 0 as credit, pay_amount As debit from payment_list where pay_crdb = 'Debit' union all select id, party_id, total_amount as amount, pl_date As paydate, 'Purchase' As type, total_amount as credit, 0 as debit from purchase_list union all select id, party_id, total_amount as amount, sale_date As paydate, 'Sale' As type, 0 as credit, total_amount as debit from sales_list) AS pt INNER JOIN party_list ON pt.party_id = party_list.id where pt.party_id='" . $id . "' and pt.paydate >= '" . $firstdate . "' and pt.paydate <= '" . $lastdate . "' ORDER BY pt.paydate";
                                                                // print_r($sql);
                                                                $resultset = mysqli_query($con, $sql);
                                                                echo "<thead>";
                                                                echo "<tr>";
                                                                echo "<td>Date</td>";
                                                                echo "<td>No.</td>";
                                                                echo "<td>Party Name</td>";
                                                                echo "<td>Title</td>";
                                                                echo "<td>Credit</td>";
                                                                echo "<td>Debit</td>";
                                                                echo '</tr>';
                                                                echo "</thead>";
                                                                $credit = 0.0;
                                                                $debit = 0.0;
                                                                $diff = 0.0;
                                                                $difcredt = 0.0;
                                                                $difdebit = 0.0;
                                                                while ($rows = mysqli_fetch_array($resultset)) {
                                                                    $credit += $rows['credit'];
                                                                    $debit += $rows['debit'];
                                                                    echo "<tr>";
                                                                    echo "<td>" . $rows['paydate'] . "</td>";
                                                                    echo "<td>" . $rows['id'] . "</td>";
                                                                    echo "<td>" . $rows['party_name'] . "</td>";
                                                                    echo "<td>" . $rows['type'] . "</td>";
                                                                    echo "<td>" . $rows['credit'] . "</td>";
                                                                    echo "<td>" . $rows['debit'] . "</td>";
                                                                    echo "</tr>";
                                                                }
                                                                $diff = $credit - $debit;
                                                                if ($diff < 0) {
                                                                    $difcredt = $diff;
                                                                } else {
                                                                    $difdebit = $diff;
                                                                }
                                                                echo "<tr>";
                                                                echo "<td></td>";
                                                                echo "<td></td>";
                                                                echo "<td></td>";
                                                                echo "<td>Current Total</td>";
                                                                echo "<td>" . $credit . "</td>";
                                                                echo "<td>" . $debit . "</td>";
                                                                echo "</tr>";
                                                                echo "<tr>";
                                                                echo "<td></td>";
                                                                echo "<td></td>";
                                                                echo "<td></td>";
                                                                echo "<td>Closing Balance</td>";
                                                                echo "<td>" . $difcredt . "</td>";
                                                                echo "<td>" . $difdebit . "</td>";
                                                                echo "</tr>";
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

                            <!-- /content-wrapper -->

                            <script src="assets/js/king-common.js"></script>
                            <script src="assets/js/plugins/bootstrap-multiselect/bootstrap-multiselect.js"></script>
                            <script src="assets/js/plugins/parsley-validation/parsley.min.js"></script>
                            <script src="assets/js/king-elements.js"></script>
                            <script src="assets/js/plugins/datatable/jquery.dataTables.min.js"></script>
                            <script src="assets/js/plugins/datatable/exts/dataTables.colVis.bootstrap.js"></script>
                            <script src="assets/js/plugins/datatable/exts/dataTables.colReorder.min.js"></script>
                            <script src="assets/js/plugins/datatable/exts/dataTables.tableTools.min.js"></script>
                            <script src="assets/js/plugins/datatable/dataTables.bootstrap.js"></script>
                            <script src="assets/js/king-table.js"></script>


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
<script src="customFile/addItemJs.js"></script>
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
<script src="assets/js/king-elements.js"></script>
<script src="assets/js/plugins/select2/select2.min.js"></script>
<link href="assets/js/datatable/css/summernote.css" rel="stylesheet">
<script src="assets/js/datatable/datatable-js/summernote.js"></script>
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
    var datefrm = yyyy + "-" + mm + "-01" ;
    document.getElementById("datevaluefrm").value = datefrm;
    document.getElementById("datevalueto").value = date;
</script>
<script type="text/javascript">
//    $(document).ready(function () {
//        $(".add-row").click(function () {
//            var name = $("#name").val();
//            var email = $("#email").val();
//            var markup = "<tr><td><input type='checkbox' name='record'></td><td>" + name + "</td><td>" + email + "</td></tr>";
//            $("table tbody").append(markup);
//        });
//
//        // Find and remove selected table rows
//        $(".delete-row").click(function () {
//            $("table tbody").find('input[name="record"]').each(function () {
//                if ($(this).is(":checked")) {
//                    $(this).parents("tr").remove();
//                }
//            });
//        });
//    });
</script>
<script>
//    $("#party_list").on('change', function ()
//    {
//
//        var f_date = $('#from_date').val();
//        var l_date = $('#to_date').val();
//        var party_id = $("#party_list").val();
//        var my_object = {"p_id": party_id, "f_date": f_date, "l_date": l_date};
//
//        $.ajax({
//            url: 'getPartyStatement.php',
//            dataType: "html",
//            data: my_object,
//            cache: false,
//            success: function (Data) {
//                $('#view_data').html(Data);
//            },
//            error: function (errorThrown) {
//                alert(errorThrown);
//                alert("There is an error with AJAX!");
//            }
//        });
//    });
</script>
</body>
</html>




