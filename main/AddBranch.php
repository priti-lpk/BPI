<?php
include './shreeLib/session_info.php';

include_once 'shreeLib/DBAdapter.php';
if (isset($_GET['type']) && isset($_GET['id'])) {
    $edba = new DBAdapter();
    $field = array("*");
    $datas = $edba->getRow("create_branch", $field, "id=" . $_GET['id']);
    echo "<input type='hidden' id='branch_id' value='" . $_GET['id'] . "'>";
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
                echo 'Edit Add Branch';
            } else {
                echo 'Add Branch';
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
                                    <h4 class="page-title">Add Branch</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="page-content-wrapper">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">                   
                                            <form action="customFile/addBranchPro.php" id="form_data" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" >  
                                                <h4 class="mt-0 header-title">Textual inputs</h4>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Branch Name</label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" type="text"  placeholder="Branch Name" id="branch_name" name="branch_name" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $datas[0][1] : ''); ?>" required="">
                                                    </div>
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Branch Address</label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" type="text"  placeholder="Branch Address" id="branch_address" name="branch_address" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $datas[0][2] : ''); ?>" required="">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Branch Contact</label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" type="text"  placeholder="Branch Contact" id="branch_contact" name="branch_contact" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $datas[0][3] : ''); ?>" required="">
                                                    </div>
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Branch Email</label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" type="text"  placeholder="Branch Email" id="branch_email" name="branch_email" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $datas[0][4] : ''); ?>" required="">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Status</label>
                                                    <?php
                                                    if (isset($_GET['type']) && isset($_GET['id'])) {
                                                        if ($datas[0][6] == 'true') {
                                                            ?>
                                                            <input type="checkbox" id="switch" switch="none" name="branch_status" checked />
                                                            <label for="switch" data-on-label="On"data-off-label="Off"</label>
                                                        <?php } elseif ($datas[0][6] == 'false') {
                                                            ?>
                                                            <input type="checkbox" id="switch" switch="none" name="branch_status" />
                                                            <label for="switch" data-on-label="On"data-off-label="Off"</label>
                                                            <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <input type="checkbox" id="switch" switch="none" name="branch_status" checked/>
                                                        <label for="switch" data-on-label="On"data-off-label="Off"></label>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="button-items">
                                                    <input type="hidden" name="action" id="action" value="<?php echo (isset($_GET['id']) ? 'edit' : 'add') ?>"/>
                                                    <input type="hidden" name="id" id="id" value="<?php echo (isset($_GET['id']) ? $datas[0][0] : '') ?>"/>
                                                    <button type="submit" id="btn_save" class="btn btn-primary waves-effect waves-light"><?php echo (isset($_GET['type']) && isset($_GET['id']) ? 'Edit' : 'Save') ?></button>
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

                                            <h4 class="mt-0 header-title">View of Branch</h4><br>
                                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Name</th>
                                                        <th>Address</th>
                                                        <th>Contact</th>
                                                        <th>Email</th>
                                                        <th>Status</th>
                                                        <th>Edit / Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include_once 'shreeLib/DBAdapter.php';
                                                    $dba = new DBAdapter();
                                                    $field = array("*");
                                                    $data = $dba->getRow("create_branch", $field, "1");
                                                    $count = count($data);
                                                    $k = 1;
                                                    if ($count >= 1) {
                                                        foreach ($data as $subData) {
                                                            echo "<tr>";
                                                            echo "<td>" . $k . "</td>";
                                                            echo "<td>" . $subData[1] . "</td>";
                                                            echo "<td>" . $subData[2] . "</td>";
                                                            echo "<td>" . $subData[3] . "</td>";
                                                            echo "<td>" . $subData[4] . "</td>";
                                                            echo "<td>";
                                                            if ($subData[6] == 'true') {
                                                                echo "<input type='checkbox' switch='none' data-status='false' id='" . $subData[0] . "'   onclick='approveuser(this.id)' checked/><label for='" . $subData[0] . "' data-on-label='On' data-off-label='Off'></label></td>";
                                                            } else {
                                                                echo "<input type='checkbox' switch='none' data-status='true' id='" . $subData[0] . "'  onclick='approveuser(this.id)'/><label for='" . $subData[0] . "'  data-on-label='On' data-off-label='Off' ></label></td>";
                                                            }

                                                            echo "</td>";
                                                            echo "<td><a href='AddBranch.php?type=edit&id=" . $subData[0] . "' class='btn btn-primary waves-effect waves-light'>Edit</a> <button class='btn btn-danger btn_delete' id='" . $subData[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash-o'>  Delete</button></td>";

                                                            echo "</tr>";
                                                            $k++;
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                        </div>
                        <!-- end page content-->

                    </div> <!-- container-fluid -->

                </div>
            </div>

            <!-- end page content-->

        </div> <!-- container-fluid -->

    </div> <!-- content -->

    <?php include 'footer.php' ?>

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
<script>
    function approveuser(sid) {
        $.ajax({
            url: "updatestatus.php",
            type: "POST",
            data: {
                sid: sid,
                status: $("#" + sid).data('status'),
                action: "mainstatus",
            },
            dataType: "json",
            success: function (data) {
                //alert(data);
                if (data.status) {
                    //alert("sucess");
                    window.location.reload();
                } else {
                    alert("fail");
                }

            },
            fail: function () {
                swal("Error!", "Error while performing operation!", "error");
            },
            error: function (data, status, jg) {
                swal("Error!", data.responseText, "error");
            }
        });
    }
//           
</script>
<script type="text/javascript">
    function SetForDelete(id) {
        location.href = "Delete.php?type=main_category&id=" + id;
    }
</script>
</body>

</html>