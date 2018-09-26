<?php
ob_start();
if (!isset($_SESSION)) {
    session_start();
}
?>
<html>

    <head>
        <base href="http://localhost/blue_parl_import_export/">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="Blue Parl Import Export">
        <meta name="author" content="LPK Technosoft">
        <!-- CSS -->

        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/main.css" rel="stylesheet" type="text/css">
        <link href="assets/css/my-custom-styles.css" rel="stylesheet" type="text/css">
        <link rel="shortcut icon" href="assets/ico/favicon.png">
        <link rel="stylesheet" href="assets/css/sweetalert2.css">
        <script type="text/javascript" src="assets/js/sweetalert2.min.js"></script>

    </head>
    <div class="top-bar navbar-fixed-top">
        <div class="container">
            <div class="clearfix">
                <a href="Dashboard.php" class="pull-left toggle-sidebar-collapse"><i class="fa fa-bars"></i></a>
                <!-- logo -->
                <div class="pull-left left logo">
                    <h3>Blue Parl Import Export Admin Panel</h3>
                    <h1 class="sr-only">Blue Parl Import Export Admin Dashboard</h1>
                </div>
                <!-- end logo -->
                <div class="pull-right right">

                    <!-- top-bar-right -->
                    <div class="top-bar-right">

                        <div class="logged-user">
                            <div class="btn-group">\
                                <?php
                                include 'shreeLib/dbconn.php';
                                $sql = "SELECT create_user.user_login_username,create_branch.id,create_branch.branch_name FROM create_user INNER JOIN create_branch ON create_user.branch_id=create_branch.id where create_user.id=".$_SESSION['user_id'];
                                $result = mysqli_query($con, $sql);
                               
                                while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                <a href="#" class="btn btn-link dropdown-toggle" data-toggle="dropdown">
                                    <img src="assets/img/admin.png" alt="User Avatar" />
                                    <span class="name"><?= $row['user_login_username'];?></span> <span class="caret"></span>&nbsp;&nbsp;&nbsp;
                                    <span class="name"><?= $row['branch_name'];?></span>
                                </a>
                                <?php } ?>
                                <ul class="dropdown-menu" role="menu">                               
                                    <li>
                                        <a href="index.php">
                                            <i class="fa fa-power-off"></i>
                                            <span class="text">Logout</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="./chang_pass.php">
                                            <i class="fa fa-lock"></i>
                                            <span class="text">Change Password</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- end logged user and the menu -->
                    </div>
                    <!-- end top-bar-right -->
                </div>
            </div>
        </div>
        <!-- /container -->
    </div>
