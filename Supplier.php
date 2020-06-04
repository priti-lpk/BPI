<?php
ob_start();
include_once 'shreeLib/DBAdapter.php';
include './shreeLib/session_info.php';
if (isset($_GET['type']) && isset($_GET['id'])) {
    $edba = new DBAdapter();
    $edata = $edba->getRow("supplier", array("*"), "id=" . $_GET['id']);
    echo "<input type='hidden' id='id' value='" . $_GET['id'] . "'>";
}
if (isset($_SESSION['user_id'])) {
    $edba = new DBAdapter();
    $servername1 = basename($_SERVER['PHP_SELF']);

    $field = array("role_rights.id");
    $data = $dba->getLastID("roles_id", "create_user", "id=" . $_SESSION['user_id']);

    $mod_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " module.mod_pagename='" . $servername1 . "' and role_rights.role_id=" . $data);
    echo "<input type='hidden' id='mod_id' value='" . $mod_data[0][0] . "'>";


    $field = array("role_rights.id,role_rights.role_edit,role_rights.role_delete,role_rights.role_create");
    $role_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " role_rights.id=" . $mod_data[0][0]);
    echo "<input type='hidden' id='up_id' value='" . $role_data[0][0] . "'>";
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
                echo 'Edit Supplier';
            } else {
                echo 'Add Supplier';
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
                                    <h4 class="page-title">Create Supplier</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="page-content-wrapper">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-20">
                                        <div class="card-body"> 
                                            <div class="form-group row">
                                                <div class="col-sm-10">
                                                    <h4><b><?php echo (isset($_GET['id']) ? 'Edit Supplier' : '') ?></b></h4>
                                                </div>
                                            </div>
                                            <form action="" id="form_data" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" >  
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Supplier Name</label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" type="text"  placeholder="Supplier Name" id="sup_name" name="sup_name" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][2] : ''); ?>" required="">
                                                    </div>
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Supplier Address</label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" type="text"  placeholder="Supplier Address" id="sup_add" name="sup_add" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][3] : ''); ?>" required="">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Supplier Contact</label>
                                                    <div class="col-sm-4">  
                                                        <input class="form-control" type="text"  placeholder="Supplier Contact" id="sup_contact" name="sup_contact" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][4] : ''); ?>" required="">
                                                    </div>
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Supplier Email</label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" type="text"  placeholder="Supplier Email" id="sup_email" name="sup_email" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][5] : ''); ?>" required="">
                                                    </div>
                                                </div>
                                                <?php
                                                include_once 'shreeLib/DBAdapter.php';
                                                include_once 'shreeLib/dbconn.php';
                                                include_once 'shreeLib/Controls.php';
                                                $dba = new DBAdapter();
                                                $cdba = new Controls();
                                                if (!isset($_SESSION)) {
                                                    session_start();
                                                }
                                                $createdby = $dba->createdby($_SESSION['user_login_username']);   // print_r($createdby);
                                                $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                ?>
                                                <input type="hidden" name="party_created_by" id="party_created_by" value='<?php echo $createdby; ?>'>
                                                <input type="hidden" name="branch_id" id="branch_id" value='<?php echo $last_id; ?>'>

                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">GST No.</label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" type="text"  placeholder="GST No." id="sup_gstno" name="sup_gstno" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][6] : ''); ?>" required="">
                                                    </div>

                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Select Country</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control select2" name="country_id" id="countries" onchange="countrychange();" required="">
                                                            <option>Select Country</option>
                                                            <?php
                                                            $dba = new DBAdapter();
                                                            $sql = "select id,name from countries";
                                                            $result = mysqli_query($con, $sql);
