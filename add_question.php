<?php
ob_start();
require_once "shreeLib/session_info.php";
include_once 'shreeLib/DBAdapter.php';
include 'shreeLib/dbconn.php';
$edba = new DBAdapter();

if (isset($_GET['type']) && isset($_GET['id'])) {

    $field = array("*");
    $datas = $edba->getRow("question_master", $field, "id=" . $_GET['id']);

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
                echo 'Edit Question';
            } else {
                echo 'Add Question';
            }
            ?></title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="Themesbrand" name="author" />
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <link href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
        <link href="plugins/bootstrap-md-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
        <link href="plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
        <link href="plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
        <style>

            #myImg {
                border-radius: 5px;
                cursor: pointer;
                transition: 0.3s;
            }

            #myImg:hover {opacity: 0.7;}

            /* The Modal (background) */
            .modal {
                display: none; /* Hidden by default */
                position: fixed; /* Stay in place */
                z-index: 1; /* Sit on top */
                padding-top: 100px; /* Location of the box */
                left: 0;
                top: 0;
                width: 100%; /* Full width */
                height: 100%; /* Full height */
                overflow: auto; /* Enable scroll if needed */
                background-color: rgb(0,0,0); /* Fallback color */
                background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
            }

            /* Modal Content (image) */
            .modal-content {
                margin: auto;
                display: block;
                width: 80%;
                max-width: 700px;
            }

            /* Caption of Modal Image */
            #caption {
                margin: auto;
                display: block;
                width: 80%;
                max-width: 700px;
                text-align: center;
                color: #ccc;
                padding: 10px 0;
                height: 150px;
            }

            /* Add Animation */
            .modal-content, #caption {  
                -webkit-animation-name: zoom;
                -webkit-animation-duration: 0.6s;
                animation-name: zoom;
                animation-duration: 0.6s;
            }

            @-webkit-keyframes zoom {
                from {-webkit-transform:scale(0)} 
                to {-webkit-transform:scale(1)}
            }

            @keyframes zoom {
                from {transform:scale(0)} 
                to {transform:scale(1)}
            }

            /* The Close Button */
            .close {
                position: absolute;
                top: 15px;
                right: 35px;
                color: #f1f1f1;
                font-size: 40px;
                font-weight: bold;
                transition: 0.3s;
            }

            .close:hover,
            .close:focus {
                color: #bbb;
                text-decoration: none;
                cursor: pointer;
            }

            /* 100% Image Width on Smaller Screens */
            @media only screen and (max-width: 700px){
                .modal-content {
                    width: 100%;
                }
            }
        </style>
    </head>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <?php include 'topbar.php'; ?>
            <!-- Top Bar End -->

            <!-- ========== Left sidebar Start ========== -->
            <?php include 'sidebar.php'; ?>
            <!-- Left sidebar End -->

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
                                    <h4 class="page-title">Add Question</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="page-content-wrapper">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">                   
                                            <form action="customFile/add_questionPro.php" id="form_data" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" >  
                                                <h4 class="mt-0 header-title">Textual inputs</h4>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Main Category</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control select2" name="main_cat_id" id="main_cat_id" required="" onchange="mainchange();">
                                                            <option>Main Category</option>
                                                            <?php
                                                            $dba = new DBAdapter();
                                                            $data = $dba->getRow("main_category", array("id", "main_cat_name"), "status='1'");
                                                            foreach ($data as $subData) {
                                                                echo "<option " . ($subData[0] == $datas[0][1] ? 'selected' : '') . " value=" . $subData[0] . ">" . $subData[1] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                       
                                                    </div>
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Sub Category</label>
                                                    <div class="col-sm-4" id="sub_list">
                                                        <select class="form-control select2" name="sub_cat_id" id="sub_cat_id" required="">
                                                            <option>Sub Category</option>
                                                            <?php
                                                            $dba = new DBAdapter();
                                                            $data = $dba->getRow("sub_category", array("id", "sub_cat_name"), "status='1'");
                                                            foreach ($data as $subData) {
                                                                echo "<option " . ($subData[0] == $datas[0][2] ? 'selected' : '') . " value=" . $subData[0] . ">" . $subData[1] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
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
                                                            foreach ($result as $subData) {
                                                                echo "<option " . ($subData['id'] == $datas[0][4] ? 'selected' : '') . " value='" . $subData['id'] . "'>" . $subData['cname'] . "</option> ";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
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
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Select Tag</label>
                                                    <div class = "col-sm-4">
                                                        <select name="tag_id[]" id="tag_list" class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Choose ...">
                                                            <?php
                                                            $dba = new DBAdapter();
                                                            $data = $dba->getRow("tag_list", array("id", "tag_name"), "1");
                                                            $tagids = explode(",", $datas[0][3]);
                                                            foreach ($data as $subData) {
                                                                if (isset($_GET['id'])) {
                                                                    if (in_array($subData[0], $tagids)) {
                                                                        echo "<option value=" . $subData[0] . " selected>" . $subData[1] . "</option>";
                                                                    } else {
                                                                        echo "<option value=" . $subData[0] . ">" . $subData[1] . "</option>";
                                                                    }
                                                                } else {
                                                                    echo "<option value=" . $subData[0] . ">" . $subData[1] . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <!--                                                </div>
                                                                                                    <div class = "form-group row">-->
                                                    <label for = "example-text-input" class = "col-sm-2 col-form-label">Image</label>
                                                    <div class = "col-sm-4">
                                                        <input type = "file" id = "image" name = "image" class = "form-control filestyle" data-input = "false" data-buttonname = "btn-secondary">
                                                    </div>
                                                </div>
                                                <div class = "form-group row">
                                                    <label for = "example-text-input" class = "col-sm-2 col-form-label">Question</label>
                                                    <div class = "col-sm-10">
                                                        <input class = "form-control" type = "text" placeholder = "Question" name = "question" id = "question" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $datas[0][7] : ''); ?>" required = "">
                                                        <div class="col-sm-9">
                                                            <div id="user-msg" class="text-danger"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--<div id="wait" style="display:none;border:0px solid black;position:absolute;top: 40%;left:85%;padding:2px;"><img src='Images/ajax-loader.gif' width="16" height="16" /></div>-->

                                                <div class = "form-group row">
                                                    <label for = "example-text-input" class = "col-sm-2 col-form-label">Option A</label>
                                                    <div class = "col-sm-4">
                                                        <input class = "form-control" type = "text" placeholder = "Option A" name = "option_a" id = "option_a" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $datas[0][8] : ''); ?>" required = "">
                                                    </div>
                                                    <label for = "example-text-input" class = "col-sm-2 col-form-label">Option B</label>
                                                    <div class = "col-sm-4">
                                                        <input class = "form-control" type = "text" placeholder = "Option B" name = "option_b" id = "option_b" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $datas[0][9] : ''); ?>" required = "">
                                                    </div>
                                                </div>
                                                <div class = "form-group row">
                                                    <label for = "example-text-input" class = "col-sm-2 col-form-label">Option C</label>
                                                    <div class = "col-sm-4">
                                                        <input class = "form-control" type = "text" placeholder = "Option C" name = "option_c" id = "option_c" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $datas[0][10] : ''); ?>" required = "">
                                                    </div>
                                                    <label for = "example-text-input" class = "col-sm-2 col-form-label">Option D</label>
                                                    <div class = "col-sm-4">
                                                        <input class = "form-control" type = "text" placeholder = "Option D" name = "option_d" id = "option_d" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $datas[0][11] : ''); ?>" required = "">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">Answer</label>
                                                    <div class="col-sm-4" id="state_list">
                                                        <select class="form-control select2" name="answer" id="answer" required="">
                                                            <option<?php
                                                            if (isset($_GET['id']) && isset($_GET['type'])) {
                                                                echo $datas[0][12] == 'Option A' ? ' selected="selected"' : '';
                                                            }
                                                            ?> value = 'Option A'>Option A</option>
                                                            <option<?php
                                                            if (isset($_GET['id']) && isset($_GET['type'])) {
                                                                echo $datas[0][12] == 'Option B' ? ' selected="selected"' : '';
                                                            }
                                                            ?> value = 'Option B'>Option B</option>
                                                            <option<?php
                                                            if (isset($_GET['id']) && isset($_GET['type'])) {
                                                                echo $datas[0][12] == 'Option C' ? ' selected="selected"' : '';
                                                            }
                                                            ?> value = 'Option C'>Option C</option>
                                                            <option<?php
                                                            if (isset($_GET['id']) && isset($_GET['type'])) {
                                                                echo $datas[0][12] == 'Option D' ? ' selected="selected"' : '';
                                                            }
                                                            ?> value = 'Option D'>Option D</option>
                                                        </select> 
                                                    </div>
                                                </div>
                                                <input type="hidden" name="user" value="0">

                                                <div class = "button-items">
                                                    <!--<div class="col-sm-4">-->
                                                    <input type = "hidden" name = "action" id = "action" value = "<?php echo (isset($_GET['id']) ? 'edit' : 'add') ?>"/>
                                                    <input type = "hidden" name = "id" id = "id" value = "<?php echo (isset($_GET['id']) ? $datas [0][0] : '') ?>"/>
                                                    <button type = "submit" id = "btn_save" class = "btn btn-primary waves-effect waves-light"><?php echo (isset($_GET['type']) && isset($_GET['id']) ? 'Edit' : 'Save') ?></button>
                                                    <!--</div>-->
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

                                            <h4 class="mt-0 header-title">Question List</h4><br>
                                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Main Category Name</th>
                                                        <th>Sub Category Name</th>
                                                        <th>Country</th>
                                                        <th>State</th>
                                                        <th>Image</th>
                                                        <th>Question</th>
                                                        <th>Option A</th>
                                                        <th>Option B</th>
                                                        <th>Option C</th>
                                                        <th>Option D</th>
                                                        <th>Answer</th>
                                                        <th>Edit / Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include_once 'shreeLib/DBAdapter.php';
                                                    $dba = new DBAdapter();
                                                    include_once("shreeLib/dbconn.php");

                                                    $k = 1;
                                                    $sql = "select question_master.id,main_category.main_cat_name,sub_category.sub_cat_name,countries.cname,states.state_name,question_master.image,question_master.question,question_master.option_a,question_master.option_b,question_master.option_c,question_master.option_d,question_master.answer from question_master INNER JOIN main_category ON question_master.main_cat_id=main_category.id LEFT JOIN sub_category ON question_master.sub_cat_id=sub_category.id INNER JOIN countries ON question_master.country_id=countries.id INNER JOIN states ON question_master.state_id=states.id";
