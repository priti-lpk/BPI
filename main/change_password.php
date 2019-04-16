<?php
//ob_start();
//include './shreeLib/session_info.php';
include_once 'shreeLib/DBAdapter.php';
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Change Password</title>
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
                                    <h4 class="page-title">Change Password</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="page-content-wrapper">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">                   
                                            <form action="" id="form_data" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" >  
                                                <h4 class="mt-0 header-title">Textual inputs</h4>
                                                <div class="form-group row">
                                                    <?php
//                                                    include_once './config/session_info.php';
                                                    if ($_SESSION['user_id']) {
                                                        ?>
                                                        <input type = "hidden" name = "pwd_id" id = "pwd_id" value = "<?php echo $_SESSION['user_id']; ?>">
                                                    <?php } ?>
                                                    <label for = "example-text-input" class = "col-sm-2 col-form-label">Old password</label>
                                                    <div class = "col-sm-10">
                                                        <input class = "form-control" type = "text" value = "" id = "old_pwd" name = "old_pwd" placeholder = "Old password" required>
                                                    </div>
                                                </div>
                                                <div class = "col-md-12">
                                                    <p id = 'waitFor'></p>
                                                </div>
                                                <div class = "form-group row">
                                                    <label for = "example-text-input" class = "col-sm-2 col-form-label">New password</label>
                                                    <div class = "col-sm-10">
                                                        <input class = "form-control" type = "text" value = "" id = "new_pwd" name = "new_pwd" placeholder = "New password" required>
                                                    </div>
                                                </div>
                                                <div class = "form-group row">
                                                    <label for = "example-text-input" class = "col-sm-2 col-form-label">Confirm password</label>
                                                    <div class = "col-sm-10">
                                                        <input class = "form-control" type = "text" value = "" id = "con_pwd" name = "con_pwd" placeholder = "Confirm password" required>
                                                    </div>
                                                </div>
                                                <div class = "col-md-12">
                                                    <p id = 'compare'></p>
                                                </div>
                                                <div class = "form-group row">
                                                    <div class = "col-sm-offset-3 col-sm-2">
                                                        <button type = "button" id = "changePass" class = "btn btn-primary btn-block waves-effect waves-light">Change Password</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                            <!--end row-->


                        </div>

                        <!--end page content-->

                    </div> <!--container-fluid -->

                </div> <!--content -->

                <?php include 'footer.php'
                ?>

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
            $(document).ready(function () {
                var oldMatched = 0;
                var bothMatched = 0;

                $('#old_pwd').on('blur', function () {
                    var dataString = 'id=' + $('#pwd_id').val() + '&old=' + $('#old_pwd').val();
                    // alert(dataString);
                    if (!$('#old_pwd').val() == '')
                    {
                        $.ajax({
                            type: "POST",
                            url: "change.php",
                            data: dataString,
                            cache: false,
                            success: function (data) {
                                //alert(data);
                                if (data == 1)
                                {
                                    $('#waitFor').html('Password matched');
                                    oldMatched = 1;
                                } else {
                                    $('#waitFor').html('Password does not match!');
                                    oldMatched = 0;
                                    $('#old_pwd').focus();
                                }
                            }
                        });
                    }
                });
                $('#new_pwd').on('blur', function () {
                    if ($('#new_pwd').val() == '')
                    {
                        $('#compare').html('new password can not be blank!');
                        bothMatched = 0;
                    } else
                    {
                        $('#compare').html('please confirm password');
                    }

                });
                $('#con_pwd').on('blur', function () {
                    if ($('#new_pwd').val() != $('#con_pwd').val())
                    {
                        $('#compare').html('Both passwords mismatched!');
                        bothMatched = 0;
                    } else
                    {
                        $('#compare').css('color', 'green');
                        $('#compare').html('Passwords matched');
                        bothMatched = 1;
                    }
                    if ($('#con_pwd').val() == '')
                    {
                        $('#compare').html('confirm password can not be blank!');
                        bothMatched = 0;
                    }
                });
                $('#changePass').click(function () {
                    if (oldMatched == '0')
                    {
                        $('#waitFor').html('provide valid password!');
                        $('#old_pwd').focus();
                    }
                    if (bothMatched == '0')
                    {
                        $('#compare').html('please check new and confirm password!');
                        $('#new_pwd').focus();
                    }
                    if ((oldMatched == '1') && (bothMatched == '1'))
                    {
                        var dataString = 'change=' + $('#pwd_id').val() + '&new=' + $('#new_pwd').val();
                        $.ajax({
                            type: "POST",
                            url: "change.php",
                            data: dataString,
                            cache: false,
                            beforeSend: function () {
                                $('#changePass').html('Changing Now...');
                            },
                            success: function (data) {
                                //  alert(data);
                                if (data == 1)
                                {
                                    //				$('#compare').html('Password changed successfully');
                                    location.href = alert('Password changed Successfully');
                                    top.location = 'change_password.php';
                                    $('#changePass').html('Change Now');
                                    $('#changePass').attr('disabled', true);

                                } else
                                {
                                    //				$('#compare').html('Couldn\'t Change Password! Try Again');
                                    location.href = alert('Couldn\'t Change Password! Try Again');
                                    top.location = 'change_password.php';
                                    $('#changePass').html('Ooops!');
                                    $('#changePass').attr('disabled', true);

                                }
                            }});
                    }
                });
            });
        </script>
    </body>

</html>