//                                                    $data = $dba->getRow("countries", array("id", "name"), "1");
                                                            foreach ($result as $subData) {
                                                                echo "<option " . ($subData['id'] == $edata[0][9] ? 'selected' : '') . " value='" . $subData['id'] . "'>" . $subData['name'] . "</option> ";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Select City</label>
                                                    <div class="col-sm-4" id="city_list">
                                                        <select class="form-control select2" name="city_id" id="cities" required="">
                                                            <option>Select City</option>

                                                            <?php
                                                            $city = $edata[0][10];
                                                            $editdata = isset($_GET['type']);
                                                            if ($editdata == 1) {
                                                                $dba = new DBAdapter();
                                                                $data = $dba->getRow("cities", array("id", "name"), "country_id=" . $edata[0][9]);
                                                                foreach ($data as $subData) {
                                                                    echo "<option " . ($subData[0] == $edata[0][10] ? 'selected' : '') . " value=" . $subData[0] . ">" . $subData[1] . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class = "button-items">
                                                    <input type = "hidden" name = "action" id = "action" value = "<?php echo (isset($_GET['id']) ? 'edit' : 'add') ?>"/>
                                                    <input type = "hidden" name = "id" id = "id" value = "<?php echo (isset($_GET['id']) ? $_GET['id'] : '') ?>"/>
                                                    <button type = "submit" id = "btn_save" class = "btn btn-primary waves-effect waves-light">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">

                                            <h4 class="mt-0 header-title">View of Supplier</h4><br>
                                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Name</th>
                                                        <th>Address</th>
                                                        <th>Contact</th>
                                                        <th>Email</th>
                                                        <th>GST No.</th>
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

                                                    // $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);

                                                    $field = array("supplier.id,supplier.sup_name,supplier.sup_add,supplier.sup_contact,supplier.sup_email,supplier.sup_gstno,countries.name,cities.name");
                                                    $data = $dba->getRow("supplier INNER JOIN countries ON supplier.country_id=countries.id INNER JOIN cities ON supplier.city_id=cities.id", $field, "1");
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
                                                            //echo "<td>" . $subData[8] . "</td>";
                                                            if ($role_data[0][1] == 1) {
                                                                echo "<td><a href='Supplier.php?type=edit&id=" . $subData[0] . "' target='_blank' class='btn btn-primary' id='" . $subData[0] . "'><i class='fa fa-edit'></i> Edit</a></td>";
                                                            }

                                                            if ($role_data[0][2] == 1) {
                                                                echo "<td> <button class='btn btn-danger btn_delete' id='" . $subData[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash'>  Delete</button></td>";
                                                            }

                                                            echo '</tr>';
                                                        }
                                                    } else {
                                                        // echo 'No Data Available';
                                                    }
                                                    ?>   
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div>
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
                                                                $('select').on(
                                                                        'select2:close',
                                                                        function () {
                                                                            $(this).focus();
                                                                        }
                                                                );
                                                            });
        </script>
        <script type="text/javascript">
            $("#btn_save").on('click', function () {
                var sup_name = document.getElementById("sup_name").value;
                var sup_add = document.getElementById("sup_add").value;
                var sup_contact = document.getElementById("sup_contact").value;
                var sup_email = document.getElementById("sup_email").value;
                var sup_gstno = document.getElementById("sup_gstno").value;
                var countries = document.getElementById("countries").value;
                var cities = document.getElementById("cities").value;
                var party_created_by = document.getElementById("party_created_by").value;
                var branch_id = document.getElementById("branch_id").value;
                var act = document.getElementById("action").value;
                var eid = document.getElementById("id").value;
                var dataString = {"sup_name": sup_name, "sup_add": sup_add, "sup_contact": sup_contact, "sup_email": sup_email, "sup_gstno": sup_gstno, "countries": countries, "cities": cities, "created_user": party_created_by, "branch_id": branch_id, "action": act, "id": eid};
                $.ajax
                        ({
                            url: "customFile/addSupplierPro.php",
                            datatype: "html",
                            data: dataString,
                            cache: false,
                            success: function (Data)
                            {
//                                                                                alert(Data);
                                alert("Success");
                            }

                        });
            });

        </script>
        <script type="text/javascript">
            $(function ()
            {
                $('#form_data').submit(function () {
                    $("input[type='submit']", this)
                            .val("Please Wait...")
                            .attr('disabled', 'disabled');
                    return true;
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
                            datatype: "html",
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
                location.href = "Delete.php?type=supplier&id=" + id;

            }
        </script>
    </body>

</html>