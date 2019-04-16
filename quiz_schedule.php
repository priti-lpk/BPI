<?php
ob_start();
require_once "shreeLib/session_info.php";
include_once 'shreeLib/DBAdapter.php';
include 'shreeLib/dbconn.php';
$edba = new DBAdapter();

if (isset($_GET['type']) && isset($_GET['id'])) {

    $field = array("*");
    $datas = $edba->getRow("quiz_schedule", $field, "id=" . $_GET['id']);

    echo "<input type='hidden' id='id' value='" . $datas[0][0] . "'>";
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
                echo 'Edit Quiz Schedule';
            } else {
                echo 'Add Quiz Schedule';
            }
            ?></title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="Themesbrand" name="author" />
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <link href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">

        <link href="plugins/bootstrap-md-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">

        <link href="plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
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
                                    <h4 class="page-title">Quiz Schedule</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="page-content-wrapper">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">                   
                                            <form action="customFile/quiz_schedulePro.php" id="form_data" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" >  
                                                <h4 class="mt-0 header-title">Textual inputs</h4>
                                                <div class = "form-group row">
                                                    <label for = "example-text-input" class = "col-sm-2 col-form-label">Title</label>
                                                    <div class = "col-sm-10">
                                                        <input class = "form-control" type = "text" placeholder = "Title" name = "title" id = "title" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $datas[0][1] : ''); ?>" required = "">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="example-date-input" class="col-sm-2 col-form-label">Date</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" type="date" name = "schedule_date" id = "schedule_date" id="example-date-input" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $datas[0][2] : ''); ?>" required="">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Country</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control select2" name="country_id" id="countries" required="" onchange="countrychange();">
                                                            <option>Select Country</option>
                                                            <?php
                                                            $dba = new DBAdapter();
                                                            $sql = "select id,cname from countries";
                                                            $result = mysqli_query($con, $sql);
//                                                    $data = $dba->getRow("countries", array("id", "name"), "1");
                                                            foreach ($result as $subData) {
                                                                echo "<option " . ($subData['id'] == $datas[0][4] ? 'selected' : '') . " value='" . $subData['id'] . "'>" . $subData['cname'] . "</option> ";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <!--                                                </div>
                                                                                                    <div class="form-group row">-->
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">State</label>
                                                    <div class="col-sm-4" id="state_list">
                                                        <select class="form-control select2" name="state_id" id="states" required="">
                                                            <option>Select States</option>
                                                            <?php
                                                            $city = $datas[0][5];
                                                            $editdata = isset($_GET['type']);
                                                            if ($editdata == 1) {
                                                                $dba = new DBAdapter();
                                                                $data = $dba->getRow("states", array("id", "state_name"), "country_id=" . $datas[0][4]);
                                                                foreach ($data as $subData) {
                                                                    echo "<option " . ($subData[0] == $datas[0][5] ? 'selected' : '') . " value=" . $subData[0] . ">" . $subData[1] . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Main Category</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control select2" name="main_cat_id" id="main_cat_id" required="">
                                                            <option>Main Category</option>
                                                            <?php
                                                            $dba = new DBAdapter();
                                                            $data = $dba->getRow("main_category", array("id", "main_cat_name"), "1");
                                                            foreach ($data as $subData) {
//                                                            echo "<option  value='" . $subData[0] . "'>" . $subData[1] . "</option> ";
                                                                echo "<option " . ($subData[0] == $datas[0][3] ? 'selected' : '') . " value=" . $subData[0] . ">" . $subData[1] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <!--                                                </div>
                                                                                                    <div class="form-group row">-->
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Sub Category</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control select2" name="sub_cat_id" id="sub_cat_id" required="">
                                                            <option>Sub Category</option>
                                                            <?php
                                                            $dba = new DBAdapter();
                                                            $data = $dba->getRow("sub_category", array("id", "sub_cat_name"), "1");
                                                            foreach ($data as $subData) {
//                                                            echo "<option  value='" . $subData[0] . "'>" . $subData[1] . "</option> ";
                                                                echo "<option " . ($subData[0] == $datas[0][4] ? 'selected' : '') . " value=" . $subData[0] . ">" . $subData[1] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Description</label>
                                                    <div class="col-sm-10">
                                                        <textarea id="elm1" name="description" required=""><?php echo (isset($_GET['type']) && isset($_GET['id']) ? $datas[0][7] : ''); ?></textarea>
                                                    </div>
                                                </div>
                                                <div class = "button-items">
                                                    <input type = "hidden" name = "action" id = "action" value = "<?php echo (isset($_GET['id']) ? 'edit' : 'add') ?>"/>
                                                    <input type = "hidden" name = "id" id = "id" value = "<?php echo (isset($_GET['id']) ? $data[0][0] : '') ?>"/>
                                                    <button type = "submit" id = "btn_save" class = "btn btn-primary waves-effect waves-light"><?php echo (isset($_GET['type']) && isset($_GET['id']) ? 'Edit' : 'Save') ?></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                        </div>
                        <!-- end page content-->

                    </div> <!-- container-fluid -->

                </div> <!-- content -->

                <?php include './footer.php' ?>

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
        <!--Wysiwig js-->
        <script src="plugins/tinymce/tinymce.min.js"></script>
        <!-- Plugins Init js -->
        <script src="assets/pages/form-advanced.js"></script>
        <!-- App js -->
        <script src="assets/js/app.js"></script>
        <script>
                                                            $(document).ready(function () {
                                                                if ($("#elm1").length > 0) {
                                                                    tinymce.init({
                                                                        selector: "textarea#elm1",
                                                                        theme: "modern",
                                                                        height: 300,
                                                                        plugins: [
                                                                            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                                                                            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                                                                            "save table contextmenu directionality emoticons template paste textcolor"
                                                                        ],
                                                                        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
                                                                        style_formats: [
                                                                            {title: 'Bold text', inline: 'b'},
                                                                            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                                                                            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                                                                            {title: 'Example 1', inline: 'span', classes: 'example1'},
                                                                            {title: 'Example 2', inline: 'span', classes: 'example2'},
                                                                            {title: 'Table styles'},
                                                                            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                                                                        ]
                                                                    });
                                                                }
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

                            url: "getstate.php",
                            datatype: "html",
                            data: dataString,
                            cache: false,
                            success: function (html)
                            {
                                //alert(html);
                                $("#state_list").html(html);
                            },
                            error: function (errorThrown) {
                                alert(errorThrown);
                                alert("There is an error with AJAX!");
                            }
                        });
            }
            ;
        </script>
    </body>

</html>


