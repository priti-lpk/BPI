<?php
ob_start();
include_once 'shreeLib/DBAdapter.php';
include './shreeLib/session_info.php';
if (isset($_GET['type']) && isset($_GET['id'])) {
    $edba = new DBAdapter();
    $edata = $edba->getRow("create_party", array("*"), "id=" . $_GET['id']);
    echo "<input type='hidden' id='id' value='" . $_GET['id'] . "'>";
}
if (isset($_SESSION['user_id'])) {
    $edba = new DBAdapter();
    $servername1 = basename($_SERVER['PHP_SELF']);

    $field = array("role_rights.id");
    $mod_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " module.mod_pagename='" . $servername1 . "' and role_rights.user_id=" . $_SESSION['user_id']);
    echo "<input type='hidden' id='mod_id' value='" . $mod_data[0][0] . "'>";


    $field = array("role_rights.id,role_rights.role_edit,role_rights.role_delete,role_rights.role_create");
    $role_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " role_rights.id=" . $mod_data[0][0]);
    echo "<input type='hidden' id='up_id' value='" . $role_data[0][0] . "'>";
}
?>
<!DOCTYPE html>
<html lang="en" class="no-js">

    <head>
        <title>
            <?php
            if (isset($_GET['type'])) {
                echo 'Edit Party';
            } else {
                echo 'Add New Party';
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
                                        <li class="active">Add New Party</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- main -->
                            <div class="content">
                                <div class="main-header">
                                    <h2>Create Party</h2>
                                    <em>Add New</em>
                                </div>
                                <div class="main-content">
                                    <!-- WYSIWYG EDITOR -->
                                    <form action="customFile/addPartyPro.php"  class="form-horizontal" role="form" method="post" enctype="multipart/form-data" >  

                                        <div class="form-group">
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblcatname">Party Name</label>
                                            <div class="col-sm-4">
                                                <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][2] : '') ?>" name="party_name" id="party_name" class="form-control" placeholder="Party name" required>
                                            </div>
                                            <!--                                        </div>
                                                                                    <div class="form-group">-->
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblcatname">Party Contact</label>
                                            <div class="col-sm-4">
                                                <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][3] : '') ?>" name="party_contact" id="party_contact" class="form-control" placeholder="Enter Contact No here" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblcatname">Party Email</label>
                                            <div class="col-sm-4">
                                                <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][4] : '') ?>" name="party_email" id="party_email" class="form-control" placeholder="Party Email" required>
                                            </div>
                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblcatname">Party Address</label>
                                            <div class="col-sm-4">
                                                <input type="text" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][5] : '') ?>" name="party_address" id="party_address" class="form-control" placeholder="Party address" required>
                                            </div>
                                        </div>
                                        <div class="form-group">

                                            <label for="ticket-name" class="col-sm-2 control-label" id="lblcatname">Select Country</label>
                                            <div class="col-sm-6" id="typelist1">

                                                <select name="country_id" id="countries" class="select2" required onchange="countrychange();">
                                                    <option>Select Country</option>
                                                    <?php
                                                    $dba = new DBAdapter();
                                                    $data = $dba->getRow("countries", array("id", "name"), "1");
                                                    foreach ($data as $subData) {
                                                        echo "<option " . ($subData[0] == $edata[0][9] ? 'selected' : '') . " value='" . $subData[0] . "'>" . $subData[1] . "</option> ";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <label for="ticket-name" class="col-sm-2 control-label">Select City</label>
                                            <div class="col-sm-4" id="city_list">
                                                <select name="city_id" id="cities" class="select2" required>
                                                    <option>Select City</option>

                                                    <?php
                                                    $dba = new DBAdapter();
                                                    $data = $dba->getRow("cities", array("id", "name"), "1");
                                                    foreach ($data as $subData) {
                                                        echo "<option value=" . $subData[0] . ">" . $subData[1] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="widget-footer">
<!--                                            <input type="hidden" name="user_info" id="user_info" value="<?php echo (isset($_SESSION['user_id']) ? $_SESSION['user_name'] : "") ?>"/>-->
                                            <input type="hidden" name="action" id="action" value="<?php echo (isset($_GET['id']) ? 'edit' : 'add') ?>"/>
                                            <input type="hidden" name="id" id="id" value="<?php echo (isset($_GET['id']) ? $_GET['id'] : "") ?>">
                                            <button type="submit" id="btn_save" class="btn btn-primary"><i class="fa fa-floppy-o"></i> <?php echo (isset($_GET['type']) && isset($_GET['id']) ? 'Edit' : 'Save') ?></button>
                                        </div>
                                    </form>
                                    <div class="main-content">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="widget widget-table">
                                                    <div class="widget-header">
                                                        <h3><i class="fa fa-table"></i>Party List</h3>
                                                    </div>
                                                    <div class="widget-content">
                                                        <table id="featured-datatable" class="table table-sorting table-striped table-hover datatable">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Party Name</th>
                                                                    <th>Party Contact</th>
                                                                    <th>Party Email</th>
                                                                    <th>Party Address</th>
                                                                    <th>Country</th>
                                                                    <th>City</th>
                                                                    <?php if ($role_data[0][1] == 1) { ?>
                                                                        <th>Edit</th> <?php } ?>
                                                                    <?php if ($role_data[0][2] == 1) { ?> <th>Delete</th><?php } ?>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                include_once 'shreeLib/DBAdapter.php';
                                                                $dba = new DBAdapter();

                                                                $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);

                                                                $field = array("create_party.id,create_party.party_name,create_party.party_contact,create_party.party_email,create_party.party_address,countries.name,cities.name");
                                                                $data = $dba->getRow("create_party INNER JOIN countries ON create_party.country_id=countries.id INNER JOIN cities ON create_party.city_id=cities.id", $field, "branch_id=" . $last_id);
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
                                                                        if ($role_data[0][1] == 1) {
                                                                            echo "<td><a href='AddParty.php?type=edit&id=" . $subData[0] . "' class='btn btn-primary' id='" . $subData[0] . "'><i class='fa fa-edit'></i> Edit</a></td>";
                                                                        }

                                                                        if ($role_data[0][2] == 1) {
                                                                            echo "<td> <button class='btn btn-danger btn_delete' id='" . $subData[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash-o'>  Delete</button></td>";
                                                                        }

                                                                        echo '</tr>';
                                                                    }
                                                                } else {
                                                                    //echo 'No Data Available';
                                                                }
                                                                ?>   
                                                            </tbody>
                                                        </table>
                                                    </div><!-- /widget-content -->
                                                </div>
                                            </div>
                                        </div><!-- /row -->
                                    </div>
                                    <!-- /main-content -->
                                </div>
                                <!-- /main-content -->
                            </div>
                            <!-- /content -->
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
        <script src="customFile/addPartyJs.js"></script>
        <script src="assets/js/jquery/jquery-2.1.0.min.js"></script>
        <script src="assets/js/bootstrap/bootstrap.js"></script>
        <script src="assets/js/plugins/modernizr/modernizr.js"></script>
        <script src="assets/js/plugins/bootstrap-tour/bootstrap-tour.custom.js"></script>
        <script src="assets/js/king-common.js"></script>
        <script src="demo-style-switcher/assets/js/deliswitch.js"></script>

        <script src="assets/js/plugins/markdown/markdown.js"></script>
        <script src="assets/js/plugins/markdown/to-markdown.js"></script>
        <script src="assets/js/plugins/markdown/bootstrap-markdown.js"></script>
        <!--<script src="assets/js/king-elements.js"></script>-->
        <script src="assets/js/plugins/select2/select2.min.js"></script>
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
                $('#featured-datatable').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
            });
        </script> 
        <script type="text/javascript">
            function countrychange()
            {

                var country1 = document.getElementById("countries").value;
                //alert(country1);
                var dataString = 'countries=' + country1;
                //alert(dataString);
                $.ajax
                        ({
                            
                            url: "getcity.php",
                            datatype:"html",
                            data: dataString,
                            cache: false,
                            success: function (html)
                            {
                                //alert(html);
                                $("#city_list").html(html);
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
                                location.href = "Delete.php?type=create_party&id=" + id;
                                swal("Deleted!", "Category has been deleted.", "success");
                            } else {
                                swal("Cancelled", "You have cancelled this :)", "error");
                            }
                        });
            }
        </script>

<!--        <script type="text/javascript">

    var btn_crate =<?php echo (isset($_SESSION['user_id']) ? $role_data[0][3] : '') ?>;
    var btn_edit =<?php echo (isset($_GET['id']) ? 1 : 0) ?>;

    if (btn_crate === 0) {
        $('#btn_save').prop('disabled', true);
    }
    if (btn_edit === 1) {
        $('#btn_save').prop('disabled', false);
    }

</script>-->

    </body>
</html>




