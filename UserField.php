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
<html lang="en" class="no-js">

    <head>
        <title>
            User Field
        </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="Moltera Ceramic Pvt.Ltd">
        <meta name="author" content="LPK Technosoft">	
        <style>
            #lblpartydue{width:105px;margin-top: 3px;}
            #lblconpass{width:150px;margin-top: 3px;}
            #partydue{width:200px;}
            @font-face{font-family: Lobster;src: url('Lobster.otf');}
            h1{font-family: Lobster;text-align:center;}
            table{border-collapse:collapse;border-radius:25px;width:500px;}
            table, td, th{border:1px solid #00BB64;}
            tr,input{height:30px;border:1px solid #fff;}
            input:focus{border:1px solid yellow;} 
            .space{margin-bottom: 2px;}
            .module_name{width:200px;}
            #container{margin-left:180px;}
            .but{width:270px;background:#00BB64;border:1px solid #00BB64;height:40px;border-radius:3px;color:white;margin-top:10px;margin:0px 0px 0px 290px;}

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
                                        <li class="active">Add User Field</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- main -->
                            <div class="content">
                                <div class="main-header">
                                    <h2>Create User</h2>
                                    <em>Add New</em>
                                </div>
                                <button type="submit" id="enable" class="btn btn-default btn-sm" data-toggle="modal" data-target="#addbranch"><b>Add New Branch</b></button><br><br>

                                <div class="main-content" style="width:870px;">
                                    <!-- WYSIWYG EDITOR -->
                                    <form action="./customFile/UserFieldPro.php" id="form_data" class="form-horizontal" role="form" method="post" enctype="multipart/form-data"  >  
                                        <div class="form-group">
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblusername1">Select Branch</label>
                                            <div class="col-sm-3" id="branchlist">
                                                <select name="branch_id" id="create_branch" class="select2" onchange="clear_rdbtn();" required>
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
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblusername1">Select Role</label>
                                            <div class="col-sm-3" id="branchlist">
                                                <select name="roles_id" id="role_master" class="select2" onchange="clear_rdbtn();getrole();" required>
                                                    <option>Select Role</option>
                                                    <?php
                                                    $dba = new DBAdapter();
                                                    $data = $dba->getRow("role_master", array("id", "role_name"), "1");
                                                    foreach ($data as $subData) {
                                                        echo" <option " . ($subData[0] == $edata[0][1] ? 'selected' : '') . " value='" . $subData[0] . "'multiple>" . $subData[1] . "</option> ";
                                                    }
                                                    ?>
                                                </select>
                                                <div id="user-msgm" class="text-danger"></div>
                                            </div>
                                        </div>
                                        <div class="form-group" id="roles">
                                            <label for="ticket-name" class="col-sm-2 control-label">Role Rights</label>
                                            <div class="col-sm-9">
                                                <select name="role_rights_id[]" id="module" class="select2 select2-multiple" required  multiple>
                                                    <!--<option value="0" selected="">---Select---</option>-->
                                                    <?php
                                                    $dba = new DBAdapter();
                                                    $data = $dba->getRow("module", array("id", "mod_name"), "1");
                                                    $tagids = explode(",", $edata[0][3]);
                                                    print_r($tagids);
                                                    foreach ($data as $subData) {
                                                        if (isset($_GET['id'])) {
                                                            if (in_array($subData[0], $tagids)) {
                                                                echo "<option value=" . $subData[0] . ">" . $subData[1] . "</option>";
                                                            } else {
                                                                echo "<option value=" . $subData[0] . ">" . $subData[1] . "</option>";
                                                            }
                                                        } else {
                                                            echo "<option value=" . $subData[0] . ">" . $subData[1] . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <input name="disable" type="hidden" id="disable" value="0">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblpartydue1">User Full Name</label>
                                            <div class="col-sm-8" >
                                                <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][4] : '') ?>" name="user_fullname" class="form-control" placeholder="User Full Name" required>

                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblpartydue1">Contact No.</label>
                                            <div class="col-sm-3">
                                                <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][5] : '') ?>" name="user_contact" id="user_contact" class="form-control" placeholder="Contact No."  onkeypress="return isNumber(event)" required>
                                            </div>
                                            <label for="ticket-name" class="col-sm-3 control-label" id="lblpartydue">Email</label>
                                            <div class="col-sm-3">
                                                <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][6] : '') ?>" name="user_email" id="user_email" class="form-control" placeholder="User Email"  required>
                                            </div>


                                        </div>

                                        <div class="form-group">
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblpartydue1">Login Username</label>
                                            <div class="col-sm-3">
                                                <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][7] : '') ?>" name="user_login_username" id="user_login_username" class="form-control" placeholder="User Login Username" onkeypress="return AvoidSpace(event)" required>
                                                <!--<div class="col-sm-3">-->
                                                <div id="user-msg" class="text-danger"></div>
                                                <!--</div>-->
                                            </div>
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblconpass1">Login Password</label>
                                            <div class="col-sm-3">
                                                <input type="password" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][8] : '') ?>" name="user_login_password" id="user_login_password" class="form-control" placeholder="User Login Password" onkeypress="return AvoidSpace(event)" onchange="checkPasswordMatch();"  required>
                                                <div id="pass-conf" class="text-danger"></div>
                                            </div>                                           

                                        </div>

                                        <!--                                        <div class="form-group">
                                                                                    <label for="user_type" class="control-label col-sm-2" id="lblconpass1">User Type</label>
                                                                                    <label class="control-inline fancy-radio">
                                                                                    <div class="col-md-9">
                                                                                        <div class="col-sm-1" style="width:10px;" >
                                                                                            <input type="radio" name="user_type" id="user_type" value="Manager"/>
                                                                                        </div>
                                                                                        <div class="col-sm-3 radio-button">
                                                                                            <span>Manager</span>
                                                                                        </div>
                                                                                        <div class="col-sm-1" style="width:10px;" >
                                                                                            <input type="radio" name="user_type" id="user_type" value="Other" onclick="clear_rdbtn();"/>
                                                                                        </div>
                                                                                        <div class="col-sm-3 radio-button">
                                                                                            <span>Other</span>
                                                                                        </div>
                                                                                    </div>
                                        
                                                                                    <div class="col-sm-12">
                                                                                        <div id="user-msg1" class="text-danger text-danger1 "></div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="ticket-name" class="col-sm-2 control-label" id="lblpartydue1">Active</label>
                                                                                    <div class="control-inline onoffswitch">
                                                                                        <input type="checkbox" name="user_status" id="user_status" class="onoffswitch-checkbox" <?php echo (isset($_GET['type']) && isset($_GET['id']) ? ($edata[0][6] == 'false' ? '' : 'checked') : 'checked') ?>>
                                                                                        <label class="onoffswitch-label" for="user_status">
                                                                                            <span class="onoffswitch-inner"></span>
                                                                                            <span class="onoffswitch-switch"></span>
                                                                                        </label>
                                                                                    </div>
                                        
                                                                                </div>
                                                                                <table id="user_table" class="user_table" border="1" cellspacing="0">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th style="text-align:center; width: 70px;">ID</th>
                                                                                            <th style="text-align:center;width: 250px;">Module Name</th>
                                                                                            <th style="text-align:center;width: 100px;">Create</th>
                                                                                            <th style="text-align:center;width: 100px;">Edit</th>
                                                                                            <th style="text-align:center;width: 80px;">View</th>
                                                                                            <th style="text-align:center;width: 80px;">Delete</th>
                                        
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody id="view_data1" name="view_data">
                                        <?php
                                        include_once 'shreeLib/dbconn.php';
                                        $sql = "SELECT id, mod_name, mod_order from module order by mod_order";
                                        //print_r($sql);
                                        $result = mysqli_query($con, $sql);
                                        while ($row = mysqli_fetch_array($result)) {
                                            ?>
                                                                                                                                                    <tr>
                                                                                                                                                        <td style="text-align:center; width: 70px;"><span id = 'snum'><?= $row['mod_order'] ?></span></td>
                                                                                                                                                        <td style="text-align:center;width: 250px;"><?= $row['mod_name'] ?></td>
                                                                                                                                                                        <input type='text' id='module_name' class='module_name'  name='mod_name[]' value="<?= $row['mod_name'] ?>" disabled=""/></td>
                                                                                                                                                        <td style="text-align:center;width: 100px;"><input type = 'checkbox' class = 'create' name="role_create[<?= $row['mod_order'] ?>]" value=""/></td>
                                                                                                                                                        <td style="text-align:center;width: 100px;"><input type = 'checkbox' id="edit<?= $row['id'] ?>" class = 'edit'  name="role_edit[<?= $row['mod_order'] ?>]" onclick="edit(<?= $row['id'] ?>)" /></td>
                                                                                                                                                        <td style="text-align:center;width: 80px;"><input type = 'checkbox' id="view<?= $row['id'] ?>" class = 'view' name="role_view[<?= $row['mod_order'] ?>]" onclick="view(<?= $row['id'] ?>)" /></td>
                                                                                                                                                        <td style="text-align:center;width: 80px;"><input type = 'checkbox' class = 'delete1' name="role_delete[<?= $row['mod_order'] ?>]"/></td>
                                                                                                                                                <input type='hidden' id='module_id' class='module_name' name='mod_id[]' value="<?= $row['id'] ?>" />
                                                                                                                                                </tr>
                                                                                                
                                        <?php } ?>
                                                                                    </tbody>                   
                                                                                </table>-->
                                        <div class="widget-footer">
                                            <input type="hidden" name="action" id="action" value="<?php echo (isset($_GET['id']) ? 'edit' : 'add') ?>">
                                            <input type="hidden" name="id" id="id" value="<?php echo (isset($_GET['id']) ? $_GET['id'] : "") ?>">
                                            <!--<input type="hidden" name="r_count" id="rid" value="<?php echo (isset($_GET['id']) ? $countrow[0][0] : "") ?>">-->
                                            <button type="submit" id="btn_save" class="btn btn-primary"><i class="fa fa-floppy-o"></i> <?php echo (isset($_GET['type']) && isset($_GET['id']) ? 'Edit' : 'Save') ?></button>
                                        </div>
                                    </form><br>
                                    <!--                                    <div class="col-sm-4">
                                    <?php
                                    include './shreeLib/dbconn.php';
                                    $sql = "SELECT * FROM role_master";
                                    $result = mysqli_query($con, $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                                                                            <input type="text" name="role_name" id="role" value="<?= $row['role_name'] ?>">
                                    <?php } ?>
                                                                        </div>-->
                                    <!-- /main-content -->
                                </div>
                                <!-- /main -->
                            </div>
                            <!-- /content-wrapper -->
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
<div class="modal fade" id="addbranch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                <h4 class="modal-title" id="myModalLabel">Add New Branch</h4>

            </div>

            <div class="modal-body">                                        
                <div id="form"> 
                    <form action="javascript:void(0);" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" onsubmit="addBranch();" >
                        <div class="form-group">
                            <label  for="ticket-name" class="col-sm-3 control-label">Branch Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="branch_name" id="branch_name" class="form-control" placeholder="Name" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label  for="ticket-name" class="col-sm-3 control-label">Branch Address</label>
                            <div class="col-sm-9">
                                <input type="text" name="branch_address" id="branch_address" class="form-control" placeholder="Address" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label  for="ticket-name" class="col-sm-3 control-label">Branch Contact</label>
                            <div class="col-sm-9">
                                <input type="text" name="branch_contact" id="branch_contact" class="form-control" placeholder="Contact" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label  for="ticket-name" class="col-sm-3 control-label">Branch Email</label>
                            <div class="col-sm-9">
                                <input type="text" name="branch_email" id="branch_email" class="form-control" placeholder="Email" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ticket-name" class="col-sm-3 control-label" id="lblpartydue" style="margin-top: -3px;">Active</label>
                            <div class="col-md-6" style="margin-left: 40px;">
                                <div class="control-inline onoffswitch">
                                    <input type="checkbox" name="branch_status" id="branch_status" class="onoffswitch-checkbox" <?php echo (isset($_GET['type']) && isset($_GET['id']) ? ($edata[0][6] == 'false' ? '' : 'checked') : 'checked') ?>>
                                    <label class="onoffswitch-label " for="branch_status">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
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
<!-- /wrapper -->
<!-- FOOTER -->
<footer class="footer">
    2018 © <a href="http://lpktechnosoft.com" target="_blank">LPK Technosoft</a>
