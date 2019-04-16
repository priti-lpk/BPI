<?php
include_once 'shreeLib/DBAdapter.php';
include_once 'shreeLib/dbconn.php';

if (isset($_GET['type']) && isset($_GET['id'])) {
    $edba = new DBAdapter();
    $edata = $edba->getRow("create_user", array("*"), "id=" . $_GET['id']);
    echo "<input type='hidden' id='create_user_id' value='" . $_GET['id'] . "'>";

    $field1 = array("COUNT(mod_id)");
    $countrow = $edba->getRow("role_rights", $field1, "user_id=" . $_GET['id']);
    //$crow= count($countrow[0][1]);
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
            if (isset($_GET['type']) && isset($_GET['id'])) {
                echo 'Edit User Field';
            } else {
                echo 'Add User Field';
            }
            ?></title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="Themesbrand" name="author" />
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <link href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
        <link href="plugins/bootstrap-md-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
        <link href="plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

        <link href="plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
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
                                    <h4 class="page-title">User Field</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="page-content-wrapper">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">                   
                                            <form action="customFile/UserFieldPro.php" id="form_data" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" >  
                                                <h4 class="mt-0 header-title">Textual inputs</h4>
                                                <button type="button" id="enable" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#addbranch"><b>Add New Branch</b></button><br><br>

                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Select Branch</label>
                                                    <div class="col-sm-4" id="branchlist">
                                                        <select class="form-control select2" name="branch_id" id="create_branch" onchange="clear_rdbtn();" required="">
                                                            <option>Select Branch</option>
                                                            <?php
                                                            $dba = new DBAdapter();
                                                            $data = $dba->getRow("create_branch", array("id", "branch_name"), "branch_status='true'");
                                                            foreach ($data as $subData) {
                                                                echo" <option " . ($subData[0] == $edata[0][1] ? 'selected' : '') . " value='" . $subData[0] . "'>" . $subData[1] . "</option> ";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Select Role</label>
                                                    <div class="col-sm-4" id="sub_list">
                                                        <select class="form-control select2" name="roles_id" id="role_master" onchange="clear_rdbtn();getrole();" required="">
                                                            <option>Select Role</option>
                                                            <?php
                                                            $dba = new DBAdapter();
                                                            $data = $dba->getRow("role_master", array("id", "role_name"), "1");
                                                            foreach ($data as $subData) {
                                                                echo" <option " . ($subData[0] == $edata[0][2] ? 'selected' : '') . " value='" . $subData[0] . "'multiple>" . $subData[1] . "</option> ";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">

                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Role Rights</label>
                                                    <div class = "col-sm-10">
                                                        <select name="role_rights_id[]" id="role_master1" class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Choose ...">
                                                            <?php
                                                            $dba = new DBAdapter();
                                                            $data = $dba->getRow("role_master", array("id", "role_name"), "1");
                                                            $json = json_decode($edata[0][3], true);
                                                            foreach ($data as $subData) {
                                                                echo" <option " . ($subData[0] == in_array($subData[0], $json) ? 'selected' : '') . " value='" . $subData[0] . "'>" . $subData[1] . "</option> ";
                                                            }
                                                            ?>
                                                        </select>

                                                        <input name="disable" type="hidden" id="disable" value="0">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Select Head Master</label>
                                                    <div class="col-sm-10">
                                                        <select class="form-control select2" name="role_user_id" id="create_user" onchange="clear_rdbtn();" required="">
                                                            <option value="0">Select Head Master</option>
                                                            <?php
                                                            $dba = new DBAdapter();
                                                            $data = $dba->getRow("create_user", array("id", "user_fullname"), "1");
                                                            foreach ($data as $subData) {
                                                                echo" <option " . ($subData[0] == $edata[0][4] ? 'selected' : '') . " value='" . $subData[0] . "'multiple>" . $subData[1] . "</option> ";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">User FullName</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" type="text"  placeholder="User Fullname" id="user_fullname" name="user_fullname" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][5] : ''); ?>" required="">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">User Contact</label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" type="text"  placeholder="User Contact" id="user_contact" name="user_contact" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][6] : ''); ?>" required="">
                                                    </div>
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">User Email</label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" type="text"  placeholder="User Email" id="user_email" name="user_email" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][7] : ''); ?>" required="">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Login Username</label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" type="text"  placeholder="Login Username" id="user_login_username" name="user_login_username" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][8] : ''); ?>" required="">
                                                        <div id="user-msg" class="text-danger"></div>
                                                    </div>
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Login Password</label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" type="password"  placeholder="Login Password" id="user_login_password" name="user_login_password" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][9] : ''); ?>" required="">
                                                        <div id="pass-conf" class="text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="button-items">
                                                    <input type="hidden" name="action" id="action" value="<?php echo (isset($_GET['id']) ? 'edit' : 'add') ?>"/>
                                                    <input type="hidden" name="id" id="id" value="<?php echo (isset($_GET['id']) ? $edata[0][0] : '') ?>"/>
                                                    <button type="submit" id="btn_save" class="btn btn-primary waves-effect waves-light"><?php echo (isset($_GET['type']) && isset($_GET['id']) ? 'Edit' : 'Save') ?></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->
                            <!-- end row -->

                        </div>
                        <!-- end page content-->

                    </div> <!-- container-fluid -->

                </div>
            </div>

            <!-- end page content-->

        </div> <!-- container-fluid -->

    </div> <!-- content -->
    <div class="col-sm-6 col-md-3 m-t-30">
        <div class="modal fade" id="addbranch" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0">Add New Branch</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:void(0);" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" onsubmit="addBranch();" >
                            <div class="form-group row" >
                                <label for="example-text-input" class="col-sm-4 col-form-label">Branch Name</label>
                                <div class="col-sm-7">
                                    <input class="form-control" type="text"  placeholder="Branch Name" id="branch_name" name="branch_name" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $datas[0][1] : ''); ?>" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label">Branch Address</label>
                                <div class="col-sm-7">
                                    <input class="form-control" type="text"  placeholder="Branch Address" id="branch_address" name="branch_address" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $datas[0][2] : ''); ?>" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label">Branch Contact</label>
                                <div class="col-sm-7">
                                    <input class="form-control" type="text"  placeholder="Branch Contact" id="branch_contact" name="branch_contact" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $datas[0][3] : ''); ?>" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label">Branch Email</label>
                                <div class="col-sm-7">
                                    <input class="form-control" type="text"  placeholder="Branch Email" id="branch_email" name="branch_email" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $datas[0][4] : ''); ?>" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label">Status</label>
                                <input type="checkbox" id="branch_status" id="switch1" name="branch_status"  switch="none" checked/>
                                <label for="branch_status" data-on-label="On" data-off-label="Off"></label>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light"  data-toggle="modal" onClick="addBranch(); getbranch();">Save changes</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
    <?php include 'footer.php' ?>