//                                                                print_r($sql);
                                                    $resultset = mysqli_query($con, $sql);
                                                    $count = count($sql);
                                                    if ($count >= 1) {
                                                        while ($rows = mysqli_fetch_array($resultset)) {

//                                                                    foreach ($data as $subData) {
                                                            echo "<tr>";
                                                            echo "<td>" . $k . "</td>";
                                                            echo "<td>" . $rows['main_cat_name'] . "</td>";
                                                            echo "<td>" . $rows['sub_cat_name'] . "</td>";
                                                            echo "<td>" . $rows['cname'] . "</td>";
                                                            echo "<td>" . $rows['state_name'] . "</td>";
                                                            echo "<td> <img src=Images/question/" . $rows['image'] . "  id='myImg' alt='image' class='img-responsive' height=50 width=50></td>";
                                                            echo "<td>" . $rows['question'] . "</td>";
                                                            echo "<td>" . $rows['option_a'] . "</td>";
                                                            echo "<td>" . $rows['option_b'] . "</td>";
                                                            echo "<td>" . $rows['option_c'] . "</td>";
                                                            echo "<td>" . $rows['option_d'] . "</td>";
                                                            echo "<td>" . $rows['answer'] . "</td>";
                                                            echo "<td><a href='add_question.php?type=edit&id=" . $rows['id'] . "' class='btn btn-primary waves-effect waves-light'>Edit</a> <button class='btn btn-danger btn_delete' id='" . $rows['id'] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash-o'>  Delete</button></td>";

                                                            echo "</tr>";
                                                            $k++;
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                            <div id="myModal" class="modal">
                                                <span class="close">&times;</span>
                                                <img class="modal-content" id="img01">
                                                <div id="caption"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                <!--end col--> 
                            </div>
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
        <script src="plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
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
        <!-- Sweet-Alert  -->
        <script src="plugins/sweet-alert2/sweetalert2.min.js"></script>
        <script src="assets/pages/sweet-alert.init.js"></script>
        <!-- Plugins Init js -->
        <script src="assets/pages/form-advanced.js"></script>
        <!-- App js -->
        <script src="assets/js/app.js"></script>
        <script type="text/javascript">
                                                            $('#question').focusout(function () {
                                                                var qus = document.getElementById("question").value;
                                                                var main = document.getElementById("main_cat_id").value;
//                                                                alert(main);
                                                                var my_object = {"add-question": qus, "main-cat": main};
                                                                $.ajax({
                                                                    url: 'validation.php',
                                                                    dataType: "html",
                                                                    data: my_object,
                                                                    cache: false,

                                                                    success: function (Data) {
                                                                        //alert(Data);
                                                                        var useri = Data;
                                                                        if (useri == 1) {
                                                                            $("#user-msg").text("This Question already exist!");
                                                                            $("#btn_save").prop('disabled', false);
                                                                        } else {
                                                                            $("#user-msg").text("");
                                                                            $("#btn_save").prop('disabled', false);
                                                                        }
                                                                    },
                                                                    error: function (errorThrown) {
                                                                        alert(errorThrown);
                                                                        alert("There is an error with AJAX!");
                                                                    }
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
        <script type="text/javascript">
            function mainchange()
            {

                var cat = document.getElementById("main_cat_id").value;
                //alert(country1);
                var dataString = 'main_cat_id=' + cat;
                //alert(dataString);
                $.ajax
                        ({

                            url: "getcat.php",
                            datatype: "html",
                            data: dataString,
                            cache: false,
                            success: function (html)
                            {
                                //alert(html);
                                $("#sub_list").html(html);
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
//                alert(id);
                location.href = "Delete.php?type=question&id=" + id;

                swal({
                    title: "Are you sure?",
                    text: "This will remove all data related to this?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
//                    closeOnConfirm: false,
//                    closeOnCancel: false
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                location.href = "Delete.php?type=question&id=" + id;
                                swal("Deleted!", "Image has been deleted.", "success");
                            } else {
                                swal("Cancelled", "You have cancelled this :)", "error");
                            }
                        });
            }
        </script>
        <script>
            // Get the modal
            var modal = document.getElementById('myModal');

            // Get the image and insert it inside the modal - use its "alt" text as a caption
            var img = document.getElementById('myImg');
            var modalImg = document.getElementById("img01");
            var captionText = document.getElementById("caption");
            img.onclick = function () {
                modal.style.display = "block";
                modalImg.src = this.src;
                captionText.innerHTML = this.alt;
            }

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks on <span> (x), close the modal
            span.onclick = function () {
                modal.style.display = "none";
            }
        </script>
    </body>

</html>