</footer>  

<!-- END FOOTER -->
<!-- Javascript -->
<script src="customFile/createbranchJs.js"></script>
<script src="assets/js/jquery/jquery-2.1.0.min.js"></script>

<script src="assets/js/bootstrap/bootstrap.js"></script>
<script src="assets/js/plugins/modernizr/modernizr.js"></script>
<script src="assets/js/plugins/bootstrap-tour/bootstrap-tour.custom.js"></script>
<script src="assets/js/king-common.js"></script>
<script src="demo-style-switcher/assets/js/deliswitch.js"></script>
<script src="assets/js/plugins/markdown/to-markdown.js"></script>
<script src="assets/js/plugins/markdown/bootstrap-markdown.js"></script>
<script src="assets/js/plugins/select2/select2.min.js"></script>
<script type="text/javascript">

                        function getrole() {

                            var value = $("#role_master").find(":selected").val();
                            var dataString = 'create-rights=' + value;

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
                                        $("#module").prop('disabled', false);
                                    } else {
                                        $("#user-msgm").text("");
                                        $("#module").prop('disabled', true);
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
<!--<script type="text/javascript">

    $('#user_type').focusout(function () {
        var username = document.getElementById("user_type").value;
        var createbranch = document.getElementById("create_branch").value;

        var my_object = {"user-type": username, "createbranch": createbranch};
        //alert(my_object);
        $.ajax({
            url: 'usertype_validation.php',
            dataType: "html",
            data: my_object,
            cache: false,
            success: function (Data) {
                // alert(Data);
                var useri = Data;
                if (useri == 1) {
                    $("#user-msg1").text("This already exist! You Check Other Option..");
                    $("#btn_save").prop('disabled', true);
                } else {
                    $("#user-msg1").text("");
                    $("#btn_save").prop('disabled', false);
                }

            },
            error: function (errorThrown) {
                alert(errorThrown);
                alert("There is an error with AJAX!");
            }
        });
    });
    function clear_rdbtn() {
        $("#user-msg1").text("");
        $("#btn_save").prop('disabled', false);

    }
    ;
</script>-->

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

<script type="text/javascript">
    function numbers() {
        var pidd =<?php echo (isset($_GET['id']) ? $edata[0][0] : '') ?>;
        // alert(pidd);
        var my_object = "user_id=" + pidd;
        $.ajax({
            url: '../main/getViewData.php',
            dataType: "html",
            data: my_object,
//            cache: false,
            success: function (Data) {
                //  alert(Data);
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

<script>
    function edit(rowid) {

        if ($("#edit" + rowid).is(':checked')) {
            // $(".view").hide();
            $("#view" + rowid).prop("checked", true);
        } else {
            $("#view" + rowid).prop("checked", false);
        }

    }
    ;
    function view(rowno) {
        if ($("#edit" + rowno).is(':checked')) {
            // alert(rowid);
            $("#view" + rowno).prop("checked", true);
        } else {
            $("#edit" + rowno).prop("checked", false);
        }
    }
    ;</script>
<script type="text/javascript">

    var editdata =<?php echo (isset($_GET['id']) ? $edata[0][0] : '') ?>;
    if (editdata === <?php echo (isset($_GET['id']) ? $edata[0][0] : '') ?>) {
        // $('#user_name1').prop('disabled', false);
        document.getElementById("user_login_username").disabled = true;
    }

</script>
<script type="text/javascript">
//    function numericFilter(txb) {
//        txb.value = txb.value.replace(/[^\0-9]/ig, "");
//        
//        onKeyUp="numericFilter(this);"
//        
//        
//    }
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
</body>
</html>



