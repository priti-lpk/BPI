<?php
include './shreeLib/session_info.php';
?>

<html lang="en" class="no-js">
    <head>
        <title>Change Passwrd</title>
    </head>
    <body class="form-val topnav-fixed ">
        <!-- WRAPPER -->
        <div id="wrapper" class="wrapper">
            <?php include './topbar.php'; ?>
            <?php include './sidebar.php'; ?>

            <!-- content-wrapper -->

            <div id="main-content-wrapper" class="content-wrapper ">
                <!-- top general alert -->
                <!-- end top general alert -->
                <div class="row">
                    <div class="col-lg-4 ">
                        <ul class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="home.php">Home</a></li>
                            <li class="active">Chang Password</li>
                        </ul>
                    </div>
                </div>

                <!-- main -->

                <div class="content">
                    <div class="main-header">
                        <h2>Change Password</h2>
                        <em>Add New Password</em>
                    </div>

                    <div class="main-content">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BASIC VALIDATION -->

                                <div class="widget">
                                    <div class="widget-header">
                                        <h3><i class="fa fa-check"></i>Change Password</h3>
                                    </div>

                                    <div class="widget-content">
                                        <form class="form-horizontal"  role="form">
                                            <div class="form-group">
                                                <label for="ticket-type" class="col-sm-3 control-label">Old password</label>

                                                <div class="col-sm-9 ssd">
                                                    <input type="hidden" name="pwd_id" id="pwd_id" value="1">
                                                    <input type="password" placeholder="Old Password" name="old_pwd" id="old_pwd" class="form-control" >
                                                </div>
                                                <div class="col-md-12">
                                                    <p id='waitFor'></p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="ticket-type" class="col-sm-3 control-label">New password</label>
                                                <div class="col-sm-9">
                                                    <input type="password" placeholder="New Password" name="new_pwd" id="new_pwd" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="ticket-type" class="col-sm-3 control-label">Confirm password</label>
                                                <div class="col-sm-9">
                                                   <input type="password" placeholder="Confirm Password" name="con_pwd" id="con_pwd" class="form-control" >
                                                </div>
                                                <div class="col-md-12">
                                                    <p id='compare'></p>
                                                </div> 
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-9">
                                                    <button type="button" id="changePass" class="btn btn-primary btn-block">Change Password</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- END BASIC VALIDATION -->
                        </div>
                    </div>
                </div>
                <!-- /main-content -->
            </div>
            <!-- /main -->
        </div>

        <?php include './footer.php'; ?>
        <script>
            $(document).ready(function () {
                var oldMatched = 0;
                var bothMatched = 0;
                $('#old_pwd').on('input', function () {
                    $('#waitFor').html('checking your password..');
                    if ($('#old_pwd').val() == '')
                    {
                        $('#waitFor').html('old password can not be blank!');
                        oldMatched = 0;
                    }
                });
                $('#old_pwd').on('blur', function () {
                    var dataString = 'id=' + $('#pwd_id').val() + '&old=' + $('#old_pwd').val();
                    if (!$('#old_pwd').val() == '')
                    {
                        $.ajax({
                            type: "POST",
                            url: "change.php",
                            data: dataString,
                            cache: false,
                            success: function (data) {
                                if (data == '1')
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
                                if (data == '1')
                                {
//				$('#compare').html('Password changed successfully');
                                    location.href = alert('Password changed Successfully');
                                    top.location = 'chang_pass.php';
                                    $('#changePass').html('Change Now');
                                    $('#changePass').attr('disabled', true);

                                } else
                                {
//				$('#compare').html('Couldn\'t Change Password! Try Again');
                                    location.href = alert('Couldn\'t Change Password! Try Again');
                                    top.location = 'chang_pass.php';
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