</div>


<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->


</div>
<!-- END wrapper -->


<!-- jQuery  -->
<script src="customFile/createbranchJs.js"></script>

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
<script src="assets/pages/datatables.init.js"></script>

<!-- Plugins Init js -->
<script src="assets/pages/form-advanced.js"></script>
<!-- App js -->
<script src="assets/js/app.js"></script>

<script type="text/javascript">

                            function getrole() {

                                var value = $("#role_master").find(":selected").val();
                                var dataString = 'create-rights=' + value;
                                //alert(dataString);
                                $.ajax({
                                    url: 'validation.php',
                                    dataType: "html",
                                    data: dataString,
                                    cache: false,
                                    success: function (Data) {
                                        //alert(Data);
                                        var useri = Data;
                                        if (useri == 1) {
                                            //$("#user-msgm").text(" You Check Other Option..");
                                            $("#role_master1").prop('disabled', false);
                                        } else {
                                            $("#user-msgm").text("");
                                            $("#role_master1").prop('disabled', true);
                                            $("#disable").val("1");

                                        }

                                    },
                                    error: function (errorThrown) {
                                        alert(errorThrown);
                                        alert("There is an error with AJAX!");
                                    }
                                });
                            }
                            ;
                            function clear_rdbtn() {
                                $("#user-msg3").text("");
                                $("#btn_save").prop('disabled', false);

                            }
                            ;
</script>
<script type="text/javascript">

    $('#user_login_username').focusout(function () {
        var username = document.getElementById("user_login_username").value;

        var my_object = "user-name=" + username;
        $.ajax({
            url: 'validation.php',
            dataType: "html",
            data: my_object,
            cache: false,
            success: function (Data) {
                //  alert(Data);
                var useri = Data;
                if (useri == 1) {
                    $("#user-msg").text("This user name already exist!");
                    $("#btn_save").prop('disabled', true);
                } else {
                    $("#user-msg").text("");
                    $("#btn_save").prop('disabled', false);
                }

                //$('#view_data1').html(Data);
            },
            error: function (errorThrown) {
                alert(errorThrown);
                alert("There is an error with AJAX!");
            }
        });
    });</script>

<script type="text/javascript">
    function checkPasswordMatch() {
        var password = $("#user_pass").val();
        var confirmPassword = $("#user_conpass").val();

        if (password != confirmPassword) {
            $("#pass-conf").text("Password does not math!!");
            $("#btn_save").prop('disabled', true);
        } else {
            $("#pass-conf").text("");
            $("#btn_save").prop('disabled', false);
        }

    }
</script>

<script type="text/javascript">
    function getbranch() {

        $.ajax({
            url: 'getNewBranch.php',
            dataType: "html",
            cache: false,
            success: function (Data) {
                //alert(Data);
                $('#branchlist').html(Data);
            },
            error: function (errorThrown) {
                alert(errorThrown);
                alert("There is an error with AJAX!");
            }
        });
    }
    ;</script>


<script>
    function AvoidSpace(event) {
        var k = event ? event.which : window.event.keyCode;
        if (k == 32)
            return false;
    }

</script>
<script type="text/javascript">
    var text = document.getElementById('user_login_username');
    text.addEventListener('input', function (e) {
        var keyCode = e.keyCode ? e.keyCode : e.which;
        this.value = this.value.replace(/\s/g, '')
        if (keyCode === 32)
            return;
    })

</script>


<script type="text/javascript">

    var editdata =<?php echo (isset($_GET['id']) ? $edata[0][0] : '') ?>;
    if (editdata === <?php echo (isset($_GET['id']) ? $edata[0][0] : '') ?>) {
        document.getElementById("user_login_username").disabled = true;

    }

</script>
<script type="text/javascript">

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
<script type="text/javascript">
    function SetForDelete(id) {
        location.href = "Delete.php?type=main_category&id=" + id;
    }
</script>
</body>

</html>