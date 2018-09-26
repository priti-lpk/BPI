<?php
ob_start();
include_once 'shreeLib/DBAdapter.php';
include './shreeLib/session_info.php';

if (isset($_GET['type']) && isset($_GET['id'])) {
    $edba = new DBAdapter();
    $field = array("payment_list.id,party_list.party_name,payment_list.party_due,payment_list.pay_crdb,payment_list.pay_amount,payment_list.pay_discount,payment_list.remain_amount,payment_list.pay_type,payment_list.bank_name,payment_list.cheque_no,payment_list.pay_date,payment_list.pay_note,payment_list.party_crdb");
    $edata = $edba->getRow("payment_list INNER JOIN party_list ON payment_list.party_id=party_list.id", $field, "payment_list.id=" . $_GET['id']);
    echo "<input type='hidden' id='payment_id' value='" . $_GET['id'] . "'>";
}
if (isset($_SESSION['user_id'])) {
    $edba = new DBAdapter();
    $servername1 = basename($_SERVER['PHP_SELF']);
    //echo $servername1;
    $field = array("role_rights.id");
    $mod_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " module.mod_pagename='" . $servername1 . "' and role_rights.user_id=" . $_SESSION['user_id']);
    echo "<input type='hidden' id='user_id' value='" . $mod_data[0][0] . "'>";

    $field = array("role_rights.id,role_rights.role_edit,role_rights.role_delete,role_rights.role_create");
    $role_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " role_rights.id=" . $mod_data[0][0]);
    echo "<input type='hidden' id='user_id' value='" . $role_data[0][3] . "'>";
}
?>
<!DOCTYPE html>
<html lang="en" class="no-js">

    <head>
        <title>
            <?php
            if (isset($_GET['type'])) {
                echo 'Edit Payment';
            } else {
                echo 'Add New Payment';
            }
            ?>
        </title>
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
                                        <li class="active">Add Payment</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- main -->
                            <div class="content">
                                <div class="main-header">
                                    <h2>Create Payment</h2>
                                    <em>Add Payment</em>
                                </div>
                                <div class="main-content">
                                    <!-- WYSIWYG EDITOR -->
                                    <button type="submit" id="enable" class="btn btn-default btn-sm" data-toggle="modal" data-target="#addparty"><b>Add New Party</b></button><br><br>

                                    <form action="customFile/addPaymentPro.php" id="form_data" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" >  

                                        <div class="form-group">
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblselectparty">Select Party</label>
                                            <div class="col-sm-3" id="partylist">
                                                <select name="party_id" id="party_list" class="select2" required>
                                                    <option value="">Select Party</option>
                                                    <?php
                                                    $dba = new DBAdapter();
                                                    $last_id = $dba->getLastID("branch_id", "system_user", "id=" . $_SESSION['user_id']);
                                                    $data = $dba->getRow("party_list", array("id", "party_name"), "branch_id=" . $last_id);
                                                    foreach ($data as $subData) {
                                                        echo "<option " . ($subData[1] == $edata[0][1] ? 'selected' : '') . " value=" . $subData[0] . ">" . $subData[1] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <!--                                        </div>
                                                                                    <div class="form-group">-->
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblpartydue">Party Due</label>
                                            <div class="col-sm-3" id="partydue">
                                                <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][2] : '') ?>" name="party_due" id="party_due" class="form-control" placeholder="Party Due" required>
                                                <label for="ticket-name" class="col-sm-2 control-label" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][12] : '') ?>"  id="lblparty">Cr/Db</label>
                                                <input type="hidden" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][12] : '') ?>" name="party_crdb" id="party_crdb" class="form-control"  required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblselectparty">Type</label>
                                            <div class="col-sm-3" id="typelist">
                                                <select name="pay_crdb" id="type" class="select2" required>
                                                    <?php if (isset($_GET['id'])) { ?>
                                                        <option value = "Credit"<?php echo $edata[0][3] == 'Credit' ? ' selected="selected"' : '';
                                                        ?>>Credit</option>
                                                        <option value="Debit"<?php echo $edata[0][3] == 'Debit' ? ' selected="selected"' : ''; ?>>Debit</option>
                                                    <?php } else {
                                                        ?>
                                                        <option value="">Select Pay CrDb</option>
                                                        <option value="Credit">Credit</option>
                                                        <option value="Debit">Debit</option>
                                                    <?php }
                                                    ?>

                                                </select>

                                            </div>
                                            <input type="hidden" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][3] : '') ?>" name="tag_pay_type" id="party_pay_type" class="form-control">

                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblpartydue">Amount</label>
                                            <div class="col-sm-3" id="partydue">
                                                <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][4] : '') ?>" name="pay_amount" id="pay_amount" class="form-control" placeholder="Payment Amount" required>
                                            </div>
                                            <input type="hidden" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][4] : '') ?>" name="tag_pay_amount" id="tag_pay_amount" class="form-control">
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblpartydue">Discount(%)</label>
                                            <div class="col-sm-3" id="partydue">
                                                <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][5] : 0.0) ?>" name="pay_discount" id="pay_discount" class="form-control" placeholder="Discount" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblcatname">Remain amount</label>
                                            <div class="col-sm-3" id="partydue">
                                                <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][6] : '') ?>" name="remain_amount" id="remain_amount" class="form-control" placeholder="Remain Amount" required>
                                            </div>

                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblselectparty"> Pay Type</label>
                                            <div class="col-sm-3" id="typelist">
                                                <select name="pay_type" id="ptype" class="select2" required>
                                                    <?php if (isset($_GET['id'])) { ?>
                                                        <option value = "Cash"<?php echo $edata[0][7] == 'Cash' ? ' selected="selected"' : '';
                                                        ?>>Cash</option>
                                                        <option value="Cheque"<?php echo $edata[0][7] == 'Cheque' ? ' selected="selected"' : ''; ?>>Cheque</option>
                                                    <?php } else {
                                                        ?>
                                                        <option value="">Select Pay</option>
                                                        <option value="Cash">Cash</option>
                                                        <option value="Cheque">Cheque</option>
                                                    <?php }
                                                    ?>
                                                </select>

                                            </div>
                                            <!--                                        </div>
                                                                                    <div class="form-group">-->
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblpartydue">Bank Name</label>
                                            <div class="col-sm-3" id="partydue">
                                                <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][8] : '') ?>" name="bank_name" id="bank_name" class="form-control" placeholder="Bank Name" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblpartydue">Cheque No.</label>
                                            <div class="col-sm-3" id="partydue">
                                                <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][9] : '') ?>" name="cheque_no" id="cheque_no" class="form-control" placeholder="Cheque No." >
                                            </div>
                                            <!--                                        </div>
                                                                                    <div class="form-group">-->
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblpartydue">Pay Date</label>
                                            <div class="col-sm-3" id="partydue">
                                                <input type="date" id="datevalue" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][10] : '') ?>" name="pay_date" id="pay_date" class="form-control" placeholder="Date" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblpartydue">Note</label>
                                            <div class="col-sm-3" id="partynote">
                                                <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][11] : '') ?>" name="pay_note" id="pay_note" class="form-control" placeholder="Note" required>
                                            </div>
                                        </div>
                                        <div class="widget-footer">
                                            <input type="hidden" name="user_info" id="user_info" value="<?php echo (isset($_SESSION['user_id']) ? $_SESSION['user_name'] : "") ?>"/>

                                            <input type="hidden" name="action" id="action" value="<?php echo (isset($_GET['id']) ? 'edit' : 'add') ?>">
                                            <input type="hidden" name="payment_id" id="std_id" value="<?php echo (isset($_GET['id']) ? $_GET['id'] : "") ?>">
                                            <button type="submit" id="btn_save"  class="btn btn-primary"><i class="fa fa-floppy-o"></i> <?php echo (isset($_GET['type']) && isset($_GET['id']) ? 'Edit' : 'Save') ?></button>
                                        </div>

                                        <div class="main-content">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="widget widget-table">
                                                        <div class="widget-header">
                                                            <h3><i class="fa fa-table"></i>Payment List</h3>
                                                        </div>
                                                        <div class="widget-content">
                                                            <table id="featured-datatable" class="table table-sorting table-striped table-hover datatable">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Party Name</th>
                                                                        <th>Cr/Db</th>
                                                                        <th>Pay Amount</th>
                                                                        <th>Discount</th>
                                                                        <th>Date</th>
                                                                        <th>Pay Type</th>
                                                                        <th>Cheque No.</th>
                                                                        <th>Note</th>
                                                                        <?php if ($role_data[0][1] == 1) { ?>
                                                                            <th>Edit</th> <?php } ?>
                                                                        <?php if ($role_data[0][2] == 1) { ?> <th>Delete</th><?php } ?>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    include_once 'shreeLib/DBAdapter.php';
                                                                    $dba = new DBAdapter();
                                                                    $field = array("payment_list.id,party_list.party_name,payment_list.pay_crdb,payment_list.pay_amount,payment_list.pay_discount,payment_list.pay_date,payment_list.pay_type,payment_list.cheque_no,payment_list.pay_note");
                                                                    $data = $dba->getRow("payment_list INNER JOIN party_list ON party_list.id = payment_list.party_id", $field, "1");
                                                                    $count = count($data);
                                                                    if ($count >= 1) {
                                                                        foreach ($data as $subData) {
                                                                            echo "<tr>";
                                                                            echo "<td>" . $subData[0] . "</td>";
                                                                            echo "<td>" . $subData[1] . "</td>";
                                                                            echo "<td>" . $subData[2] . "</td>";
                                                                            echo "<td>" . $subData[3] . "</td>";
                                                                            echo "<td>" . $subData[4] . "</td>";
                                                                            echo "<td>" . $subData[5] . "</td>";
                                                                            echo "<td>" . $subData[6] . "</td>";
                                                                            echo "<td>" . $subData[7] . "</td>";
                                                                            echo "<td>" . $subData[8] . "</td>";
                                                                            if ($role_data[0][1] == 1) {
                                                                                echo "<td><a href='AddPayment.php?type=edit&id=" . $subData[0] . "' class='btn btn-primary' id='" . $subData[0] . "'><i class='fa fa-edit'></i> Edit</a></td>";
                                                                            }

                                                                            if ($role_data[0][2] == 1) {
                                                                                echo "<td> <button class='btn btn-danger btn_delete' id='" . $subData[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash-o'>  Delete</button></td>";
                                                                            }
                                                                            // echo "<td><a href='AddPayment.php?type=edit&id=" . $subData[0] . "' class='btn btn-primary' id='" . $subData[0] . "'><i class='fa fa-edit'></i> Edit</a> <button class='btn btn-danger' id='" . $subData[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash-o'>  Delete</button></td></tr>";
                                                                            echo '</tr>';
                                                                        }
                                                                    } else {
                                                                        echo 'No Data Available';
                                                                    }
                                                                    ?>                                                        
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                                      
                                    </form>
                                    <!-- /main-content -->
                                </div>
                                <!-- /main -->
                            </div>
                            <!-- /content-wrapper -->
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
        <div class="modal fade" id="addparty" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                        <h4 class="modal-title" id="myModalLabel">Add New Party</h4>

                    </div>

                    <div class="modal-body">                                        
                        <div id="form">
                            <form action="javascript:void(0);" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" onsubmit="addParty();" >
                                <div class="form-group">
                                    <label  for="ticket-name" class="col-sm-2 control-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="party_name" id="party_name" class="form-control" placeholder="Name" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ticket-name" class="col-sm-2 control-label">Contact</label>
                                    <div class="col-sm-10">
                                        <input type="text"  name="party_contact" id="party_contact" class="form-control" placeholder="Contact No" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ticket-name" class="col-sm-2 control-label">Address</label>
                                    <div class="col-sm-10">
                                        <input type="text"  name="party_address" id="party_address" class="form-control" placeholder="Address" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ticket-name" class="col-sm-2 control-label">GST No.</label>
                                    <div class="col-sm-10">
                                        <input type="text"  name="party_gstno" id="party_gstno" class="form-control" placeholder="GST no." required="" style="text-transform:uppercase">
                                    </div>
                                </div>
                                <div class="modal-footer">
                            <!--<input type="hidden" name="action" id="action" value="add"/>-->
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>

                                    <button type="submit" class="btn btn-custom-primary" ><i class="fa fa-check-circle" ></i>Add</button>

                                </div>
                            </form>
                        </div>

                    </div>

                </div>

            </div>

        </div>
        
        <!-- FOOTER -->
        <footer class="footer">
            2018 © <a href="http://lpktechnosoft.com" target="_blank">LPK Technosoft</a>
        </footer>  

        <!-- END FOOTER -->
        <!-- Javascript -->
        <script src="customFile/createpartyJs.js"></script>
        <script src="assets/js/jquery/jquery-2.1.0.min.js"></script>
        <script src="assets/js/jquery/jquery-1.12.4.min.js"></script>
        <script src="assets/js/bootstrap/bootstrap.js"></script>
        <script src="assets/js/plugins/modernizr/modernizr.js"></script>
        <script src="assets/js/plugins/bootstrap-tour/bootstrap-tour.custom.js"></script>
        <script src="assets/js/king-common.js"></script>
        <script src="demo-style-switcher/assets/js/deliswitch.js"></script>
        <!--<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.7/summernote.css" rel="stylesheet">
        <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.7/summernote.js"></script>-->
        <script src="assets/js/plugins/markdown/markdown.js"></script>
        <script src="assets/js/plugins/markdown/to-markdown.js"></script>
        <script src="assets/js/plugins/markdown/bootstrap-markdown.js"></script>
        <!--<script src="assets/js/king-elements.js"></script>-->
        <script src="assets/js/plugins/select2/select2.min.js"></script>
        <script>
                                $("#party_list").on('change', function ()
                                {
                                    var id = $(this).find(":selected").val();
                                    var dataString = 'id=' + id;
                                    $.ajax({
                                        url: 'getPartyamount.php',
                                        dataType: "html",
                                        data: dataString,
                                        cache: false,
                                        success: function (Data) {
                                            var amt = Data;
                                            if (amt < 0) {
                                                $('#party_due').val(amt * (-1));
                                                $('#lblparty').text('Credit');
                                                $('#party_crdb').val('Credit');
                                            } else {
                                                $('#party_due').val(Data);
                                                $('#lblparty').text('Debit');
                                                $('#party_crdb').val('Debit');
                                            }
                                        },
                                        error: function (errorThrown) {
                                            alert(errorThrown);
                                            alert("There is an error with AJAX!");
                                        }
                                    });
                                });
                                $('#pay_amount').on('keyup', function () {
                                    var damount = document.getElementById("party_due").value;
                                    var amount = document.getElementById("pay_amount").value;
                                    var total = damount - amount;
                                    document.getElementById("remain_amount").value = parseFloat(total).toFixed(2);
                                    // document.getElementById("total_hidden").value = document.getElementById("total" + index).value;
                                });
                                $('#pay_discount').on('keyup', function () {
                                    var damount = document.getElementById("party_due").value;
                                    var amount = document.getElementById("pay_amount").value;
                                    var dsct = document.getElementById("pay_discount").value;
                                    var amountdsct = amount * (dsct / 100);
                                    var total = damount - amount - amountdsct;
                                    document.getElementById("remain_amount").value = parseFloat(total).toFixed(2);
                                    // document.getElementById("total_hidden").value = document.getElementById("total" + index).value;
                                });
                                $('#ptype').on('click', function () {
                                    if ($(this).val() == 'Cash') {
                                        $('#bank_name').prop("disabled", true);
                                        $('#cheque_no').prop("disabled", true);
                                    } else {
                                        $('#bank_name').prop("disabled", false);
                                        $('#cheque_no').prop("disabled", false);
                                    }
                                });
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
                                                    location.href = "Delete.php?type=payment_list&id=" + id;
                                                    swal("Deleted!", "Category has been deleted.", "success");
                                                } else {
                                                    swal("Cancelled", "You have cancelled this :)", "error");
                                                }
                                            });
                                }
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
            document.getElementById("datevalue").value = date;
        </script>
        <script type="text/javascript">
            function getparty() {

                $.ajax({
                    url: 'getNewParty.php',
                    dataType: "html",
                    cache: false,
                    success: function (Data) {
                        // alert(Data);
                        $('#partylist').html(Data);
                        $('#party_due').val('0');
                    },
                    error: function (errorThrown) {
                        alert(errorThrown);
                        alert("There is an error with AJAX!");
                    }
                });
            }
            ;

        </script>
        <script type="text/javascript">

            var btn_crate =<?php echo (isset($_SESSION['user_id']) ? $role_data[0][3] : '') ?>;

            var btn_edit =<?php echo (isset($_GET['id']) ? 1 : 0) ?>;

            if (btn_crate === 0) {
                $('#btn_save').prop('disabled', true);
            }
            if (btn_edit === 1) {
                $('#btn_save').prop('disabled', false);
            }

        </script>
    </body>
</html>


