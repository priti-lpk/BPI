<?php
ob_start();
include '../shreeLib/session_info.php';
include_once '../shreeLib/DBAdapter.php';
//echo $_GET['party_id'];
if (isset($_GET['type']) && isset($_GET['id'])) {
    $edba = new DBAdapter();
    $edata = $edba->getRow("inquiry", array("*"), "id=" . $_GET['id']);
    echo "<input type='hidden' id='inquiry_id' value='" . $_GET['id'] . "'>";
}
if (isset($_SESSION['user_id'])) {
    $edba = new DBAdapter();
    $servername1 = basename($_SERVER['PHP_SELF']);
// echo $servername1;
    $field = array("role_rights.id");
    $data = $dba->getLastID("roles_id", "create_user", "id=" . $_SESSION['user_id']);
//    print_r($data);
    $role_name = $dba->getLastID("role_name", "role_master", "id=" . $data);
//    print_r($data1);
    $mod_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, " module.mod_pagename='" . $servername1 . "' and role_rights.role_id=" . $data);
    echo "<input type='hidden' id='role_id' value='" . $mod_data[0][0] . "'>";

    $field = array("role_rights.id,role_rights.role_edit,role_rights.role_delete");
    $role_data = $edba->getRow("role_rights INNER JOIN  module ON role_rights.mod_id= module.id", $field, "  role_rights.id=" . $mod_data[0][0]);
    echo "<input type='hidden' id='role_id' value='" . $role_data[0][1] . "'>";
    $editdata = 0;
    $deletedata = 0;
    if ($role_data[0][1] == 1) {
        $editdata = 1;
//echo $editdata;
    }
    if ($role_data[0][2] == 1) {
        $deletedata = 1;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>View Inquiry</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="Themesbrand" name="author" />
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <link href="../plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
        <link href="../plugins/bootstrap-md-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
        <link href="../plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="../plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />

        <!-- DataTables -->
        <link href="../plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="../plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="../plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="../assets/css/style.css" rel="stylesheet" type="text/css">
    </head>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <?php include '../topbar.php'; ?>
            <!-- Top Bar End -->

            <!-- ========== Left Sidebar Start ========== -->
            <?php include '../sidebar.php'; ?>
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
                                    <h4 class="page-title">View Of Inquiry</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        <?php
                        if ($role_name == 'Manager') {
                            if (isset($_GET['p_id'])) {
                                ?>
                                <div class="page-content-wrapper">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card m-b-20">
                                                <div class="card-body">                   
                                                    <form action="" id="form_data" class="form-horizontal" role="form" method="get" enctype="multipart/form-data" >  
                                                        <div class="form-group row">
                                                            <label for="ticket-name" class="col-sm-1 control-label" id="lblpartydate">From</label>
                                                            <div class="col-sm-3" id="partydue">
                                                                <input type="date"  id="datevaluefrm" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][1] : '') ?>" name="from_date" id="from_date"  class="form-control" placeholder="Inquiry Date" required>
                                                            </div>
                                                            <label for="ticket-name" class="col-sm-1 control-label" id="lblpartydate">To</label>
                                                            <div class="col-sm-3" id="partydue">
                                                                <input type="date"  id="datevalueto" value="<?php echo (isset($_GET['type']) && isset($_GET['id']) ? $edata[0][1] : '') ?>" name="to_date" id="to_date"  class="form-control" placeholder="Inquiry Date" require2]d>
                                                            </div>
                                                            <div class = "button-items">
                                                                <button type = "submit" id="btn_go" name="btn_go" class = "btn btn-primary waves-effect waves-light"><i class="fa fa-search"></i></button>
                                                            </div>
                                                            <div class="col-sm-3" align="right">
                                                                <td><a href = '#addinstruction' style="color: black;margin-right: -30px;" data-toggle = 'modal'><i class="fa fa-info-circle"></i></a>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <form action="" id="form_data" class="form-horizontal" role="form" method="get" enctype="multipart/form-data" >  

                                                        <div class="form-group row">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">Select Party</label>
                                                            <input type="hidden" id="pdatevaluefrm"  name="pfrom_date" id="from_date" class="form-control"  required>
                                                            <input type="hidden" id="pdatevalueto"  name="pto_date" id="to_date" class="form-control"  required>

                                                            <div class="col-sm-5" id="party">       
                                                                <select class="form-control select2" name="party_id" id="create_party" required="">
                                                                    <option>Select Party</option>
                                                                    <?php
                                                                    $dba = new DBAdapter ();
                                                                    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                                    $data = $dba->getRow("create_party", array("id", "party_name"), "1");
                                                                    foreach ($data as $subData) {
                                                                        echo "<option value=" . $subData[0] . ">" . $subData[1] . "</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class = "button-items">
                                                                <button type = "submit" id="pbtn_go" name="btn_go" class = "btn btn-primary waves-effect waves-light"><i class="fa fa-search"></i></button>
                                                            </div>
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

                                                    <h4 class="mt-0 header-title">View Of Inquiry</h4>
                                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                                        <thead>
                                                            <tr>
                                                                <th>Inquiry No.</th>
                                                                <th>Party Name</th>
                                                                <th>Inquiry Date</th>
                                                                <th>Remark</th>
                                                                <th>Status</th>
                                                                <th>Total Items</th>
                                                                <?php if ($role_data[0][1] == 1) { ?>
                                                                    <th>Edit</th> <?php } ?>
                                                                <?php if ($role_data[0][2] == 1) { ?> <th>Delete</th><?php } ?>

                                                            </tr>
                                                        </thead>

                                                        <tbody>

                                                        </tbody>

                                                    </table>

                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                    </div>
                                </div>

                                <?php
                            } elseif (isset($_GET['from_date']) && isset($_GET['to_date'])) {
                                ?>
                                <div class="page-content-wrapper">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card m-b-20">
                                                <div class="card-body">                   
                                                    <form action="" id="form_data" class="form-horizontal" role="form" method="get" enctype="multipart/form-data" >  
                                                        <div class="form-group row">
                                                            <label for="ticket-name" class="col-sm-1 control-label" id="lblpartydate">From</label>
                                                            <div class="col-sm-3" id="partydue">
                                                                <input type="date"   value="<?php echo ( isset($_GET['from_date']) && isset($_GET['to_date']) ? $_GET['from_date'] : '') ?>" id="datevaluefrm" name="from_date" id="from_date"  class="form-control" placeholder="Inquiry Date" required>
                                                            </div>
                                                            <label for="ticket-name" class="col-sm-1 control-label" id="lblpartydate">To</label>
                                                            <div class="col-sm-3" id="partydue">
                                                                <input type="date"  id="datevalueto" value="<?php echo ( isset($_GET['from_date']) && isset($_GET['to_date']) ? $_GET['to_date'] : '') ?>" name="to_date" id="to_date"  class="form-control" placeholder="Inquiry Date" require2]d>
                                                            </div>
                                                            <div class = "button-items">
                                                                <button type = "submit" id="btn_go" name="btn_go" class = "btn btn-primary waves-effect waves-light"><i class="fa fa-search"></i></button>
                                                            </div>
                                                            <div class="col-sm-3" align="right">
                                                                <td><a href = '#addinstruction' style="color: black;margin-right: -30px;" data-toggle = 'modal'><i class="fa fa-info-circle"></i></a>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <form action="" id="form_data" class="form-horizontal" role="form" method="get" enctype="multipart/form-data" >  

                                                        <div class="form-group row">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">Select Party</label>
                                                            <input type="hidden" id="pdatevaluefrm"  name="pfrom_date" id="from_date" class="form-control"  required>
                                                            <input type="hidden" id="pdatevalueto"  name="pto_date" id="to_date" class="form-control"  required>
                                                            <div class="col-sm-5" id="party">       
                                                                <select class="form-control select2" name="party_id" id="create_party" required="">
                                                                    <option>Select Party</option>
                                                                    <?php
                                                                    $dba = new DBAdapter();
                                                                    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                                    $data = $dba->getRow("create_party", array("id", "party_name"), "1");
                                                                    foreach ($data as $subData) {
                                                                        echo "<option " . ($subData[0] == $_GET['party_id'] ? 'selected' : '') . " value=" . $subData[0] . ">" . $subData[1] . "</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class = "button-items">
                                                                <button type = "submit" id="pbtn_go" name="btn_go" class = "btn btn-primary waves-effect waves-light"><i class="fa fa-search"></i></button>
                                                            </div>
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

                                                    <h4 class="mt-0 header-title">View Of Inquiry</h4>
                                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                                        <thead>
                                                            <tr>
                                                                <th>Inquiry No.</th>
                                                                <th>Party Name</th>
                                                                <th>Inquiry Date</th>
                                                                <th>Remark</th>
                                                                <th>Status</th>
                                                                <th>Total Items</th>
                                                                <th>Action</th>

                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php
                                                            if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
                                                                $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                                $userid = $_SESSION['user_id'];
//                                                                    $id = $_GET['party_id'];
                                                                $firstdate = $_GET['from_date'];
//                                                                    print_r($firstdate);
                                                                $lastdate = $_GET['to_date'];

                                                                $del = $deletedata;
                                                                $edit = $editdata;

                                                                include_once("../shreeLib/dbconn.php");
                                                                $sql = "SELECT inquiry.id,create_party.party_name,inquiry.inq_date,inquiry.inq_remark, inquiry.user_id,inquiry.status,COUNT(inquiry_item_list.inq_id) as total FROM inquiry_item_list LEFT JOIN inquiry ON inquiry_item_list.inq_id=inquiry.id INNER JOIN create_party ON create_party.id = inquiry.party_id WHERE inquiry.inq_date >='" . $firstdate . "' AND inquiry.inq_date <='" . $lastdate . "' GROUP BY inquiry.id";
//                                                                    print_r($sql);
                                                                $resultset = mysqli_query($con, $sql);
                                                                while ($rows = mysqli_fetch_array($resultset)) {

                                                                    echo "<tr>";
                                                                    echo "<td>" . $rows['id'] . "</td>";
                                                                    echo "<td>" . $rows['party_name'] . "</td>";
                                                                    $date = $rows['inq_date'];
                                                                    $dates = date("d-m-Y", strtotime($date));
                                                                    echo "<td>" . $dates . "</td>";
                                                                    echo "<td>" . $rows['inq_remark'] . "</td>";
                                                                    echo "<td>";
                                                                    if ($rows['status'] == 'on') {
                                                                        echo "<input type='checkbox' switch='none' data-status='off' id='" . $rows['id'] . "'   onclick='approveuser(this.id)' checked/><label for='" . $rows['id'] . "' data-on-label='On' data-off-label='Off'></label></td>";
                                                                    } else {
                                                                        echo "<input type='checkbox' switch='none' data-status='on' id='" . $rows['id'] . "'  onclick='approveuser(this.id)'/><label for='" . $rows['id'] . "'  data-on-label='On' data-off-label='Off' ></label></td>";
                                                                    }
                                                                    echo "</td>";
                                                                    echo "<td>" . $rows['total'] . "</td>";
                                                                    echo "<td><a href='view/view_inquiry_item.php?id=" . $rows[0] . "'  class='btn btn-primary' id='" . $rows[0] . "'><i class='fa fa-edit'></i> View Items</a>&nbsp;";

                                                                    if ($edit == 1) {
                                                                        echo "<a href='Inquiry.php?type=edit&id=" . $rows[0] . "' target='_blank' class='btn btn-primary' id='" . $rows[0] . "'><i class='fa fa-edit'></i> Edit</a>&nbsp;";
                                                                    }

                                                                    if ($del == 1) {
                                                                        echo "<button class='btn btn-danger' id='" . $rows[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash'>Delete</i></button></td>";
                                                                    }
                                                                    echo '</tr>';
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>

                                                    </table>

                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                    </div>
                                </div>
                                <?php
                            } elseif (isset($_GET['party_id'])) {
                                ?>
                                <div class="page-content-wrapper">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card m-b-20">
                                                <div class="card-body">                   
                                                    <form action="" id="form_data" class="form-horizontal" role="form" method="get" enctype="multipart/form-data" >  
                                                        <div class="form-group row">
                                                            <label for="ticket-name" class="col-sm-1 control-label" id="lblpartydate">From</label>
                                                            <div class="col-sm-3" id="partydue">
                                                                <input type="date"  id="datevaluefrm" value="<?php echo (isset($_GET['pfrom_date']) && isset($_GET['pto_date']) ? $_GET['pfrom_date'] : '') ?>" name="from_date" id="from_date"  class="form-control" placeholder="Inquiry Date" required>
                                                            </div>
                                                            <label for="ticket-name" class="col-sm-1 control-label" id="lblpartydate">To</label>
                                                            <div class="col-sm-3" id="partydue">
                                                                <input type="date"  id="datevalueto" value="<?php echo (isset($_GET['pfrom_date']) && isset($_GET['pto_date']) ? $_GET['pto_date'] : '') ?>" name="to_date" id="to_date"  class="form-control" placeholder="Inquiry Date" require2]d>
                                                            </div>
                                                            <div class = "button-items">
                                                                <button type = "submit" id="btn_go" name="btn_go" class = "btn btn-primary waves-effect waves-light"><i class="fa fa-search"></i></button>
                                                            </div>
                                                            <div class="col-sm-3" align="right">
                                                                <td><a href = '#addinstruction' style="color: black;margin-right: -30px;" data-toggle = 'modal'><i class="fa fa-info-circle"></i></a>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <form action="" id="form_data" class="form-horizontal" role="form" method="get" enctype="multipart/form-data" >  

                                                        <div class="form-group row">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">Select Party</label>
                                                            <input type="hidden" id="pdatevaluefrm"  name="pfrom_date" id="from_date" class="form-control"  required>
                                                            <input type="hidden" id="pdatevalueto"  name="pto_date" id="to_date" class="form-control"  required>

                                                            <div class="col-sm-5" id="party">       
                                                                <select class="form-control select2" name="party_id" id="create_party" required="">
                                                                    <option>Select Party</option>
                                                                    <?php
                                                                    $dba = new DBAdapter ();
                                                                    $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                                    $data = $dba->getRow("create_party", array("id", "party_name"), "1");
                                                                    foreach ($data as $subData) {
                                                                        echo "<option " . ($subData[0] == $_GET['party_id'] ? 'selected' : '') . " value=" . $subData[0] . ">" . $subData[1] . "</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class = "button-items">
                                                                <button type = "submit" id="pbtn_go" name="btn_go" class = "btn btn-primary waves-effect waves-light"><i class="fa fa-search"></i></button>
                                                            </div>
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

                                                    <h4 class="mt-0 header-title">View Of Inquiry</h4>
                                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                                        <thead>
                                                            <tr>
                                                                <th>Inquiry No.</th>
                                                                <th>Party Name</th>
                                                                <th>Inquiry Date</th>
                                                                <th>Remark</th>
                                                                <th>Status</th>
                                                                <th>Total Items</th>
                                                                <th>Action</th>

                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php
                                                            if (isset($_GET['party_id'])) {
//                                                                   
                                                                $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                                $userid = $_SESSION['user_id'];
                                                                $id = $_GET['party_id'];
                                                                $pfirstdate = $_GET['pfrom_date'];
                                                                $plastdate = $_GET['pto_date'];

                                                                $del = $deletedata;
                                                                $edit = $editdata;

                                                                include_once ("../shreeLib/dbconn.php");
                                                                $sql = "SELECT inquiry.id,create_party.party_name,inquiry.inq_date,inquiry.inq_remark,inquiry.user_id,inquiry.status,COUNT(inquiry_item_list.inq_id) as total FROM inquiry_item_list LEFT JOIN inquiry ON inquiry_item_list.inq_id=inquiry.id INNER JOIN create_party ON create_party.id = inquiry.party_id WHERE inquiry.inq_date >='" . $pfirstdate . "' AND inquiry.inq_date <='" . $plastdate . "' AND  inquiry.party_id=" . $id . " GROUP BY inquiry.id";
                                                                //print_r($sql);
                                                                $resultset = mysqli_query($con, $sql);
                                                                while ($rows = mysqli_fetch_array($resultset)) {
                                                                    echo "<tr>";
                                                                    echo "<td>" . $rows['id'] . "</td>";
                                                                    echo "<td>" . $rows['party_name'] . "</td>";
                                                                    $date = $rows['inq_date'];
                                                                    $dates = date("d-m-Y", strtotime($date));
                                                                    echo "<td>" . $dates . "</td>";
                                                                    echo "<td>" . $rows['inq_remark'] . "</td>";
                                                                    echo "<td>";
                                                                    if ($rows['status'] == 'on') {
                                                                        echo "<input type='checkbox' switch='none' data-status='off' id='" . $rows['id'] . "'   onclick='approveuser(this.id)' checked/><label for='" . $rows['id'] . "' data-on-label='On' data-off-label='Off'></label></td>";
                                                                    } else {
                                                                        echo "<input type='checkbox' switch='none' data-status='on' id='" . $rows['id'] . "'  onclick='approveuser(this.id)'/><label for='" . $rows['id'] . "'  data-on-label='On' data-off-label='Off' ></label></td>";
                                                                    }
                                                                    echo "</td>";
                                                                    echo"<td>" . $rows['total'] . "</td>";
                                                                    echo "<td><a href='view/view_inquiry_item.php?id=" . $rows[0] . "'  class='btn btn-primary' id='" . $rows[0] . "'><i class='fa fa-edit'></i> View Items</a>&nbsp;";

                                                                    if ($edit == 1) {
                                                                        echo "<a href='Inquiry.php?type=edit&id=" . $rows[0] . "' target='_blank' class='btn btn-primary' id='" . $rows[0] . "'><i class='fa fa-edit'></i> Edit</a>&nbsp;";
                                                                    }

                                                                    if ($del == 1) {
                                                                        echo "<button class='btn btn-danger' id='" . $rows[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash'>Delete</button></td>";
                                                                    }

                                                                    //echo "<td><a href='AddPurchaseList.php?type=edit&id=" . $rows[0] . "' class='btn btn-primary' id='" . $rows[0] . "'><i class='fa fa-edit'></i> Edit</a> <button class='btn btn-danger' id='" . $rows[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash-o'>Delete</button></td></tr>";
                                                                    echo '</tr>';
                                                                    //}
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>

                                                    </table>

                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                    </div>
                                </div>
                                <?php
                            } else {
                                ?>

                                <div class = "row">
                                    <div class = "col-12">
                                        <div class = "card m-b-20">
                                            <div class = "card-body">

                                                <h4 class = "mt-0 header-title">View of Party</h4><br>
                                                <table id = "datatable-buttons" class = "table table-striped table-bordered dt-responsive nowrap" style = "border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Party Name</th>
                                                            <th>Party Contact</th>
                                                            <th>Party Email</th>
                                                            <th>Party Address</th>
                                                            <th>Total Inquiry</th>
                                                            <th>View Inquiry</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        include_once '../shreeLib/DBAdapter.php';
                                                        $dba = new DBAdapter();
                                                        $field = array("create_party.id,create_party.party_name,create_party.party_contact,create_party.party_email,create_party.party_address,COUNT(inquiry.party_id) as total");
                                                        $data = $dba->getRow("create_party left JOIN inquiry ON create_party.id=inquiry.party_id", $field, "1 GROUP BY create_party.id");
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

                                                                echo "<td><a href='view/Inquiry.php?p_id=" . $subData[0] . "'  class='btn btn-primary' id='" . $subData[0] . "'><i class='fa fa-list fw'></i>View Inquiry</a></td>";

                                                                echo '</tr>';
                                                            }
                                                        } else {
                                                            //echo 'No Data Available';
                                                        }
                                                        ?>   
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="page-content-wrapper">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card m-b-20">
                                            <div class="card-body">                   
                                                <form action="" id="form_data" class="form-horizontal" role="form" method="get" enctype="multipart/form-data" >  
                                                    <div class="form-group row">
                                                        <label for="ticket-name" class="col-sm-1 control-label" id="lblpartydate">From</label>
                                                        <div class="col-sm-3" id="partydue">
                                                            <input type="date"  id="datevaluefrm" value="<?php echo ( isset($_GET['type']) && isset($_GET['id']) ? $edata[0][1] : '') ?>" name="from_date" id="from_date"  class="form-control" placeholder="Inquiry Date" required>
                                                        </div>
                                                        <label for="ticket-name" class="col-sm-1 control-label" id="lblpartydate">To</label>
                                                        <div class="col-sm-3" id="partydue">
                                                            <input type="date"  id="datevalueto" value="<?php echo ( isset($_GET['type']) && isset($_GET['id']) ? $edata[0][1] : '') ?>" name="to_date" id="to_date"  class="form-control" placeholder="Inquiry Date" require2]d>
                                                        </div>
                                                        <div class = "button-items">
                                                            <button type = "submit" id="btn_go" name="btn_go" class = "btn btn-primary waves-effect waves-light"><i class="fa fa-search"></i></button>
                                                        </div>
                                                        <div class="col-sm-3" align="right">
                                                            <td><a href = '#addinstruction' style="color: black;margin-right: -30px;" data-toggle = 'modal'><i class="fa fa-info-circle"></i></a>
                                                        </div>
                                                    </div>
                                                </form>
                                                <form action="" id="form_data" class="form-horizontal" role="form" method="get" enctype="multipart/form-data" >  

                                                    <div class="form-group row">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">Select Party</label>
                                                        <input type="hidden" id="pdatevaluefrm"  name="pfrom_date" id="from_date" class="form-control"  required>
                                                        <input type="hidden" id="pdatevalueto"  name="pto_date" id="to_date" class="form-control"  required>

                                                        <div class="col-sm-5" id="party">       
                                                            <select class="form-control select2" name="party_id" id="create_party" required="">
                                                                <option>Select Party</option>
                                                                <?php
                                                                $dba = new DBAdapter();
                                                                $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                                $data = $dba->getRow("create_party", array("id", "party_name"), "1");
                                                                foreach ($data as $subData) {
                                                                    echo "<option value=" . $subData[0] . ">" . $subData[1] . "</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class = "button-items">
                                                            <button type = "submit" id="pbtn_go" name="btn_go" class = "btn btn-primary waves-effect waves-light"><i class="fa fa-search"></i></button>
                                                        </div>
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

                                                <h4 class="mt-0 header-title">View Of Inquiry</h4>
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <?php
                                                    if ($role_name == 'Manager') {
                                                        ?>
                                                        <thead>
                                                            <tr>
                                                                <th>Inquiry No.</th>
                                                                <th>Party Name</th>
                                                                <th>Inquiry Date</th>
                                                                <th>Remark</th>
                                                                <th>Status</th>
                                                                <th>Total Items</th>
                                                                <?php if ($role_data[0][1] == 1) { ?>
                                                                    <th>Edit</th> <?php } ?>
                                                                <?php if ($role_data[0][2] == 1) { ?> <th>Delete</th><?php } ?>

                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php
                                                            if (isset($_GET['party_id'])) {
//                                                                   
                                                                $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                                $userid = $_SESSION['user_id'];
                                                                $id = $_GET['party_id'];
                                                                $pfirstdate = $_GET['pfrom_date'];
                                                                $plastdate = $_GET['pto_date'];

                                                                $del = $deletedata;
                                                                $edit = $editdata;

                                                                include_once("../shreeLib/dbconn.php");
                                                                $sql = "SELECT inquiry.id,create_party.party_name,inquiry.inq_date,inquiry.inq_remark,inquiry.user_id,inquiry.status,COUNT(inquiry_item_list.inq_id) as total FROM inquiry_item_list LEFT JOIN inquiry ON inquiry_item_list.inq_id=inquiry.id INNER JOIN create_party ON create_party.id = inquiry.party_id WHERE inquiry.inq_date >='" . $pfirstdate . "' AND inquiry.inq_date <='" . $plastdate . "' AND  inquiry.party_id=" . $id . " GROUP BY inquiry.id";
                                                                //print_r($sql);
                                                                $resultset = mysqli_query($con, $sql);
                                                                while ($rows = mysqli_fetch_array($resultset)) {
                                                                    echo "<tr>";
                                                                    echo "<td>" . $rows['id'] . "</td>";
                                                                    echo "<td>" . $rows['party_name'] . "</td>";
                                                                    $date = $rows['inq_date'];
                                                                    $dates = date("d-m-Y", strtotime($date));
                                                                    echo "<td>" . $dates . "</td>";
                                                                    echo "<td>" . $rows['inq_remark'] . "</td>";
                                                                    echo "<td>";
                                                                    if ($rows['status'] == 'on') {
                                                                        echo "<input type='checkbox' switch='none' data-status='off' id='" . $rows['id'] . "'   onclick='approveuser(this.id)' checked/><label for='" . $rows['id'] . "' data-on-label='On' data-off-label='Off'></label></td>";
                                                                    } else {
                                                                        echo "<input type='checkbox' switch='none' data-status='on' id='" . $rows['id'] . "'  onclick='approveuser(this.id)'/><label for='" . $rows['id'] . "'  data-on-label='On' data-off-label='Off' ></label></td>";
                                                                    }
                                                                    echo "</td>";
                                                                    echo"<td>" . $rows['total'] . "</td>";
                                                                    if ($edit == 1) {
                                                                        echo "<td><a href='Inquiry.php?type=edit&id=" . $rows[0] . "' target='_blank' class='btn btn-primary' id='" . $rows[0] . "'><i class='fa fa-edit'></i> Edit</a></td>";
                                                                    }

                                                                    if ($del == 1) {
                                                                        echo "<td><button class='btn btn-danger' id='" . $rows[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash'>Delete</button></td>";
                                                                    }

                                                                    //echo "<td><a href='AddPurchaseList.php?type=edit&id=" . $rows[0] . "' class='btn btn-primary' id='" . $rows[0] . "'><i class='fa fa-edit'></i> Edit</a> <button class='btn btn-danger' id='" . $rows[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash-o'>Delete</button></td></tr>";
                                                                    echo '</tr>';
                                                                    //}
                                                                }
                                                            } elseif (isset($_GET['from_date']) && isset($_GET['to_date'])) {
                                                                $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                                $userid = $_SESSION['user_id'];
//                                                                    $id = $_GET['party_id'];
                                                                $firstdate = $_GET['from_date'];
//                                                                    print_r($firstdate);
                                                                $lastdate = $_GET['to_date'];

                                                                $del = $deletedata;
                                                                $edit = $editdata;

                                                                include_once("../shreeLib/dbconn.php");
                                                                $sql = "SELECT inquiry.id,create_party.party_name,inquiry.inq_date,inquiry.inq_remark, inquiry.user_id,inquiry.status,COUNT(inquiry_item_list.inq_id) as total FROM inquiry_item_list LEFT JOIN inquiry ON inquiry_item_list.inq_id=inquiry.id INNER JOIN create_party ON create_party.id = inquiry.party_id WHERE inquiry.inq_date >='" . $firstdate . "' AND inquiry.inq_date <='" . $lastdate . "' GROUP BY inquiry.id";
//                                                                    print_r($sql);
                                                                $resultset = mysqli_query($con, $sql);
                                                                while ($rows = mysqli_fetch_array($resultset)) {

                                                                    echo "<tr>";
                                                                    echo "<td>" . $rows['id'] . "</td>";
                                                                    echo "<td>" . $rows['party_name'] . "</td>";
                                                                    $date = $rows['inq_date'];
                                                                    $dates = date("d-m-Y", strtotime($date));
                                                                    echo "<td>" . $dates . "</td>";
                                                                    echo "<td>" . $rows['inq_remark'] . "</td>";
                                                                    echo "<td>";
                                                                    if ($rows['status'] == 'on') {
                                                                        echo "<input type='checkbox' switch='none' data-status='off' id='" . $rows['id'] . "'   onclick='approveuser(this.id)' checked/><label for='" . $rows['id'] . "' data-on-label='On' data-off-label='Off'></label></td>";
                                                                    } else {
                                                                        echo "<input type='checkbox' switch='none' data-status='on' id='" . $rows['id'] . "'  onclick='approveuser(this.id)'/><label for='" . $rows['id'] . "'  data-on-label='On' data-off-label='Off' ></label></td>";
                                                                    }
                                                                    echo "</td>";
                                                                    echo "<td>" . $rows['total'] . "</td>";
                                                                    if ($edit == 1) {
                                                                        echo "<td><a href='Inquiry.php?type=edit&id=" . $rows[0] . "' target='_blank' class='btn btn-primary' id='" . $rows[0] . "'><i class='fa fa-edit'></i> Edit</a></td>";
                                                                    }

                                                                    if ($del == 1) {
                                                                        echo "<td><button class='btn btn-danger' id='" . $rows[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash'>Delete</button></td>";
                                                                    }
                                                                    echo '</tr>';
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <thead>
                                                            <tr>
                                                                <th>Inquiry No.</th>
                                                                <!--<th>Party Name</th>-->
                                                                <th>Inquiry Date</th>
                                                                <th>Remark</th>
                                                                <th>Status</th>
                                                                <th>Total Items</th>
                                                                <?php if ($role_data[0][1] == 1) { ?>
                                                                    <th>Edit</th> <?php } ?>
                                                                <?php if ($role_data[0][2] == 1) { ?> <th>Delete</th><?php } ?>

                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php
                                                            if (isset($_GET['party_id'])) {
//                                                                   
                                                                $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                                $userid = $_SESSION['user_id'];
                                                                $id = $_GET['party_id'];
                                                                $pfirstdate = $_GET['pfrom_date'];
                                                                $plastdate = $_GET['pto_date'];

                                                                $del = $deletedata;
                                                                $edit = $editdata;

                                                                include_once("../shreeLib/dbconn.php");
                                                                $sql = "SELECT inquiry.id,create_party.party_name,inquiry.inq_date,inquiry.inq_remark,inquiry.user_id,inquiry.status,COUNT(inquiry_item_list.inq_id) as total FROM inquiry_item_list LEFT JOIN inquiry ON inquiry_item_list.inq_id=inquiry.id INNER JOIN create_party ON create_party.id = inquiry.party_id WHERE inquiry.inq_date >='" . $pfirstdate . "' AND inquiry.inq_date <='" . $plastdate . "' AND  inquiry.party_id=" . $id . " GROUP BY inquiry.id";
                                                                //print_r($sql);
                                                                $resultset = mysqli_query($con, $sql);
                                                                while ($rows = mysqli_fetch_array($resultset)) {
                                                                    echo "<tr>";
                                                                    echo "<td>" . $rows['id'] . "</td>";
//                                                                echo "<td>" . $rows['party_name'] . "</td>";
                                                                    $date = $rows['inq_date'];
                                                                    $dates = date("d-m-Y", strtotime($date));
                                                                    echo "<td>" . $dates . "</td>";
                                                                    echo "<td>" . $rows['inq_remark'] . "</td>";
                                                                    echo "<td>";
                                                                    if ($rows['status'] == 'on') {
                                                                        echo "<input type='checkbox' switch='none' data-status='off' id='" . $rows['id'] . "'   onclick='approveuser(this.id)' checked/><label for='" . $rows['id'] . "' data-on-label='On' data-off-label='Off'></label></td>";
                                                                    } else {
                                                                        echo "<input type='checkbox' switch='none' data-status='on' id='" . $rows['id'] . "'  onclick='approveuser(this.id)'/><label for='" . $rows['id'] . "'  data-on-label='On' data-off-label='Off' ></label></td>";
                                                                    }
                                                                    echo "</td>";
                                                                    echo"<td>" . $rows['total'] . "</td>";
                                                                    if ($edit == 1) {
                                                                        echo "<td><a href='Inquiry.php?type=edit&id=" . $rows[0] . "' target='_blank' class='btn btn-primary' id='" . $rows[0] . "'><i class='fa fa-edit'></i> Edit</a></td>";
                                                                    }

                                                                    if ($del == 1) {
                                                                        echo "<td><button class='btn btn-danger' id='" . $rows[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash'>Delete</button></td>";
                                                                    }

                                                                    //echo "<td><a href='AddPurchaseList.php?type=edit&id=" . $rows[0] . "' class='btn btn-primary' id='" . $rows[0] . "'><i class='fa fa-edit'></i> Edit</a> <button class='btn btn-danger' id='" . $rows[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash-o'>Delete</button></td></tr>";
                                                                    echo '</tr>';
                                                                    //}
                                                                }
                                                            } elseif (isset($_GET['from_date']) && isset($_GET['to_date'])) {
                                                                $last_id = $dba->getLastID("branch_id", "create_user", "id=" . $_SESSION['user_id']);
                                                                $userid = $_SESSION['user_id'];
//                                                                    $id = $_GET['party_id'];
                                                                $firstdate = $_GET['from_date'];
//                                                                    print_r($firstdate);
                                                                $lastdate = $_GET['to_date'];

                                                                $del = $deletedata;
                                                                $edit = $editdata;

                                                                include_once("../shreeLib/dbconn.php");
                                                                $sql = "SELECT inquiry.id,create_party.party_name,inquiry.inq_date,inquiry.inq_remark, inquiry.user_id,inquiry.status,COUNT(inquiry_item_list.inq_id) as total FROM inquiry_item_list LEFT JOIN inquiry ON inquiry_item_list.inq_id=inquiry.id INNER JOIN create_party ON create_party.id = inquiry.party_id WHERE inquiry.inq_date >='" . $firstdate . "' AND inquiry.inq_date <='" . $lastdate . "' GROUP BY inquiry.id";
//                                                                    print_r($sql);
                                                                $resultset = mysqli_query($con, $sql);
                                                                while ($rows = mysqli_fetch_array($resultset)) {

                                                                    echo "<tr>";
                                                                    echo "<td>" . $rows['id'] . "</td>";
//                                                                echo "<td>" . $rows['party_name'] . "</td>";
                                                                    $date = $rows['inq_date'];
                                                                    $dates = date("d-m-Y", strtotime($date));
                                                                    echo "<td>" . $dates . "</td>";
                                                                    echo "<td>" . $rows['inq_remark'] . "</td>";
                                                                    echo "<td>";
                                                                    if ($rows['status'] == 'on') {
                                                                        echo "<input type='checkbox' switch='none' data-status='off' id='" . $rows['id'] . "'   onclick='approveuser(this.id)' checked/><label for='" . $rows['id'] . "' data-on-label='On' data-off-label='Off'></label></td>";
                                                                    } else {
                                                                        echo "<input type='checkbox' switch='none' data-status='on' id='" . $rows['id'] . "'  onclick='approveuser(this.id)'/><label for='" . $rows['id'] . "'  data-on-label='On' data-off-label='Off' ></label></td>";
                                                                    }
                                                                    echo "</td>";
                                                                    echo "<td>" . $rows['total'] . "</td>";
                                                                    if ($edit == 1) {
                                                                        echo "<td><a href='Inquiry.php?type=edit&id=" . $rows[0] . "' class='btn btn-primary' id='" . $rows[0] . "'><i class='fa fa-edit'></i> Edit</a></td>";
                                                                    }

                                                                    if ($del == 1) {
                                                                        echo "<td><button class='btn btn-danger' id='" . $rows[0] . "' onclick='SetForDelete(this.id);'><i class='fa fa-trash'>Delete</button></td>";
                                                                    }
                                                                    echo '</tr>';
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>
                                                        <?php
                                                    }
                                                    ?>
                                                </table>

                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div>
                            </div>
                        <?php }
                        ?>
                        <!-- end page content-->

                    </div> <!-- container-fluid -->

                </div> <!-- content -->
                <div class="col-sm-6 col-md-3 m-t-30">
                    <div class="modal fade" id="addinstruction" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title mt-0">View Instruction</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <p><i class="fa fa-hand-point-right"></i> First of  date select  then search the inquiry between two date.</p>
                                            <p><i class="fa fa-hand-point-right"></i> After  party select then search inquiry between two date and selected party.</p>
                                            <p><i class="fa fa-hand-point-right"></i> You can edit and delete inquiry.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </div>
                <?php include '../footer.php' ?>

            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->


        <!-- jQuery  -->       
        <script src = "customFile/cancelmsgJs.js"></script>
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
        <!-- Required datatable js -->
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

        <!-- Datatable init js -->
        <script src="assets/pages/datatables.init.js"></script>

        <script src="assets/pages/form-advanced.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>
        <script>

        </script>
        <script>
            $(document).ready(function () {

                $('#addmsg').on('show.bs.modal', function (e) {
                    var i_Id = $(e.relatedTarget).data('id');
                    // alert(i_Id);
                    $(e.currentTarget).find('input[name="inquiry_id"]').val(i_Id);
                });
            });
        </script>
        <script>
            function approveuser(sid) {
                $.ajax({
                    url: "status.php",
                    type: "POST",
                    data: {
                        sid: sid,
                        status: $("#" + sid).data('status'),
                        action: "mainstatus",
                    },
                    dataType: "html",
                    success: function (data) {
//                        alert(data);
                        window.location.reload(true);

                    },
                    //                    fail: function () {
                    //                        swal("Error!", "Error while performing operation!", "error");
                    //                    },
                    //                    error: function (data, status, jg) {
                    //                        swal("Error!", data.responseText, "error");
                    //                    }
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
            var datefrm = yyyy + "-" + mm + "-01";
//            document.getElementById("datevaluefrm").value = datefrm;
//            document.getElementById("datevalueto").value = date;
        </script>
        <script type="text/javascript">
            $("#pbtn_go").on('click', function ()
            {
                var fdate = document.getElementById("datevaluefrm").value;
                var tdate = document.getElementById("datevalueto").value;
                $('#pdatevaluefrm').val(fdate);
                $('#pdatevalueto').val(tdate);

            });
        </script>
        <script type="text/javascript">

            function SetForDelete(id) {
                location.href = "Delete.php?type=inquiry&id=" + id;

            }
        </script>
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
    </body>

</html>


